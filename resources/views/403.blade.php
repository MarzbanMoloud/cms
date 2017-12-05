@extends('layout.adminLayout')
@section('title','403')
@section('content')




    <div class="container">
        <div class="push-up blocks-spacer">
            <div class="row">

                <!--  ==========  -->
                <!--  = Main content =  -->
                <!--  ==========  -->
                <section class="span12">

                    <p class="container-404" >
                       <h1 style="text-align: center">خطای 403</h1>
                    </p>

                    <hr/>

                    <p style="text-align: center">
                      شما مجوز دسترسی به این صفحه را ندارید
                    </p>
                    <p style="text-align: center">
                        به <a href="{{route('home')}}">خانه</a> باز گردید
                    </p>


                </section> <!-- /main content -->
            </div>
        </div>
    </div> <!-- /container -->


@stop