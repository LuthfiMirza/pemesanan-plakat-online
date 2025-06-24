<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plakat extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi', 
        'harga',
        'gambar',
        'kategori',
        'status'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}