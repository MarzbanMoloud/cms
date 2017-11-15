@extends('layout.panel-layout')
@section('title','افزودن صفحه')
@section('content')

    <hr>
        <div class="well">
            <form role="form" action="{{$modify==1 ? route('updatePage',['page'=>$page->id]) : route('addPage')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group center">
                    <label for="type" class="control-label">نوع صفحه</label>
                    <select name="type" class="form-control " id="type">
                        @foreach($types as $type)
                            <option value="{{$type->id }}" {{($modify==1 and $type->id==$page->type_id) ? 'selected' : ''}}> {{ $type->name }} </option>
                        @endforeach
                    </select>

                    <label for="tite" class="control-label"> عنوان صفحه</label>
                    <input class="form-control" id="title" type="text" name="title" value="{{$modify==1 ? $page->title : old('title')}}"/>
                    @if ($errors->has('title'))
                        <span class="help-block error">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif

                    <br>

                    <label for="ckeditor" class="control-label">متن صفحه</label>
                    <textarea class="form-control postBody" id="ckeditor" name="ckeditor" rows="15">
                        {{$modify==1 ? $page->body : old('ckeditor')}}
                    </textarea>

                    <!-- CKEditor start -->
                    <script src="{{ asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
                    <script>
                        CKEDITOR.replace('ckeditor');
                    </script>
                    <!-- CKEditor end -->
                </div>
                <input type="submit" name="submit" class="btn btn-primary" value="  ارسال  ">
            </form>


        </div>
    <hr>


@stop
