<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**** Public methods ****/
    public static function forDropdown()
    {
        return DB::table('schedules as s')
              ->select(['s.id', 's.name_es' ])
              ->orderBy('name_es')
              ->get()->pluck('name_es','id');   
    }
}