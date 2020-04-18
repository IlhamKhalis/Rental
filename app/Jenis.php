<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    protected $table="jenis_mobil";
    protected $tableprimaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'jenis'
    ];
}
