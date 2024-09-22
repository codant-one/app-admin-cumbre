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

use App\Models\Schedule;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Schedule::query();
            
            foreach ($request->input('order') as $order) {
                $query->orderBy($order['column_name'], $order['dir']);
            }

            foreach ($request->input('columns') as $key => $column) {
                if (!$request->filled("columns.$key.search.value")) continue;

                $column_name = $request->input("columns.$key.data");
                $search_value = $request->input("columns.$key.search.value");
                $date_columns = ['created_at'];

                if (!in_array($column_name, $date_columns)) {
                    $query->where($column_name, 'LIKE', "%$search_value%");
                } elseif (in_array($column_name, $date_columns)) {
                    $query->whereDate($column_name, Carbon::parse($search_value)->format('Y-m-d'));
                }
            }

            $schedules = ($request->length == -1) ? $query->paginate( $query->count() ) : $query->paginate($request->length);

            return response()->json($schedules, 200);
        }
        
        return view('admin.cruds.schedules.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cruds.schedules.create');
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

        $schedule = new Schedule;
        $schedule->fill($request->except(['image']));
        $schedule->save();

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $path = 'schedules/';

            $file_data = uploadFile($image, $path);

            $schedule->image = $file_data['filePath'];
            $schedule->save();
        }

        return redirect()->route('schedules.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Agenda creada exitosamente'
            ]
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedule = Schedule::where('id', $id)->first();

        if (!$schedule)
            return redirect()->route('schedules.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la agenda'
                ]
            ]);

        return view('admin.cruds.schedules.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule)
            return redirect()->route('schedules.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la agenda'
                ]
            ]);

        $request = $this->prepareRequest($request, $schedule);
        $schedule->fill($request->except(['image']));
        $schedule->update();

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $path = 'schedules/';

            $file_data = uploadFile($image, $path, $schedule->image);

            $schedule->image = $file_data['filePath'];
            $schedule->update();
        }

        return redirect()->route('schedules.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                 'message' => 'Agenda actualizada exitosamente'
               ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedule = Schedule::find($id);
        
        if (!$schedule)
            return redirect()->route('schedules.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la agenda'
                ]
            ]);

        $schedule->delete();
        deleteFile($schedule->image);

        return redirect()->route('schedules.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'warning',
                'message' => 'Agenda eliminada'
            ]
        ]);
    }

    public function deleteSchedules(Request $request)
    {
        try{
            $schedules = Schedule::whereIn('id', $request->ids)->get();
            
            foreach($schedules as $item){
                $schedule = Schedule::findOrFail($item->id);

                $schedule->delete();
                deleteFile($schedule->image);
            }

            $message = array('message' => 'Agendas Eliminadas Exitosamente', 'title' => 'Columnas Eliminadas');
            return response()->json($message);

        } catch(\Exception $e){
            return redirect()->route('schedules.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'danger',
                    'message' => 'Ha ocurrido un error: '.$e
                ]
            ]);
        }

    }

    private function prepareRequest(Request $request, $schedule)
    {
        $request->request->remove('image_remove');

        return $request;
    }
}