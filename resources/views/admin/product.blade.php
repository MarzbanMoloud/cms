@extends('layout.panel-layout')
@section('content')

    <hr>
        <div class="well">
            <form role="form" action="{{$modify==1 ? route('update_product',['product'=>$product->id]) : route('addPost')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-group center">
                    <label for="cat" class="control-label"> دسته بندی ها</label>
                    <select name="cat" class="form-control " id="cat">
                        @foreach($categories as $category)
                            <option value="{{$category->id }}" {{($modify==1 and $category->id==$product->$category_id) ? 'selected' : ''}}> {{ $category->catName }} </option>
                        @endforeach
                    </select>
                    <label for="discount" class="control-label"> تخفیف</label>
                    <select name="discount" class="form-control " id="discount">
                        @foreach($discounts as $discount)
                            <option value="{{ $discount->id }}" {{($modify==1 and $discount->id==$product->discount_id) ? 'selected' : ''}}> {{ $discount->discountPercent }} </option>
                        @endforeach
                    </select>

                    <label for="tite" class="control-label"> عنوان</label>
                    <input class="form-control" id="title" type="text" name="title" value="{{$modify==1 ? $product->title : old('title')}}"/>
                    @if ($errors->has('title'))
                        <span class="help-block error">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                    @endif
                    <label for="price" class="control-label">قیمت</label>
                    <input class="form-control" id="price" type="text" name="price" value="{{$modify==1 ? $product->price : old('price')}}"/>
                    @if ($errors->has('price'))
                        <span class="help-block error">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                    @endif

                    <label for="quantity" class="control-label">تعداد</label>
                    <input class="form-control" id="quantity" type="text" name="quantity" value="{{$modify==1 ? $product->quantity : old('quantity')}}"/>
                    @if ($errors->has('quantity'))
                        <span class="help-block error">
                            <strong>{{ $errors->first('quantity') }}</strong>
                        </span>
                    @endif

                    <label for="image" class="control-label">تصویر</label>
                    <input type="file" id="image" name="image" value="">
                    @if ($errors->has('image'))
                        <span class="help-block error">
                            <strong>{{ $errors->first('image') }}</strong>
                        </span>
                    @endif

                    <br>
                    <label for="detail" class="control-label">توضیحات</label>
                    <textarea class="form-control postBody" id="detail" name="detail" rows="7">{{$modify==1 ? $product->detail : old('detail')}}</textarea>
                    @if ($errors->has('detail'))
                        <span class="help-block error">
                            <strong>{{ $errors->first('detail') }}</strong>
                        </span>
                    @endif

                </div>
                <input type="submit" name="submit" class="btn btn-primary" value="  ارسال  ">
            </form>


        </div>
    <hr>

@stop
