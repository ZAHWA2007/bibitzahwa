<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Detiltransaksi extends Model
{
    protected $fillable=['transaksi_id','bibit_id','qty','total','price'];
    use HasFactory;

    public function transaksi():BelongsTo
    {
        return $this->belongsTo(transaksis::class);
    }

    public function bibit():BelongsTo
    {
        return $this->belongsTo(bibit::class);
    }
}