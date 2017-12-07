@extends('layout.adminLayout')
@section('title' , 'مجوزها')
@section('content')
    <div class="col-md-4" style="float: right;">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title" style="font-family: 'B Yekan Regular';">ایجاد گروه جدید</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route' => 'addRole'  ,  'method' => 'POST' , 'role' => 'form' , 'class' => 'form-horizontal']) !!}
            {{ Form::token() }}
                <div class="box-body">

                    <div class="form-group">
                        <div class="col-sm-8" style="float: right;">
                            {{ Form::label('role', 'نام گروه') }}
                        </div>

                        @if ($errors->has('role'))
                            <span class="help-block error">
                            <strong>{{ $errors->first('role') }}</strong>
                        </span>
                        @endif

                        <div class="col-sm-12" style="float: right;">
                            {{ Form::text('role', null , ['class' => 'form-control' , 'id' => 'role']) }}
                            <div id="error" data-title="My tooltip"  class="hidden pointer_tooltip"></div>
                        </div>
                    </div>
                </div>
                <br>
                <!-- /.box-body -->
                <div class="box-footer">
                    <br>
                    {{ Form::submit('افزودن', ['class' => 'btn btn-primary' ]) }}
                </div>
                <!-- /.box-footer -->
            {!! Form::close() !!}
            <br>
            <br>
        </div>
    </div>

    <div class="col-md-4" style="float: right;">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title" style="font-family: 'B Yekan Regular';">ویرایش/نمایش گروه</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['route' => 'loadingRole' ,'role' => 'form' ,'method' => 'GET' , 'class' => 'form-horizontal']) !!}
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-8" style="float: right;">
                                {{ Form::label('role', 'انتخاب گروه') }}
                            </div>
                            <div class="col-sm-12" style="float: right;">
                                {{ Form::select('role' , $roles , null ,['class' => 'form-control'])  }}
                            </div>
                        </div>

                    </div>
                    <br>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <br>
                        {{ Form::submit('بارگزاری', ['class' => 'btn btn-primary']) }}
                    </div>
                    <!-- /.box-footer -->
                {!! Form::close() !!}
                <br>
                <br>
            </div>
        </div>

    <div class="col-md-4" style="float: right;">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title" style="font-family: 'B Yekan Regular';">کپی گروه</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['route' => 'copyRole' , 'method' => 'POST' ,'role' => 'form' , 'class' => 'form-horizontal']) !!}
            {{ Form::token() }}
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-sm-8" style="float: right;">
                            {{ Form::label('roleCopy', 'انتخاب گروه') }}
                        </div>
                        <div class="col-sm-12" style="float: right;">
                            {{ Form::select('roleCopy' , $roles , null ,['class' => 'form-control'])  }}
                        </div>
                    </div>

                    @if ($errors->has('roleNew'))
                        <span class="help-block error">
                            <strong>{{ $errors->first('roleNew') }}</strong>
                        </span>
                    @endif
                    <div class="form-group">
                        <div class="col-sm-8" style="float: right;">
                            {{ Form::label('roleNew', 'نام گروه') }}
                        </div>
                        <div class="col-sm-12" style="float: right;">
                            {{ Form::text('roleNew', null , ['class' => 'form-control' , 'id' => 'roleNew']) }}
                            <div id="error-new" data-title="My tooltip"  class="hidden pointer_tooltip"></div>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {{ Form::submit('کپی', ['class' => 'btn btn-primary']) }}
                </div>
                <!-- /.box-footer -->
            {!! Form::close() !!}
        </div>
    </div>


    <script>

        $("#role").on('change keyup paste keydown', function(e) {
            var p = /^[\u0600-\u06FF\s]+$/;
            if (e.keyCode != 8) {
                if (! p.test(e.key)) {
                    e.preventDefault();
                    document.getElementById("error").innerHTML = 'حروف فارسی';
                    $('#error').removeClass('hidden');
                } else {
                    $("#role").attr({ maxLength : 25 });
                    $('#error').addClass('hidden');
                }
            }
        });
        $("#roleNew").on('change keyup paste keydown', function(e) {
            var p = /^[\u0600-\u06FF\s]+$/;
            if (e.keyCode != 8) {
                if (! p.test(e.key)) {
                    e.preventDefault();
                    document.getElementById("error-new").innerHTML = 'حروف فارسی';
                    $('#error-new').removeClass('hidden');
                } else {
                    $("#roleNew").attr({ maxLength : 25 });
                    $('#error-new').addClass('hidden');
                }
            }
        });

        $(function() {
            $(".form-control").blur(function () {
                $('#error').addClass('hidden');
            });
        });
    </script>
@stop