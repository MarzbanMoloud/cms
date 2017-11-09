@extends('layout.panel-layout')
@section('title','دسته بندی')
@section('content')

    <h3>دسته بندی</h3>
    <hr>
    <div class="well">
        <h4>افزودن دسته</h4>
        <form action="{{$modify==1 ? route('updateCat' , ['category' => $category->id]) : route('addCat')}}" role="form" method="post">
            {{ csrf_field() }}
            <input class="form-control w30p" type="text" name="cat" value="@if($modify == 1) {{ $category->catName }} @endif " placeholder="نام دسته بندی"/>

            @if ($errors->has('cat'))
                <span class="help-block error">
                    <strong>{{ $errors->first('cat') }}</strong>
                </span>
            @endif

            <br>
            <button name="submitCat" type="submit" class="btn btn-primary">ارسال</button>
        </form>
        <hr>

        <table class="table table-striped table-condensed table-hover">
            <tr>
                <td>نام دسته بندی</td>
                <td>عملیات</td>
            </tr>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->catName }}</td>
                    <td>
                        <a href="{{route('deleteCat' ,['category' => $category->id])}}">حذف</a>|
                        <a href="{{route('editCat' ,['category' => $category->id])}}">ویرایش</a>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
@stop