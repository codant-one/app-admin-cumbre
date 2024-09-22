<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Position extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**** Public methods ****/
    public static function forDropdown()
    {
        return DB::table('positions as p')
               ->select(['p.id', 'p.name_es' ])
               ->orderBy('name_es')
               ->get()->pluck('name_es','id');   
    }
}