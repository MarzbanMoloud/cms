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
						@if ($errors->has('national_code'))
							<span class="help-block error">
							{{ $errors->first('national_code') }}
							</span>
						@endif
					{{ Form::text('national_code', null, ['class' => 'right-text-input', 'placeholder' => 'کد ملی', 'value' => old('national_code')]) }}

						@if ($errors->has('password'))
							<span class="help-block error">
							{{ $errors->first('password') }}
							</span>
						@endif
					{{ Form::password('password', ['class' => 'right-text-input', 'placeholder' => 'رمز عبور']) }}
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
					{{ Form::text('fname', null, ['class' => 'right-text-input', 'placeholder' => 'نام', 'value' => old('fname')]) }}

						@if ($errors->has('lname'))
							<span class="help-block error">
							{{ $errors->first('lname') }}
							</span>
						@endif
					{{ Form::text('lname', null, ['class' => 'right-text-input', 'placeholder' => 'نام خانوادگی', 'value' => old('lname')]) }}

						@if ($errors->has('phone'))
							<span class="help-block error">
							{{ $errors->first('phone') }}
							</span>
						@endif
					{{ Form::text('phone', null, ['class' => 'right-text-input', 'placeholder' => 'تلفن', 'value' => old('phone')]) }}

						@if ($errors->has('national_code'))
							<span class="help-block error">
							{{ $errors->first('national_code') }}
							</span>
						@endif
					{{ Form::text('national_code', null, ['class' => 'right-text-input','id' => 'national_code' , 'placeholder' => 'کد ملی', 'value' => old('national_code')]) }}
						<div id="message"></div>

						@if ($errors->has('username'))
							<span class="help-block error">
							{{ $errors->first('username') }}
							</span>
						@endif
					{{ Form::text('username', null, ['class' => 'right-text-input', 'placeholder' => 'نام کاربری', 'value' => old('username')]) }}

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
                            $("#message").html("<img src='images/cross.png' style='width: 20px;' /> کد ملی تکراری است");
                        } else {
                            $("#message").html("<img src='images/yes.png' style='width: 20px;' /> کد ملی تایید شد ");
                        }
                    }
                });
            }
        });
    });
</script>
<!-- check_Unique_National_code_End -->

<!-- Validation_for_SignUp_Start -->
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
    $.validator.addMethod('customphone', function (value, element) {
        return this.optional(element) || /^\d{3}-\d{3}-\d{4}$/.test(value);
    }, "Please enter a valid phone number");
	$().ready(function () {
        $( ".signup-form" ).validate({
            rules: {
                phone: {
                    regx:customphone,
                    required: true,
                    number: true
                }
            }
        });
    })
</script>
<!-- Validation_for_SignUp_End -->

@stop