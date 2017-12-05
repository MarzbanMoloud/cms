@extends('layout.adminLayout')
@section('title' , 'افزودن پست')
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
                            {{ Form::label('cat', ' دسته بندی') }}
                            {{ Form::select('cat' , $categories , null ,['class' => 'form-control'])  }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('discount', 'تخفیف') }}
                            {{  Form::select('discount' , $discounts , null ,['class' => 'form-control']) }}
                        </div>

                        @if ($errors->has('title'))
                            <span class="help-block error">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('title', 'عنوان') }}
                            {{ Form::text('title', ($post)? $post->title : ''  , ['class' => 'form-control' , 'id' => 'title']) }}
                            <div id="error-title" data-title="My tooltip"  class="hidden pointer_tooltip">حروف فارسی</div>
                        </div>

                        @if ($errors->has('price'))
                            <span class="help-block error">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('price', 'قیمت') }}
                            {{ Form::text('price', ($post)? $post->price : ''  , ['class' => 'form-control' , 'id' => 'price']) }}
                            <div id="error-price" data-title="My tooltip"  class="hidden pointer_tooltip">فقط عدد</div>
                        </div>

                        @if ($errors->has('quantity'))
                            <span class="help-block error">
                                <strong>{{ $errors->first('quantity') }}</strong>
                            </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('quantity', 'تعداد') }}
                            {{ Form::text('quantity', ($post)? $post->quantity : ''  , ['class' => 'form-control' , 'id' => 'quantity']) }}
                            <div id="error-qty" data-title="My tooltip"  class="hidden pointer_tooltip">فقط عدد</div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('image', 'تصویر شاخص') }}
                            {{ Form::file('image') }}
                        </div>

                        @if ($errors->has('detail'))
                            <span class="help-block error" >
                                <strong>{{ $errors->first('detail') }}</strong>
                            </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('detail', 'توضیحات') }}
                            {{ Form::textarea('detail', ($post)? $post->detail : '' , ['size' => '30x5' , 'class' => 'form-control']) }}
                        </textarea>
                        </div>

                        <div class="box-footer">
                            {{ Form::submit(' پیش نویس' , ['class' => 'btn btn-primary' , 'name' => 'draft']) }}
                            @if($publish_posts == 1)
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
    <script>
        $("#price").on('change keyup paste keydown', function(e) {
            var p = /^[0-9]+$/;
            if (e.keyCode != 8) {
                if (! p.test(e.key)) {
                    e.preventDefault();
                    $('#error-price').removeClass('hidden');}
                else {
                    $('#price').attr({ maxLength : 9 });
                    $('#error-price').addClass('hidden');
                }
            }
        });
    </script>
    <script>
        $("#quantity").on('change keyup paste keydown', function(e) {
            var p = /^[0-9]+$/;
            if (e.keyCode != 8) {
                if (! p.test(e.key)) {
                    e.preventDefault();
                    $('#error-qty').removeClass('hidden');}
                else {
                    $('#quantity').attr({ maxLength : 4 });
                    $('#error-qty').addClass('hidden');
                }
            }
        });
    </script>
@stop