@extends('layout.adminLayout')
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
                <form role="form" action="{{$modify==1 ? route('updatePost',['post'=>$post->id]) : route('addPost')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="cat">دسته بندی</label>
                            <select class="form-control select2" name="cat" id="cat">
                                @foreach($categories as $category)
                                    <option value="{{$category->id }}" {{($modify==1 and $category->id==$post->category_id) ? 'selected' : ''}}> {{ $category->catName }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="discount">تخفیف</label>
                            <select class="form-control select2" name="discount" id="discount">
                                @foreach($discounts as $discount)
                                    <option value="{{ $discount->id }}" {{($modify==1 and $discount->id==$post->discount_id) ? 'selected' : ''}}> {{ $discount->discountPercent }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tite">عنوان پست</label>
                            <input type="text" class="form-control" id="title"  name="title" value="{{$modify==1 ? $post->title : old('title')}}">
                        </div>
                        @if ($errors->has('title'))
                            <span class="help-block error">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                        @endif

                        <div class="form-group">
                            <label for="price">قیمت</label>
                            <input type="text" class="form-control" id="price" name="price" value="{{$modify==1 ? $post->price : old('price')}}">
                        </div>
                        @if ($errors->has('price'))
                            <span class="help-block error">
                            <strong>{{ $errors->first('price') }}</strong>
                        </span>
                        @endif

                        <div class="form-group">
                            <label for="quantity">تعداد</label>
                            <input type="text" class="form-control" id="quantity" name="quantity" value="{{$modify==1 ? $post->quantity : old('quantity')}}">
                        </div>
                        @if ($errors->has('quantity'))
                            <span class="help-block error">
                            <strong>{{ $errors->first('quantity') }}</strong>
                        </span>
                        @endif

                        <div class="form-group">
                            <label for="image">تصویر شاخص</label>
                            <input type="file" id="image" name="image">
                        </div>
                        @if ($errors->has('image'))
                            <span class="help-block error">
                            <strong>{{ $errors->first('image') }}</strong>
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

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" name="draft" value="پیش نویس" />
                            <input type="submit" class="btn btn-primary" name="publish" value="انتشار" />
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