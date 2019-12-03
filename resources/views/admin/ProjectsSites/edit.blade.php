@extends('admin.index')
@section('title',trans('admin.edit_projectsite'))
@section('content')
    {{-- @push('js')

        <script>
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                rtl: true,
                language: '{{session('lang')}}',
                inline:true,
                minDate: 0,
                autoclose:true,
                minDateTime: dateToday

            });
        </script>
    @endpush --}}
@hasanyrole('writer|admin')
@can('create')
    <div class="box">
        {{--  @include('admin.layouts.message')  --}}
        <div class="box-header">
            <h3 class="box-title">{{trans('admin.edit_projectsite')}}</h3>
        </div>
        <div class="box-body">
            {!! Form::model($ProjectsSites,['method'=>'PUT','route' => ['ProjectsSites.update',$ProjectsSites->id]]) !!}
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('project_id', trans('admin.project_name'), ['class' => 'control-label']) }}
                    {{ Form::select('project_id',$project, $ProjectsSites->project_id, array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                    @if ($errors->has('project_id'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('project_id') }}</div>
                    @endif
                </div>
                <div class="col-md-4">
                    {{ Form::label('name_ar', trans('admin.name_projectsite_ar'), ['class' => 'control-label']) }}
                    {{ Form::text('name_ar', $ProjectsSites->name_ar, array_merge(['class' => 'form-control','placeholder'=>trans('admin.name_projectsite_ar')])) }}
                    @if ($errors->has('name_ar'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('name_ar') }}</div>
                    @endif
                </div>
                <div class="col-md-4">
                    {{ Form::label('name_en', trans('admin.name_projectsite_en'), ['class' => 'control-label']) }}
                    {{ Form::text('name_en', $ProjectsSites->name_en, array_merge(['class' => 'form-control','placeholder'=>trans('admin.name_projectsite_en')])) }}
                    @if ($errors->has('name_en'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('name_en') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    {{ Form::label('contract_number',trans('admin.contract_number') , ['class' => 'control-label']) }}
                    {{ Form::number('contract_number', $ProjectsSites->contract_number, array_merge(['class' => 'form-control','placeholder'=>trans('admin.contract_number')])) }}
                    @if ($errors->has('contract_number'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('contract_number') }}</div>
                    @endif
                </div>
                <div class="col-md-6">
                    {{ Form::label('phone_number',trans('admin.phone_number') , ['class' => 'control-label']) }}
                    {{ Form::number('phone_number', $ProjectsSites->phone_number, array_merge(['class' => 'form-control','placeholder'=>trans('admin.phone_number')])) }}
                    @if ($errors->has('phone_number'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('phone_number') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    {{ Form::label('email',trans('admin.email_projectsite') , ['class' => 'control-label']) }}
                    {{ Form::email('email', $ProjectsSites->email, array_merge(['class' => 'form-control','placeholder'=>trans('admin.email_projectsite')])) }}
                    @if ($errors->has('email'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="col-md-6">
                    {{ Form::label('responsible_person',trans('admin.responsible_person') , ['class' => 'control-label']) }}
                    {{ Form::text('responsible_person', $ProjectsSites->responsible_person, array_merge(['class' => 'form-control','placeholder'=>trans('admin.responsible_person')])) }}
                    @if ($errors->has('responsible_person'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('responsible_person') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    {{ Form::label('warehouse',trans('admin.warehouse') , ['class' => 'control-label']) }}
                    {{ Form::number('warehouse', $ProjectsSites->warehouse, array_merge(['class' => 'form-control','placeholder'=>trans('admin.warehouse')])) }}
                    @if ($errors->has('warehouse'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('warehouse') }}</div>
                    @endif
                </div>
                <div class="col-md-6">
                    {{ Form::label('project_title',trans('admin.projectsite_title'), ['class' => 'control-label']) }}
                    {{ Form::text('project_title', $ProjectsSites->project_title, array_merge(['class' => 'form-control','placeholder'=>trans('admin.projectsite_title')])) }}
                    @if ($errors->has('project_title'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('project_title') }}</div>
                    @endif
                </div>
            </div>

            {{Form::submit(trans('admin.edit_projectsite'),['class'=>'btn btn-primary'])}}
            {!! Form::close() !!}
        </div>
    </div>
    @endcan
@else
    <div class="alert alert-danger">{{trans('admin.you_cannt_see_invoice_because_you_dont_have_role_to_access')}}</div>

@endhasanyrole







@endsection
