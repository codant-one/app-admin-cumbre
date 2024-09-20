<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';
    protected $guarded = [];

    /**** Relationship ****/
    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**** Attributes ****/
    public function getPopularLabelAttribute()
    {
         switch ($this->is_popular) {
             case 1:
                 $class = 'primary';
                 $name = 'SI';
                 break;
             case 0:
                 $class = 'info';
                 $name = 'NO';
                 break;
         }
 
         return '<div class="badge badge-light-' . $class . ' fs-8 fw-bolder">' . $name . '</div>';
     }
}