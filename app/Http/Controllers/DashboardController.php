<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userDashboard()
    {
        $user = Auth::user();
        $transactions = Transaction::where('email', $user->email)
            ->with('plakat')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard.user', compact('transactions'));
    }

    public function orderHistory()
    {
        $user = Auth::user();
        $transactions = Transaction::where('email', $user->email)
            ->with('plakat')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('dashboard.order-history', compact('transactions'));
    }

    public function showInvoice($id)
    {
        $user = Auth::user();
        $transaction = Transaction::where('id', $id)
            ->where('email', $user->email)
            ->with('plakat')
            ->firstOrFail();

        return view('dashboard.invoice', compact('transaction'));
    }
}