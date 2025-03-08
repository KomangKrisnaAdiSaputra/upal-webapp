<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilitas extends Model
{
    use HasFactory, HasUuids;

    public const STATUS_MENUNGGU = "MENUNGGU";
    public const STATUS_VALIDASI = "VALIDASI";

    public const TYPE_AIR_LIMBAH = "AIR_LIMBAH";
    public const TYPE_AIR_IRIGASI = "AIR_IRIGASI";

    protected $fillable = [
        'id',
        'customer_id',
        'user_id',
        'type',
        'tanggal',
        'nilai',
        'keterangan',
        // 'status',
    ];

    protected $casts = [
        'id' => 'string',
        'customer_id' => 'string',
        'user_id' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
