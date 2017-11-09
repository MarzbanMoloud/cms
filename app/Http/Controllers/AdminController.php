<?php

namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function category()
    {
        $modify = 0;
        $categories = Category::all();
        return view('admin.category' , ['categories' => $categories , 'modify' => $modify]);
    }

    public function addCat(Request $request)
    {
        $modify = 0;
        $this->validate(request(),
            [
                'cat' => 'required|min:3',
            ]);
        Category::create(['catName' => $request->cat]);
        $categories = Category::all();
        return view('admin.category' , ['categories' => $categories , 'modify' => $modify]);
    }

    public function editCat(Category $category)
    {
        $modify = 1;
        $categories = Category::all();
        return view('admin.category' , ['category' => $category , 'categories' => $categories , 'modify' => $modify]);
    }

    public function updateCat(Category $category , Request $request)
    {
        $this->validate(request(),
            [
                'cat' => 'required|min:3',
            ]);
        $category->update(['catName' => $request->cat]);
        return redirect()->back();
    }

    public function deleteCat(Category $category)
    {
        $category->delete();
        return redirect()->back();
    }
}
