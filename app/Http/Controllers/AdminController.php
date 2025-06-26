<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        // Basic statistics
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::where('status_pembayaran', 'confirmed')->sum('total_harga');
        $pendingTransactions = Transaction::where('status_pembayaran', 'pending')->count();
        $totalUsers = User::where('role', 'user')->count();

        // Recent transactions
        $recentTransactions = Transaction::with('plakat')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalTransactions',
            'totalRevenue',
            'pendingTransactions',
            'totalUsers',
            'recentTransactions'
        ));
    }

    public function salesReport(Request $request)
    {
        $period = $request->get('period', 'daily');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Transaction::where('status_pembayaran', 'confirmed');

        // Apply date filters
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        switch ($period) {
            case 'daily':
                $salesData = $this->getDailySales($query, $startDate, $endDate);
                break;
            case 'weekly':
                $salesData = $this->getWeeklySales($query, $startDate, $endDate);
                break;
            case 'monthly':
                $salesData = $this->getMonthlySales($query, $startDate, $endDate);
                break;
            case 'yearly':
                $salesData = $this->getYearlySales($query, $startDate, $endDate);
                break;
            default:
                $salesData = $this->getDailySales($query, $startDate, $endDate);
        }

        return view('admin.sales-report', compact('salesData', 'period', 'startDate', 'endDate'));
    }

    private function getDailySales($query, $startDate, $endDate)
    {
        $start = $startDate ? Carbon::parse($startDate) : Carbon::now()->subDays(30);
        $end = $endDate ? Carbon::parse($endDate) : Carbon::now();

        return $query->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_harga) as total_revenue')
            )
            ->whereBetween('created_at', [$start, $end])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'desc')
            ->get();
    }

    private function getWeeklySales($query, $startDate, $endDate)
    {
        $start = $startDate ? Carbon::parse($startDate) : Carbon::now()->subWeeks(12);
        $end = $endDate ? Carbon::parse($endDate) : Carbon::now();

        return $query->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('WEEK(created_at) as week'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_harga) as total_revenue')
            )
            ->whereBetween('created_at', [$start, $end])
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('WEEK(created_at)'))
            ->orderBy('year', 'desc')
            ->orderBy('week', 'desc')
            ->get();
    }

    private function getMonthlySales($query, $startDate, $endDate)
    {
        $start = $startDate ? Carbon::parse($startDate) : Carbon::now()->subMonths(12);
        $end = $endDate ? Carbon::parse($endDate) : Carbon::now();

        return $query->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_harga) as total_revenue')
            )
            ->whereBetween('created_at', [$start, $end])
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
    }

    private function getYearlySales($query, $startDate, $endDate)
    {
        $start = $startDate ? Carbon::parse($startDate) : Carbon::now()->subYears(5);
        $end = $endDate ? Carbon::parse($endDate) : Carbon::now();

        return $query->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_harga) as total_revenue')
            )
            ->whereBetween('created_at', [$start, $end])
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->orderBy('year', 'desc')
            ->get();
    }

    public function transactions()
    {
        $transactions = Transaction::with('plakat')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.transactions', compact('transactions'));
    }

    public function updateTransactionStatus(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->status_pembayaran = $request->status;
        $transaction->save();

        return back()->with('success', 'Status transaksi berhasil diupdate');
    }
}