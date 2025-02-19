<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilitas extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'id_customer',
        'id_user',
        'jenis',
        'satuan',
        'tanggal',
        'nilai',
        'status',
    ];

    protected $casts = [
        'id' => 'string',
        'id_customer' => 'string',
        'id_user' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }
}
