@extends('layout.panel-layout')
@section('title','پست ها')
@section('content')

    <h3>لیست محصولات</h3>
    <div class="well">
        <table class="table table-striped table-condensed table-hover">
            <tr>
                <td style="width: 30%">عنوان پست</td>
                <td>عملیات</td>

            </tr>
            @foreach($posts as $post)
                <tr>
                    <td>{{$post->title}}</td>
                    <td>
                        <a href="{{route('deletePost',['post'=>$post->id])}}">حذف</a>|
                        <a href="{{route('editPost',['post'=>$post->id])}}">ویرایش</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="text-center">
        {{$posts->links()}}
    </div>
@stop
