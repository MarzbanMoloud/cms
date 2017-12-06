@extends('layout.adminLayout')
@section('title' , 'سفارشی کردن گروه')
@section('content')
    <div class="col-md-12" style="float: right;">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title" style="font-family: 'B Yekan Regular';">سفارشی کردن گروه</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{ route('savePermissions' , [ 'role' => $permission['id'] ]) }}" method="post">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-sm-8" style="float: right;">
                            <label for="nameRole">نام گروه</label>
                        </div>
                        <div class="col-sm-12" style="float: right;">
                            <input type="text" id="nameRole" class="form-control" name="nameRole" readonly value="{{ $permission['role'] }}">
                        </div>
                    </div>
                    <table id="example">
                    <tr style="height: 50px;">
                        <th style="width: 300px; text-align: right">پست</th>
                        <th style="text-align: right">صفحه</th>
                        <th style="text-align: right">غیره</th>
                    </tr>
                    <tr>
                        <td style="width: 300px">
                            <div class="form-group" style="margin-right: 0px;">

                                <div>
                                    <input type="checkbox" id="edit_posts" name="edit_posts" @if($permission['edit_posts'] ==1) {{ 'checked' }} @endif>
                                    <label for="edit_posts">ویرایش پست</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="del_posts" name="del_posts" @if($permission['del_posts'] ==1) {{ 'checked' }} @endif>
                                    <label for="del_posts">حذف پست</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="edit_publish_posts" name="edit_publish_posts" @if($permission['edit_publish_posts'] ==1) {{ 'checked' }} @endif>
                                    <label for="edit_publish_posts">ویرایش پست منتشر شده</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="del_publish_posts" name="del_publish_posts" @if($permission['del_publish_posts'] ==1) {{ 'checked' }} @endif>
                                    <label for="del_publish_posts">حذف پست منتشر شده</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="publish_posts" name="publish_posts" @if($permission['publish_posts'] ==1) {{ 'checked' }} @endif>
                                    <label for="publish_posts">انتشار پست</label>
                                </div>
                            </div>
                        </td>
                        <td style="width: 300px">
                            <div class="form-group" style="margin-right: 0px;">

                                <div>
                                    <input type="checkbox" id="edit_pages" name="edit_pages" @if($permission['edit_pages'] ==1) {{ 'checked' }} @endif>
                                    <label for="edit_pages">ویرایش صفحه</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="del_pages" name="del_pages" @if($permission['del_pages'] ==1) {{ 'checked' }} @endif>
                                    <label for="del_pages">حذف صفحه</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="edit_publish_pages" name="edit_publish_pages" @if($permission['edit_publish_pages'] ==1) {{ 'checked' }} @endif>
                                    <label for="edit_publish_pages">ویرایش صفحه منتشر شده</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="del_publish_pages" name="del_publish_pages" @if($permission['del_publish_pages'] ==1) {{ 'checked' }} @endif>
                                    <label for="del_publish_pages">حذف صفحه منتشر شده</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="publish_pages" name="publish_pages" @if($permission['publish_pages'] ==1) {{ 'checked' }} @endif>
                                    <label for="publish_pages">انتشار صفحه</label>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group" style="margin-right: 0px;">
                                <div>
                                    <input type="checkbox" id="manage_category" name="manage_category" @if($permission['manage_category'] ==1) {{ 'checked' }} @endif>
                                    <label for="manage_category">مدیریت دسته بندی</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="create_user" name="create_user" @if($permission['create_user'] ==1) {{ 'checked' }} @endif>
                                    <label for="create_user">ایجاد کاربر</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="edit_user" name="edit_user" @if($permission['edit_user'] ==1) {{ 'checked' }} @endif>
                                    <label for="edit_user">ویرایش کاربر</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="del_user" name="del_user" @if($permission['del_user'] ==1) {{ 'checked' }} @endif>
                                    <label for="del_user">حذف کاربر</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="promote_user" name="promote_user" @if($permission['promote_user'] ==1) {{ 'checked' }} @endif>
                                    <label for="promote_user">مجوزها</label>
                                </div>
                                <div>
                                    <input type="checkbox" id="list_user" name="list_user" @if($permission['list_user'] ==1) {{ 'checked' }} @endif>
                                    <label for="list_user">لیست کابران</label>
                                </div>
                                <div></div>
                            </div>
                        </td>
                    </tr>
                    </table>
                    <button type="button" id="selectAll" class="btn btn-primary">
                        <span class="sub"></span> انتخاب همه </button></th>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">اعمال تغییرات</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        $("#selectAll").on("click", function () {
            $("#example tr").each( function() {
                $(this).find("input").attr('checked', true);
            });
        });
    </script>
@stop