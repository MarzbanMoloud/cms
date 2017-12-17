@extends('layout.adminLayout')
@section('title','403')
@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-yellow"> 403 </h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> خطا! عدم دسترسی</h3>

                <p>
                    متاسفانه شما به محتوای این صفحه دسترسی ندارید
                    شما می توانید به   <a href="{{ route('dashboard') }}">داشبورد</a> بازگردید
                </p>

            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>
    <!-- /.content -->


@stop