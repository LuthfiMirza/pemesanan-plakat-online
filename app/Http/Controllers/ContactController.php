<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'telepon' => 'required',
            'pesan' => 'required'
        ]);

        // Kirim email
        Mail::raw($request->pesan, function($message) use ($request) {
            $message->from($request->email, $request->nama)
                    ->to('yuda99354@gmail.com')
                    ->subject('Pesan dari ' . $request->nama);
        });

        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}