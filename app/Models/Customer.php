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

    protected $appends = [
        'nilai_str',
    ];

    public function utilitas()
    {
        return $this->hasMany(Utilitas::class, 'customer_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    function getNilaiStrAttribute()
    {
        $nilai_str = "";
        $pal = preg_split('/\sx\s/i', $this->penanganan_air_limbah);
        if (count($pal) > 1) $nilai_str =  $pal[1];
        return $nilai_str;
    }
}
