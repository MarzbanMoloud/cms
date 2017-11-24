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
            <form class="form-horizontal" action="{{ route('addRole') }}" method="post">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-sm-8" style="float: right;">
                            <label for="role">نام گروه</label>
                        </div>
                        <div class="col-sm-12" style="float: right;">
                            <input type="text" class="form-control" name="role">
                        </div>
                    </div>

                </div>
                <br>
                <!-- /.box-body -->
                <div class="box-footer">
                    <br>
                    <button type="submit" class="btn btn-primary">افزودن</button>
                </div>
                <!-- /.box-footer -->
            </form>
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
                <form class="form-horizontal" action="{{ route('loadingRole') }}">
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-8" style="float: right;">
                                <label for="role">انتخاب گروه</label>
                            </div>
                            <div class="col-sm-12" style="float: right;">
                            <select class="form-control" name="role" id="role">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}"> {{ $role->role }} </option>
                                @endforeach
                            </select>
                            </div>
                        </div>

                    </div>
                    <br>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <br>
                        <button type="submit" class="btn btn-primary">بارگذاری</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
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
            <form class="form-horizontal" action="{{ route('copyRole') }}" method="post">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-sm-8" style="float: right;">
                            <label for="roleCopy">انتخاب گروه</label>
                        </div>
                        <div class="col-sm-12" style="float: right;">
                            <select class="form-control" name="roleCopy" id="role">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}"> {{ $role->role }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8" style="float: right;">
                            <label for="roleNew">نام گروه</label>
                        </div>
                        <div class="col-sm-12" style="float: right;">
                            <input type="text" class="form-control" name="roleNew">
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">کپی</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>



@stop