<?php

namespace App\Http\Controllers;
use App\Category;
use App\Discount;
use App\Http\Requests\PostRequest;
use App\Page;
use App\Post;
use App\Role;
use App\Type;
use App\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //Dashboard
    public function dashboard(Request $request)
    {
        return view('adminPage.dashboard');
    }
    //Category
    public function category()
    {
        $modify = 0;
        $categories = Category::all();
        return view('adminPage.category' , ['categories' => $categories , 'modify' => $modify]);
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
        return view('adminPage.category' , ['categories' => $categories , 'modify' => $modify]);
    }
    //pass to edit
    public function editCat(Category $category)
    {
        $modify = 1;
        $categories = Category::all();
        return view('adminPage.category' , ['category' => $category , 'categories' => $categories , 'modify' => $modify]);
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
        return view('adminPage.post', ['categories' => $categories, 'discounts' => $discounts, 'modify' => $modify]);
    }
    //Add post
    public function addPost(Request $request)
    {
        $file = $request->file('image');
        $name = time() . '-' . $file->getClientOriginalName();
        $file->move('photos', $name);
        $path = "/photos/" . $name;
        if (isset($_POST['draft'])) {
            Post::create(['category_id' => $request->cat, 'discount_id' => $request->discount, 'title' => $request->title, 'price' => $request->price, 'photo' => $path, 'quantity' => $request->quantity, 'detail' => $request->detail, 'published' => '0']);
        }elseif (isset($_POST['publish'])){
            Post::create(['category_id' => $request->cat, 'discount_id' => $request->discount, 'title' => $request->title, 'price' => $request->price, 'photo' => $path, 'quantity' => $request->quantity, 'detail' => $request->detail, 'published' => '1']);
        }
        return back();
    }
    //Show post list = managment post
    public function postList()
    {
        $posts = Post::paginate(10);
        return view('adminPage.post-list', ['posts' => $posts]);
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
        return view('adminPage.post', ['post' => $post,'categories' => $categories, 'discounts' => $discounts, 'modify' => $modify]);
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
            if (isset($_POST['draft'])) {
                $post->update(['discount_id' => $request->discount, 'category_id' => $request->cat, 'title' => $request->title, 'price' => $request->price, 'quantity' => $request->quantity, 'photo' => $path, 'detail' => $request->detail, 'published' => '0']);
            }elseif(isset($_POST['publish'])){
                $post->update(['discount_id' => $request->discount, 'category_id' => $request->cat, 'title' => $request->title, 'price' => $request->price, 'quantity' => $request->quantity, 'photo' => $path, 'detail' => $request->detail, 'published' => '1']);
            }
            return redirect()->back();
        }
    }

    //Page
    public function page()
    {
        $modify = 0;
        $typs = Type::all();
        return view('adminPage.page' , ['types' => $typs , 'modify' => $modify]);
    }
    //Add page
    public function addPage()
    {
        if (isset($_POST['draft'])){
            Page::create(['type_id' => $_POST['type'] ,'title' => $_POST['title'] , 'body' => $_POST['ckeditor1'] , 'published' => '0' ]);
        }elseif (isset($_POST['publish'])){
            Page::create(['type_id' => $_POST['type'] ,'title' => $_POST['title'] , 'body' => $_POST['ckeditor1'] , 'published' => '1' ]);
        }
        return redirect()->back();
    }
    //Show page list = managment page
    public function pageList()
    {
        $pages = Page::paginate(10);
        return view('adminPage.page-list', ['pages' => $pages]);
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
        return view('adminPage.page', ['page' => $page , 'types' => $types , 'modify' => $modify]);
    }
    //Update page
    public function updatePage(Page $page , Request $request)
    {
        if (isset($_POST['draft'])){
            $page->update(['type_id' => $request->type , 'title' => $request->title , 'body' => $request->ckeditor , 'published' => '0']);
        }elseif (isset($_POST['publish'])){
            $page->update(['type_id' => $request->type , 'title' => $request->title , 'body' => $request->ckeditor , 'published' => '1']);
        }
        return redirect()->back();
    }
    //User
    public function userList()
    {
        $users = User::with('role')->get();
        return view('adminPage.user-list' , ['users' => $users]);
    }
    //Active or deActive user
    public function statusUser(User $user)
    {
        if (isset($_POST['deActive'])){
            $user->update(['status' => '0']);
        }
        elseif (isset($_POST['active'])){
            $user->update(['status' => '1']);
        }
        return redirect()->back();
    }

    //Remove User
    public function removeUser(User $user)
    {
        $user->delete();
        return redirect()->back();
    }
    //Show Add user Page
    public function user()
    {
        $modify = 0;
        $roles = Role::all();
        return view('adminPage.user' , ['roles' => $roles , 'modify' => $modify]);
    }
    //Add User
    public function addUser(Request $request)
    {
        $this->validate(request(),
            [
                'fname' => 'required',
                'lname' => 'required',
                'phone' => 'required',
                'national_code' => 'required',
                'username' => 'required',
                'password' => 'required|confirmed'
            ]);

        $hashedPassword = Hash::make(request('password'));
        User::create([
            'role_id' => $request->role ,
            'profile_id' => 1 ,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'phone' => $request->phone,
            'national_code' => $request->national_code,
            'username' => $request->username,
            'password' => $hashedPassword,
            'status' => '0',
        ]);

        return redirect()->back();
    }

    //Pass to edit
    public function editUser(User $user)
    {
        $modify = 1;
        $roles = Role::all();
        return view('adminPage.user', ['user' => $user , 'roles' => $roles , 'modify' => $modify]);
    }

    //Update User
    public function updateUser(User $user , Request $request)
    {
        $this->validate(request(),
            [
                'fname' => 'required',
                'lname' => 'required',
                'phone' => 'required',
                'national_code' => 'required',
                'username' => 'required',
                'password' => 'required|confirmed'
            ]);

        $hashedPassword = Hash::make(request('password'));
        $user->update([
            'role_id' => $request->role ,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'phone' => $request->phone,
            'national_code' => $request->national_code,
            'username' => $request->username,
            'password' => $hashedPassword,
            'status' => '0',
        ]);
        return redirect()->back();
    }
    //Show Promote Page
    public function promote()
    {
        $roles = Role::all();
        return view('adminPage.promote' , ['roles' => $roles]);
    }
    //Add Role
    public function addRole()
    {
        Role::create(['role' => $_POST['role']]);
        return redirect()->back();
    }
    //Copy Role
    public function copyRole()
    {
        $role = Role::where('id' , $_POST['roleCopy'])->first();
        Role::create(['role' => $_POST['roleNew'],
                    'edit_other_posts' => $role['edit_other_posts'],
                    'del_other_posts' => $role['del_other_posts'],
                    'edit_posts'  => $role['edit_posts'],
                    'del_posts' => $role['del_posts'],
                    'edit_publish_posts' => $role['edit_publish_posts'],
                    'del_publish_posts' => $role['del_publish_posts'],
                    'edit_other_pages' => $role['edit_other_pages'],
                    'del_other_pages' => $role['del_other_pages'],
                    'edit_pages' => $role['edit_pages'],
                    'del_pages' => $role['del_pages'],
                    'edit_publish_pages' => $role['edit_publish_pages'],
                    'del_publish_pages' => $role['del_publish_pages'],
                    'publish_posts' => $role['publish_posts'],
                    'publish_pages' => $role['publish_pages'],
                    'manage_category' => $role['manage_category'],
                    'create_user' => $role['create_user'],
                    'edit_user' => $role['edit_user'],
                    'del_user' => $role['del_user'],
                    'promote_user' => $role['promote_user'],
                    'list_user' => $role['list_user']
            ]);
        return redirect()->back();
    }
    //Loading Role
    public function loadingRole(Role $role)
    {
        $permission = Role::where('id' , $_GET['role'])->first();
        //return $permission;
        return view('adminPage.customize' , [ 'permission' => $permission]);
    }
    //Save Permissions = Customize Role
    public function savePermissions(Role $role)
    {
        (! (isset($_POST['edit_other_posts']))? $_POST['edit_other_posts']=0 : $_POST['edit_other_posts']=1 );
        (! (isset($_POST['del_other_posts']))? $_POST['del_other_posts']=0 : $_POST['del_other_posts']=1 );
        (! (isset($_POST['edit_posts']))? $_POST['edit_posts']=0 : $_POST['edit_posts']=1);
        (! (isset($_POST['del_posts']))? $_POST['del_posts']=0 : $_POST['del_posts']=1);
        (! (isset($_POST['edit_publish_posts']))? $_POST['edit_publish_posts']=0 : $_POST['edit_publish_posts']=1);
        (! (isset($_POST['del_publish_posts']))? $_POST['del_publish_posts']=0 : $_POST['del_publish_posts']=1);
        (! (isset($_POST['edit_other_pages']))? $_POST['edit_other_pages']=0 : $_POST['edit_other_pages']=1);
        (! (isset($_POST['del_other_pages']))? $_POST['del_other_pages']=0 : $_POST['del_other_pages']=1);
        (! (isset($_POST['edit_pages']))? $_POST['edit_pages']=0 : $_POST['edit_pages']=1);
        (! (isset($_POST['del_pages']))? $_POST['del_pages']=0 : $_POST['del_pages']=1);
        (! (isset($_POST['edit_publish_pages']))? $_POST['edit_publish_pages']=0 : $_POST['edit_publish_pages']=1);
        (! (isset($_POST['del_publish_pages']))? $_POST['del_publish_pages']=0 : $_POST['del_publish_pages']=1);
        (! (isset($_POST['publish_posts']))? $_POST['publish_posts']=0 : $_POST['publish_posts']=1);
        (! (isset($_POST['publish_pages']))? $_POST['publish_pages']=0 : $_POST['publish_pages']=1);
        (! (isset($_POST['manage_category']))? $_POST['manage_category']=0 : $_POST['manage_category']=1);
        (! (isset($_POST['create_user']))? $_POST['create_user']=0 : $_POST['create_user']=1);
        (! (isset($_POST['edit_user']))? $_POST['edit_user']=0 : $_POST['edit_user']=1);
        (! (isset($_POST['del_user']))? $_POST['del_user']=0 : $_POST['del_user']=1);
        (! (isset($_POST['promote_user']))? $_POST['promote_user']=0 : $_POST['promote_user']=1);
        (! (isset($_POST['list_user']))? $_POST['list_user']=0 : $_POST['list_user']=1);
        $role->update([
            'role' => $_POST['nameRole'],
            'edit_other_posts' => $_POST['edit_other_posts'],
            'del_other_posts' => $_POST['del_other_posts'],
            'edit_posts'  => $_POST['edit_posts'],
            'del_posts' => $_POST['del_posts'],
            'edit_publish_posts' => $_POST['edit_publish_posts'],
            'del_publish_posts' => $_POST['del_publish_posts'],
            'edit_other_pages' => $_POST['edit_other_pages'],
            'del_other_pages' => $_POST['del_other_pages'],
            'edit_pages' => $_POST['edit_pages'],
            'del_pages' => $_POST['del_pages'],
            'edit_publish_pages' => $_POST['edit_publish_pages'],
            'del_publish_pages' => $_POST['del_publish_pages'],
            'publish_posts' => $_POST['publish_posts'],
            'publish_pages' => $_POST['publish_pages'],
            'manage_category' => $_POST['manage_category'],
            'create_user' => $_POST['create_user'],
            'edit_user' => $_POST['edit_user'],
            'del_user' => $_POST['del_user'],
            'promote_user' => $_POST['promote_user'],
            'list_user' => $_POST['list_user']
        ]);
        return redirect()->back();
    }
}
