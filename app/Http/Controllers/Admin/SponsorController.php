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

use App\Models\Sponsor;
use App\Models\Category;

class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Sponsor::with(['category'])->orderByRaw('order_id IS NULL, order_id ASC');
            
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
                } elseif ($column_name == 'popular_label') { 
                    $query->where('is_popular', $search_value);
                } elseif (!in_array($column_name, $date_columns)) {
                    $query->where($column_name, 'LIKE', "%$search_value%");
                } elseif (in_array($column_name, $date_columns)) {
                    $query->whereDate($column_name, Carbon::parse($search_value)->format('Y-m-d'));
                }
            }

            $sponsors = ($request->length == -1) ? $query->paginate( $query->count() ) : $query->paginate($request->length);

            return response()->json($sponsors, 200);
        }

        $categories = Category::forDropdown(1); 
        
        return view('admin.cruds.sponsors.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::forDropdown(1);  
        
        return view('admin.cruds.sponsors.create', 
            compact(
                'categories'
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

        $sponsor = new Sponsor;
        $sponsor->fill($request->except(['logo']));
        $sponsor->save();

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');

            $path = 'sponsors/';

            $file_data = uploadFile($logo, $path);

            $sponsor->logo = $file_data['filePath'];
            $sponsor->save();
        }

        return redirect()->route('sponsors.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Patrocinador creado exitosamente'
            ]
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function show(Sponsor $sponsor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sponsor = Sponsor::where('id', $id)->first();
        $categories = Category::forDropdown(1);  

        if (!$sponsor)
            return redirect()->route('sponsors.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el patrocinador'
                ]
            ]);

        return view('admin.cruds.sponsors.edit', compact('sponsor', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sponsor = Sponsor::find($id);

        if (!$sponsor)
            return redirect()->route('sponsors.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el patrocinador'
                ]
            ]);

        $request = $this->prepareRequest($request, $sponsor);
        $sponsor->fill($request->except(['logo']));
        $sponsor->update();

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');

            $path = 'sponsors/';

            $file_data = uploadFile($logo, $path, $sponsor->logo);

            $sponsor->logo = $file_data['filePath'];
            $sponsor->update();
        }

        return redirect()->route('sponsors.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Patrocinador actualizado exitosamente'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sponsor = Sponsor::find($id);
        
        if (!$sponsor)
            return redirect()->route('sponsors.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el patrocinador'
                ]
            ]);

        $sponsor->delete();
        deleteFile($sponsor->logo);

        return redirect()->route('sponsors.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'warning',
                'message' => 'Patrocinador eliminado'
            ]
        ]);
    }

    public function deleteSponsors(Request $request)
    {
        try{
            $sponsors = Sponsor::whereIn('id', $request->ids)->get();
            
            foreach($sponsors as $item){
                $sponsor = Sponsor::findOrFail($item->id);

                $sponsor->delete();
                deleteFile($sponsor->logo);
            }

            $message = array('message' => 'Patrocinadores Eliminados Exitosamente', 'title' => 'Columnas Eliminadas');
            return response()->json($message);

        } catch(\Exception $e){
            return redirect()->route('sponsors.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'danger',
                    'message' => 'Ha ocurrido un error: '.$e
                ]
            ]);
        }

    }

    private function prepareRequest(Request $request, $sponsor)
    {
        $request->request->remove('logo_remove');

        return $request;
    }
}