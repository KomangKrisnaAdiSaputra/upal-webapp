<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'customer';

    protected $fillable = [
        'nama',
        'catatan',
        'status',
        'role',
        'status',
    ];

    protected $casts = [
        'id' => 'string',
        'status' => 'bolean'
    ];

    public function utilitas()
    {
        return $this->hasMany(Utilitas::class, 'id_customer', 'id');
    }
}
