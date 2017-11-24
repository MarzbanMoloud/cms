@extends('layout.adminLayout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <br>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
                <form role="form" action="{{$modify==1 ? route('updatePage',['page'=>$page->id]) : route('addPage')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="type">نوع صفحه</label>
                        <select name="type" class="form-control " id="type">
                            @foreach($types as $type)
                                <option value="{{$type->id }}" {{($modify==1 and $type->id==$page->type_id) ? 'selected' : ''}}> {{ $type->typeName }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tite">عنوان صفحه</label>
                        <input id="title" type="text" name="title" class="form-control" value="{{$modify==1 ? $page->title : old('title')}}">
                    </div>
                    @if ($errors->has('title'))
                        <span class="help-block error">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                    <textarea id="ckeditor" name="ckeditor" rows="10" cols="80">
                        {{$modify==1 ? $page->body : old('ckeditor1')}}
                    </textarea>
                    <!-- CKEditor start -->
                    <script type="text/javascript" src="{{ asset('ckeditor/ckeditor/ckeditor.js') }}"></script>
                    <script type="text/javascript" src="{{ asset('/ckeditor/ckfinder/ckfinder.js') }}"></script>
                    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
                    <script>
                         CKEDITOR.replace('ckeditor' ,
                                {
                                    language: 'fa',
                                    filebrowserBrowseUrl: "{{ asset('ckeditor/ckfinder/ckfinder.html?Type=Files') }}",
                                    filebrowserImageBrowseUrl: "{{ asset('ckeditor/ckfinder/ckfinder.html?Type=Images') }}",
                                    filebrowserFlashBrowseUrl: "{{ asset('ckeditor/ckfinder/ckfinder.html?Type=Flash') }}",
                                    filebrowserUploadUrl: "{{ asset('ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}",
                                    filebrowserImageUploadUrl: "{{ asset('ckeditor/ckfinder/core/connctor/php/connector.php?command=QuickUpload&type=Images') }}",
                                    filebrowserFlashUploadUrl: "{{ asset('ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}"
                                }
                        );

                    </script>
                    <!-- CKEditor end -->
                    <br>
                    <div class="box-footer">
                        <input type="submit" class="btn btn-primary" name="draft" value="پیش نویس" />
                        <input type="submit" class="btn btn-primary" name="publish" value="انتشار" />
                    </div>
                </form>
            </div>
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col-->
</div>
<!-- ./row -->
@stop