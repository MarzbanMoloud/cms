@extends('layout.layout')
@section('title','تماس با ما')
@section('content')

    <div id="contact-page" class="container">
        <div class="bg">
            <div class="row">
                <div class="col-sm-8 pull-right">
                    <div class="contact-form">
                        <br>
                        <br>
                        <br>
                        <div class="status alert alert-success" style="display: none"></div>
                        <form id="main-contact-form" class="contact-form row" name="contact-form" method="post">
                            <div class="form-group col-md-6">
                                <input type="text" name="name" class="form-control right-text-input" required="required" placeholder="نام">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="email" name="email" class="form-control right-text-input" required="required" placeholder="ایمیل">
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" name="subject" class="form-control right-text-input" required="required" placeholder="عنوان">
                            </div>
                            <div class="form-group col-md-12">
                                <textarea name="message" id="message" required="required" class="form-control right-text-input" rows="8" placeholder="متن پیام"></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <input type="submit" name="submit" class="btn btn-primary pull-right" value="ارسال">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="contact-info">

                    </div>
                </div>
            </div>
        </div>
    </div><!--/#contact-page-->

@stop
    
    