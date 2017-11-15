<?php

namespace App\Http\Controllers;
use App\Category;
use App\Discount;
use App\Http\Requests\PostRequest;
use App\Page;
use App\Post;
use App\Type;
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
    //Add category
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
    //pass to edit
    public function editCat(Category $category)
    {
        $modify = 1;
        $categories = Category::all();
        return view('admin.category' , ['category' => $category , 'categories' => $categories , 'modify' => $modify]);
    }
    //update category
    public function updateCat(Category $category , Request $request)
    {
        $this->validate(request(),
            [
                'cat' => 'required|min:3',
            ]);
        $category->update(['catName' => $request->cat]);
        return redirect()->back();
    }
    //delete category
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
        return view('admin.post', ['categories' => $categories, 'discounts' => $discounts, 'modify' => $modify]);
    }
    //Add post
    public function addPost(PostRequest $request)
    {
        $file = $request->file('image');
        $name = time() . '-' . $file->getClientOriginalName();
        $file->move('photos', $name);
        $path = "/photos/" . $name;
        Post::create(['category_id' => $request->cat , 'discount_id' => $request->discount, 'title' => $request->title, 'price' => $request->price,'photo' => $path, 'quantity' => $request->quantity, 'detail' => $request->detail]);
        return back();
    }
    //Show post list = managment post
    public function postList()
    {
        $posts = Post::paginate(10);
        return view('admin.post-list', ['posts' => $posts]);
    }
    //Delete post
    public function deletePost(Post $post)
    {
        $post->delete();
        return redirect()->back();
    }
    //Pass to edit
    public function editPost(Post $post)
    {
        $modify = 1;
        $categories = Category::all();
        $discounts = Discount::all();
        return view('admin.post', ['post' => $post,'categories' => $categories, 'discounts' => $discounts, 'modify' => $modify]);
    }
    //Update post
    public function updatePost(Post $post , Request $request)
    {
        if ($request->hasFile('image'))
        {
            if (is_file($post->photo))
            {
                unlink(public_path() . '/' . $post->photo);
            }
            $file = $request->file('image');
            $name = time() . '-' . $file->getClientOriginalName();
            $file->move('photos', $name);
            $path = "/photos/" . $name;
            $post->update(['discount_id' => $request->discount, 'category_id' => $request->cat, 'title' => $request->title, 'price' => $request->price, 'quantity' => $request->quantity, 'photo' => $path, 'detail' => $request->detail]);
            return redirect()->back();
        }
    }

    //Page
    public function page()
    {
        $modify = 0;
        $typs = Type::all();
        return view('admin.page' , ['types' => $typs , 'modify' => $modify]);
    }
    //Add page
    public function addPage()
    {
        Page::create(['type_id' => $_POST['type'] ,'title' => $_POST['title'] , 'body' => $_POST['ckeditor'] ]);
        return redirect()->back();
    }
    //Show page list = managment page
    public function pageList()
    {
        $pages = Page::paginate(10);
        return view('admin.page-list', ['pages' => $pages]);
    }
    //Delete page
    public function deletePage(Page $page)
    {
        $page->delete();
        return redirect()->back();
    }
    //Pass to edit
    public function editPage(Page $page)
    {
        $modify = 1;
        $types = Type::all();
        return view('admin.page', ['page' => $page , 'types' => $types , 'modify' => $modify]);
    }
    //Update page
    public function updatePage(Page $page , Request $request)
    {
        $page->update(['type_id' => $request->type , 'title' => $request->title , 'body' => $request->ckeditor]);
        return redirect()->back();
    }
}
