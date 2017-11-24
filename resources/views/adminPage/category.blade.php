@extends('layout.adminLayout')
@section('title' , 'دسته بندی')
@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <br>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{$modify==1 ? route('updateCat' , ['category' => $category->id]) : route('addCat')}}" role="form" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="cat">عنوان دسته بندی</label>
                            <input type="text" class="form-control" name="cat" value="@if($modify == 1) {{ $category->catName }} @endif ">
                        </div>
                        @if ($errors->has('cat'))
                            <span class="help-block error">
                            <strong>{{ $errors->first('cat') }}</strong>
                            </span>
                        @endif

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" name="submit" value="ارسال" />
                        </div>
                    </form>
                </div>

            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
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
                    <th style="text-align: right">عنوان دسته بندی</th>
                    <th style="text-align: right">تاریخ ایجاد</th>
                    <th style="text-align: right">آخرین ویرایش</th>
                    <th style="text-align: right">حذف</th>
                    <th style="text-align: right">ویرایش</th>
                </tr>
                @foreach($categories as $category)
                    <tr>
                        <td>{{$category->catName}}</td>
                        <td>{{$category->created_at}}</td>
                        <td>{{$category->updated_at}}</td>
                        <td>
                            <a href="{{route('deleteCat' ,['category' => $category->id])}}"><i class="fa fa-remove"></i></a>
                        </td>
                        <td>
                            <a href="{{route('editCat' ,['category' => $category->id])}}"><i class="fa fa-edit"></i></a>
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

@stop