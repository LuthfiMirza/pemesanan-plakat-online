<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Plakat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Transaction extends Model
{
    protected $fillable = [
        'plakat_id',
        'nama_pembeli',
        'email',
        'no_telepon',
        'alamat',
        'design_file',
        'catatan_design',
        'quantity',
        'unit_price',
        'total_harga',
        'metode_pembayaran',
        'bank',
        'ewallet',
        'bukti_pembayaran',
        'status_pembayaran',
        'invoice_number'
    ];

    protected $appends = ['design_file_url', 'bukti_pembayaran_url'];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'metode_pembayaran' => 'string',
        'status_pembayaran' => 'string'
    ];

    public function getDesignFileUrlAttribute()
    {
        return $this->design_file ? asset('storage/design-files/' . $this->design_file) : null;
    }

    public function getBuktiPembayaranUrlAttribute()
    {
        return $this->bukti_pembayaran ? asset('storage/bukti-pembayaran/' . $this->bukti_pembayaran) : null;
    }

    public function plakat(): BelongsTo
    {
        return $this->belongsTo(Plakat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    /**
     * Generate invoice number
     */
    public static function generateInvoiceNumber()
    {
        $prefix = 'INV';
        $date = date('Ymd');
        $lastTransaction = self::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastTransaction ? (int)substr($lastTransaction->invoice_number, -4) + 1 : 1;
        
        return $prefix . $date . str_pad((string)$sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Boot method to auto-generate invoice number
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($transaction) {
            if (!$transaction->invoice_number) {
                $transaction->invoice_number = self::generateInvoiceNumber();
            }
        });
    }
}