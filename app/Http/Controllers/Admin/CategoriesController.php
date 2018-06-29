<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index');
    }

    public function edit($id)
    {
        $category =Category::find($id);
        return view('admin.categories.edit', ['category' =>$category]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'=>'required'
        ]);
        $category = Category::find($id); //достаём категорию по id
        $category->update($request->all()); //обнавляем выбранную категорию на значения из формы
        //dd($request->all(), $id);
        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        Category::find($id)->delete(); //достаём категорию по id
        return redirect()->route('categories.index');
    }

}
