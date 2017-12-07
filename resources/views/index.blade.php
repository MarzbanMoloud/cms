@extends('layout.layout')
@section('content')
	<div class="header-bottom"><!--header-bottom-->
		<div class="container">
			<div class="row">
				<div class="col-sm-9">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>

					</div>
				</div>
			</div>
		</div>
	</div><!--/header-bottom-->
	</header><!--/header-->
	@if(isset($userpage) and $userpage == true)
		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-3 pull-right" >
						<div class="left-sidebar">
							<h2>دسته بندی</h2>
							<div class="panel-group category-products" id="accordian" ><!--category-productsr-->
								@foreach($categories as $category)
									<div class="panel panel-default" >
										<div class="panel-heading">
											<h4 class="panel-title"><strong><a href="{{ $category->id }}">{{ $category->catName }}</a></strong></h4>
										</div>
									</div>
								@endforeach
							</div><!--/category-products-->


							<div class="price-range" ><!--price-range-->
								<h2>فیلتر قیمت</h2>
								<div class="well text-center">
									<input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
									<b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
								</div>
							</div><!--/price-range-->

						</div>
					</div>
					<div class="col-sm-9 padding-right" style="text-align: right;padding-right: 10px;">
 							<div>{!! $page->body !!}</div>
					</div>
				</div>
			</div>
		</section>
		<hr>
	@else
	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>

						<div class="carousel-inner">
							<div class="item active">
								<div class="col-sm-6">
									<img src="images/home/slide3.jpg" class="girl img-responsive" alt="" />
								</div>
								<div class="col-sm-4" style="text-align: right">
									<h2> لباس های بچه گانه</h2>
									<p> با کیفیت و مقرون به صرفه </p>
								</div>
								<div class="col-sm-2"></div>
							</div>
							<div class="item">
								<div class="col-sm-6">
									<img src="images/home/slide3.jpg" class="girl img-responsive" alt="" />
								</div>
								<div class="col-sm-4" style="text-align: right">
									<h2> لباس های دخترانه و پسرانه</h2>
									<p> در رنگ ها و طرح های مختلف </p>
								</div>
								<div class="col-sm-2"></div>
							</div>

							<div class="item">
								<div class="col-sm-6">
									<img src="images/home/slide3.jpg" class="girl img-responsive" alt="" />
								</div>
								<div class="col-sm-4" style="text-align: right">
									<h2>جدیدترین و شیک ترین پوشاک</h2>
									<p> خرید اینترنتی را با ما تجربه کنید </p>
								</div>
								<div class="col-sm-2"></div>
							</div>

						</div>

						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>

				</div>
			</div>
		</div>
	</section><!--/slider-->

	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3 pull-right" >
					<div class="left-sidebar">
						<h2>دسته بندی</h2>
						<div class="panel-group category-products" id="accordian" ><!--category-productsr-->
							@foreach($categories as $category)
							<div class="panel panel-default" >
								<div class="panel-heading">
									<h4 class="panel-title"><strong><a href="{{ $category->id }}">{{ $category->catName }}</a></strong></h4>
								</div>
							</div>
							@endforeach
						</div><!--/category-products-->


						<div class="price-range" ><!--price-range-->
							<h2>فیلتر قیمت</h2>
							<div class="well text-center">
								<input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
								<b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
							</div>
						</div><!--/price-range-->

					</div>
				</div>

				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">محصولات</h2>
						@foreach($products as $product)
						<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
										<div class="productinfo text-center">
											<img src={{$product->photo}} alt="" style="width: 250px;height: 250px;" />
											<h2>{{ number_format($product->price) }}</h2>
											<p>{{ $product->title }}</p>
											<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>افزوددن به سبد</a>
										</div>
										<div class="product-overlay">
											<div class="overlay-content">
												<h2>{{ number_format($product->price) }}</h2>
												<p>{{ $product->title }}</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
											</div>
										</div>
								</div>
							</div>
						</div>
						@endforeach

						<div class="text-center">
							{{$products->appends(Request::input())->links()}}
						</div>

					</div><!--features_items-->
				</div>
			</div>
		</div>
	</section>
	@endif
@stop