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

    public function postList()
    {
        $products = Product::paginate(10);
        return view('admin.product-list', ['products' => $products]);
    }

    public function deletePost(Product $product)
    {
        $product->delete();
        return redirect()->back();
    }

    public function editPost(Product $product)
    {
        $modify = 1;
        $categories = Category::all();
        $discounts = Discount::all();
        return view('admin.product', ['product' => $product,'categories' => $categories, 'discounts' => $discounts, 'modify' => $modify]);
    }

    public function updatePost(Product $product , Request $request)
    {
        if ($request->hasFile('image')) {
            if (is_file($product->photo)) {
                unlink(public_path() . '/' . $product->photo);
            }
            $file = $request->file('image');
            $name = time() . '-' . $file->getClientOriginalName();
            $file->move('photos', $name);
            $path = "/photos/" . $name;
            $product->update(['discount_id' => $request->discount, 'category_id' => $request->cat, 'title' => $request->title, 'price' => $request->price, 'quantity' => $request->quantity, 'photo' => $path, 'detail' => $request->detail]);
            return redirect()->back();
        }
    }
}
