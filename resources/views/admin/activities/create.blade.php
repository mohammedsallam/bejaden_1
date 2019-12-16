@extends('admin.index')
@section('title', trans('admin.add_type_of_activitie'))
@section('content')


    @include('admin.layouts.message')

    {!! Form::open(['method'=>'POST','route' => 'activities.store']) !!}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>{{trans('admin.create_new_supervisor')}}</h5>
            </div>
            <div class="panel-body">
                @can('single')

                    <div class="form-group col-md-8">
                        <div class="form-group row col-md-12">
                            <div class="col-md-9">
                                <div class="col-md-4">{!!Form::label('Nutr_No', trans('admin.Nutr_No'))!!}</div>
                                <div class="col-md-8">{!!Form::text('Nutr_No', $last, ['class'=>'form-control', 'readonly'=>'true'])!!}</div>

                            </div>
                        </div>

                        <div class="form-group row col-md-12">
                            <div class="col-md-3">{!!Form::label('Nutr_NmAr', trans('admin.arabic_name'))!!}</div>
                            <div class="col-md-9">{!!Form::text('Nutr_NmAr', null, ['class'=>'form-control'])!!}</div>
                        </div>
                        <div class="form-group row col-md-12">
                            <div class="col-md-3">{!!Form::label('Nutr_NmEn', trans('admin.english_name'))!!}</div>
                            <div class="col-md-9">{!!Form::text('Nutr_NmEn', null, ['class'=>'form-control'])!!}</div>
                        </div>
                        <div class="form-group row col-md-12">
                            <div class="col-md-3">{!!Form::label('Short_Arb', trans('admin.Short_Arb'))!!}</div>
                            <div class="col-md-9">{!!Form::text('Short_Arb', null, ['class'=>'form-control'])!!}</div>
                        </div>
                        <div class="form-group row col-md-12">
                            <div class="col-md-3">{!!Form::label('Short_Eng', trans('admin.Short_Eng'))!!}</div>
                            <div class="col-md-9">{!!Form::text('Short_Eng', null, ['class'=>'form-control'])!!}</div>
                        </div>





                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">{{trans('admin.add')}}</button>

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
@endsection
