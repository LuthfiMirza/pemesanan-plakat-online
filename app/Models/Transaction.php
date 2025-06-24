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
        'total_harga',
        'metode_pembayaran',
        'bank',
        'ewallet',
        'bukti_pembayaran',
        'status_pembayaran'
    ];

    protected $appends = ['design_file_url', 'bukti_pembayaran_url'];

    protected $casts = [
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
}