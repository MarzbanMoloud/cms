@extends('layout.adminLayout')
@section('title' , 'لیست صفحات')
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
                            <th style="text-align: right">عنوان صفحه</th>
                            <th style="text-align: right">تاریخ ایجاد</th>
                            <th style="text-align: right">آخرین ویرایش</th>
                            <th style="text-align: right">وضعیت</th>
                            <th style="text-align: right">حذف</th>
                            <th style="text-align: right">ویرایش</th>
                        </tr>
                        @foreach($pages as $page)
                        <tr>
                            <td>{{$page->title}}</td>
                            <td>{{$page->created_at}}</td>
                            <td>{{$page->updated_at}}</td>
                            <td>
                                {{ ($page->published == '0') ?  'پیش نویس':'منتشر شده' }}
                            </td>
                            <td>
                                <a href="{{route('deletePage',['page' => $page->id])}}"><i class="fa fa-trash-o"></i></a>
                            </td>
                            <td>
                                <a href="{{route('editPage',['page' => $page->id])}}"><i class="fa fa-edit"></i></a>
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