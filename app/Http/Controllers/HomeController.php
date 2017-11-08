<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::all()->paginate(8);
        return view('index' , ['categories' => $categories , 'products' => $products]);
    }

}
