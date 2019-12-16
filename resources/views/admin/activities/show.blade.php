@extends('admin.index')
@section('title', trans('admin.show_activity').$activities->Nutr_NmAr)
@section('content')
@can('create')

    @include('admin.layouts.message')

        {{Form::model($activities,['method'=>'PUT','route'=>['activities.show',$activities->ID_No],'class'=>'form-group','files'=>true])}}
            <div class="panel panel-default">
            <div class="panel-heading">
                <h5>{{trans('admin.show_activity').$activities->Nutr_NmAr}}</h5>
            </div>
            <div class="panel-body">
                @can('single')

                    <div class="form-group col-md-8">
                        <div class="form-group row col-md-12">
                            <div class="col-md-9">
                                <div class="col-md-4">{!!Form::label('Nutr_No', trans('admin.Nutr_No'))!!}</div>
                                <div class="col-md-8">{!!Form::text('Nutr_No', null, ['class'=>'form-control', 'readonly'=>'true'])!!}</div>

                            </div>
                        </div>

                        <div class="form-group row col-md-12">
                            <div class="col-md-3">{!!Form::label('Nutr_NmAr', trans('admin.arabic_name'))!!}</div>
                            <div class="col-md-9">{!!Form::text('Nutr_NmAr', null, ['class'=>'form-control', 'readonly'=>'true'])!!}</div>
                        </div>
                        <div class="form-group row col-md-12">
                            <div class="col-md-3">{!!Form::label('Nutr_NmEn', trans('admin.english_name'))!!}</div>
                            <div class="col-md-9">{!!Form::text('Nutr_NmEn', null, ['class'=>'form-control', 'readonly'=>'true'])!!}</div>
                        </div>
                        <div class="form-group row col-md-12">
                            <div class="col-md-3">{!!Form::label('Short_Arb', trans('admin.Short_Arb'))!!}</div>
                            <div class="col-md-9">{!!Form::text('Short_Arb', null, ['class'=>'form-control', 'readonly'=>'true'])!!}</div>
                        </div>
                        <div class="form-group row col-md-12">
                            <div class="col-md-3">{!!Form::label('Short_Eng', trans('admin.Short_Eng'))!!}</div>
                            <div class="col-md-9">{!!Form::text('Short_Eng', null, ['class'=>'form-control', 'readonly'=>'true'])!!}</div>
                        </div>

                    </div>

                    <div class="col-md-6">


                        @else
                            <div class="alert alert-danger">{{trans('admin.you_cannt_see_invoice_because_you_dont_have_role_to_access')}}</div>

                        @endcan
                    </div>


                    {{ Form::close() }}

            </div>
        </div>
    @endcan







@endsection
