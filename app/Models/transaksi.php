<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksis extends Model
{
    use HasFactory;

    protected $fillable=['invoice','pelanggan_id','user_id','total'];

    public function detiltransaksis():HasMany
    {
        return $this->hasMany(Detiltransaksis::class);
    }

    public function pelanggans():BelongsTo
    {
        return $this->belongsTo(Pelanggans::class);
    }
}
