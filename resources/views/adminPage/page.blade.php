@extends('layout.adminLayout')
@section('title' , 'افزودن صفحه')
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
                {!! Form::open(['url' => ($_SERVER['REQUEST_URI'])  ,  'method' => 'POST' , 'role' => 'form' , 'enctype' => 'multipart/form-data']) !!}
                {{ Form::token() }}
                    <div class="form-group">
                        {{ Form::label('type', 'نوع صفحه') }}
                        {{ Form::select('type' , $types , null ,['class' => 'form-control'])  }}
                    </div>

                    @if ($errors->has('title'))
                        <span class="help-block error">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                    @endif
                    <div class="form-group">
                        {{ Form::label('title', 'عنوان') }}
                        {{ Form::text('title', ($page)? $page->title : '' , ['class' => 'form-control' , 'id' => 'title']) }}
                        <div id="error-title" data-title="My tooltip"  class="hidden pointer_tooltip">حروف فارسی</div>
                    </div>

                    @if ($errors->has('ckeditor'))
                        <span class="help-block error">
                            <strong>{{ $errors->first('ckeditor') }}</strong>
                        </span>
                    @endif
                    {{ Form::textarea('ckeditor', ($page)? $page->body : '' , ['class' => 'form-control' , 'id' => 'ckeditor']) }}
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
                        {{ Form::submit(' پیش نویس' , ['class' => 'btn btn-primary' , 'name' => 'draft']) }}
                        @if($publish_pages == 1)
                            {{ Form::submit('انتشار', ['class' => 'btn btn-primary' , 'name' => 'publish']) }}
                        @endif
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col-->
</div>
<!-- ./row -->
<script>
    $("#title").on('change keyup paste keydown', function(e) {
        var p = /^[\u0600-\u06FF\s]+$/;
        if (e.keyCode != 8) {
            if (! p.test(e.key)) {
                e.preventDefault();
                $('#error-title').removeClass('hidden');}
            else {
                $('#title').attr({ maxLength : 30 });
                $('#error-title').addClass('hidden');
            }
        }
    });
</script>
@stop