<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Plakat;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function showPaymentForm($plakat_id)
    {
        $plakat = Plakat::findOrFail($plakat_id);
        return view('payment.form', compact('plakat'));
    }

    public function processPayment(Request $request)
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
                'quantity' => 'required|integer|min:1|max:100',
                'total_harga' => 'required|numeric',
                'unit_price' => 'required|numeric',
                'metode_pembayaran' => 'required|in:transfer_bank,e_wallet,cod',
                'bank' => 'nullable|string',
                'ewallet' => 'nullable|string',
            ]);

            // Verify that total_harga matches unit_price * quantity
            $expectedTotal = $validatedData['unit_price'] * $validatedData['quantity'];
            if (abs($validatedData['total_harga'] - $expectedTotal) > 0.01) {
                return back()->withErrors(['error' => 'Total harga tidak sesuai dengan perhitungan.'])->withInput();
            }

            // Upload design file jika ada
            if ($request->hasFile('design_file')) {
                $designFile = $request->file('design_file');
                $designFileName = time() . '_' . $designFile->getClientOriginalName();
                $designFile->storeAs('design-files', $designFileName, 'public');
                $validatedData['design_file'] = $designFileName;
            }

            // Set status pembayaran berdasarkan metode
            if ($validatedData['metode_pembayaran'] === 'cod') {
                $validatedData['status_pembayaran'] = 'pending';
            } else {
                $validatedData['status_pembayaran'] = 'menunggu_pembayaran';
            }

            // Simpan transaksi
            $transaction = Transaction::create($validatedData);

            // Redirect ke halaman pembayaran sesuai metode
            if ($validatedData['metode_pembayaran'] === 'cod') {
                return redirect()->route('payment.success', $transaction->id)
                    ->with('success', 'Pesanan berhasil dibuat. Anda akan membayar saat barang diterima.');
            } else {
                return redirect()->route('payment.upload', $transaction->id);
            }

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function showUploadForm($transaction_id)
    {
        $transaction = Transaction::with('plakat')->findOrFail($transaction_id);
        return view('payment.upload', compact('transaction'));
    }

    public function uploadProof(Request $request, $transaction_id)
    {
        try {
            $transaction = Transaction::findOrFail($transaction_id);

            // Debug: Log request data
            \Log::info('Upload Proof Request', [
                'transaction_id' => $transaction_id,
                'has_file' => $request->hasFile('bukti_pembayaran'),
                'files' => $request->allFiles(),
                'all_data' => $request->all()
            ]);

            // Validate the request
            $validatedData = $request->validate([
                'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'bukti_pembayaran.required' => 'File bukti pembayaran wajib diupload.',
                'bukti_pembayaran.image' => 'File harus berupa gambar.',
                'bukti_pembayaran.mimes' => 'Format file harus JPG, PNG, atau JPEG.',
                'bukti_pembayaran.max' => 'Ukuran file maksimal 2MB.',
            ]);

            // Check if file is actually uploaded
            if (!$request->hasFile('bukti_pembayaran')) {
                \Log::error('No file uploaded', ['request_files' => $request->allFiles()]);
                return back()->withErrors(['bukti_pembayaran' => 'File bukti pembayaran tidak ditemukan.'])->withInput();
            }

            $buktiFile = $request->file('bukti_pembayaran');
            
            // Additional validation
            if (!$buktiFile->isValid()) {
                \Log::error('Invalid file uploaded', ['file_error' => $buktiFile->getError()]);
                return back()->withErrors(['bukti_pembayaran' => 'File yang diupload tidak valid.'])->withInput();
            }

            // Generate unique filename
            $buktiFileName = time() . '_' . uniqid() . '.' . $buktiFile->getClientOriginalExtension();
            
            // Store the file
            $path = $buktiFile->storeAs('bukti-pembayaran', $buktiFileName, 'public');
            
            if (!$path) {
                \Log::error('Failed to store file', ['filename' => $buktiFileName]);
                return back()->withErrors(['bukti_pembayaran' => 'Gagal menyimpan file. Silakan coba lagi.'])->withInput();
            }
            
            // Update transaction
            $transaction->bukti_pembayaran = $buktiFileName;
            $transaction->status_pembayaran = 'menunggu_verifikasi';
            $transaction->save();

            \Log::info('File uploaded successfully', ['filename' => $buktiFileName, 'transaction_id' => $transaction_id]);

            return redirect()->route('payment.success', $transaction->id)
                ->with('success', 'Bukti pembayaran berhasil diupload. Pesanan Anda sedang diverifikasi.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Upload error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengupload file: ' . $e->getMessage()])->withInput();
        }
    }

    public function paymentSuccess($transaction_id)
    {
        $transaction = Transaction::with('plakat')->findOrFail($transaction_id);
        return view('payment.success', compact('transaction'));
    }

    public function getPaymentStatus($transaction_id)
    {
        $transaction = Transaction::findOrFail($transaction_id);
        return response()->json([
            'status' => $transaction->status_pembayaran,
            'updated_at' => $transaction->updated_at->format('Y-m-d H:i:s')
        ]);
    }

    public function checkout(Request $request)
    {
        // Keep the old method for backward compatibility
        return $this->processPayment($request);
    }
}
