@extends('layout.panel-layout')
@section('title','صفحه ها')
@section('content')

    <h3>لیست محصولات</h3>
    <div class="well">
        <table class="table table-striped table-condensed table-hover">
            <tr>
                <td style="width: 30%">عنوان صفحه</td>
                <td>عملیات</td>

            </tr>
            @foreach($pages as $page)
                <tr>
                    <td>{{$page->title}}</td>
                    <td>
                        <a href="{{route('deletePage',['page' => $page->id])}}">حذف</a>|
                        <a href="{{route('editPage',['page' => $page->id])}}">ویرایش</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@stop
