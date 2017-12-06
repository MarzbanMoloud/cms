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
                    {!! Form::open([NULL  ,  'method' => 'POST' , 'role' => 'form' , 'enctype' => 'multipart/form-data']) !!}
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
                        <div id="error" data-title="My tooltip"  class="hidden pointer_tooltip"></div>

                        @if ($errors->has('lname'))
                            <span class="help-block error">
                                {{ $errors->first('lname') }}
                                </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('lname', 'نام خانوادگی') }}
                            {{ Form::text('lname', ($user)? $user->lname : ''  , ['class' => 'form-control' , 'id' => 'lname']) }}
                        </div>

                        @if ($errors->has('phone'))
                            <span class="help-block error">
                                {{ $errors->first('phone') }}
                                </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('phone', 'تلفن') }}
                            {{ Form::text('phone', ($user)? $user->phone : ''  , ['class' => 'form-control num_must' , 'id' => 'phone']) }}
                        </div>

                        @if ($errors->has('national_code'))
                            <span class="help-block error">
                                {{ $errors->first('national_code') }}
                                </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('national_code', 'کد ملی') }}
                            {{ Form::text('national_code', ($user)? $user->national_code : ''  , ['class' => 'form-control num_must' , 'id' => 'national_code']) }}
                        </div>
                        <div id="message"></div>

                        @if ($errors->has('username'))
                            <span class="help-block error">
                                {{ $errors->first('username') }}
                            </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('username', 'نام کاربری') }}
                            {{ Form::text('username', ($user)? $user->username : ''  , ['class' => 'form-control' , 'id' => 'username']) }}
                        </div>

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
    <script>
        $(document).ready(function () {
            $("#search").click(function () {
                var national_code = $("#national_code").val();
                if(document.getElementById("national_code").value) {
                    $("#message").html("<img src='images/loading.gif' style='width: 20px;' /> Checking..." );
                    setTimeout(function () {
                        checkData()
                    }, 3000);

                    function checkData() {
                        $.ajax({
                            type: "post",
                            url: 'uniqueCode',
                            dataType: 'json',
                            data: {'national_code': national_code, "_token": "{{ csrf_token() }}"},
                            success: function (data) {
                                if (data) {
                                    $("#message").html("<img src='images/cross.png' style='width: 20px;' /> کد ملی تکراری است");
                                } else {
                                    $("#message").html("<img src='images/yes.png' style='width: 20px;' /> کد ملی تایید شد ");
                                }
                            }
                        });
                    }
                }else{
                    $("#message").html(" فیلد خالی است ");
                }
            });
        });
    </script>
    <!-- check_Unique_National_code_End -->

    <!-- Validation_for_SignUp_Start -->
    <script>
        $("#national_code").on('blur', function(e) {
            var input = $("#national_code").val();
            var p = /^[0-9]{10}$/ ;

            if (! p.test(input)){
                $("#national_code").css("background-color","#f5cac2").val("").focus();
            }

            var controlCode = Number(input[9]);
            var sumOfCodeSet = 0;

            for (var i = 0; i < 9; i++) {
                sumOfCodeSet += parseInt(input[i]) * (10 - i);
            }

            var remainValue = sumOfCodeSet % 11;

            if ((remainValue < 2 && remainValue === controlCode) || (remainValue >= 2 && (controlCode + remainValue) === 11)){
                $("#national_code").css("background-color","white");
            } else{
                $("#national_code").css("background-color","#f5cac2").val("").focus();
            }
        });
    </script>
    <!-- Validation_for_SignUp_End -->

   <script>
        function persian_denied(elename , e , pos , msg){
            var p = /^[\u0600-\u06FF\s]+$/;
            if (e.keyCode != 8) {
                if (! p.test(e.key)) {
                    e.preventDefault();
                    document.getElementById("error").innerHTML = msg;
                    $('#error').css("top",pos+38).removeClass('hidden');
                } else {
                    elename.attr({ maxLength : 40 });
                    $('#error').addClass('hidden');
                }
            }
        }

        function just_en(elename , e , pos , msg){
            var p = /^[a-zA-Z\s]+$/;
            if (e.keyCode != 8) {
                if (! p.test(e.key)) {
                    e.preventDefault();
                    document.getElementById("error").innerHTML = msg;
                    $('#error').css("top",pos+38).removeClass('hidden');
                } else {
                    elename.attr({ maxLength : 20 });
                    $('#error').addClass('hidden');
                }
            }
        }

        $("#lname").on('change keyup paste keydown', function(e) {
            persian_denied( $("#lname") , e , parseInt($("#lname").position().top) , "حروف فارسی");
        });

        $("#fname").on('change keyup paste keydown', function(e) {
            persian_denied( $("#fname") , e , parseInt($("#fname").position().top) , 'حروف فارسی');
        });

        $("#username").on('change keyup paste keydown', function(e) {
            just_en( $("#username") , e , parseInt($("#username").position().top) , 'حروف لاتین');
        });

        $(function(){
            $(".form-control").blur(function(){
                $('#error').addClass('hidden');
            });

            $("#phone").on('blur', function(e) {
                var p = /^(09{1})+([0-3]{1})+(\d{8})$/;
                if (! p.test($("#phone").val())) {
                    $("#phone").css("background-color","#f5cac2").val("").focus();
                }else{
                    $("#phone").css("background-color","white");
                }
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
        });

    </script>

@stop