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
                    {!! Form::open([NULL  ,  'method' => 'POST' , 'role' => 'form' , 'enctype' => 'multipart/form-data']) !!}
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
                            <div id="error" data-title="My tooltip"  class="hidden pointer_tooltip"></div>
                        </div>

                        @if ($errors->has('price'))
                            <span class="help-block error">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('price', 'قیمت') }}
                            {{ Form::text('price', ($post)? $post->price : ''  , ['class' => 'form-control' , 'id' => 'price']) }}
                        </div>

                        @if ($errors->has('quantity'))
                            <span class="help-block error">
                                <strong>{{ $errors->first('quantity') }}</strong>
                            </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('quantity', 'تعداد') }}
                            {{ Form::text('quantity', ($post)? $post->quantity : ''  , ['class' => 'form-control num_must' , 'id' => 'quantity']) }}
                        </div>

                        @if ($errors->has('image'))
                            <span class="help-block error">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                        @endif
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
        $("#title").on('change keyup paste keydown', function(e) {
            persian_denied( $("#title") , e , parseInt($("#title").position().top) , "حروف فارسی");
        });

        $("#quantity").on('change keyup paste keydown', function(e) {
            $('#quantity').attr({ maxLength : 4 });
        });

        $(function() {
            $(".form-control").blur(function () {
                $('#error').addClass('hidden');
            });
        });

        $('#price').keyup(function(event) {

            // skip for arrow keys
            if(event.which >= 37 && event.which <= 40) return;

            // format number
            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    ;
            });
            $('#price').attr({ maxLength : 15 });
        });

        $(".num_must").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    </script>
@stop