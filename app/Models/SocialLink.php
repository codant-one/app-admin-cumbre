<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**** Relationship ****/
    public function speaker() {
        return $this->belongsTo(Speaker::class, 'speaker_id', 'id');
    }

    public function social_network() {
        return $this->belongsTo(SocialNetwork::class, 'social_network_id', 'id');
    }
}