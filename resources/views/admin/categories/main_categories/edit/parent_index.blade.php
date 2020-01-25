@extends('admin.index')
@section('title',trans('admin.basic_types'))
@section('content')
    <div class="box">

    @include('admin.layouts.message')

    <!-- /.box-header -->
        <div class="box-body table-responsive" id="create_chart">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger error_message hidden"></div>
                </div>
                <div class="col-md-12">
                    <div class="alert alert-success success_message hidden"></div>
                </div>
            </div>
            <div class="row text-left" style="margin-bottom: 5px">
                <div class="col-md-4 pull-left">
                    <a class="btn btn-info editRootOrChildLink hidden" href="#"><i class="fa fa-floppy-o"></i></a>
                    <a class="btn btn-danger deleteRootOrChildLink hidden" href="#"><i class="fa fa-trash"></i></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" style="display: flex">
                        <label style="width: 25%" for="Cmp_No">{{trans('admin.companies')}}</label>
                        {{--@if($cmp->ID_No == session('updatedComNo')) selected @endif--}}
                        <select name="Cmp_No" id="Cmp_No" class="form-control Cmp_No">
                            <option value="">{{trans('admin.select')}}</option>
                            @if(count($cmps) > 0)
                                @foreach($cmps as $cmp)
                                    <option value="{{$cmp->ID_No}}">{{$cmp->{'Cmp_Nm'.ucfirst(session('lang'))} }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    {{--@if($active->ID_No == session('updatedActiveNo')) selected @endif--}}
                    <div class="form-group" style="display: flex">
                        <label style="width: 25%" for="Actvty_No" >{{trans('admin.activity')}}</label>
                        <select name="Actvty_No" id="Actvty_No" class="form-control Actvty_No">
                            <option value="">{{trans('admin.select')}}</option>
                            @if(count($activity) > 0)
                                @foreach($activity as $active)
                                    <option value="{{$active->ID_No}}">{{$active->{'Name_'.ucfirst(session('lang'))} }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>

            {{-- start Ul taps--}}
            <ul class="nav nav-tabs nav-justified" id="myTab1" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link active" id="home-tab1" data-toggle="tab" href="#cat_data" role="tab" aria-controls="home"
                       aria-selected="true">{{trans('admin.cat_data')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab1" data-toggle="tab" href="#weight_measure" role="tab" aria-controls="profile"
                       aria-selected="false">{{trans('admin.weight_measure')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#purchases" role="tab" aria-controls="profile"
                       aria-selected="false">{{trans('admin.purchases')}}</a>
                </li>
            </ul>
            {{-- End Ul taps--}}


            <div class="panel panel-default col-md-4" style="margin-top:1%; overflow: auto">
                <div class="panel-body">
                    <a class="btn btn-primary addRootOrChild" id="addRootOrChild">{{trans('admin.new_category')}}</a>
                    <div id="parent_name" style="display: inline-block"></div>
                    <div id="jstree" style="margin-top: 20px"></div>
                </div>
            </div>
            {{----}}
            <div class="tab-content" id="myTabContent1" style="margin-top:1%">

                {{--First tap--}}
                @include('admin.categories.main_categories.create_parent.cat_data')
                {{--Second tap--}}
                @include('admin.categories.main_categories.create_parent.weight_measure')
                {{--third tap--}}
                @include('admin.categories.main_categories.create_parent.purchases')
            </div>
        </div>
    </div>

@endsection
