<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class detiltransaksi extends Model
{
    protected $fillable=['transaksis_id','bibit_id','qty','harga'];
    use HasFactory;

    public function transaksi():BelongsTo
    {
        return $this->belongsTo(Transaksis::class);
    }

    public function bibit():BelongsTo
    {
        return $this->belongsTo(bibit::class);
    }
}
