<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**** Relationship ****/
    public function category_type() {
        return $this->belongsTo(CategoryType::class, 'category_type_id', 'id');
    }
}
