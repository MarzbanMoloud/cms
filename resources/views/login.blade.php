@extends('layout.layout')
@section('content')
<section id="form"><!--form-->
	<div class="containe">
		<div class="row">
			<div class="col-sm-4 col-sm-offset-1">
				<div class="login-form"><!--login form-->
					<h2 style="text-align: right;">ورود به حساب کاربری</h2>
					<form action="{{ route('login') }}" method="post">
						{{ csrf_field() }}
						<input type="text" placeholder="نام کاربری" class="right-text-input" name="username"/>
						<input type="password" placeholder="رمز عبور" class="right-text-input" name="password"/>
						<button type="submit" class="btn btn-default pull-right" name="login">ورود</button>
					</form>
				</div><!--/login form-->
			</div>
			<div class="col-sm-1">
				<h2 class="or">یا</h2>
			</div>
			<div class="col-sm-4">
				<div class="signup-form"><!--sign up form-->
					<h2 style="text-align: right;">ثبت نام</h2>
					<form action="{{ route('register') }}" method="post">
						{{ csrf_field() }}

						@if ($errors->has('fname'))
							<span class="help-block error">
							{{ $errors->first('fname') }}
							</span>
						@endif
						<input type="text" placeholder="نام" class="right-text-input" name="fname"/>

						@if ($errors->has('lname'))
							<span class="help-block error">
							{{ $errors->first('lname') }}
							</span>
						@endif
						<input type="text" placeholder="نام خانوادگی" class="right-text-input" name="lname"/>

						@if ($errors->has('phone'))
							<span class="help-block error">
							{{ $errors->first('phone') }}
							</span>
						@endif
						<input type="text" placeholder="تلفن" class="right-text-input" name="phone"/>

						@if ($errors->has('national_code'))
							<span class="help-block error">
							{{ $errors->first('national_code') }}
							</span>
						@endif
						<input type="text" placeholder="کد ملی" class="right-text-input" name="national_code" id="national_code"/>
						<div id="message"></div>

						@if ($errors->has('username'))
							<span class="help-block error">
							{{ $errors->first('username') }}
							</span>
						@endif
						<input type="text" placeholder="نام کاربری" class="right-text-input" name="username"/>

						@if ($errors->has('password'))
							<span class="help-block error">
							{{ $errors->first('password') }}
							</span>
						@endif
						<input type="password" placeholder="رمز عبور " class="right-text-input" name="password"/>
						<input type="password" name="password_confirmation" placeholder="تکرار رمز عبور" class="right-text-input"/>

						<button type="submit" class="btn btn-default pull-right" name="register">ثبت نام</button>
					</form>
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
@stop