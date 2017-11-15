@extends('layout.layout')
@section('title','درباره ی ما')
@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div id="contact-page" class="container" style="height: 400px;padding-right: 100px">
                    <br>
                    <div class="bg">
                        <div class="row pull-right" style="border:solid 1px;border-color:#ffcc33;background-color:#f5f5ef;padding: 15px;width: 900px;">
                            <div class="col-sm-12">
                                {!! $page->body !!}
                            </div>
                        </div>
                    </div>
                </div><!--/#contact-page-->
            </div>
        </div>
    </section>
@stop

    
    