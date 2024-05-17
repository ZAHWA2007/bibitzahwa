<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class transaksi extends Model
{
    use HasFactory;

    protected $fillable=['invoice','pelanggans_id','users_id','total'];

    public function detiltransaksis():HasMany
    {
        return $this->hasMany(detiltransaksi::class);
    }

    public function pelanggans():BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }
}
