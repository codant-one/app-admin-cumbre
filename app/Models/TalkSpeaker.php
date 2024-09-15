<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalkSpeaker extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**** Relationship ****/
    public function talk() {
        return $this->belongsTo(Talk::class, 'talk_id', 'id');
    }

    public function speaker() {
        return $this->belongsTo(Speaker::class, 'speaker_id', 'id');
    }
}
