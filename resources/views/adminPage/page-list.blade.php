@extends('layout.adminLayout')
@section('title' , 'لیست صفحات')
@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="box">
                <div class="box-header">
                    <div class="box-tools">
                        {!! Form::open([NULL ,  'method' => 'GET' , 'role' => 'form']) !!}
                        <div class="input-group input-group-sm" style="width: 150px;">
                            {{ Form::text('search', null  , ['class' => 'form-control pull-right' , 'placeholder' => 'جستجو']) }}
                            <div class="input-group-btn">
                                {{ Form::button('<i class="fa fa-search"></i>', ['class' => 'btn btn-default btn-sm', 'type' => 'submit']) }}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <br>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: right">@sortablelink('title' , 'عنوان صفحه')</th>
                                <th style="text-align: right">@sortablelink('created_at' , 'تاریخ ایجاد')</th>
                                <th style="text-align: right">@sortablelink('updated_at' , 'آخرین ویرایش')</th>
                                <th style="text-align: right">وضعیت</th>
                                <th style="text-align: right">حذف</th>
                                <th style="text-align: right">ویرایش</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pages as $page)
                            <tr>
                                <td>{{$page->title}}</td>
                                <td>{{ jDate($page->created_at)->format('datetime') }}</td>
                                <td>{{ jDate($page->updated_at)->format('datetime') }}</td>
                                <td>
                                    {{ ($page->published == '0') ?  'پیش نویس':'منتشر شده' }}
                                </td>
                                @if($del_pages == 1)
                                    <td>
                                        <a href="{{route('deletePage',['page' => $page->id])}}" ><i class="fa fa-trash-o"></i></a>
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
                        </tbody>
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

