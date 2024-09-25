<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\Notification;

class NotificationType extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**** Relationship ****/
     public function notifications() {
        return $this->hasMany(Notification::class, 'notificatio_type_id', 'id');
    }

    /**** Public methods ****/
    public static function forDropdown()
    {
        return DB::table('notification_types as n')
               ->select(['n.id', 'n.name' ])
               ->orderBy('name')
               ->get()->pluck('name','id');   
    }

}
