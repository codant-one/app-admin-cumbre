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

use App\Models\Place;
use App\Models\PlaceImage;
use App\Models\Category;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Place::with(['category']);
            
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

            $places = ($request->length == -1) ? $query->paginate( $query->count() ) : $query->paginate($request->length);
            $places->append(['popular_label']);

            return response()->json($places, 200);
        }

        $categories = Category::forDropdown(2); 
        
        return view('admin.cruds.places.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::forDropdown(2);  
        
        return view('admin.cruds.places.create', 
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

        $place = new Place;
        $place->fill($request->except(['image','images']));
        $place->save();

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $path = 'places/';

            $file_data = uploadFile($image, $path);

            $place->image = $file_data['filePath'];
            $place->save();
        }

        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach($images as $image) {
                $path = 'places/';
                $place_image = new PlaceImage;
                $place_image->place_id = $place->id;

                $file_data = uploadFile($image, $path);

                $place_image->image = $file_data['filePath'];
                $place_image->save();
            }
        }

        if ($request->hasFile('images'))
            return response()->json([
                'success' => true,
                'message' => 'Lugar creado exitosamente',
                'redirect' => route('places.index')
            ]);
        else 
            return redirect()->route('places.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'success',
                    'message' => 'Lugar creado exitosamente'
                ]
            ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $place = Place::with(['images'])->where('id', $id)->first();
        $categories = Category::forDropdown(2);  

        if (!$place)
            return redirect()->route('places.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el Lugar'
                ]
            ]);

        $images = $place->images->map(function($image) {
            return [
                'filename' => $image->image,
                'url' => asset('storage/' . $image->image)  // Generar URL correcta
            ];
        });

        return view('admin.cruds.places.edit', compact('place', 'images', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $place = Place::with(['images'])->find($id);

        if (!$place)
            return redirect()->route('places.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el lugar'
                ]
            ]);

        $request = $this->prepareRequest($request, $place);
        $place->fill($request->except(['image','images']));
        $place->update();

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $path = 'places/';

            $file_data = uploadFile($image, $path, $place->image);

            $place->image = $file_data['filePath'];
            $place->update();
        }

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $place->images()->delete();

            foreach ($place->images as $image) {
                deleteFile($image->image);  // Elimina el archivo del almacenamiento
            }

            foreach($images as $image) {
                $path = 'places/';
                $place_image = new PlaceImage;
                $place_image->place_id = $place->id;

                $file_data = uploadFile($image, $path);

                $place_image->image = $file_data['filePath'];
                $place_image->save();
            }
        }

        if ($request->hasFile('images'))
            return response()->json([
                'success' => true,
                'message' => 'Lugar actualizado exitosamente',
                'redirect' => route('places.index')
            ]);
        else 
            return redirect()->route('places.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'success',
                    'message' => 'Lugar actualizado exitosamente'
                ]
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $place = Place::with(['images'])->find($id);
        
        if (!$place)
            return redirect()->route('places.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la lugar'
                ]
            ]);

        $place->delete();
        deleteFile($place->image);

        $place->images()->delete();
        foreach ($place->images as $image) {
            deleteFile($image->image);
        }

        return redirect()->route('places.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'warning',
                'message' => 'Lugar eliminado'
            ]
        ]);
    }

    public function deletePlaces(Request $request)
    {
        try{
            $places = Place::whereIn('id', $request->ids)->get();
            
            foreach($places as $item){
                $place = Place::with(['images'])->findOrFail($item->id);

                $place->delete();
                deleteFile($place->image);

                $place->images()->delete();
                foreach ($place->images as $image) {
                    deleteFile($image->image);
                }
            }

            $message = array('message' => 'Lugares Eliminados Exitosamente', 'title' => 'Columnas Eliminadas');
            return response()->json($message);

        } catch(\Exception $e){
            return redirect()->route('places.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'danger',
                    'message' => 'Ha ocurrido un error: '.$e
                ]
            ]);
        }

    }

    private function prepareRequest(Request $request, $place)
    {
        $popular = ($request->popular == "on") ? 1 : 0;

        $request->request->add(['is_popular' => $popular]);

        $request->request->remove('popular');
        $request->request->remove('image_remove');

        return $request;
    }
}