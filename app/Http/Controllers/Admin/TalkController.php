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

use App\Models\Talk;
use App\Models\Category;
use App\Models\Schedule;
use App\Models\TalkSpeaker;
use App\Models\Speaker;

class TalkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Talk::with(['category', 'schedule']);
            
            foreach ($request->input('order') as $order) {
                $query->orderBy($order['column_name'], $order['dir']);
            }

            foreach ($request->input('columns') as $key => $column) {
                if (!$request->filled("columns.$key.search.value")) continue;

                $column_name = $request->input("columns.$key.data");
                $search_value = $request->input("columns.$key.search.value");
                $date_columns = ['created_at'];

                if ($column_name == 'category.name_es') { 
                    $query->whereHas('category', function ($q) use ($search_value) {
                        $q->where('id', $search_value);
                    });
                } elseif ($column_name == 'type_label') { 
                    $query->whereHas('schedule', function ($q) use ($search_value) {
                        $q->where('id', $search_value);
                    });
                } elseif (!in_array($column_name, $date_columns)) {
                    $query->where($column_name, 'LIKE', "%$search_value%");
                } elseif (in_array($column_name, $date_columns)) {
                    $query->whereDate($column_name, Carbon::parse($search_value)->format('Y-m-d'));
                }
            }

            $talks = ($request->length == -1) ? $query->paginate( $query->count() ) : $query->paginate($request->length);
            $talks->append(['type_label']);

            return response()->json($talks, 200);
        }

        $categories = Category::forDropdown(4); 
        $schedules = Schedule::forDropdown(); 
        
        return view('admin.cruds.talks.index', compact('categories', 'schedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::forDropdown(4);  
        $schedules = Schedule::forDropdown(); 
        $speakers = Speaker::forDropdown();

        return view('admin.cruds.talks.create', 
            compact(
                'categories',
                'schedules',
                'speakers'
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

        $talk = new Talk;
        $talk->fill($request->except(['image', 'speakers']));
        $talk->save();

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $path = 'talks/';

            $file_data = uploadFile($image, $path);

            $talk->image = $file_data['filePath'];
            $talk->save();
        }

        foreach($request->speakers as $speaker) {
            $talk_speaker = new TalkSpeaker;
            $talk_speaker->talk_id = $talk->id;
            $talk_speaker->speaker_id = $speaker;
            $talk_speaker->save();
        }

        return redirect()->route('talks.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Charla creada exitosamente'
            ]
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Talk  $talk
     * @return \Illuminate\Http\Response
     */
    public function show(Talk $talk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Talk  $talk
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $talk = Talk::with(['speakers'])->where('id', $id)->first();
        $categories = Category::forDropdown(4);  
        $schedules = Schedule::forDropdown(); 
        $speakers = Speaker::forDropdown(); 

        if (!$talk)
            return redirect()->route('talks.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la Charla'
                ]
            ]);

        $selectedSpeakers = $talk->speakers->map(function($talkWraper) {
            return $talkWraper->speaker_id;
        })->toArray();

        return view('admin.cruds.talks.edit', compact('talk', 'categories', 'schedules', 'speakers', 'selectedSpeakers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Talk  $talk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $talk = Talk::with(['speakers'])->find($id);

        if (!$talk)
            return redirect()->route('talks.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la Charla'
                ]
            ]);

        $request = $this->prepareRequest($request, $talk);
        $talk->fill($request->except(['image', 'speakers']));
        $talk->update();

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $path = 'talks/';

            $file_data = uploadFile($image, $path, $talk->image);

            $talk->image = $file_data['filePath'];
            $talk->update();
        }

        $talk->speakers()->delete();

        foreach($request->speakers as $speaker) {
            $talk_speaker = new TalkSpeaker;
            $talk_speaker->talk_id = $talk->id;
            $talk_speaker->speaker_id = $speaker;
            $talk_speaker->save();
        }

        return redirect()->route('talks.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                 'message' => 'Charla actualizada exitosamente'
               ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Talk  $talk
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $talk = Talk::find($id);
        
        if (!$talk)
            return redirect()->route('talks.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la Charla'
                ]
            ]);

        $talk->delete();
        deleteFile($talk->image);

        return redirect()->route('talks.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'warning',
                'message' => 'Charla eliminada'
            ]
        ]);
    }

    public function deleteTalks(Request $request)
    {
        try{
            $talks = Talk::whereIn('id', $request->ids)->get();
            
            foreach($talks as $item){
                $talk = Talk::findOrFail($item->id);

                $talk->delete();
                deleteFile($talk->image);
            }

            $message = array('message' => 'Charlas Eliminadas Exitosamente', 'title' => 'Columnas Eliminadas');
            return response()->json($message);

        } catch(\Exception $e){
            return redirect()->route('talks.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'danger',
                    'message' => 'Ha ocurrido un error: '.$e
                ]
            ]);
        }

    }

    private function prepareRequest(Request $request, $talk)
    {
        $request->request->remove('image_remove');

        return $request;
    }
}