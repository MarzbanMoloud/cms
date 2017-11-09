<?php

namespace App\Http\Controllers;
use App\Category;
use App\Discount;
use App\Http\Requests\ProductRequest;
use App\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //Category
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

    //Post
    public function post()
    {
        $categories = Category::all();
        $discounts = Discount::all();
        $modify = 0;
        return view('admin.product', ['categories' => $categories, 'discounts' => $discounts, 'modify' => $modify]);
    }

    public function addPost(ProductRequest $request)
    {
        $file = $request->file('image');
        $name = time() . '-' . $file->getClientOriginalName();
        $file->move('photos', $name);
        $path = "/photos/" . $name;
        Product::create(['category_id' => $request->cat , 'discount_id' => $request->discount, 'title' => $request->title, 'price' => $request->price,'photo' => $path, 'quantity' => $request->quantity, 'detail' => $request->detail]);
        return back();
    }
}
