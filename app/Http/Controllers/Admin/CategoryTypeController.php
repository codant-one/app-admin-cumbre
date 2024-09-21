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

use App\Models\CategoryType;

class CategoryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = CategoryType::query();
            
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

            $category_types = ($request->length == -1) ? $query->paginate( $query->count() ) : $query->paginate($request->length);

            return response()->json($category_types, 200);
        }
        
        return view('admin.cruds.category_types.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        return view('admin.cruds.category_types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category_type = new CategoryType;
        $category_type->fill($request->all());
        $category_type->save();

        return redirect()->route('category-types.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Tipo de categoría creada exitosamente'
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryType  $category_type
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryType $category_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryType  $new
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category_type = CategoryType::where('id', $id)->first();

        if (!$category_type)
            return redirect()->route('category-types.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el tipo de categoría'
                ]
            ]);

        return view('admin.cruds.category_types.edit', compact('category_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoryType  $category_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category_type = CategoryType::find($id);

        if (!$category_type)
            return redirect()->route('category-types.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el tipo de categoría'
                ]
            ]);

        $category_type->fill($request->all());
        $category_type->update();

        return redirect()->route('category-types.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                 'message' => 'Tipo de categoría actualizada exitosamente'
               ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryType  $category_type
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category_type = CategoryType::find($id);
        
        if (!$category_type)
            return redirect()->route('category-types.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el tipo de categoría'
                ]
            ]);

        $category_type->delete();

        return redirect()->route('category-types.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'warning',
                'message' => 'Tipo de categoría eliminada'
            ]
        ]);
    }

    public function deleteCategoryTypes(Request $request)
    {
        try{
            $category_types = CategoryType::whereIn('id', $request->ids)->get();
            
            foreach($category_types as $item){
                $category_type = CategoryType::findOrFail($item->id);
                $category_type->delete();
            }

            $message = array('message' => 'Tipo de Categorías Eliminadas Exitosamente', 'title' => 'Columnas Eliminadas');
            return response()->json($message);

        } catch(\Exception $e){
            return redirect()->route('category-types.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'danger',
                    'message' => 'Ha ocurrido un error: '.$e
                ]
            ]);
        }

    }
}