@extends('admin.index')
@section('title', trans('admin.add_type_of_activitie'))
@section('content')
@can('create')
<div class="box">
    @include('admin.layouts.message')
    <div class="box-header">
        <h3 class="box-title">{{$title}}</h3>
    </div>
    <div class="box-body">
        {!! Form::open(['method'=>'POST','route' => 'activities.store']) !!}
    <button class="btn btn-primary" style="float: left;"><i class="fa fa-save"></i></button>

        <div class="box-body">

            @can('single')


            <div class="col-md-9">

                <div class="form-group row col-md-12">
                    <div class="col-md-12">
                        <div class="col-md-1" style="margin-right: -47px;left: -18px;">{!!Form::label('Nutr_NmAr', trans('admin.subscriber_name_ar'))!!}</div>
                        <div class="col-md-11" style="margin-bottom: 10px;right: 27px;">{!!Form::text('Nutr_NmAr', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-1" style="margin-right: -47px;left: -18px;">{!!Form::label('Nutr_NmEn', trans('admin.subscriber_name_en'))!!}</div>
                        <div class="col-md-11" style="margin-bottom: 10px;right: 27px;">{!!Form::text('Nutr_NmEn', null, ['class'=>'form-control'])!!}</div>
                    </div>
                </div>

                <div class="form-group row col-md-6" style="margin-right: 4px;">
                    <div class="col-md-2" style="margin-right: -47px;left: -18px;">{!!Form::label('Short_Arb', trans('admin.Short_Arb'))!!}
                    </div>
                    <div class="col-md-10" style="margin-bottom: 10px;right: 23px;padding-right: -1px;">{!!Form::text('Short_Arb', null, ['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group row col-md-6">
                    <div class="col-md-2" style="margin-right: -47px;left: -18px;">{!!Form::label('Short_Eng', trans('admin.Short_Eng'))!!}
                    </div>
                    <div class="col-md-10" style="margin-bottom: 10px;right: 23px;padding-right: -1px;">{!!Form::text('Short_Eng', null, ['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="row col-md-6">
                        <div class="col-md-2">{!!Form::label('Nutr_No', trans('admin.Nutr_No'))!!}</div>
                        <div class="col-md-10" style="margin-bottom: 10px;padding-left: 22px;">{!!Form::text('Nutr_No', null, ['class'=>'form-control'])!!}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">


            @else
                <div class="alert alert-danger">{{trans('admin.you_cannt_see_invoice_because_you_dont_have_role_to_access')}}</div>

            @endcan
            </div>


    </div>
    {!! Form::close() !!}
    </div>
</div>
    @endcan







@endsection
