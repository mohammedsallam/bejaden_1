@extends('admin.index')
@section('title',trans('admin.add_project'))
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
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        {{-- @include('admin.layouts.message') --}}
        <div class="box-header">
            <h3 class="box-title">{{trans('admin.add_project')}}</h3>
        </div>
        <div class="box-body">
            {!! Form::open(['method'=>'POST','route' => 'projects.store']) !!}
            <div class="form-group row">
                <div class="col-md-3">
                    {{ Form::label('name_ar', trans('admin.name_project_ar'), ['class' => 'control-label']) }}
                    {{ Form::text('name_ar', old('name_ar'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.arabic_name')])) }}
                    @if ($errors->has('name_ar'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('name_ar') }}</div>
                    @endif
                </div>
                <div class="col-md-3">
                    {{ Form::label('name_en', trans('admin.name_project_en'), ['class' => 'control-label']) }}
                    {{ Form::text('name_en', old('name_en'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.english_name')])) }}
                    @if ($errors->has('name_en'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('name_en') }}</div>
                    @endif
                </div>
                <div class="col-md-3">
                    {{ Form::label(trans('admin.Departments'), null, ['class' => 'control-label']) }}
                    {{ Form::select('tree_id', $tree,null, array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                </div>
                <div class="col-md-3">
                    {{ Form::label(trans('admin.single_cc'), null, ['class' => 'control-label']) }}
                    {{ Form::select('cc_id', $glcc,null, array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('contract_number',trans('admin.contract_number') , ['class' => 'control-label']) }}
                    {{ Form::number('contract_number', old('contract_number'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.contract_number')])) }}
                    @if ($errors->has('contract_number'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('contract_number') }}</div>
                    @endif
                </div>
                <div class="col-md-4">
                    {{ Form::label('phone_number',trans('admin.phone_number') , ['class' => 'control-label']) }}
                    {{ Form::number('phone_number', old('phone_number'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.phone_number')])) }}
                    @if ($errors->has('phone_number'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('phone_number') }}</div>
                    @endif
                </div>
                <div class="col-md-4">
                    {{ Form::label('fax_number',trans('admin.fax_number') , ['class' => 'control-label']) }}
                    {{ Form::number('fax_number', old('fax_number'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.fax_number')])) }}
                    @if ($errors->has('fax_number'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('fax_number') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    {{ Form::label('email',trans('admin.email_project') , ['class' => 'control-label']) }}
                    {{ Form::email('email', old('email'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.email_project')])) }}
                    @if ($errors->has('email'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="col-md-6">
                    {{ Form::label('responsible_person',trans('admin.responsible_person') , ['class' => 'control-label']) }}
                    {{ Form::text('responsible_person', old('responsible_person'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.responsible_person')])) }}
                    @if ($errors->has('responsible_person'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('responsible_person') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('warehouse',trans('admin.warehouse') , ['class' => 'control-label']) }}
                    {{ Form::number('warehouse', old('warehouse'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.warehouse')])) }}
                    @if ($errors->has('warehouse'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('warehouse') }}</div>
                    @endif
                </div>
                <div class="col-md-4">
                    {{ Form::label('customer_id',trans('admin.customer_name'), ['class' => 'control-label']) }}
                    {{-- {{ Form::select('customer_id',$employee, old('customer_id'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }} --}}
                    @if ($errors->has('customer_id'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('customer_id') }}</div>
                    @endif
                </div>
                <div class="col-md-4">
                    {{ Form::label('project_title',trans('admin.project_title'), ['class' => 'control-label']) }}
                    {{ Form::text('project_title', old('project_title'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.project_title')])) }}
                    @if ($errors->has('project_title'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('project_title') }}</div>
                    @endif
                </div>
            </div>

            {{Form::submit(trans('admin.add_new_project'),['class'=>'btn btn-primary'])}}
            {!! Form::close() !!}
        </div>
    </div>
    @endcan
@else
    <div class="alert alert-danger">{{trans('admin.you_cannt_see_invoice_because_you_dont_have_role_to_access')}}</div>

@endhasanyrole







@endsection
