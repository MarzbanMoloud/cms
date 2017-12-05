<?php

namespace App\Http\Controllers;
use App\Category;
use App\Discount;
use App\Page;
use App\Post;
use App\Profile;
use App\Role;
use App\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Traits\Permission;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    //Get Permission of Login_user
    use Permission;

    //Dashboard
    public function dashboard(Request $request)
    {
        return view('adminPage.dashboard');
    }
    //Show Add Update category
    public function category(Category $category = null  , Request $request)
    {
        if(Auth::user()->role->manage_category==1) {
            $msg = '';
            if ($request->isMethod('post')) {
                $this->validate(request(),
                    [
                        'cat' => 'required|min:3|max:25',
                    ]);
                if ($category->id) {
                    $category->update(['catName' => $request->cat]);
                    $msg = 'ویرایش با موفقیت انجام شد ';
                } else {
                    Category::create(['catName' => $request->cat]);
                    $msg = 'دسته بندی با موفقیت ثبت شد';
                }
            }
            $categories = Category::all();
            return view('adminPage.category', ['category' => $category, 'categories' => $categories, 'msg' => $msg]);
        }
        else{
            return view('403');
        }
    }
    //delete category
    public function deleteCat(Category $category)
    {
        $category->delete();
        $msg = 'حذف با موفقیت انجام شد ';
        return redirect()->back()->with(compact('msg'));
    }
    //Show Add Update Post
    public function post(Post $post = null  , Request $request)
    {
        $msg = '';
        $permission = $this->permissionsLoginUser();
        $publish_posts = $permission['role']['publish_posts'];
        $categories = Category::pluck( 'catName' , 'id');
        $discounts = Discount::pluck( 'discountPercent', 'id');
        if ($request->isMethod('post')){
            $this->validate(request(),
                [
                    'title' => 'required|min:3|max:25',
                    'price' => 'required',
                    'quantity' => 'required',
                    'detail' => 'required',
                ]);
            if ($post->id){
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
                        $post->update([ 'discount_id' => $request->discount, 'category_id' => $request->cat, 'title' => $request->title, 'price' => $request->price, 'quantity' => $request->quantity, 'photo' => $path, 'detail' => $request->detail, 'published' => '0']);
                        $msg = 'پست ویرایش و به عنوان پیش نویس ثبت شد';
                    }elseif(isset($_POST['publish'])){
                        $post->update(['discount_id' => $request->discount, 'category_id' => $request->cat, 'title' => $request->title, 'price' => $request->price, 'quantity' => $request->quantity, 'photo' => $path, 'detail' => $request->detail, 'published' => '1']);
                        $msg = 'پست ویرایش و منتشر شد';
                    }
                }
            }else{
                $id = \Session::get('id');
                $file = $request->file('image');
                $name = time() . '-' . $file->getClientOriginalName();
                $file->move('photos', $name);
                $path = "/photos/" . $name;
                if (isset($_POST['draft'])) {
                    Post::create(['user_id' => $id , 'category_id' => $request->cat, 'discount_id' => $request->discount, 'title' => $request->title, 'price' => $request->price, 'photo' => $path, 'quantity' => $request->quantity, 'detail' => $request->detail, 'published' => '0']);
                    $msg = 'پست جدید به عنوان پیش نویس ثبت شد';
                }elseif (isset($_POST['publish'])){
                    Post::create(['user_id' => $id ,'category_id' => $request->cat, 'discount_id' => $request->discount, 'title' => $request->title, 'price' => $request->price, 'photo' => $path, 'quantity' => $request->quantity, 'detail' => $request->detail, 'published' => '1']);
                    $msg = 'پست جدید ثبت و منتشر شد';
                }
            }
        }
        return view('adminPage.post', ['post' => $post , 'categories' => $categories, 'discounts' => $discounts, 'publish_posts' => $publish_posts , 'msg' => $msg]);
    }
    //Show post list = managment post
    public function postList()
    {
        $permission = $this->permissionsLoginUser();
        $edit_posts = $permission['role']['edit_posts'];
        $del_posts = $permission['role']['del_posts'];

        $posts = Post::paginate(10);
        return view('adminPage.post-list', ['posts' => $posts , 'edit_posts' => $edit_posts , 'del_posts' => $del_posts]);
    }
    //Delete post
    public function deletePost(Post $post)
    {
        $post->delete();
        $msg = 'حذف با موفقیت انجام شد ';
        return redirect()->back()->with(compact('msg'));
    }
    //Page
    public function page(Page $page = null , Request $request)
    {
        $msg = '';
        $permission = $this->permissionsLoginUser();
        $publish_pages = $permission['role']['publish_pages'];
        $types = Type::pluck('typeName' , 'id');
        if ($request->isMethod('post')){
            $this->validate(request(),
                [
                    'title' => 'required|max:25',
                    'ckeditor' => 'required',
                ]);
            if ($page->id){
                if (isset($_POST['draft'])){
                    $page->update(['type_id' => $request->type , 'title' => $request->title , 'body' => $request->ckeditor , 'published' => '0']);
                    $msg = 'صفحه ویرایش و به عنوان پیش نویس ثبت شد';
                }elseif (isset($_POST['publish'])){
                    $page->update(['type_id' => $request->type , 'title' => $request->title , 'body' => $request->ckeditor , 'published' => '1']);
                    $msg = 'صفحه ویرایش و منتشر شد';
                }
            }else{
                $id = \Session::get('id');
                if (isset($_POST['draft'])){
                    Page::create(['user_id' => $id ,'type_id' => $_POST['type'] ,'title' => $_POST['title'] , 'body' => $_POST['ckeditor'] , 'published' => '0' ]);
                    $msg = 'صفحه جدید به عنوان پیش نویس ثبت شد';
                }elseif (isset($_POST['publish'])){
                    Page::create(['user_id' => $id  ,'type_id' => $_POST['type'] ,'title' => $_POST['title'] , 'body' => $_POST['ckeditor'] , 'published' => '1' ]);
                    $msg = 'صفحه جدید ثبت و منتشر شد';
                }
            }
        }
        return view('adminPage.page' , ['types' => $types , 'publish_pages' => $publish_pages , 'page' => $page , 'msg' => $msg]);
    }

    //Show page list = managment page
    public function pageList()
    {
        $permission = $this->permissionsLoginUser();
        $edit_pages = $permission['role']['edit_pages'];
        $del_pages = $permission['role']['del_pages'];
        $pages = Page::paginate(10);
        return view('adminPage.page-list', ['pages' => $pages , 'edit_pages' => $edit_pages , 'del_pages' => $del_pages]);
    }
    //Delete page
    public function deletePage(Page $page)
    {
        $page->delete();
        $msg = 'حذف با موفقیت انجام شد ';
        return redirect()->back()->with(compact('msg'));
    }
    //User List
    public function userList()
    {
        if(Auth::user()->role->list_user == 1) {
            $permission = $this->permissionsLoginUser();
            $edit_user = $permission['role']['edit_user'];
            $del_user = $permission['role']['del_user'];
            $users = User::with('role')->get();
            return view('adminPage.user-list', ['users' => $users, 'edit_user' => $edit_user, 'del_user' => $del_user]);
        }else{
            return view('403');
        }
    }
    //Active or deActive user
    public function statusUser(User $user)
    {
        $msg = '';
        if (isset($_POST['deActive'])){
            $user->update(['status' => '0']);
            $msg = 'کاربر غیرفعال شد';
        }
        elseif (isset($_POST['active'])){
            $user->update(['status' => '1']);
            $msg = 'کاربر فعال شد' ;
        }
        return redirect()->back()->with(compact('msg'));
    }
    //Remove User
    public function removeUser(User $user)
    {
        $user->delete();
        $msg = 'کاربر حذف شد' ;
        return redirect()->back()->with(compact('msg'));
    }
    //Show Add Update User
    public function user(User $user , Request $request)
    {
        $msg = '';
        if(Auth::user()->role->create_user == 1) {
            $roles = Role::pluck('role' , 'id');
            if ($request->isMethod('post')) {
                $this->validate(request(),
                    [
                        'fname' => 'required|max:30',
                        'lname' => 'required|max:40',
                        'phone' => 'required|max:11',
                        'national_code' => 'required|max:10',
                        'username' => 'required',
                        'password' => 'required|confirmed'
                    ]);
                if ($user->id) {
                    $hashedPassword = Hash::make(request('password'));
                    $user->update([
                        'role_id' => $request->role,
                        'fname' => $request->fname,
                        'lname' => $request->lname,
                        'phone' => $request->phone,
                        'national_code' => $request->national_code,
                        'username' => $request->username,
                        'password' => $hashedPassword,
                    ]);
                    $msg = 'ویرایش با موفقیت انجام شد';
                } else {

                    $hashedPassword = Hash::make(request('password'));
                    User::create([
                        'role_id' => $request->role,
                        'fname' => $request->fname,
                        'lname' => $request->lname,
                        'phone' => $request->phone,
                        'national_code' => $request->national_code,
                        'username' => $request->username,
                        'password' => $hashedPassword,
                        'status' => '0',
                    ]);
                    $msg = 'کاربر جدید ایجاد شد';
                }
            }
                return view('adminPage.user' , ['roles' => $roles , 'user' => $user , 'msg' => $msg]);
        }
        else{
            return view('403');
        }
    }
    //Show Promote Page
    public function promote()
    {
        if(Auth::user()->role->promote_user == 1) {
            $roles = Role::pluck('role', 'id');
            return view('adminPage.promote', ['roles' => $roles]);
        }else{
            return view('403');
        }
    }
    //Add Role
    public function addRole()
    {
        $this->validate(request(),
            [
                'role' => 'required',
            ]);
        Role::create(['role' => $_POST['role']]);
        $msg = 'گروه جدید ایجاد شد ';
        return redirect()->back()->with(compact('msg'));
    }
    //Copy Role
    public function copyRole()
    {
        $this->validate(request(),
            [
                'roleNew' => 'required',
            ]);
        $role = Role::where('id' , $_POST['roleCopy'])->first();
        Role::create(['role' => $_POST['roleNew'],
                    'edit_posts'  => $role['edit_posts'],
                    'del_posts' => $role['del_posts'],
                    'edit_publish_posts' => $role['edit_publish_posts'],
                    'del_publish_posts' => $role['del_publish_posts'],
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
        $msg = 'عملیات کپی با موفقیت انجام شد ';
        return redirect()->back()->with(compact('msg'));
    }
    //Loading Role
    public function loadingRole(Request $request)
    {
        if(Auth::user()->role->promote_user == 1) {
            $permission = Role::where('id', $request->role)->first();
            return view('adminPage.customize', ['permission' => $permission]);
        }else{
            return view('403');
        }
    }
    //Save Permission = Customize Role
    public function savePermissions(Role $role)
    {
        (! (isset($_POST['edit_posts']))? $_POST['edit_posts']=0 : $_POST['edit_posts']=1);
        (! (isset($_POST['del_posts']))? $_POST['del_posts']=0 : $_POST['del_posts']=1);
        (! (isset($_POST['edit_publish_posts']))? $_POST['edit_publish_posts']=0 : $_POST['edit_publish_posts']=1);
        (! (isset($_POST['del_publish_posts']))? $_POST['del_publish_posts']=0 : $_POST['del_publish_posts']=1);
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
            'edit_posts'  => $_POST['edit_posts'],
            'del_posts' => $_POST['del_posts'],
            'edit_publish_posts' => $_POST['edit_publish_posts'],
            'del_publish_posts' => $_POST['del_publish_posts'],
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
        $msg = 'تغییرات اعمال شد ';
        return redirect()->back()->with(compact('msg'));
    }
    //Show User Profile Form
    public function profile()
    {
        $modify = 0;
        return view('adminPage.profile' , ['modify' => $modify]);
    }
    //Create Profile
    public function createProfile(Request $request)
    {
        $id = \Session::get('id');
        $is_profile = Profile::where('user_id' , $id)->first();
        if ($is_profile == ''){
            $file = $request->file('avatar');
            $name = time() . '-' . $file->getClientOriginalName();
            $file->move('photos', $name);
            $path = "/photos/" . $name;

            Profile::create(['user_id' => $id,
                            'job' => $_POST['job'] ,
                            'education' => $_POST['education'],
                            'mail' => $_POST['mail'],
                            'address' => $_POST['address'],
                            'avatar' => $path,
                            'detail' => $_POST['detail']
            ]);
            return redirect()->back();
        }
        return redirect()->back();

    }
}
