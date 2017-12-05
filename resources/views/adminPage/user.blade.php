@extends('layout.adminLayout')
@section('title' , 'ایجاد کاربر')
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
                            {{ Form::label('role', 'گروه') }}
                            {{ Form::select('role' , $roles , null ,['class' => 'form-control'])  }}
                        </div>

                        @if ($errors->has('fname'))
                            <span class="help-block error">
                                {{ $errors->first('fname') }}
                                </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('fname', 'نام') }}
                            {{ Form::text('fname', ($user)? $user->fname : ''  , ['class' => 'form-control' , 'id' => 'fname']) }}
                        </div>
                        <div id="error-fname" data-title="My tooltip"  class="hidden pointer_tooltip">حروف فارسی</div>

                        @if ($errors->has('lname'))
                            <span class="help-block error">
                                {{ $errors->first('lname') }}
                                </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('lname', 'نام خانوادگی') }}
                            {{ Form::text('lname', ($user)? $user->lname : ''  , ['class' => 'form-control' , 'id' => 'lname']) }}
                        </div>
                        <div id="error-lname" data-title="My tooltip"  class="hidden pointer_tooltip">حروف فارسی</div>

                        @if ($errors->has('phone'))
                            <span class="help-block error">
                                {{ $errors->first('phone') }}
                                </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('phone', 'تلفن') }}
                            {{ Form::text('phone', ($user)? $user->phone : ''  , ['class' => 'form-control' , 'id' => 'phone']) }}
                        </div>
                        <div id="error-phone" data-title="My tooltip"  class="hidden pointer_tooltip">تلفن</div>

                        @if ($errors->has('national_code'))
                            <span class="help-block error">
                                {{ $errors->first('national_code') }}
                                </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('national_code', 'کد ملی') }}
                            {{ Form::text('national_code', ($user)? $user->national_code : ''  , ['class' => 'form-control' , 'id' => 'national_code']) }}
                        </div>
                        <div id="message"></div>
                        <div id="error-ncode" data-title="My tooltip"  class="hidden pointer_tooltip">کد ملی</div>

                        @if ($errors->has('username'))
                            <span class="help-block error">
                                {{ $errors->first('username') }}
                            </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('username', 'نام کاربری') }}
                            {{ Form::text('username', ($user)? $user->username : ''  , ['class' => 'form-control' , 'id' => 'username']) }}
                        </div>
                        <div id="error-username" data-title="My tooltip"  class="hidden pointer_tooltip">حروف لاتین</div>

                        @if ($errors->has('password'))
                            <span class="help-block error">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('password', 'کلمه عبور') }}
                            {{ Form::password('password' , ['class' => 'form-control']) }}
                            <br>
                            {{ Form::password('password_confirmation' , ['class' => 'form-control']) }}
                        </div>

                        <div class="box-footer">
                            {{ Form::submit('ارسال', ['class' => 'btn btn-primary' , 'name' => 'submit']) }}
                        </div>
                    {!! Form::close() !!}
            </div>
        </div>
            <!-- /.box -->
    </div>
        <!-- /.col-->
</div>
    <!-- ./row -->
    <!-- check_Unique_National_code_Start -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#national_code").change(function () {
                $("#message").html("<img src='images/loading.gif' style='width: 20px;' /> Checking..." );
                var national_code=$("#national_code").val();
                setTimeout(function(){checkData()}, 3000);
                function checkData() {
                    $.ajax({
                        type: "post",
                        url: 'uniqueCode',
                        dataType: 'json',
                        data: {'national_code': national_code, "_token": "{{ csrf_token() }}"},
                        success: function (data) {
                            if (data) {
                                $("#message").html("<img src='images/cross.png' style='width: 20px;' /> National_code already taken");
                            } else {
                                $("#message").html("<img src='images/yes.png' style='width: 20px;' /> National_code available ");
                            }
                        }
                    });
                }
            });
        });
    </script>
    <!-- check_Unique_National_code_End -->
    <script>
        $("#fname").on('change keyup paste keydown', function(e) {
            var p = /^[\u0600-\u06FF\s]+$/;
            if (e.keyCode != 8) {
                if (! p.test(e.key)) {
                    e.preventDefault();
                    $('#error-fname').removeClass('hidden');}
                else {
                    $('#fname').attr({ maxLength : 30 });
                    $('#error-fname').addClass('hidden');
                }
            }
        });
    </script>
    <script>
        $("#lname").on('change keyup paste keydown', function(e) {
            var p = /^[\u0600-\u06FF\s]+$/;
            if (e.keyCode != 8) {
                if (! p.test(e.key)) {
                    e.preventDefault();
                    $('#error-lname').removeClass('hidden');}
                else {
                    $('#lname').attr({ maxLength : 40 });
                    $('#error-lname').addClass('hidden');
                }
            }
        });
    </script>
    <script>
        $("#phone").on('change keyup paste keydown', function(e) {
            var p = /^[0-9]+$/;
            if (e.keyCode != 8) {
                if (! p.test(e.key)) {
                    e.preventDefault();
                    $('#error-phone').removeClass('hidden');}
                else {
                    $('#phone').attr({ maxLength : 11 });
                    $('#error-phone').addClass('hidden');
                }
            }
        });
    </script>
    <script>
        $("#national_code").on('change keyup paste keydown', function(e) {
            var p = /^[0-9]+$/;
            if (e.keyCode != 8) {
                if (! p.test(e.key)) {
                    e.preventDefault();
                    $('#error-ncode').removeClass('hidden');}
                else {
                    $('#national_code').attr({ maxLength : 10 });
                    $('#error-ncode').addClass('hidden');
                }
            }
        });
    </script>
    <script>
        $("#username").on('change keyup paste keydown', function(e) {
            var p = /^[a-zA-Z]+$/;
            if (e.keyCode != 8) {
                if (! p.test(e.key)) {
                    e.preventDefault();
                    $('#error-username').removeClass('hidden');}
                else {
                    $('#username').attr({ maxLength : 15 });
                    $('#error-username').addClass('hidden');
                }
            }
        });
    </script>
@stop