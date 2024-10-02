<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

use File;
use Validator;
use App;

use App\Services\ExpoHost;
use App\Jobs\SendUserNotification;

use App\Models\User;
use App\Models\Map;
use App\Models\Translation;
use App\Models\Talk;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\NotificationType;
use App\Models\Schedule;
use App\Models\Token;

class ConfigController extends Controller
{
    
    protected $expoHost;

    public function map()
    {
        $map = Map::first();
            
        return view('admin.config.maps.index', compact('map'));
    }

    public function mapUpdate(Request $request)
    {

        $map = Map::find($request->id);

        if (!$map) {
            $map = new Map;
        }
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = 'maps/';

            $file_data = uploadFile($image, $path, $map->image);
            $map->image = $file_data['filePath'];
            $map->save();
        }

        if ($request->hasFile('image_2')) {
            $image_2 = $request->file('image_2');
            $path = 'maps/';
            $file_data2 = uploadFile($image_2, $path, $map->image_2);
            $map->image_2 = $file_data2['filePath'];
            $map->save();
        }

        if ($request->hasFile('image_3')) {
            $image_3 = $request->file('image_3');
            $path = 'maps/';
            $file_data2 = uploadFile($image_3, $path, $map->image_3);
            $map->image_3 = $file_data2['filePath'];
            $map->save();
        }

        return redirect()->route('map')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Datos actualizados exitosamente'
            ]
        ]);
    }

    public function translations()
    {
        $translation = Translation::first();
            
        return view('admin.config.translations.index', compact('translation'));
    }

    public function translationsUpdate(Request $request)
    {

        $translation = Translation::find($request->id);

        if (!$translation) {
            $translation = new Translation;
        }

        $translation->link_es = $request->link_es;
        $translation->link_en = $request->link_en;
        $translation->save();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = 'translations/';

            $file_data = uploadFile($image, $path, $translation->image);
            $translation->image = $file_data['filePath'];
            $translation->save();
        }

        return redirect()->route('translations')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Datos actualizados exitosamente'
            ]
        ]);
    }

    public function notifications()
    {          
        $user = "{{user}}";
        $schedules = Schedule::forDropdown();
        $notification_types = NotificationType::forDropdown();

        return view('admin.config.notifications.index', compact('user', 'schedules', 'notification_types'));
    }

    public function notificationStore(Request $request)
    {
        $type = (int)$request->notification_type_id;
        $talk_id = (int)$request->talk_id ?? 0;

        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'App');
        })->whereNotNull('fcm_token')->get();

        foreach($users as $user) {

            $full_name = $user->name . ' ' . $user->last_name;
            $band = false;

            if($type === 2) {//GENERAL
                $notification = new Notification;
                $notification->user_id = $user->id;
                $notification->notification_type_id = 2;
                $notification->title_es = $request->title_es;
                $notification->description_es = str_replace('{{user}}', $full_name, $request->description_es);
                $notification->title_en = $request->title_en;
                $notification->description_en = str_replace('{{user}}', $full_name, $request->description_en);
                $notification->date = now();
                $notification->save();

                $band = true;

            } else {//AGENDA

                $notification_user = NotificationUser::where([
                    ['user_id', $user->id],
                    ['talk_id', $talk_id]
                ])->first();

                if ($notification_user) {
                    $notification = new Notification;
                    $notification->user_id = $user->id;
                    $notification->notification_type_id = 1;
                    $notification->notification_user_id = $notification_user->id;
                    $notification->title_es = $request->title_es;
                    $notification->description_es = str_replace('{{user}}', $full_name, $request->description_es);
                    $notification->title_en = $request->title_en;
                    $notification->description_en = str_replace('{{user}}', $full_name, $request->description_en);
                    $notification->date = now();
                    $notification->save();

                    $band = true;
                }

            }

            // if($band) {
            //     $title = ($user->lang === 'es') ? $request->title_es : $request->title_en;
            //     $body = str_replace('{{user}}', $full_name, ($user->lang === 'es') ? $request->description_es : $request->description_en);

            //     $this->expoHost = new ExpoHost();
            //     $this->expoHost->pushNotification([$user->fcm_token], $title, $body);
            // }
            // Log::info('antes');
            if($band) {
                $title = ($user->lang === 'es') ? $request->title_es : $request->title_en;
                $body = str_replace('{{user}}', $full_name, ($user->lang === 'es') ? $request->description_es : $request->description_en);
                // Log::info('adentro');
                // Enviar la notificaicion en segundo plano usando colas
                SendUserNotification::dispatch($user->fcm_token, $title, $body)->delay(now()->addSeconds(1));
            }
        }
       
        return redirect()->route('notifications')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Mensaje enviado'. $notification_user
            ]
        ]);
    }

    public function publicNotifications()
    {          
        return view('admin.config.publicNotifications.index');
    }

    public function publicNotificationsStore(Request $request)
    {   
        $tokens = Token::select('token')->get()->pluck('token');
        $chunkSize = 50;
        $groupedIds = $tokens->chunk($chunkSize);

        $title = $request->title;
        $body = $request->body;

        foreach ($groupedIds as $tokens_) {
            $cleanedTokens = Token::select('token')->whereIn('token', $tokens_)->pluck('token');

            $this->expoHost = new ExpoHost();
            $this->expoHost->pushNotification($cleanedTokens, $title, $body);
        }

        return redirect()->route('publicNotifications')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Mensaje enviado'
            ]
        ]);
    }

}