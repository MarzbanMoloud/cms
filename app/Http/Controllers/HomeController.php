<?php

namespace App\Http\Controllers;

use App\Category;
use App\Page;
use App\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //show home page
    public function index()
    {
        $categories = Category::all();
        $products = Post::paginate(9);
        return view('index' , ['categories' => $categories , 'products' => $products]);
    }

    //show contact us page
    public function contactUs()
    {
        $pages = Page::all();
        return view('contactUs');
    }

    //show user page
    public function showPage($title)
    {
        $page = Page::where('title' , $title)->first();
        if($page['type_id'] == 1){
            $userpage =true;
            $categories = Category::all();
            return view('index' , ['page' => $page , 'userpage' => $userpage , 'categories' => $categories]);
        }
        elseif ($page['type_id'] == 2){
            return view('aboutUs' ,['page' => $page]);
        }
    }

}
