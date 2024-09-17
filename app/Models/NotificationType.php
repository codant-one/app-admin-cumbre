<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Notification;

class NotificationType extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**** Relationship ****/
     public function notifications() {
        return $this->hasMany(Notification::class, 'notificatio_type_id', 'id');
    }

}
