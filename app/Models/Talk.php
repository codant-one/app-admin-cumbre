<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function favorite() {
        return $this->hasOne(Favorite::class, 'talk_id', 'id')->where('user_id', Auth::guard('api')->user()->id);
    }

    public function notification() {
        return $this->hasOne(NotificationUser::class, 'talk_id', 'id')->where('user_id', Auth::guard('api')->user()->id);
    }

    /**** Public methods ****/
    public static function forDropdown()
    {
        return DB::table('talks as t')
               ->select(['t.id', 't.title_es' ])
               ->orderBy('title_es')
               ->get()->pluck('title_es','id');   
    }

    /**** Attributes ****/
    public function getTypeLabelAttribute()
    {
        switch ($this->schedule_id) {
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
     
        return '<div class="badge badge-light-' . $class . ' fs-8 fw-bolder">' . $this->schedule->name_es . '</div>';
    }
}
