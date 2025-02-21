<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'group_id',
        'nama',
        'air_irigasi',
        'harga_air_irigasi',
        'air_limbah',
        'harga_air_limbah',
        'penanganan_air_limbah',
        'status',
    ];

    protected $casts = [
        'id' => 'string',
        'status' => 'boolean'
    ];

    public function utilitas()
    {
        return $this->hasMany(Utilitas::class, 'customer_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
