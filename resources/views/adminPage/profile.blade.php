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
                    {!! Form::open([NULL  ,  'method' => 'POST' , 'role' => 'form' , 'files'=>true]) !!}
                    {{ Form::token() }}

                        @if ($errors->has('job'))
                            <span class="help-block error">
                                <strong>{{ $errors->first('job') }}</strong>
                            </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('job', 'شغل') }}
                            {{ Form::text('job', ($profile)? $profile->job : ''  , ['class' => 'form-control' , 'id' => 'job']) }}
                        </div>

                        @if ($errors->has('education'))
                            <span class="help-block error">
                                <strong>{{ $errors->first('education') }}</strong>
                            </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('education', 'تحصیلات') }}
                            {{ Form::text('education', ($profile)? $profile->education : ''  , ['class' => 'form-control' , 'id' => 'education']) }}
                        </div>

                        @if ($errors->has('mail'))
                            <span class="help-block error">
                                <strong>{{ $errors->first('mail') }}</strong>
                            </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('mail', 'پست الکترونیک') }}
                            {{ Form::text('mail', ($profile)? $profile->mail : ''  , ['class' => 'form-control' , 'id' => 'mail']) }}
                        </div>

                        @if ($errors->has('address'))
                            <span class="help-block error">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('address', 'آدرس') }}
                            {{ Form::text('address', ($profile)? $profile->address : ''  , ['class' => 'form-control' , 'id' => 'address']) }}
                        </div>

                        @if ($errors->has('detail'))
                            <span class="help-block error">
                                    <strong>{{ $errors->first('detail') }}</strong>
                                </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('detail', 'توضیحات') }}
                            {{ Form::textarea('detail', ($profile)? $profile->detail : '' , ['size' => '30x5' , 'class' => 'form-control']) }}
                        </div>

                        @if ($errors->has('avatar'))
                            <span class="help-block error">
                                <strong>{{ $errors->first('avatar') }}</strong>
                            </span>
                        @endif
                        <div class="form-group">
                            {{ Form::label('image', 'تصویر') }}
                            {{ Form::file('avatar') }}
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
@stop