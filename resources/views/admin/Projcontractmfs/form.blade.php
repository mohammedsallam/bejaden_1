
<div style="border: 1px solid #ddd;padding: 9px">
    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('Cmp_No', trans('admin.na_Comp'), ['class' => 'control-label']) }}
            {{ Form::select('Cmp_No',$branches, old('Cmp_No'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}

            @if ($errors->has('Cmp_No'))
                <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Cmp_No') }}</div>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-2">
            {{ Form::label('Cntrct_No',trans('admin.cntrct_No') , ['class' => 'control-label']) }}
            {{ Form::text('Cntrct_No', old('Cntrct_No'), array_merge(['class' => 'form-control ','placeholder'=>trans('admin.cntrct_No')])) }}
        </div>
        <div class="col-md-2">
            {{ Form::label('Rvisd_No',trans('admin.rvisd_No') , ['class' => 'control-label']) }}
            {{ Form::text('Rvisd_No', old('Rvisd_No'), array_merge(['class' => 'form-control ','placeholder'=>trans('admin.rvisd_No')])) }}
        </div>

        <div class="col-md-2">
            {{ Form::label('date',trans('admin.date') , ['class' => 'control-label']) }}
            {{ Form::text('Tr_Dt', old('Tr_Dt'), array_merge(['class' => 'form-control datepicker','id' => 'history_date_project','placeholder'=>trans('admin.date')])) }}
            @if ($errors->has('Tr_Dt'))
                <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Tr_Dt') }}</div>
            @endif
        </div>
        <div class="col-md-2">
            {{ Form::label('date_hijri',trans('admin.date_hijri') , ['class' => 'control-label']) }}
            {{ Form::hidden('Tr_DtAr', old('Tr_DtAr'), array_merge(['class' => 'form-control higri_date_project','placeholder'=>trans('admin.higri_date')])) }}
            {{ Form::text('Tr_DtAr', old('Tr_DtAr'), array_merge(['class' => 'form-control higri_date_project','disabled' => 'disabled','placeholder'=>trans('admin.higri_date')])) }}
            @if ($errors->has('Tr_DtAr'))
                <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Tr_DtAr') }}</div>
            @endif
        </div>

            <div class="col-md-4">
                {{ Form::label('project_id',trans('admin.project_name') , ['class' => 'control-label']) }}
                {{ Form::select('Prj_No',$Projects , old('Prj_No'), array_merge(['class' => 'form-control selected','placeholder'=>trans('admin.select')])) }}
                @if ($errors->has('Prj_No'))
                    <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Prj_No') }}</div>
                @endif
            </div>

    </div>

    <div class="form-group row">
        <div class="col-md-6">
            {{ Form::label('note',trans('admin.notee') , ['class' => 'control-label']) }}
            {{ Form::textarea('note', old('note'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.note'),'cols' => '-58' ,'rows' => '-9'])) }}
            @if ($errors->has('email'))
                <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('note') }}</div>
            @endif
        </div>
        <div class="col-md-6">
            {{ Form::label('note_en',trans('admin.notee_en') , ['class' => 'control-label']) }}
            {{ Form::textarea('note_en', old('note_en'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.note_en'),'cols' => '-58' ,'rows' => '-9'])) }}
            @if ($errors->has('note_en'))
                <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('note') }}</div>
            @endif
        </div>
    </div>
</div>

<br>
<br>
<div style="border: 1px solid #ddd;padding: 9px">
    <div class="form-group row">
        <div class="col-md-3">
            <div class="form-group row">
                <div class="col-md-4"> {{ Form::label('Date_contract',trans('admin.Date_contract') , ['class' => 'control-label']) }}</div>
                <div class="col-md-8">
                    {{ Form::text('Cnt_Dt', old('Cnt_Dt'), array_merge(['class' => 'form-control datepicker'])) }}
                    @if ($errors->has('Cnt_Dt'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Cnt_Dt') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('beginning_contract',trans('admin.beginning_contract') , ['class' => 'control-label']) }}
                </div>

                <div class="col-md-8">
                    {{ Form::text('CntStrt_Dt', old('CntStrt_Dt'), array_merge(['class' => 'form-control datepicker'])) }}
                    @if ($errors->has('CntStrt_Dt'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('CntStrt_Dt') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('CntCompl_Dt',trans('admin.End_contract') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('CntCompl_Dt', old('CntCompl_Dt'), array_merge(['class' => 'form-control datepicker'])) }}
                    @if ($errors->has('CntCompl_Dt'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('CntCompl_Dt') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('period_contract',trans('admin.period_contract') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('CntCompL_Priod', old('CntCompL_Priod'), array_merge(['class' => 'form-control'])) }}
                    @if ($errors->has('CntCompL_Priod'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('CntCompL_Priod') }}</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('Inst_Dt',trans('admin.start_implementation') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Inst_Dt', old('Inst_Dt'), array_merge(['class' => 'form-control datepicker'])) }}
                    @if ($errors->has('Inst_Dt'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Inst_Dt') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('Comisn_Dt',trans('admin.end_implementation') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Comisn_Dt', old('Comisn_Dt'), array_merge(['class' => 'form-control datepicker'])) }}
                    @if ($errors->has('Comisn_Dt'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Comisn_Dt') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('start_warranty',trans('admin.start_warranty') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Wrntstrt_dt', old('Wrntstrt_dt'), array_merge(['class' => 'form-control datepicker'])) }}
                    @if ($errors->has('Wrntstrt_dt'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Wrntstrt_dt') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('end_warranty',trans('admin.end_warranty') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Wrntend_Dt', old('Wrntend_Dt'), array_merge(['class' => 'form-control datepicker'])) }}
                    @if ($errors->has('Wrntend_Dt'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Wrntend_Dt') }}</div>
                    @endif
                </div>
            </div>




        </div>
        <div class="col-md-3">
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('number_employees',trans('admin.number_employees') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('NofEmp', old('NofEmp'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.number_employees')])) }}
                    @if ($errors->has('NofEmp'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('NofEmp') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('Hour_employee',trans('admin.Hour_employee') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Emp_Hur', old('Emp_Hur'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.Hour_employee')])) }}
                    @if ($errors->has('Emp_Hur'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Emp_Hur') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('number_months',trans('admin.number_months') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('NofMonths', old('NofMonths'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.number_months')])) }}
                    @if ($errors->has('NofMonths'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('NofMonths') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('monthly_payment',trans('admin.monthly_payment') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Mnthly_Pyment', old('Mnthly_Pyment'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.monthly_payment')])) }}
                    @if ($errors->has('Mnthly_Pyment'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Mnthly_Pyment') }}</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('revenue_measurement',trans('admin.revenue_measurement') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Acc_CR', old('Acc_CR'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.revenue_measurement')])) }}
                    @if ($errors->has('Acc_CR'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Acc_CR') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('expenses_measurement',trans('admin.expenses_measurement') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Acc_DB', old('Acc_DB'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.expenses_measurement')])) }}
                    @if ($errors->has('Acc_DB'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Acc_DB') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('cost_limit',trans('admin.cost_limit') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Comitd_Cost', old('Comitd_Cost'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.cost_limit')])) }}
                    @if ($errors->has('Comitd_Cost'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Comitd_Cost') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('Actul_Cost',trans('admin.actual_cost') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Actul_Cost', old('Actul_Cost'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.actual_cost')])) }}
                    @if ($errors->has('Actul_Cost'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Actul_Cost') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<br>
<br>

<div style="border: 1px solid #ddd;padding: 9px">
    <div class="form-group row">
        <div class="col-md-4">
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('Estimated_value',trans('admin.Estimated_value') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Cnt_Bdgt', old('Cnt_Bdgt'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.Estimated_value')])) }}
                    @if ($errors->has('Cnt_Bdgt'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Cnt_Bdgt') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('contract_value',trans('admin.contract_value') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Cnt_Vl', old('Cnt_Vl'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.contract_value')])) }}
                    @if ($errors->has('Cnt_Vl'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Cnt_Vl') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('deviation_value',trans('admin.deviation_value') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-5">
                    {{ Form::text('Cntrb_VL', old('Cntrb_VL'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.deviation_value')])) }}
                    @if ($errors->has('Cntrb_VL'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Cntrb_VL') }}</div>
                    @endif
                </div>
                <div class="col-md-3">
                    {{ Form::text('Cntrb_Prct', old('Cntrb_Prct'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.deviation_value')])) }}
                    @if ($errors->has('Cntrb_Prct'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Cntrb_Prct') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('Bank_guarantee_number',trans('admin.Bank_guarantee_number') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Bnkgrnt_No', old('Bnkgrnt_No'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.Bank_guarantee_number')])) }}
                    @if ($errors->has('Bnkgrnt_No'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Bnkgrnt_No') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('warranty_history',trans('admin.warranty_history') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('warranty_history', old('warranty_history'), array_merge(['class' => 'form-control datepicker','placeholder'=>trans('admin.warranty_history')])) }}
                    @if ($errors->has('warranty_history'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('warranty_history') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('amount_guarantee',trans('admin.amount_guarantee') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Bnkgrnt_Amount', old('Bnkgrnt_Amount'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.amount_guarantee')])) }}
                    @if ($errors->has('Bnkgrnt_Amount'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Bnkgrnt_Amount') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('warranty_issued',trans('admin.warranty_issued') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Bnkgrnt_IsudByAr', old('Bnkgrnt_IsudByAr'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.warranty_issued')])) }}
                    @if ($errors->has('Bnkgrnt_IsudByAr'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Bnkgrnt_IsudByAr') }}</div>
                    @endif
                </div>
            </div>

        </div>

        <div class="col-md-4">
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('comprehensive_insurance',trans('admin.comprehensive_insurance') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Insurnc_Comprehensive', old('Insurnc_Comprehensive'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.comprehensive_insurance')])) }}
                    @if ($errors->has('Insurnc_Comprehensive'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Insurnc_Comprehensive') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('contractor_insurance',trans('admin.contractor_insurance') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Insurnc_Contractors', old('Insurnc_Contractors'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.contractor_insurance')])) }}
                    @if ($errors->has('Insurnc_Contractors'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Insurnc_Contractors') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('reference_retirement',trans('admin.reference_retirement') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Cnt_Refno', old('Cnt_Refno'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.reference_retirement')])) }}
                    @if ($errors->has('Cnt_Refno'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Cnt_Refno') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('subscriber_id',trans('admin.customer_name') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::select('Cstm_No',$subscription,old('Cstm_No'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                    @if ($errors->has('Cstm_No'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Cstm_No') }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('branche', trans('admin.branche'), ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::select('Brn_No',$branches, old('Brn_No'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}

                    @if ($errors->has('Brn_No'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Brn_No') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group row"></div>
            <div class="form-group row"></div>
            <div class="form-group row"></div>
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('subscriber_id','EN' , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-8">
                    {{ Form::text('Bnkgrnt_IsudByEn', old('Bnkgrnt_IsudByEn'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.warranty_issued_en')])) }}
                    @if ($errors->has('Bnkgrnt_IsudByEn'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Bnkgrnt_IsudByEn') }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('management_expenses',trans('admin.management_expenses') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-5">
                    {{ Form::text('Gnrlovhd_VaL', old('Gnrlovhd_VaL'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.management_expenses')])) }}
                    @if ($errors->has('Gnrlovhd_VaL'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Gnrlovhd_VaL') }}</div>
                    @endif
                </div>
                <div class="col-md-3">
                    {{ Form::text('Gnrlovhd_Prct', old('Gnrlovhd_Prct'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.management_expenses_percentage')])) }}
                    @if ($errors->has('Gnrlovhd_Prct'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Gnrlovhd_Prct') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('department_expenses',trans('admin.department_expenses') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-5">
                    {{ Form::text('Dprtmovhd_Vl', old('Dprtmovhd_Vl'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.department_expenses')])) }}
                    @if ($errors->has('Dprtmovhd_Vl'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Dprtmovhd_Vl') }}</div>
                    @endif
                </div>
                <div class="col-md-3">
                    {{ Form::text('Dprtmovhd_Prct', old('Dprtmovhd_Prct'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.department_expenses_percentage')])) }}

                    @if ($errors->has('Dprtmovhd_Prct'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Dprtmovhd_Prct') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('warranty_period',trans('admin.warranty_period') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-5">

                    {{ Form::text('Wrnt_Vl', old('Wrnt_Vl'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.warranty_period')])) }}

                    @if ($errors->has('Wrnt_Vl'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Wrnt_Vl') }}</div>
                    @endif
                </div>

                <div class="col-md-3">
                    {{ Form::text('Wrnt_Prct', old('Wrnt_Prct'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.warranty_period_percentage')])) }}

                    @if ($errors->has('Wrnt_Prct'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('Wrnt_Prct') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('financial_expenses',trans('admin.financial_expenses') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-5">

                    {{ Form::text('financial_expenses', old('financial_expenses'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.financial_expenses')])) }}

                    @if ($errors->has('financial_expenses'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('financial_expenses') }}</div>
                    @endif
                </div>

                <div class="col-md-3">
                    {{ Form::text('financial_expenses_percentage', old('financial_expenses_percentage'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.financial_expenses_percentage')])) }}

                    @if ($errors->has('financial_expenses_percentage'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('financial_expenses_percentage') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('subtotal',trans('admin.subtotal') , ['class' => 'control-label']) }}
                </div>

                <div class="col-md-5">

                    {{ Form::text('subtotal', old('subtotal'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.subtotal')])) }}

                    @if ($errors->has('subtotal'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('subtotal') }}</div>
                    @endif
                </div>

                <div class="col-md-3">
                    {{ Form::text('subtotal_percentage', old('subtotal_percentage'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.subtotal_percentage')])) }}

                    @if ($errors->has('subtotal_percentage'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('subtotal_percentage') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('net_deviation',trans('admin.net_deviation') , ['class' => 'control-label']) }}
                </div>

                <div class="col-md-5">

                    {{ Form::text('net_deviation', old('net_deviation'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.net_deviation')])) }}

                    @if ($errors->has('net_deviation'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('net_deviation') }}</div>
                    @endif
                </div>
                <div class="col-md-3">
                    {{ Form::text('net_deviation_percentage', old('net_deviation_percentage'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.net_deviation_percentage')])) }}

                    @if ($errors->has('net_deviation_percentage'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('net_deviation_percentage') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('total_collection',trans('admin.total_collection') , ['class' => 'control-label']) }}
                </div>

                <div class="col-md-5">
                    {{ Form::text('total_collection', old('total_collection'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.total_collection')])) }}
                    @if ($errors->has('total_collection'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('total_collection') }}</div>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    {{ Form::label('current_balance',trans('admin.current_balance') , ['class' => 'control-label']) }}
                </div>
                <div class="col-md-5">

                    {{ Form::text('current_balance', old('current_balance'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.current_balance')])) }}
                    @if ($errors->has('current_balance'))
                        <div class="alert alert-danger" style="margin-top: 10px">{{ $errors->first('current_balance') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>








