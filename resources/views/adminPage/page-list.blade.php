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
                            @if($del_pages == 1)
                                <td>
                                    <a href="{{route('deletePage',['page' => $page->id])}}"><i class="fa fa-trash-o"></i></a>
                                </td>
                            @elseif($del_pages == 0)
                                <td>
                                    <a href="{{route('deletePage',['page' => $page->id])}}" style=" pointer-events: none;color: grey;"><i class="fa fa-trash-o"></i></a>
                                </td>
                            @endif

                            @if($edit_pages == 1)
                                <td>
                                    <a href="/page/{{$page->id}}"><i class="fa fa-edit"></i></a>
                                </td>
                            @elseif($edit_pages == 0)
                                <td>
                                    <a href="/page/{{$page->id}}" style=" pointer-events: none;color: grey;"><i class="fa fa-edit"></i></a>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    {{ $pages->links() }}
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop