<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order_detail extends Model
{
    protected $fillable=['transaksis_id','bibit_id','qty','price'];
    use HasFactory;

    public function order():BelongsTo
    {
        return $this->belongsTo(Transaksis::class);
    }

    public function product():BelongsTo
    {
        return $this->belongsTo(bibit::class);
    }
}
