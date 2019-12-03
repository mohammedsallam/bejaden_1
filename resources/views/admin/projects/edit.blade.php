@extends('admin.index')
@section('title',trans('admin.edit_project'))
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
        @include('admin.layouts.message')
        <div class="box-header">
            <h3 class="box-title">{{trans('admin.edit_project')}}</h3>
        </div>
        <div class="box-body">
            {!! Form::model($project,['method'=>'PUT','route' => ['projects.update',$project->id]]) !!}
            <div class="form-group row">
                <div class="col-md-6">
                    {{ Form::label('name_ar', trans('admin.name_project_ar'), ['class' => 'control-label']) }}
                    {{ Form::text('name_ar', $project->name_ar, array_merge(['class' => 'form-control','placeholder'=>trans('admin.arabic_name')])) }}
                </div>
                <div class="col-md-6">
                    {{ Form::label('name_en', trans('admin.name_project_en'), ['class' => 'control-label']) }}
                    {{ Form::text('name_en', $project->name_en, array_merge(['class' => 'form-control','placeholder'=>trans('admin.english_name')])) }}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('contract_number',trans('admin.contract_number') , ['class' => 'control-label']) }}
                    {{ Form::number('contract_number', $project->contract_number, array_merge(['class' => 'form-control','placeholder'=>trans('admin.contract_number')])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('phone_number',trans('admin.phone_number') , ['class' => 'control-label']) }}
                    {{ Form::number('phone_number', $project->phone_number, array_merge(['class' => 'form-control','placeholder'=>trans('admin.phone_number')])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('fax_number',trans('admin.fax_number') , ['class' => 'control-label']) }}
                    {{ Form::number('fax_number', $project->fax_number, array_merge(['class' => 'form-control','placeholder'=>trans('admin.fax_number')])) }}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    {{ Form::label('email',trans('admin.email_project') , ['class' => 'control-label']) }}
                    {{ Form::email('email', $project->email, array_merge(['class' => 'form-control','placeholder'=>trans('admin.email_project')])) }}
                </div>
                <div class="col-md-6">
                    {{ Form::label('responsible_person',trans('admin.responsible_person') , ['class' => 'control-label']) }}
                    {{ Form::text('responsible_person', $project->responsible_person, array_merge(['class' => 'form-control','placeholder'=>trans('admin.responsible_person')])) }}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('warehouse',trans('admin.warehouse') , ['class' => 'control-label']) }}
                    {{ Form::number('warehouse', $project->warehouse, array_merge(['class' => 'form-control','placeholder'=>trans('admin.warehouse')])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('subscriber_id',trans('admin.customer_name'), ['class' => 'control-label']) }}
                    {{ Form::select('subscriber_id',$subscribers, $project->subscriber_id, array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('project_title',trans('admin.project_title'), ['class' => 'control-label']) }}
                    {{ Form::text('project_title', $project->project_title, array_merge(['class' => 'form-control','placeholder'=>trans('admin.project_title')])) }}
                </div>
            </div>

            {{Form::submit('تعديل',['class'=>'btn btn-primary'])}}
            {!! Form::close() !!}
        </div>
    </div>
    @endcan
@else
    <div class="alert alert-danger">{{trans('admin.you_cannt_see_invoice_because_you_dont_have_role_to_access')}}</div>

@endhasanyrole







@endsection
