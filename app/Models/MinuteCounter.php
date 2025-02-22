<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinuteCounter extends Model
{
    use HasFactory, HasUuids;

    public const TYPE_AIR_LIMBAH = "AIR_LIMBAH";
    public const TYPE_AIR_IRIGASI = "AIR_IRIGASI";

    protected $fillable = [
        'user_id',
        'type',
        'lokasi',
        'sub_lokasi',
        'pompa_terpasang',
        'jam',
        'nilai',
        'volume',
        'ampere',
        'keterangan',
        'tanggal',
    ];

    protected $casts = [
        'id' => 'string',
        'volume' => 'boolean',
        'ampere' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
