<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | E-Shopper</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <style>
        .right-text-input
        {
            text-align: right;
            padding-right:10px ;
        }
        .error {
            color: red;
        }
    </style>
</head><!--/head-->

<body>
<header id="header"><!--header-->

    <div class="header-middle"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="logo pull-left">
                        <a href="index.html"><img src="images/home/logo.png" alt="" /></a>
                    </div>
                    <div class="btn-group pull-right">
                    </div>
                </div>

                <div class="col-sm-2">
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())

                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu" style="text-align: right;">
                                    @if(Auth::user()->admin == 0)
                                        <li>
                                            <a href="{{ route('category') }}">پنل مدیریت</a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="#">پنل کاربری</a>
                                        </li>
                                    @endif
                                    <li>
                                        <a href="{{ route('logout') }}">
                                            خروچ از حساب
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">

                            <li><a href="#">درباره ما</a></li>
                            <li><a href="contact-us.html">تماس با ما</a></li>
                            <li><a href="{{ route('account') }}"><i class="fa fa-lock"></i> ورود</a></li>
                            <li><a href="cart.html"><i class="fa fa-shopping-cart"></i> سبد خرید</a></li>
                            <li><a href="{{ route('home') }}" class="active">خانه</a></li>

                        </ul>
                    </div>
                </div>

            </div>
            <div>
                <div class="search_box pull-left">
                    <input type="text" placeholder="Search"/>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->

                @yield('content');

<footer id="footer"><!--Footer-->
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="companyinfo">
                        <h2><span>e</span>-shopper</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
                    </div>
                </div>

        </div>
    </div>
    </div>



</footer><!--/Footer-->



<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.scrollUp.min.js"></script>
<script src="js/price-range.js"></script>
<script src="js/jquery.prettyPhoto.js"></script>
<script src="js/main.js"></script>
</body>
</html>