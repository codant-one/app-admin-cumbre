<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**** Relationship ****/
    public function notification_type() {
        return $this->belongsTo(NotificationType::class, 'notification_type_id', 'id');
    }
}
