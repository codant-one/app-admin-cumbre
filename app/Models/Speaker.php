<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**** Relationship ****/
    public function position() {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    public function social_links() {
        return $this->hasMany(SocialLink::class, 'speaker_id', 'id');
    }

    public function talk_speaker() {
        return $this->hasMany(TalkSpeaker::class, 'speaker_id', 'id');
    }
}