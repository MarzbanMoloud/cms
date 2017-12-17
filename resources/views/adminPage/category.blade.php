@extends('layout.adminLayout')
@section('title' , 'دسته بندی')
@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            افزودن/ویرایش دسته بندی
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div>
        <!-- /.box-header -->

        <div class="box-body">
            <div class="row  ">
                {!! Form::open([NULL ,  'method' => 'POST' , 'role' => 'form']) !!}
                {{ Form::token() }}
                <div class="col-md-1 pull-right" style="padding-top: 8px; width: 125px">
                    <div class="form-group">
                        {{ Form::label('cat', 'عنوان دسته بندی') }}
                    </div>
                </div>
                <div class="col-md-3 pull-right">
                        <div class="form-group">
                            {{ Form::text('cat', ($category)? $category->catName : ''  , ['class' => 'form-control' , 'id' => 'cat']) }}
                            <div id="error" data-title="My tooltip"  class="hidden pointer_tooltip"></div>
                        </div>
                        @if ($errors->has('cat'))
                            <span class="help-block error">
                                <strong>{{ $errors->first('cat') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="col-md-6 pull-right">
                    <div class="form-group">
                    {{ Form::submit('ارسال', ['class' => 'btn btn-primary' , 'name' => 'submit']) }}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
    <div class="box">
        <div class="box-header">
            <div class="box-tools">
                {!! Form::open([NULL ,  'method' => 'GET' , 'role' => 'form']) !!}
                <div class="input-group input-group-sm" style="width: 200px;">
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
                        <th style="text-align: right">@sortablelink('catName' , 'دسته بندی')</th>
                        <th style="text-align: right">@sortablelink('created_at' , 'تاریخ ایجاد')</th>
                        <th style="text-align: right">@sortablelink('updated_at' , 'آخرین ویرایش')</th>
                        <th style="text-align: right">حذف</th>
                        <th style="text-align: right">ویرایش</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{$category->catName}}</td>
                        <td>{{ jDate($category->created_at)->format('datetime') }}</td>
                        <td>{{jDate($category->updated_at)->format('datetime') }}</td>
                        <td>
                            <a href="{{route('deleteCat' ,['category' => $category->id])}}"><i class="fa fa-remove"></i></a>
                        </td>
                        <td>
                            <a href="/category/{{$category->id}}"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            {{ $categories->links() }}
        </div>
    </div>
    <!-- /.box -->
    <script>
        function persian_denied(elename , e , pos , msg){
            var p = /^[\u0600-\u06FF\s]+$/;
            if (e.keyCode != 8) {
                if (! p.test(e.key)) {
                    e.preventDefault();
                    document.getElementById("error").innerHTML = msg;
                    $('#error').css("top",pos+38).removeClass('hidden');
                } else {
                    elename.attr({ maxLength : 25 });
                    $('#error').addClass('hidden');
                }
            }
        }
        $("#cat").on('change keyup paste keydown', function(e) {
            persian_denied( $("#cat") , e , parseInt($("#cat").position().top) , "حروف فارسی");
        });
        $(function() {
            $(".form-control").blur(function () {
                $('#error').addClass('hidden');
            });
        });
    </script>
@stop


