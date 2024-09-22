<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

use Carbon\Carbon;

use File;
use Validator;
use App;

use App\Models\Map;
use App\Models\Translation;

class ConfigController extends Controller
{
    
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

        return redirect()->route('translations')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Datos actualizados exitosamente'
            ]
        ]);
    }

}