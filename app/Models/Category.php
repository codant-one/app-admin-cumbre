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

    /**** Attributes ****/
    public function getTypeLabelAttribute()
    {
        switch ($this->category_type_id) {
            case 1:
                $class = 'primary';
                break;
            case 2:
                $class = 'success';
                break;
            case 3:
                $class = 'info';
                break;
            case 4:
                $class = 'warning';
                break;
            default:
                $class = 'error';
                break;

        }
 
        return '<div class="badge badge-light-' . $class . ' fs-8 fw-bolder">' . $this->category_type->name_es . '</div>';
    }
}
