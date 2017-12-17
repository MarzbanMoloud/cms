@extends('layout.adminLayout')
@section('title' , 'مدیریت کاربران ')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-tools">
                        {!! Form::open([NULL ,  'method' => 'GET' , 'role' => 'form']) !!}
                            <div class="input-group input-group-sm" style="width: 150px;">
                                {{ Form::text('search', null  , ['class' => 'form-control pull-right' , 'placeholder' => 'جستجو']) }}
                                <div class="input-group-btn">
                                    {{ Form::button('<i class="fa fa-search"></i>', ['class' => 'btn btn-default btn-sm', 'type' => 'submit']) }}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <br>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: right">@sortablelink('fname' , 'نام')</th>
                                <th style="text-align: right">@sortablelink('lname' , 'نام خانوادگی')</th>
                                <th style="text-align: right">@sortablelink('national_code' , 'کد ملی')</th>
                                <th style="text-align: right">@sortablelink('username' , 'نام کاربری')</th>
                                <th style="text-align: right">@sortablelink('role' , 'گروه')</th>
                                <th style="text-align: right">حذف</th>
                                <th style="text-align: right">ویرایش</th>
                                <th style="text-align: right">وضعیت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->fname }}</td>
                                    <td>{{ $user->lname }}</td>
                                    <td>{{ $user->national_code }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->role->role }}</td>
                                    <td>
                                        <a href="{{ route('removeUser' , ['user' => $user->id]) }}"><i class="fa fa-remove"></i></a>
                                    </td>
                                    <td>
                                        <a href="/user/{{$user->id}}"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <form action="{{ route('statusUser' , ['user' => $user->id]) }}" method="post">
                                            {{ csrf_field() }}
                                            @if($user->status == '0')
                                                <i class="fa fa-lock"></i>
                                                <input type="submit" name="active" class="btn btn-primary btn-xs" value="فعال" style="float: left">
                                            @elseif($user->status == '1')
                                                <i class="fa fa-unlock"></i>
                                                <input type="submit" name="deActive" class="btn btn-primary btn-xs" value="غیر فعال" style="float: left">
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    {{ $users->links() }}
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop