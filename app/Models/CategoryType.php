<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\Category;

class CategoryType extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**** Relationship ****/
     public function categories() {
        return $this->hasMany(Category::class, 'category_type_id', 'id');
    }

    /**** Public methods ****/
    public static function forDropdown()
    {
        return DB::table('category_types as c')
              ->select(['c.id', 'c.name_es' ])
              ->orderBy('name_es')
              ->get()->pluck('name_es','id');   
    }

}
