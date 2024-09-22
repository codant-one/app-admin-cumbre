<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    /**** Public methods ****/
    public static function forDropdown()
    {
        return DB::table('speakers as s')
                ->select(DB::raw("CONCAT(s.name, ' ', s.last_name) as full_name"), 's.id')
                ->orderBy('s.name')
                ->get()
                ->pluck('full_name', 'id');  
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