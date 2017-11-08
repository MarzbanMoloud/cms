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
						<input type="email" placeholder="ایمیل" class="right-text-input" name="email"/>
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

						@if ($errors->has('name'))
							<span class="help-block error">
							{{ $errors->first('name') }}
							</span>
						@endif
						<input type="text" placeholder="نام" class="right-text-input" name="name"/>

						@if ($errors->has('email'))
							{{ $errors->first('email') }}
						@endif
						<input type="email" placeholder="ایمیل" class="right-text-input" name="email"/>

						@if ($errors->has('password'))
							{{ $errors->first('password') }}
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
@stop