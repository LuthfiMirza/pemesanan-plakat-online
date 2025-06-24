<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Plakat;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkout(Request $request)
{
    try {
        $validatedData = $request->validate([
            'plakat_id' => 'required|exists:plakats,id',
            'nama_pembeli' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telepon' => 'required|string|max:255',
            'alamat' => 'required|string',
            'design_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'catatan_design' => 'nullable|string',
            'total_harga' => 'required|numeric',
            'metode_pembayaran' => 'required|in:transfer_bank,e_wallet',
            'bank' => 'required_if:metode_pembayaran,transfer_bank',
            'ewallet' => 'required_if:metode_pembayaran,e_wallet',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status_pembayaran' => 'required|in:menunggu_pembayaran,menunggu_verifikasi,dibayar,ditolak'
        ]);

        // Upload design file jika ada
        if ($request->hasFile('design_file')) {
            $designFile = $request->file('design_file');
            $designFileName = time() . '_' . $designFile->getClientOriginalName();
            $designFile->storeAs('design-files', $designFileName, 'public');  // Hapus 'public/' dari path
            $validatedData['design_file'] = $designFileName;
        }

        // Upload bukti pembayaran
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiFile = $request->file('bukti_pembayaran');
            $buktiFileName = time() . '_' . $buktiFile->getClientOriginalName();
            $buktiFile->storeAs('bukti-pembayaran', $buktiFileName, 'public');  // Hapus 'public/' dari path
            $validatedData['bukti_pembayaran'] = $buktiFileName;
        }

        // Simpan transaksi
        $transaction = Transaction::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil diproses',
            'data' => $transaction
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}
}
