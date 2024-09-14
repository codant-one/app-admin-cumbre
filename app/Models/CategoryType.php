<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Category;

class CategoryType extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**** Relationship ****/
     public function categories() {
        return $this->hasMany(Category::class, 'category_type_id', 'id');
    }

}
