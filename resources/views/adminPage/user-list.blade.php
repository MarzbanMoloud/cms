@extends('layout.adminLayout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control pull-right" placeholder="جستجو">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="text-align: right">نام</th>
                            <th style="text-align: right">نام خانوادگی</th>
                            <th style="text-align: right">کدملی</th>
                            <th style="text-align: right">نام کاربری</th>
                            <th style="text-align: right">گروه</th>
                            <th style="text-align: right">حذف</th>
                            <th style="text-align: right">ویرایش</th>
                            <th style="text-align: right">وضعیت</th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->fname }}</td>
                                <td>{{ $user->lname }}</td>
                                <td>{{ $user->national_code }}</td>
                                <td>{{ $user->username }}</td>
                                <td>گروه</td>
                                <td>
                                    <a href="{{ route('removeUser' , ['user' => $user->id]) }}"><i class="fa fa-remove"></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('editUser' , ['user' => $user->id]) }}"><i class="fa fa-edit"></i></a>
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
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <li><a href="#">&laquo;</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">&raquo;</a></li>
                    </ul>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop