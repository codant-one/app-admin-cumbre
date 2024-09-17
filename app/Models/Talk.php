<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**** Relationship ****/
    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function schedule() {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'id');
    }

    public function speakers() {
        return $this->hasMany(TalkSpeaker::class, 'talk_id', 'id');
    }

    public function questions() {
        return $this->hasMany(Question::class, 'talk_id', 'id');
    }
}
