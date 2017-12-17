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
use Crypt;
use Faker\Provider\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    //Get Permission of Login_user

    //Dashboard
    public function dashboard(Request $request)
    {
        $pIsLogin = Session::get('permissions');
        if( $pIsLogin['dashboard'] == 1){
            return view('adminPage.dashboard');
        }else{
            return view('403');
        }

    }
    //Show Add Update category
    public function category(Category $category = null , Request $request)
    {
        $pIsLogin = Session::get('permissions');
        if($pIsLogin['manage_category'] == 1) {
            $msg = '';
            if ($request->isMethod('post')) {
                $this->validate(request(),
                    [
                        'cat' => 'required|min:3|max:25|persian_alpha',
                    ]);
                if ($category->id) {
                    $category->update(['catName' => $request->cat]);
                    $msg = 'ویرایش با موفقیت انجام شد ';
                } else {
                    Category::create(['catName' => $request->cat]);
                    $msg = 'دسته بندی با موفقیت ثبت شد';
                }
            }
            if (Input::get('search')){
                $categories = Category::where('catName' , 'like', '%' . Input::get('search') . '%' )->sortable()->paginate(10);
            }else{
                $categories = Category::sortable()->paginate(10);
            }
            return view('adminPage.category', ['category' => $category, 'categories' => $categories, 'msg' => $msg]);
        }
        else{
            return view('403');
        }
    }
    //delete category
    public function deleteCat(Category $category)
    {
        $pIsLogin = Session::get('permissions');
        if(($pIsLogin['manage_category'] == 1) and ($category != null)) {
            $category->delete();
            $msg = 'حذف با موفقیت انجام شد ';
            return redirect()->back()->with(compact('msg'));
        }else{
            return view('403');
        }
    }
    //Show Add Update Post
    public function post(Post $post = null  , Request $request)
    {
        $msg = '';
        $pIsLogin = Session::get('permissions');
        $categories = Category::pluck( 'catName' , 'id');
        $discounts = Discount::pluck( 'discountPercent', 'id');
        if ($request->isMethod('post')){
            $this->validate(request(),
                [
                    'title' => 'required|min:3|max:25|persian_alpha',
                    'price' => 'required|max:15',
                    'quantity' => 'required|max:4',
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
                }else{
                    $path = $post->photo;
                }
                $price = str_replace(',', '', $request->price);
                if (isset($_POST['draft'])) {
                    $post->update([ 'discount_id' => $request->discount, 'category_id' => $request->cat, 'title' => $request->title, 'price' => $price, 'quantity' => $request->quantity, 'photo' => $path, 'detail' => $request->detail, 'published' => '0']);
                    $msg = 'پست ویرایش و به عنوان پیش نویس ثبت شد';
                }elseif(isset($_POST['publish'])){
                    $post->update(['discount_id' => $request->discount, 'category_id' => $request->cat, 'title' => $request->title, 'price' => $price, 'quantity' => $request->quantity, 'photo' => $path, 'detail' => $request->detail, 'published' => '1']);
                    $msg = 'پست ویرایش و منتشر شد';
                }
            }else{
                $this->validate(request(),
                    [
                        'image' => 'required|mimes:jpeg,png,gif,jpg,bmp',
                    ]);
                $id = Session::get('id');
                $file = $request->file('image');
                $name = time() . '-' . $file->getClientOriginalName();
                $file->move('photos', $name);
                $path = "/photos/" . $name;
                $price = str_replace(',', '', $request->price);
                if (isset($_POST['draft'])) {
                    Post::create(['user_id' => $id , 'category_id' => $request->cat, 'discount_id' => $request->discount, 'title' => $request->title, 'price' => $price, 'photo' => $path, 'quantity' => $request->quantity, 'detail' => $request->detail, 'published' => '0']);
                    $msg = 'پست جدید به عنوان پیش نویس ثبت شد';
                }elseif (isset($_POST['publish'])){
                    Post::create(['user_id' => $id ,'category_id' => $request->cat, 'discount_id' => $request->discount, 'title' => $request->title, 'price' => $price, 'photo' => $path, 'quantity' => $request->quantity, 'detail' => $request->detail, 'published' => '1']);
                    $msg = 'پست جدید ثبت و منتشر شد';
                }
            }
        }

        if (($pIsLogin['edit_posts'] == 1) and ($post->id != null) ){
            return view('adminPage.post', ['post' => $post , 'categories' => $categories, 'discounts' => $discounts, 'msg' => $msg]);
        }elseif ($pIsLogin['create_posts'] == 1 and ($post->id == null)){
            return view('adminPage.post', ['post' => $post , 'categories' => $categories, 'discounts' => $discounts, 'msg' => $msg]);
        }else{
            return view('403');
        }
    }
    //Managment post
    public function postList()
    {
        $pIsLogin = Session::get('permissions');
        $edit_posts = $pIsLogin['edit_posts'];
        $del_posts = $pIsLogin['del_posts'];
        if ($edit_posts == 1 or $del_posts == 1) {
            if (Input::get('search')) {
                $posts = Post::where('title' , 'like', '%' . Input::get('search') . '%' )
                    ->orWhere('detail' , 'like', '%' . Input::get('search') . '%' )
                    ->sortable()->paginate(10);
            }else{
                $posts = Post::sortable()->paginate(10);
            }
            return view('adminPage.post-list', ['posts' => $posts, 'edit_posts' => $edit_posts, 'del_posts' => $del_posts]);
        }else{
            return view('403');
        }
    }
    //Delete post
    public function deletePost(Post $post)
    {
        $pIsLogin = Session::get('permissions');
        if (($pIsLogin['del_posts'] == 1) and ($post != null)) {
            $post->delete();
            $msg = 'حذف با موفقیت انجام شد ';
            return redirect()->back()->with(compact('msg'));
        }else{
            return view('403');
        }
    }
    //Page
    public function page(Page $page = null , Request $request)
    {
        $msg = '';
        $pIsLogin = Session::get('permissions');
        $types = Page::getTypes();
        if ($request->isMethod('post')){
            $this->validate(request(),
                [
                    'title' => 'required|max:25|persian_alpha',
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
                $id = Session::get('id');
                if (isset($_POST['draft'])){
                    Page::create(['user_id' => $id ,'type_id' => $_POST['type'] ,'title' => $_POST['title'] , 'body' => $_POST['ckeditor'] , 'published' => '0' ]);
                    $msg = 'صفحه جدید به عنوان پیش نویس ثبت شد';
                }elseif (isset($_POST['publish'])){
                    Page::create(['user_id' => $id  ,'type_id' => $_POST['type'] ,'title' => $_POST['title'] , 'body' => $_POST['ckeditor'] , 'published' => '1' ]);
                    $msg = 'صفحه جدید ثبت و منتشر شد';
                }
            }
        }
        if (($pIsLogin['edit_pages'] == 1) and ($page->id != null) ){
            return view('adminPage.page' , ['types' => $types , 'page' => $page , 'msg' => $msg]);
        }elseif (($pIsLogin['create_pages'] == 1) and ($page->id == null) ){
            return view('adminPage.page' , ['types' => $types , 'page' => $page , 'msg' => $msg]);
        }else{
            return view('403');
        }

    }

    //Show page list = managment page
    public function pageList()
    {
        $pIsLogin = Session::get('permissions');
        $edit_pages = $pIsLogin['edit_pages'];
        $del_pages = $pIsLogin['del_pages'];
        if ($edit_pages == 1 or $del_pages == 1) {
            if (Input::get('search')) {
                $pages = Page::where('title' , 'like', '%' . Input::get('search') . '%' )
                    ->orWhere('body' , 'like', '%' . Input::get('search') . '%' )
                    ->sortable()->paginate(10);
            }else{
                $pages = Page::sortable()->paginate(10);
            }
            return view('adminPage.page-list', ['pages' => $pages, 'edit_pages' => $edit_pages, 'del_pages' => $del_pages]);
        }else{
            return view('403');
        }
    }
    //Delete page
    public function deletePage(Page $page)
    {
        $pIsLogin = Session::get('permissions');
        if (($pIsLogin['del_pages'] == 1) and ($page != null)) {
            $page->delete();
            $msg = 'حذف با موفقیت انجام شد ';
            return redirect()->back()->with(compact('msg'));
        }else{
            return view('403');
        }
    }
    //User List
    public function userList()
    {
        $pIsLogin = Session::get('permissions');
        if ($pIsLogin['manage_user'] == 1){
            if (Input::get('search')) {
                $users = User::with('role')->where('fname' , 'like', '%' . Input::get('search') . '%' )
                    ->orWhere('lname' , 'like', '%' . Input::get('search') . '%' )
                    ->orWhere('national_code' , 'like', '%' . Input::get('search') . '%' )
                    ->sortable()->paginate(10);
            }else{
                $users = User::with('role')->sortable()->paginate(10);
            }
            return view('adminPage.user-list', ['users' => $users]);
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
        $pIsLogin = Session::get('permissions');
        if ( ($pIsLogin['manage_user'] == 1) and ($user !=  null)) {
            $user->delete();
            $msg = 'کاربر حذف شد';
            return redirect()->back()->with(compact('msg'));
        }else{
            return view('403');
        }
    }
    //Show Add Update User
    public function user(User $user , Request $request)
    {
        $msg = '';
        $pIsLogin = Session::get('permissions');
        $id = Session::get('id');
            $roles = Role::pluck('role' , 'id');
            if ($request->isMethod('post')) {
                $this->validate(request(),
                    [
                        'fname' => 'required|max:30|persian_alpha',
                        'lname' => 'required|max:30|persian_alpha',
                        'phone' => 'required|max:11|min:11|iran_mobile',
                        'national_code' => 'required|melli_code|max:10|min:10|unique:users,id,' . $id,
                        'username' => 'required|is_not_persian',
                        'password' => 'required|confirmed'
                    ]);
                if ($user->id) {
                    $user->update([
                        'role_id' => $request->role,
                        'fname' => $request->fname,
                        'lname' => $request->lname,
                        'phone' => $request->phone,
                        'national_code' => $request->national_code,
                        'username' => $request->username
                    ]);
                    $msg = 'ویرایش با موفقیت انجام شد';
                } else {
                    $hashedPassword =  Hash::make(request('password'));
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
        if ( ($pIsLogin['manage_user'] == 1) and ($user->id !=  null)) {
            return view('adminPage.user', ['roles' => $roles, 'user' => $user, 'msg' => $msg]);
        }elseif ( ($pIsLogin['create_user'] == 1) and ($user->id == null)){
            return view('adminPage.user', ['roles' => $roles, 'user' => $user, 'msg' => $msg]);
        }else{
            return view('403');
        }

    }
    //Show Promote Page
    public function promote()
    {
        $pIsLogin = Session::get('permissions');
        if ($pIsLogin['promote_user'] == 1){
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
                'role' => 'required|min:3|max:25|persian_alpha',
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
                'roleNew' => 'required|min:3|max:25|persian_alpha',
            ]);
        $role = Role::where('id' , $_POST['roleCopy'])->first();
        Role::create(['role' => $_POST['roleNew'],
                    'edit_posts'  => $role['edit_posts'],
                    'del_posts' => $role['del_posts'],
                    'create_posts' => $role['create_posts'],
                    'edit_pages' => $role['edit_pages'],
                    'del_pages' => $role['del_pages'],
                    'create_pages' => $role['create_pages'],
                    'manage_category' => $role['manage_category'],
                    'create_user' => $role['create_user'],
                    'manage_user' => $role['manage_user'],
                    'promote_user' => $role['promote_user'],
                    'dashboard' => $role['dashboard']
            ]);
        $msg = 'عملیات کپی با موفقیت انجام شد ';
        return redirect()->back()->with(compact('msg'));
    }
    //Loading Role
    public function loadingRole(Request $request)
    {
        $pIsLogin = Session::get('permissions');
        if ($pIsLogin['promote_user'] == 1) {
            $permission = Role::where('id', $request->role)->first();
            return view('adminPage.customize', ['permission' => $permission]);
        }
    }
    //Save Permission = Customize Role
    public function savePermissions(Role $role)
    {
        (! (isset($_POST['edit_posts']))? $_POST['edit_posts']=0 : $_POST['edit_posts']=1);
        (! (isset($_POST['del_posts']))? $_POST['del_posts']=0 : $_POST['del_posts']=1);
        (! (isset($_POST['create_posts']))? $_POST['create_posts']=0 : $_POST['create_posts']=1);
        (! (isset($_POST['edit_pages']))? $_POST['edit_pages']=0 : $_POST['edit_pages']=1);
        (! (isset($_POST['del_pages']))? $_POST['del_pages']=0 : $_POST['del_pages']=1);
        (! (isset($_POST['create_pages']))? $_POST['create_pages']=0 : $_POST['create_pages']=1);
        (! (isset($_POST['manage_category']))? $_POST['manage_category']=0 : $_POST['manage_category']=1);
        (! (isset($_POST['create_user']))? $_POST['create_user']=0 : $_POST['create_user']=1);
        (! (isset($_POST['manage_user']))? $_POST['manage_user']=0 : $_POST['manage_user']=1);
        (! (isset($_POST['promote_user']))? $_POST['promote_user']=0 : $_POST['promote_user']=1);
        (! (isset($_POST['dashboard']))? $_POST['dashboard']=0 : $_POST['dashboard']=1);
        $role->update([
            'role' => $_POST['nameRole'],
            'edit_posts'  => $_POST['edit_posts'],
            'del_posts' => $_POST['del_posts'],
            'create_posts' => $_POST['create_posts'],
            'edit_pages' => $_POST['edit_pages'],
            'del_pages' => $_POST['del_pages'],
            'create_pages' => $_POST['create_pages'],
            'manage_category' => $_POST['manage_category'],
            'create_user' => $_POST['create_user'],
            'manage_user' => $_POST['manage_user'],
            'promote_user' => $_POST['promote_user'],
            'dashboard' => $_POST['dashboard']
        ]);
        $msg = 'تغییرات اعمال شد ';
        return redirect()->back()->with(compact('msg'));
    }
    //Show Add Edit Profile
    public function profile(Request $request)
    {
            $msg = '';
            $path = '';
            $id = Session::get('id');
            $profile = Profile::where('user_id' , $id)->first();
            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'avatar' => 'mimes:jpg,jpeg,png,bmp',
                ]);
                if (Input::file('avatar')) {
                    if (($profile) && $profile->avatar != null) {
                        if (\File::exists(public_path($profile->avatar))) {
                            unlink(public_path($profile->avatar));
                        }
                    }
                    $file = $request->file('avatar');
                    $name = time() . '-' . $file->getClientOriginalName();
                    $file->move('photos', $name);
                    $path = "/photos/" . $name;

                } elseif ($profile) {
                    $path = $profile->avatar;
                }

                if ($profile == null) { $profile = new Profile(); }

                $profile->user_id = $id;
                $profile->job = $request->job;
                $profile->education = $request->education;
                $profile->mail = $request->mail;
                $profile->address = $request->address;
                $profile->avatar = $path;
                $profile->detail = $request->detail;
                $profile->save();
                $msg = 'عملیات با موفقیت انجام شد';
            }
        return view('adminPage.profile' , ['msg' => $msg , 'profile' => $profile]);
    }

    public function resetPass(Request $request)
    {
            $this->validate($request, [
                'oldPass' => 'required',
                'newPass' => 'required',
                'newPassConfirmation' => 'required|same:newPass',
            ]);
            $id = Session::get('id');
            $user = User::where('id' ,$id)->first();
            $hashedPassword = $user->password;

            if (Hash::check($request->oldPass, $hashedPassword)) {
                $user->update(['password' => Hash::make($request->newPass)]);
                $msg = 'ریست رمز عبور با موفقیت انجام شد';
                return redirect()->back()->with(compact('msg'));
            } else {
                $msg = 'رمز عبور قبلی اشتباه است';
                return redirect()->back()->with(compact('msg'));
            }
    }
}
