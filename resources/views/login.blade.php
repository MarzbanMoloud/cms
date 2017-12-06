@extends('layout.layout')
@section('content')
<section id="form"><!--form-->
	<div class="containe">
		<div class="row">
			<div class="col-sm-4 col-sm-offset-1">
				<div class="login-form"><!--login form-->
					<h2 style="text-align: right;">ورود به حساب کاربری</h2>
					{!! Form::open(['route' => 'login', 'method' => 'POST']) !!}

					{{ Form::token() }}
						@if ($errors->has('ncode'))
							<span class="help-block error">
							{{ $errors->first('ncode') }}
							</span>
						@endif
					{{ Form::text('ncode', null, ['class' => 'right-text-input', 'placeholder' => 'کد ملی', 'value' => old('ncode')]) }}

						@if ($errors->has('pass'))
							<span class="help-block error">
							{{ $errors->first('pass') }}
							</span>
						@endif
					{{ Form::password('pass', ['class' => 'right-text-input', 'placeholder' => 'رمز عبور']) }}
					{{ Form::submit('Login', ['class' => 'btn btn-default pull-right']) }}

					{!! Form::close() !!}
				</div><!--/login form-->
			</div>
			<div class="col-sm-1">
				<h2 class="or">یا</h2>
			</div>
			<div class="col-sm-4">
				<div class="signup-form"><!--sign up form-->
					<h2 style="text-align: right;">ثبت نام</h2>
					{!! Form::open(['route' => 'register', 'method' => 'POST']) !!}
					{{ Form::token() }}

						@if ($errors->has('fname'))
							<span class="help-block error">
							{{ $errors->first('fname') }}
							</span>
						@endif
					{{ Form::text('fname', null, ['class' => 'right-text-input', 'placeholder' => 'نام', 'value' => old('fname') , 'id' => 'fname']) }}
                    <div id="error" data-title="My tooltip"  class="hidden pointer_tooltip"></div>

						@if ($errors->has('lname'))
							<span class="help-block error">
							{{ $errors->first('lname') }}
							</span>
						@endif
					{{ Form::text('lname', null, ['class' => 'right-text-input', 'placeholder' => 'نام خانوادگی', 'value' => old('lname') , 'id' => 'lname']) }}

						@if ($errors->has('phone'))
							<span class="help-block error">
							{{ $errors->first('phone') }}
							</span>
						@endif
					{{ Form::text('phone', null, ['class' => 'right-text-input', 'placeholder' => 'تلفن', 'value' => old('phone') , 'id' => 'phone']) }}

						@if ($errors->has('national_code'))
							<span class="help-block error">
							{{ $errors->first('national_code') }}
							</span>
						@endif
					{{ Form::text('national_code', null, ['class' => 'right-text-input','id' => 'national_code' , 'placeholder' => 'کد ملی', 'value' => old('national_code')]) }}<img src="{{ asset('images/search.png') }}" id="search" width="20px;">
						<div id="message"></div>

						@if ($errors->has('username'))
							<span class="help-block error">
							{{ $errors->first('username') }}
							</span>
						@endif
					{{ Form::text('username', null, ['class' => 'right-text-input', 'placeholder' => 'نام کاربری', 'value' => old('username') , 'id' => 'username']) }}

						@if ($errors->has('password'))
							<span class="help-block error">
							{{ $errors->first('password') }}
							</span>
						@endif
					{{ Form::password('password',  array('placeholder'=>'رمز عبور' , 'class' => 'right-text-input')) }}
					{{ Form::password('password_confirmation', array('class' => 'right-text-input', 'placeholder' => 'تکرار رمز عبور')) }}
					{{ Form::submit('register', ['class' => 'btn btn-default pull-right' , 'value' => 'ثبت نام']) }}

					{!! Form::close() !!}
				</div><!--/sign up form-->
			</div>
		</div>
	</div>
</section><!--/form-->




<!-- check_Unique_National_code_Start -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
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
            $("#national_code").css("background-color","#e7ffde");
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
        $(".right-text-input").blur(function(){
            $('#error').addClass('hidden');
        });

        $("#phone").on('blur', function(e) {
            var p = /^(09{1})+([0-3]{1})+(\d{8})$/;
            if (! p.test($("#phone").val())) {
                $("#phone").css("background-color","#f5cac2").val("").focus();
            }else{
                $("#phone").css("background-color","#e7ffde");
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