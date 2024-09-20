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

use App\Models\News;
use App\Models\Category;

class NewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = News::with(['category']);
            
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

            $news = ($request->length == -1) ? $query->paginate( $query->count() ) : $query->paginate($request->length);
            $news->append(['popular_label']);

            return response()->json($news, 200);
        }

        $categories = Category::forDropdown(3); 
        
        return view('admin.cruds.news.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::forDropdown(3);  
        
        return view('admin.cruds.news.create', 
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

        $new = new News;
        $new->fill($request->except(['image']));
        $new->save();

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $path = 'news/';

            $file_data = uploadFile($image, $path);

            $new->image = $file_data['filePath'];
            $new->save();
        }


        return redirect()->route('news.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Noticia creada exitosamente'
            ]
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $new
     * @return \Illuminate\Http\Response
     */
    public function show(News $new)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $new
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $new = News::where('id', $id)->first();
        $categories = Category::forDropdown(3);  

        if (!$new)
            return redirect()->route('news.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la Noticia'
                ]
            ]);

        return view('admin.cruds.news.edit', compact('new', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $new
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $new = News::find($id);

        if (!$new)
            return redirect()->route('news.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró la Noticia'
                ]
            ]);

        $request = $this->prepareRequest($request, $new);
        $new->fill($request->except(['image']));
        $new->update();

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $path = 'news/';

            $file_data = uploadFile($image, $path, $new->image);

            $new->image = $file_data['filePath'];
            $new->update();
        }

        return redirect()->route('news.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                 'message' => 'Noticia actualizada exitosamente'
               ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $new
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $new = News::find($id);
        
        if (!$new)
            return redirect()->route('news.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el Noticia'
                ]
            ]);

        $new->delete();
        deleteFile($new->image);

        return redirect()->route('news.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'warning',
                'message' => 'Noticia eliminada'
            ]
        ]);
    }

    public function deleteNews(Request $request)
    {
        try{
            $news = News::whereIn('id', $request->ids)->get();
            
            foreach($news as $item){
                $new = News::findOrFail($item->id);

                $new->delete();
                deleteFile($new->image);
            }

            $message = array('message' => 'Noticias Eliminadas Exitosamente', 'title' => 'Columnas Eliminadas');
            return response()->json($message);

        } catch(\Exception $e){
            return redirect()->route('news.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'danger',
                    'message' => 'Ha ocurrido un error: '.$e
                ]
            ]);
        }

    }

    private function prepareRequest(Request $request, $new)
    {
        $popular = ($request->popular == "on") ? 1 : 0;

        $request->request->add(['is_popular' => $popular]);

        $request->request->remove('popular');
        $request->request->remove('image_remove');

        return $request;
    }
}