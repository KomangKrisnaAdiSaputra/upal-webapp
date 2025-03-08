<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'type_perhitungan',
        'perhitungan',
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

    function typePerhitungan()
    {
        $datas = collect();
        $types = ['WATER METER', 'RNS', 'PDAM'];

        foreach ($types as $type) {
            $datas->push(convertToObject([
                "value" => $type,
                "label" => Str::title($type)
            ]));
        }
        return $datas;
    }
}
