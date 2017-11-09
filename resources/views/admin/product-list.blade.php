@extends('layout.panel-layout')
@section('content')

    <h3>لیست محصولات</h3>
    <div class="well">
        <table class="table table-striped table-condensed table-hover">
            <tr>
                <td style="width: 30%">نام محصول</td>
                <td>عملیات</td>

            </tr>
            @foreach($products as $product)
                <tr>
                    <td>{{$product->title}}</td>
                    <td>
                        <a href="{{route('deletePost',['product'=>$product->id])}}">حذف</a>|
                        <a href="{{route('editPost',['product'=>$product->id])}}">ویرایش</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="text-center">
        {{$products->links()}}
    </div>
@stop
