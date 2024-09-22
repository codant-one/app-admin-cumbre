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

use App\Models\Speaker;
use App\Models\Position;
use App\Models\SocialNetwork;
use App\Models\SocialLink;

class SpeakerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Speaker::with(['position']);
            
            foreach ($request->input('order') as $order) {
                $query->orderBy($order['column_name'], $order['dir']);
            }

            foreach ($request->input('columns') as $key => $column) {
                if (!$request->filled("columns.$key.search.value")) continue;

                $column_name = $request->input("columns.$key.data");
                $search_value = $request->input("columns.$key.search.value");
                $date_columns = ['created_at'];

                if ($column_name == 'position.name_es') { 
                    $query->whereHas('position', function ($q) use ($search_value) {
                        $q->where('id', $search_value);
                    });
                } elseif ($column_name == 'popular_label') { 
                    $query->where('is_popular', $search_value);
                } elseif (!in_array($column_name, $date_columns)) {
                    $query->where($column_name, 'LIKE', "%$search_value%");
                } elseif (in_array($column_name, $date_columns)) {
                    $query->whereDate($column_name, Carbon::parse($search_value)->format('Y-m-d'));
                }
            }

            $speakers = ($request->length == -1) ? $query->paginate( $query->count() ) : $query->paginate($request->length);
            $speakers->append(['popular_label']);

            return response()->json($speakers, 200);
        }
        
        return view('admin.cruds.speakers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Position::forDropdown();  
        $social_networks = SocialNetwork::forDropdown();  
        

        return view('admin.cruds.speakers.create', 
            compact(
                'positions',
                'social_networks'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = $this->prepareRequest($request, false);

        $speaker = new Speaker;
        $speaker->fill($request->except(['avatar', 'facebook', 'instagram', 'twitter']));
        $speaker->save();

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

            $path = 'speakers/';

            $file_data = uploadFile($avatar, $path);

            $speaker->avatar = $file_data['filePath'];
            $speaker->save();
        }

        if(!empty($request->facebook) && !is_null($request->facebook)){//1
            $social_network = new SocialLink;
            $social_network->speaker_id = $speaker->id;
            $social_network->social_network_id = 1;
            $social_network->link = $request->facebook;
            $social_network->save();
        }

        if(!empty($request->instagram) && !is_null($request->instagram)){//2
            $social_network = new SocialLink;
            $social_network->speaker_id = $speaker->id;
            $social_network->social_network_id = 2;
            $social_network->link = $request->instagram;
            $social_network->save();
        }

        if(!empty($request->twitter) && !is_null($request->twitter)){//3
            $social_network = new SocialLink;
            $social_network->speaker_id = $speaker->id;
            $social_network->social_network_id = 3;
            $social_network->link = $request->twitter;
            $social_network->save();
        }

        return redirect()->route('speakers.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Panelista creado exitosamente'
            ]
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function show(Speaker $speaker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $speaker = Speaker::with(['social_links'])->where('id', $id)->first();
        $positions = Position::forDropdown();  

        if (!$speaker)
            return redirect()->route('speakers.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el panelista'
                ]
            ]);

        $socials = $speaker->social_links->mapWithKeys(function($speakerWraper) {
            switch ($speakerWraper->social_network_id) {
                case 1:
                    $social_network = 'facebook';
                    break;
                case 2:
                    $social_network = 'instagram';
                    break;
                case 3:
                    $social_network = 'twitter';
                    break;
                default:
                    $social_network = null; // Por si hay otras redes sociales que no están mapeadas
            }
            
            return [$social_network => $speakerWraper->link];
        })->filter()->toArray();

        return view('admin.cruds.speakers.edit', compact('speaker', 'positions', 'socials'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $speaker = Speaker::find($id);

        if (!$speaker)
            return redirect()->route('speakers.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el panelista'
                ]
            ]);

        $request = $this->prepareRequest($request, $speaker);
        $speaker->fill($request->except(['avatar', 'facebook', 'instagram', 'twitter']));
        $speaker->update();

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

            $path = 'speakers/';

            $file_data = uploadFile($avatar, $path, $speaker->avatar);

            $speaker->avatar = $file_data['filePath'];
            $speaker->update();
        }

        if(!empty($request->facebook) && !is_null($request->facebook)){//1
            SocialLink::updateOrCreate(
                [    
                    'speaker_id' => $speaker->id,
                    'social_network_id' => 1
                ],
                [    'link' => $request->facebook ]
            );
        }

        if(!empty($request->instagram) && !is_null($request->instagram)){//2
            SocialLink::updateOrCreate(
                [    
                    'speaker_id' => $speaker->id,
                    'social_network_id' => 2
                ],
                [    'link' => $request->instagram ]
            );
        }

        if(!empty($request->twitter) && !is_null($request->twitter)){//3
            SocialLink::updateOrCreate(
                [    
                    'speaker_id' => $speaker->id,
                    'social_network_id' => 3
                ],
                [    'link' => $request->twitter ]
            );
        }

        return redirect()->route('speakers.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Panelista actualizado exitosamente'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $speaker = Speaker::find($id);
        
        if (!$speaker)
            return redirect()->route('speakers.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el panelista'
                ]
            ]);

        $speaker->delete();
        deleteFile($speaker->avatar);

        return redirect()->route('speakers.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'warning',
                'message' => 'Panelista eliminado'
            ]
        ]);
    }

    public function deleteSpeakers(Request $request)
    {
        try{
            $speakers = Speaker::whereIn('id', $request->ids)->get();
            
            foreach($speakers as $item){
                $speaker = Speaker::findOrFail($item->id);

                $speaker->delete();
                deleteFile($speaker->avatar);
            }

            $message = array('message' => 'Panelistas Eliminados Exitosamente', 'title' => 'Columnas Eliminadas');
            return response()->json($message);

        } catch(\Exception $e){
            return redirect()->route('speakers.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'danger',
                    'message' => 'Ha ocurrido un error: '.$e
                ]
            ]);
        }

    }

    private function prepareRequest(Request $request, $speaker)
    {
        $popular = ($request->popular == "on") ? 1 : 0;

        $request->request->add(['is_popular' => $popular]);

        $request->request->remove('popular');
        $request->request->remove('avatar_remove');

        return $request;
    }
}