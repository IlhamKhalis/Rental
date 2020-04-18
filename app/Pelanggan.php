<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table="pelanggan";
    protected $tableprimaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'nama_pelanggan', 'no_ktp', 'alamat', 'no_telp'
    ];
}
