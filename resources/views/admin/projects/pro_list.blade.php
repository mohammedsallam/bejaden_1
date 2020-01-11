@extends('admin.index')
@section('title','قسم المشاريع')

@section('content')
    @push('css')
        <style>
            .bg-warning {
                background-color: #ffc107!important;

            }
        </style>
    @endpush
    <div class="box">

        <div class="col-md-3 col-sm-6 col-12">
            <a href="projects">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fa fa-calculator"></i></span>

                    <div class="info-box-content">
                        <h2 class="info-box-text">بيانات المشاريع</h2>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="ProjectsSites">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fa fa-user-plus"></i></span>

                    <div class="info-box-content">
                        <h2 class="info-box-text">بيانات مواقع المشاريع</h2>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="project_contract">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fa fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                        <h2 class="info-box-text">عقود المشروع</h2>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="contracts">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fa fa-users"></i></span>

                    <div class="info-box-content">
                        <h2 class="info-box-text">بيانات عقود المقاولين</h2>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </a>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <a href="#">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fa fa-money" aria-hidden="true"></i></span>

                    <div class="info-box-content">
                        <h2 class="info-box-text">التقارير </h2>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </a>
        </div>
{{--        <div class="col-md-3 col-sm-6 col-12">--}}
{{--            <a href="#">--}}
{{--                <div class="info-box">--}}
{{--                    <span class="info-box-icon bg-warning"><i class="fa fa-money" aria-hidden="true"></i></span>--}}

{{--                    <div class="info-box-content">--}}
{{--                        <h2 class="info-box-text">بيانات العملات </h2>--}}
{{--                    </div>--}}
{{--                    <!-- /.info-box-content -->--}}
{{--                </div>--}}
{{--                <!-- /.info-box -->--}}
{{--            </a>--}}
{{--        </div>--}}
{{--        <div class="col-md-3 col-sm-6 col-12">--}}
{{--            <a href="#">--}}
{{--                <div class="info-box">--}}
{{--                    <span class="info-box-icon bg-warning"><i class="fa fa-money" aria-hidden="true"></i></span>--}}

{{--                    <div class="info-box-content">--}}
{{--                        <h2 class="info-box-text">طريقة الدفع </h2>--}}
{{--                    </div>--}}
{{--                    <!-- /.info-box-content -->--}}
{{--                </div>--}}
{{--                <!-- /.info-box -->--}}
{{--            </a>--}}
{{--        </div>--}}
{{--        <div class="col-md-3 col-sm-6 col-12">--}}
{{--            <a href="#">--}}
{{--                <div class="info-box">--}}
{{--                    <span class="info-box-icon bg-warning"><i class="fa fa-money" aria-hidden="true"></i></span>--}}

{{--                    <div class="info-box-content">--}}
{{--                        <h2 class="info-box-text">مكان تسليم البضاعة </h2>--}}
{{--                    </div>--}}
{{--                    <!-- /.info-box-content -->--}}
{{--                </div>--}}
{{--                <!-- /.info-box -->--}}
{{--            </a>--}}
{{--        </div>--}}

    </div>


@endsection
