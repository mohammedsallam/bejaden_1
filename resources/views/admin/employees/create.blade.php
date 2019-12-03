@extends('admin.index')
@section('title',trans('admin.Create_new_employees'))
@section('content')
    @push('js')

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
    @endpush
@hasanyrole('writer|admin')
@can('create')
    <div class="box">
        @include('admin.layouts.message')
        <div class="box-header">
            <h3 class="box-title">{{$title}}</h3>
        </div>
        <div class="box-body">
            {!! Form::open(['method'=>'POST','route' => 'employees.store']) !!}
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label(trans('admin.arabic_name'), null, ['class' => 'control-label']) }}
                    {{ Form::text('name_ar', old('name_ar'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.arabic_name')])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label(trans('admin.english_name'), null, ['class' => 'control-label']) }}
                    {{ Form::text('name_en', old('name_en'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.english_name')])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('tree_id',trans('admin.Departments') , ['class' => 'control-label']) }}
                    {{ Form::select('tree_id', $departments,null, array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                </div>
{{--                <div class="col-md-3" style="padding-top: 30px">--}}
{{--                    {{ Form::label('cc_type',trans('admin.with_cc') , ['class' => 'control-label']) }}--}}
{{--                    {{ Form::checkbox('cc_type', 1) }}--}}
{{--                </div>--}}
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label(trans('admin.beginning_date'), null, ['class' => 'control-label']) }}
                    {{ Form::text('beginning_date', old('beginning_date'), array_merge(['class' => 'form-control datepicker','placeholder'=>trans('admin.beginning_date'),'autocomplete'=>'off'])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label(trans('admin.end_date'), null, ['class' => 'control-label']) }}
                    {{ Form::text('end_date',old('end_date'), array_merge(['class' => 'form-control datepicker','placeholder'=>trans('admin.end_date'),'autocomplete'=>'off'])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label(trans('admin.renew_date'), null, ['class' => 'control-label']) }}
                    {{ Form::text('renew_date',old('renew_date') ,array_merge(['class' => 'form-control datepicker','placeholder'=>trans('admin.renew_date'),'autocomplete'=>'off'])) }}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('salary_type',trans('admin.salary_type') , ['class' => 'control-label']) }}
                    {{ Form::select('salary_type', \App\Enums\SalaryType::toSelectArray(),null, array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('salary', trans('admin.salary'), ['class' => 'control-label']) }}
                    {{ Form::text('salary', old('salary'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.salary')])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('transition_allowance', trans('admin.transition_allowance'), ['class' => 'control-label']) }}
                    {{ Form::text('transition_allowance', old('transition_allowance'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.transition_allowance')])) }}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('housing_allowance',trans('admin.housing_allowance') , ['class' => 'control-label']) }}
                    {{ Form::text('housing_allowance',old('housing_allowance'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.housing_allowance')])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('food_allowance', trans('admin.food_allowance'), ['class' => 'control-label']) }}
                    {{ Form::text('food_allowance', old('food_allowance'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.food_allowance')])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('other_allowances', trans('admin.other_allowances'), ['class' => 'control-label']) }}
                    {{ Form::text('other_allowances', old('other_allowances'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.other_allowances')])) }}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('work_type',trans('admin.work_type') , ['class' => 'control-label']) }}
                    {{ Form::select('work_type',\App\Enums\WorkType::toSelectArray(),null, array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('number_rest',trans('admin.number_rest') , ['class' => 'control-label']) }}
                    {{ Form::text('number_rest',old('number_rest'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.number_rest')])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('work_status', trans('admin.work_status'), ['class' => 'control-label']) }}
                    {{ Form::select('work_status',\App\Enums\WorkStatusType::toSelectArray(), null, array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('payment_methods', trans('admin.payment_methods'), ['class' => 'control-label']) }}
                    {{ Form::select('payment_methods',\App\Enums\PayType::toSelectArray() ,null, array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('workhour_count',trans('admin.workhour_count') , ['class' => 'control-label']) }}
                    {{ Form::text('workhour_count',old('workhour_count'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.workhour_count')])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('hour_payment', trans('admin.hour_payment'), ['class' => 'control-label']) }}
                    {{ Form::text('hour_payment', old('hour_payment'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.hour_payment')])) }}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3">
                    {{ Form::label('employee_ticket', trans('admin.employee_ticket'), ['class' => 'control-label']) }}
                    {{ Form::text('employee_ticket',old('employee_ticket'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.employee_ticket')])) }}
                </div>
                <div class="col-md-3">
                    {{ Form::label('ticket_class',trans('admin.ticket_class') , ['class' => 'control-label']) }}
                    {{ Form::text('ticket_class',old('ticket_class'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.ticket_class')])) }}
                </div>
                <div class="col-md-3">
                    {{ Form::label('children_ticket', trans('admin.children_ticket'), ['class' => 'control-label']) }}
                    {{ Form::text('children_ticket', old('children_ticket'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.children_ticket')])) }}
                </div>
                <div class="col-md-3">
                    {{ Form::label('sales_officer', trans('admin.sales_officer'), ['class' => 'control-label']) }}
                    {{ Form::checkbox('sales_officer', 1) }}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('sales_number',trans('admin.sales_number') , ['class' => 'control-label']) }}
                    {{ Form::text('sales_number',old('sales_number'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.sales_number')])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('percentage', trans('admin.percentage'), ['class' => 'control-label']) }}
                    {{ Form::text('percentage', old('percentage'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.percentage')])) }}
                </div>
                <div class="col-md-4">
                    {{ Form::label('branches_id', trans('admin.Branches'), ['class' => 'control-label']) }}
                    {{ Form::select('branches_id',$branches ,null, array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3">
                    {{ Form::label('companybanks_id', trans('admin.companybanks_id'), ['class' => 'control-label']) }}
                    {{ Form::select('companybanks_id',$departmentsbanks ,null, array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                </div>
                <div class="col-md-3">
                    {{ Form::label('company_banks_num', trans('admin.company_banks_num'), ['class' => 'control-label']) }}
                    {{ Form::text('company_banks_num',old('company_banks_num'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.company_banks_num')])) }}
                </div>
                <div class="col-md-3">
                    {{ Form::label('employeebanks_id', trans('admin.employeebanks_id'), ['class' => 'control-label']) }}
                    {{ Form::select('employeebanks_id',$departmentsbanks ,null, array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                </div>
                <div class="col-md-3">
                    {{ Form::label('employee_banks_num', trans('admin.employee_banks_num'), ['class' => 'control-label']) }}
                    {{ Form::text('employee_banks_num', old('employee_banks_num'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.employee_banks_num')])) }}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3">
                    {{ Form::label('employee_banks_branches', trans('admin.employee_banks_branches'), ['class' => 'control-label']) }}
                    {{ Form::text('employee_banks_branches',old('employee_banks_branches'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.employee_banks_branches')])) }}
                </div>
                <div class="col-md-3">
                    {{ Form::label('debtor', trans('admin.debtor'), ['class' => 'control-label']) }}
                    {{ Form::text('debtor',0, array_merge(['class' => 'form-control','placeholder'=>trans('admin.debtor')])) }}
                </div>
                <div class="col-md-3">
                    {{ Form::label('creditor', trans('admin.creditor'), ['class' => 'control-label']) }}
                    {{ Form::text('creditor', 0, array_merge(['class' => 'form-control','placeholder'=>trans('admin.creditor')])) }}
                </div>
                <div class="col-md-3">
                    {{ Form::label('accounts_receivable', trans('admin.accounts_receivable'), ['class' => 'control-label']) }}
                    {{ Form::text('accounts_receivable',old('accounts_receivable'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.accounts_receivable')])) }}
                </div>
            </div>

            {{Form::submit(trans('admin.create'),['class'=>'btn btn-primary'])}}
            {!! Form::close() !!}
        </div>
    </div>
    @endcan
@else
    <div class="alert alert-danger">{{trans('admin.you_cannt_see_invoice_because_you_dont_have_role_to_access')}}</div>

@endhasanyrole







@endsection
