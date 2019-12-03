@extends('admin.index')
@section('title', trans('admin.show_profile_to') .session_lang($driver->name_en,$driver->name_ar))
@section('content')
    @push('css')
        <style>
            .list-group-item {
                padding: 30px 15px !important;
            }
        </style>

    @endpush


    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="@if($driver->image != null){{asset('storage/'.$driver->image)}}@else {{url('/')}}/adminlte/previewImage.png @endif" alt="User profile picture">

                    <h3 class="profile-username text-center">{{session_lang($driver->name_en,$driver->name_ar)}}</h3>

                    <p class="text-muted text-center">{{\App\Enums\StatusType::getDescription($driver->status)}}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>{{trans('admin.salary')}}</b> <a class="pull-right">{{$driver->salary}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{trans('admin.license_num')}}</b> <a class="pull-right">{{$driver->license_num}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{trans('admin.license_type')}}</b> <a class="pull-right">{{\App\Enums\LicenseType::getDescription($driver->license_type)}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{trans('admin.date_issuance')}}</b> <a class="pull-right">{{$driver->date_issuance}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{trans('admin.expired_date')}}</b> <a class="pull-right">{{$driver->expired_date}}</a>
                        </li>
                        @if($driver->state != null)
                        <li class="list-group-item">
                            <b>{{trans('admin.place_issuance')}}</b> <a class="pull-right">{{session_lang($driver->state->state_name_en,$driver->state->state_name_ar)}}</a>
                        </li>
                        @endif
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{trans('admin.about_driver')}}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <strong><i class="fa fa-map-marker margin-r-5"></i> {{trans('admin.addriss')}}</strong>

                    <p class="text-muted">{{$driver->addriss}}</p>
                    <hr>
                    <strong><i class="fa fa-phone margin-r-5"></i> {{trans('admin.mob')}}</strong>

                    <p class="text-muted">{{$driver->phone}}</p>
                    <hr>

                    <strong><i class="fa fa-circle margin-r-5"></i> {{trans('admin.gender')}}</strong>

                    <p class="text-muted">{{\App\Enums\GenderType::getDescription($driver->gender)}}</p>

                    <hr>


                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab">{{trans('admin.activity')}}</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <div class="row">
                            <div class="col-md-2">
                                <strong>
                                    {{trans('admin.full_name')}}
                                </strong>
                            </div>
                            <div class="col-md-10">
                                :     {{session_lang($driver->name_en,$driver->name_ar)}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <strong>
                                    {{trans('admin.addriss')}}
                                </strong>
                            </div>
                            <div class="col-md-10">
                                :     {{$driver->addriss}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <strong>
                                    {{trans('admin.phone')}}
                                </strong>
                            </div>
                            <div class="col-md-10">
                                :     {{$driver->phone}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <strong>
                                    {{trans('admin.license_image')}}
                                </strong>
                            </div>
                            <div class="col-md-10">
                                :     <img class="img-responsive img-thumbnail" src="{{asset('storage/'.$driver->license_image)}}" alt="" style="width:300px">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <strong>
                                    {{trans('admin.birth_date')}}
                                </strong>
                            </div>
                            <div class="col-md-10">
                                :     {{$driver->birth_date}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <strong>
                                    {{trans('admin.birth_place')}}
                                </strong>
                            </div>
                            <div class="col-md-10">
                                :     @if($driver->birth != null ){{session_lang($driver->birth->state_name_en,$driver->birth->state_name_ar)}}@else {{null}} @endif
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <strong>
                                    {{trans('admin.religion')}}
                                </strong>
                            </div>
                            <div class="col-md-10">
                                :     {{\App\Enums\ReligionType::getDescription($driver->religion)}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <strong>
                                    {{trans('admin.social_status')}}
                                </strong>
                            </div>
                            <div class="col-md-10">
                                :     {{\App\Enums\SocialType::getDescription($driver->social_status)}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <strong>
                                    {{trans('admin.education')}}
                                </strong>
                            </div>
                            <div class="col-md-10">
                                :     {{\App\Enums\EducateType::getDescription($driver->education)}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <strong>
                                    {{trans('admin.health_status')}}
                                </strong>
                            </div>
                            <div class="col-md-10">
                                :     {{\App\Enums\HealthType::getDescription($driver->health_status)}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <strong>
                                    {{trans('admin.work_type')}}
                                </strong>
                            </div>
                            <div class="col-md-10">
                                :     {{\App\Enums\WorkType::getDescription($driver->work_type)}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <strong>
                                    {{trans('admin.blood')}}
                                </strong>
                            </div>
                            <div class="col-md-10">
                                :     {{\App\Enums\BloodType::getDescription($driver->blood)}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <strong>
                                    {{trans('admin.state_date')}}
                                </strong>
                            </div>
                            <div class="col-md-10">
                                :     {{$driver->state_date}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <strong>
                                    {{trans('admin.work_date')}}
                                </strong>
                            </div>
                            <div class="col-md-10">
                                :     {{$driver->work_date}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <strong>
                                    {{trans('admin.experiance')}}
                                </strong>
                            </div>
                            <div class="col-md-10">
                                :     {{\App\Enums\ExperianceType::getDescription($driver->experiance)}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <strong>
                                    {{trans('admin.note')}}
                                </strong>
                            </div>
                            <div class="col-md-10">
                                :     @if($driver->note == null) <div class="badge">{{trans('admin.theres_no_notes')}} </div> @else {{$driver->note}}  @endif
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <strong>
                                    {{trans('admin.first_date_debtor')}}
                                </strong>
                            </div>
                            <div class="col-md-10">
                                :     @if($driver->debtor != null) {{$driver->debtor}} @else 0  @endif
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <strong>
                                    {{trans('admin.first_date_creditor')}}
                                </strong>
                            </div>
                            <div class="col-md-10">
                                :     @if($driver->creditor != null) {{$driver->creditor}} @else 0  @endif
                            </div>
                        </div>
                        <br>
                        <!-- /.post -->
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
@endsection