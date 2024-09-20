<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**** Relationship ****/
    public function category_type() {
        return $this->belongsTo(CategoryType::class, 'category_type_id', 'id');
    }

    /**** Public methods ****/
    public static function forDropdown($category_type_id)
    {
        return DB::table('categories as c')
              ->select(['c.id', 'c.name_es' ])
              ->orderBy('name_es')
              ->where('category_type_id', $category_type_id)
              ->get()->pluck('name_es','id');   
    }
}
