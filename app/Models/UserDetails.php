<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'document',
        'store_name'
    ];

    /**** Relationship ****/
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**** Public methods ****/
    public static function updateOrCreateUser($request, $user) {
        $userD = UserDetails::updateOrCreate(
            [    'user_id' => $user->id ],
            [
                'phone' => $request->phone,
                'address' => $request->address,
                'document' => $request->document,
                'store_name' => $request->store_name
            ]
        );

        return $userD;
    }

    public static function updateOrCreateStore($request, $user) {
        $userD = UserDetails::updateOrCreate(
            [    'user_id' => $user->id ],
            [
                'store_name' => $request->store_name
            ]
        );

        return $userD;
    }

    public static function updateOrCreateUserApp($request, $user) {
        $userD = UserDetails::updateOrCreate(
            [    'user_id' => $user->id ],
            [
                'address' => $request->address,
                'document' => $request->document
            ]
        );

        return $userD;
    }

    public static function updateOrCreatePhone($request, $user) {
        $userD = UserDetails::updateOrCreate(
            [    'user_id' => $user->id ],
            [
                'phone' => $request->phone
            ]
        );

        return $userD;
    }
}
