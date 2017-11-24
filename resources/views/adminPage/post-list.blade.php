@extends('layout.adminLayout')
@section('title' , 'لیست پست ها')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control pull-right" placeholder="جستجو">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="text-align: right">عنوان پست</th>
                            <th style="text-align: right">تاریخ ایجاد</th>
                            <th style="text-align: right">آخرین ویرایش</th>
                            <th style="text-align: right">وضعیت</th>
                            <th style="text-align: right">حذف</th>
                            <th style="text-align: right">ویرایش</th>
                        </tr>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{$post->title}}</td>
                                <td>{{$post->created_at}}</td>
                                <td>{{$post->updated_at}}</td>
                                <td>
                                    {{ ($post->published == '0') ?  'پیش نویس':'منتشر شده' }}
                                </td>
                                <td>
                                    <a href="{{route('deletePost',['post'=>$post->id])}}"><i class="fa fa-trash-o"></i></a>
                                </td>
                                <td>
                                    <a href="{{route('editPost',['post'=>$post->id])}}"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <li><a href="#">&laquo;</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">&raquo;</a></li>
                    </ul>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop