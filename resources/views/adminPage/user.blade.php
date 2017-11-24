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
                <form role="form" action="{{$modify==1 ? route('updateUser',['user'=>$user->id]) : route('addUser')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="role">گروه</label>
                            <select class="form-control" name="role" id="role">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}"> {{ $role->role }} </option>
                            @endforeach
                            </select>
                        </div>

                        @if ($errors->has('fname'))
                            <span class="help-block error">
                                {{ $errors->first('fname') }}
                                </span>
                        @endif
                        <div class="form-group">
                            <label for="fname">نام</label>
                            <input type="text" class="form-control" id="fname"  name="fname" value="{{$modify==1 ? $user->fname : old('fname')}}">
                        </div>

                        @if ($errors->has('lname'))
                            <span class="help-block error">
                                {{ $errors->first('lname') }}
                                </span>
                        @endif
                        <div class="form-group">
                            <label for="lname">نام خانوادگی</label>
                            <input type="text" class="form-control" id="lname"  name="lname" value="{{$modify==1 ? $user->lname : old('lname')}}">
                        </div>

                        @if ($errors->has('phone'))
                            <span class="help-block error">
                                {{ $errors->first('phone') }}
                                </span>
                        @endif
                        <div class="form-group">
                            <label for="phone">تلفن</label>
                            <input type="text" class="form-control" id="phone"  name="phone" value="{{$modify==1 ? $user->phone : old('phone')}}">
                        </div>

                        @if ($errors->has('national_code'))
                            <span class="help-block error">
                                {{ $errors->first('national_code') }}
                                </span>
                        @endif
                        <div class="form-group">
                            <label for="national_code">کد ملی</label>
                            <input type="text" class="form-control" id="national_code" name="national_code" value="{{$modify==1 ? $user->national_code : old('national_code')}}">
                        </div>
                        <div id="message"></div>

                        @if ($errors->has('username'))
                            <span class="help-block error">
                                {{ $errors->first('username') }}
                                </span>
                        @endif
                        <div class="form-group">
                            <label for="username">نام کاربری</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{$modify==1 ? $user->username : old('username')}}">
                        </div>

                        @if ($errors->has('password'))
                            <span class="help-block error">
                                {{ $errors->first('password') }}
                                </span>
                        @endif
                        <div class="form-group">
                            <label for="image"> کلمه عبور</label>
                            <input type="password" placeholder="رمز عبور " class="form-control" name="password"/>
                            <br>
                            <input type="password" name="password_confirmation" placeholder="تکرار کلمه عبور" class="form-control"/>
                        </div>

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" name="submit" value="ارسال" />
                        </div>
                </form>
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
@stop