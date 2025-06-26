<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Plakat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Order Inbox - Pesanan masuk yang perlu diproses
     */
    public function orderInbox()
    {
        $newOrders = Transaction::with('plakat')
            ->whereIn('status_pembayaran', ['pending', 'menunggu_verifikasi'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $urgentOrders = Transaction::with('plakat')
            ->where('created_at', '<=', Carbon::now()->subDays(2))
            ->whereNotIn('status_pembayaran', ['completed', 'cancelled', 'rejected'])
            ->orderBy('created_at', 'asc')
            ->limit(10)
            ->get();

        return view('admin.order-inbox', compact('newOrders', 'urgentOrders'));
    }

    /**
     * Production Queue - Antrian produksi
     */
    public function productionQueue()
    {
        $inProduction = Transaction::with('plakat')
            ->where('status_pembayaran', 'in_production')
            ->orderBy('production_start_date', 'asc')
            ->get();

        $readyForProduction = Transaction::with('plakat')
            ->where('status_pembayaran', 'confirmed')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.production-queue', compact('inProduction', 'readyForProduction'));
    }

    /**
     * Update order status with additional tracking info
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        
        $validatedData = $request->validate([
            'status' => 'required|string',
            'notes' => 'nullable|string',
            'estimated_completion' => 'nullable|date',
            'production_notes' => 'nullable|string'
        ]);

        $transaction->status_pembayaran = $validatedData['status'];
        
        if (isset($validatedData['notes'])) {
            $transaction->admin_notes = $validatedData['notes'];
        }
        
        if (isset($validatedData['estimated_completion'])) {
            $transaction->estimated_completion = $validatedData['estimated_completion'];
        }
        
        if (isset($validatedData['production_notes'])) {
            $transaction->production_notes = $validatedData['production_notes'];
        }

        // Set production start date when status changes to in_production
        if ($validatedData['status'] === 'in_production' && !$transaction->production_start_date) {
            $transaction->production_start_date = now();
        }

        // Set completion date when status changes to completed
        if ($validatedData['status'] === 'completed' && !$transaction->completed_at) {
            $transaction->completed_at = now();
        }

        $transaction->save();

        return back()->with('success', 'Status pesanan berhasil diupdate');
    }

    /**
     * Bulk actions for multiple orders
     */
    public function bulkAction(Request $request)
    {
        $validatedData = $request->validate([
            'action' => 'required|string',
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:transactions,id'
        ]);

        $transactions = Transaction::whereIn('id', $validatedData['order_ids']);

        switch ($validatedData['action']) {
            case 'confirm':
                $transactions->update(['status_pembayaran' => 'confirmed']);
                break;
            case 'start_production':
                $transactions->update([
                    'status_pembayaran' => 'in_production',
                    'production_start_date' => now()
                ]);
                break;
            case 'mark_ready':
                $transactions->update(['status_pembayaran' => 'ready_to_ship']);
                break;
        }

        return back()->with('success', 'Bulk action berhasil dijalankan');
    }

    /**
     * Order analytics and reports
     */
    public function orderAnalytics()
    {
        $statusCounts = Transaction::select('status_pembayaran', DB::raw('count(*) as count'))
            ->groupBy('status_pembayaran')
            ->get()
            ->pluck('count', 'status_pembayaran');

        $dailyOrders = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total_harga) as revenue')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'desc')
            ->get();

        $topProducts = Transaction::with('plakat')
            ->select('plakat_id', DB::raw('COUNT(*) as order_count'), DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('plakat_id')
            ->orderBy('order_count', 'desc')
            ->limit(10)
            ->get();

        $avgProcessingTime = Transaction::where('status_pembayaran', 'completed')
            ->whereNotNull('completed_at')
            ->selectRaw('AVG(DATEDIFF(completed_at, created_at)) as avg_days')
            ->first();

        return view('admin.order-analytics', compact(
            'statusCounts', 
            'dailyOrders', 
            'topProducts', 
            'avgProcessingTime'
        ));
    }
}