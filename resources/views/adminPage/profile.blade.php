@extends('layout.adminLayout')
@section('title' , 'پروفایل')
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
                <form role="form" action="{{$modify==1 ? route('updatePost',['post'=>$post->id]) : route('createProfile')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="job">شغل</label>
                            <input type="text" class="form-control" id="job"  name="job" value="{{$modify==1 ? $post->job : old('job')}}">
                        </div>
                        @if ($errors->has('job'))
                            <span class="help-block error">
                            <strong>{{ $errors->first('jib') }}</strong>
                        </span>
                        @endif

                        <div class="form-group">
                            <label for="education">تحصیلات</label>
                            <input type="text" class="form-control" id="education" name="education" value="{{$modify==1 ? $post->education : old('education')}}">
                        </div>
                        @if ($errors->has('education'))
                            <span class="help-block error">
                            <strong>{{ $errors->first('education') }}</strong>
                        </span>
                        @endif

                        <div class="form-group">
                            <label for="mail">پست الکترونیک</label>
                            <input type="email" class="form-control" id="mail" name="mail" value="{{$modify==1 ? $post->mail : old('mail')}}">
                        </div>
                        @if ($errors->has('mail'))
                            <span class="help-block error">
                            <strong>{{ $errors->first('mail') }}</strong>
                        </span>
                        @endif

                        <div class="form-group">
                            <label for="address">آدرس</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{$modify==1 ? $post->address : old('address')}}">
                        </div>
                        @if ($errors->has('address'))
                            <span class="help-block error">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif

                        <div class="form-group">
                            <label for="detail">توضیحات</label>
                            <textarea class="form-control" id="detail" name="detail" rows="7">
                                {{$modify==1 ? $post->detail : old('detail')}}
                            </textarea>
                        </div>
                        @if ($errors->has('detail'))
                            <span class="help-block error">
                                <strong>{{ $errors->first('detail') }}</strong>
                            </span>
                        @endif

                        <div class="form-group">
                            <label for="avatar">عکس</label>
                            <input type="file" id="avatar" name="avatar">
                        </div>
                        @if ($errors->has('avatar'))
                            <span class="help-block error">
                            <strong>{{ $errors->first('avatar') }}</strong>
                        </span>
                        @endif

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
@stop