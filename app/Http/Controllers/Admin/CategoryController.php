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

use App\Models\Category;
use App\Models\CategoryType;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Category::with(['category_type']);
            
            foreach ($request->input('order') as $order) {
                $query->orderBy($order['column_name'], $order['dir']);
            }

            foreach ($request->input('columns') as $key => $column) {
                if (!$request->filled("columns.$key.search.value")) continue;

                $column_name = $request->input("columns.$key.data");
                $search_value = $request->input("columns.$key.search.value");
                $date_columns = ['created_at'];

                if ($column_name == 'type_label') { 
                    $query->whereHas('category_type', function ($q) use ($search_value) {
                        $q->where('id', $search_value);
                    });
                } elseif (!in_array($column_name, $date_columns)) {
                    $query->where($column_name, 'LIKE', "%$search_value%");
                } elseif (in_array($column_name, $date_columns)) {
                    $query->whereDate($column_name, Carbon::parse($search_value)->format('Y-m-d'));
                }
            }

            $categories = ($request->length == -1) ? $query->paginate( $query->count() ) : $query->paginate($request->length);
            $categories->append(['type_label']);

            return response()->json($categories, 200);
        }

        $category_types = CategoryType::forDropdown(); 
        
        return view('admin.cruds.categories.index', compact('category_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category_types = CategoryType::forDropdown();  
        
        return view('admin.cruds.categories.create', 
            compact(
                'category_types'
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
        $category = new Category;
        $category->fill($request->all());
        $category->save();

        return redirect()->route('categories.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Categoría creada exitosamente'
            ]
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::where('id', $id)->first();
        $category_types = CategoryType::forDropdown();  

        if (!$category)
            return redirect()->route('categories.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la categoría'
                ]
            ]);

        return view('admin.cruds.categories.edit', compact('category', 'category_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category)
            return redirect()->route('categories.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la categoría'
                ]
            ]);

        $category->fill($request->all());
        $category->update();

        return redirect()->route('categories.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                 'message' => 'Categoría actualizada exitosamente'
               ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        
        if (!$category)
            return redirect()->route('categories.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la categoría'
                ]
            ]);

        $category->delete();

        return redirect()->route('categories.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'warning',
                'message' => 'Categoría eliminada'
            ]
        ]);
    }

    public function deleteCategories(Request $request)
    {
        try{
            $categories = Category::whereIn('id', $request->ids)->get();
            
            foreach($categories as $item){
                $category = Category::findOrFail($item->id);
                $category->delete();
            }

            $message = array('message' => 'Categorías Eliminadas Exitosamente', 'title' => 'Columnas Eliminadas');
            return response()->json($message);

        } catch(\Exception $e){
            return redirect()->route('categories.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'danger',
                    'message' => 'Ha ocurrido un error: '.$e
                ]
            ]);
        }

    }
}