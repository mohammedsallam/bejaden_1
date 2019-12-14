@extends('admin.index')
@inject('companies', 'App\Models\Admin\MainCompany')
@inject('branches', 'App\Models\Admin\MainBranch')
@inject('customers', 'App\Models\Admin\MainBranch')
@inject('customers', 'App\Models\Admin\MTsCustomer')
@inject('delegates', 'App\Models\Admin\AstSalesman')
@inject('supervisors', 'App\Models\Admin\AstMarket')
@inject('supctgs', 'App\Models\Admin\Astsupctg')
@inject('activities', 'App\Models\Admin\AstNutrbusn')
@inject('countries', 'App\country')
@inject('cities', 'App\city')
@section('title',trans('admin.Edit_Subscriber').' '.session_lang($subscriber->Cstm_NmEN,$subscriber->Cstm_NmAr))
@section('content')
    @push('css')
    <style>
        fieldset {
            display: block;
            margin-left: 2px;
            margin-right: 2px;
            padding-top: 0.35em;
            padding-bottom: 0.625em;
            padding-left: 0.75em;
            padding-right: 0.75em;
            border: 2px solid #ccc;
        }
        legend{
            display: block;
            padding: 0;
            margin-bottom: 20px;
            font-size: 18px;
            line-height: inherit;
            color: #333;
            width: 152px;
            border-bottom: none;
        }
    </style>
    @endpush
    @hasrole('writer','admin')
    <div class="box">
    @include('admin.layouts.message')
    <div class="box-header">
        <h3 class="box-title"></h3> {{-- {{$title}} --}}
    </div>
<div>
  {{Form::model($subscriber,['method'=>'PUT','route'=>['subscribers.update',$subscriber->ID_No],'class'=>'form-group','files'=>true])}}
  <button class="btn btn-primary" style="float: left;"><i class="fa fa-save"></i></button>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#main_data" aria-controls="home" role="tab" data-toggle="tab">{{trans('admin.main_data')}}</a></li>
    <li role="presentation"><a href="#responsible_persons" aria-controls="profile" role="tab" data-toggle="tab">{{trans('admin.responsible_persons')}}</a></li>
  </ul>

  <!-- Tab panes -->

  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="main_data">

            <div class="box-body">

            @can('single')


                <div class="col-md-6">

                <div class="form-group row col-md-12">

                    <div class="form-group">
                        <div class="col-md-2" style="margin-right: -38px;left: -21px;">{!!Form::label('Cmp_No', trans('admin.company'))!!}</div>
                        @if(auth()->user()->company_id == '-1')
                        <div class="col-md-10" style="margin-bottom: 10px; padding-left: 1px;">{!!Form::select('Cmp_No', $companies->pluck('Cmp_ShrtNm', 'ID_NO')->toArray(),null,[
                                'class'=>'form-control','id'=>'companies', 'placeholder'=>trans('admin.select')
                        ])!!}</div>
                        @else
                            <div class="col-md-10" style="margin-bottom: 10px; padding-left: 1px;">{!!Form::text('Cmp_No', null, ['class'=>'form-control'])!!}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="col-md-2" style="left: 8px;">{!!Form::label('Brn_No', trans('admin.branche'))!!}</div>
                        <div class="col-md-10" style="margin-bottom: 10px; padding-left: 38px;">
                            <select class="form-control" name="Brn_No" id="branches">
                               <option>{{trans('admin.select')}}</option>
                           </select>
                        </div>

                    </div>

                </div>
                <div class="form-group row">
                    <div class="form-group row col-md-6">
                        <div class="col-md-3">{!!Form::label('Cstm_No', trans('admin.subscriber_no'))!!}</div>
                        <div class="col-md-9" style="margin-bottom: 10px;">{!!Form::text('Cstm_No', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="col-md-3" style="margin-right: -22px;">{!!Form::label('Cstm_Refno', trans('admin.customer_Ref_no'))!!}</div>
                        <div class="col-md-9" style="margin-bottom: 10px;">{!!Form::text('Cstm_Refno', null, ['class'=>'form-control'])!!}</div>
                    </div>

                </div>
                <div class="form-group row col-md-12">
                    <div class="col-md-12">
                        <div class="col-md-2" style="margin-right: -47px;left: -18px;">{!!Form::label('Cstm_NmAr', trans('admin.subscriber_name_ar'))!!}</div>
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Cstm_NmAr', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-2" style="margin-right: -47px;left: -18px;">{!!Form::label('Cstm_NmEn', trans('admin.subscriber_name_en'))!!}</div>
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Cstm_NmEn', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-2" style="margin-right: -47px;left: -18px;">{!!Form::label('Cstm_Email', trans('admin.email'))!!}</div>
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Cstm_Email', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-2" style="margin-right: -47px;left: -18px;">{!!Form::label('Cstm_Adr', trans('admin.address'))!!}</div>
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Cstm_Adr', null, ['class'=>'form-control'])!!}</div>

                    </div>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="col-md-3" style="margin-right: -26px;">{!!Form::label('Cstm_POBox', trans('admin.mail_box'))!!}</div>
                        <div class="col-md-9">{!!Form::text('Cstm_POBox', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-2" style="margin-right: -29px; left: 16px;">{!!Form::label('Cstm_ZipCode', trans('admin.mail_area'))!!}</div>
                        <div class="col-md-9">{!!Form::text('Cstm_ZipCode', null, ['class'=>'form-control'])!!}</div>
                    </div>
                </div>
                <div class="row col-md-12">

                    <div class="col-md-6">
                        <div class="col-md-3" style="margin-right: -26px;">{!!Form::label('Cstm_Tel', trans('admin.tel'))!!}</div>
                        <div class="col-md-9" style="margin-bottom: 10px;">{!!Form::text('Cstm_Tel', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-3" style="margin-right: -45px;">{!!Form::label('Cstm_Fax', trans('admin.fax'))!!}</div>
                        <div class="col-md-9">{!!Form::text('Cstm_Fax', null, ['class'=>'form-control'])!!}</div>
                    </div>
                </div>
                    <div class="col-md-12">
                        <div class="col-md-2" style="margin-right: -54px; left: -27px;">{!!Form::label('Tel1', trans('admin.tel_1'))!!}</div>
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Tel1', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-2" style="margin-right: -54px;left: -27px;">{!!Form::label('Tel2', trans('admin.mobile'))!!}</div>
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Tel2', null, ['class'=>'form-control'])!!}</div>
                    </div>
                <div class="row col-md-8">
                    <div class="col-md-12">
                        <div class="col-md-3" style="margin-right: -43px;left: -19px;">{!!Form::label('Credit_Value', trans('admin.credit_value'))!!}</div>
                        <div class="col-md-9">{!!Form::text('Credit_Value', null, ['class'=>'form-control'])!!}</div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-3" style="margin-right: -43px;left: -19px;">{!!Form::label('Credit_Days', trans('admin.credit_days'))!!}</div>
                        <div class="col-md-9" style="margin-bottom: 10px;">{!!Form::text('Credit_Days', null, ['class'=>'form-control'])!!}</div>
                    </div>
                </div>
                <div class="row col-md-4">
                    <div class="col-md-12">
                        {!! Form::label('Cstm_Active', trans('admin.active')) !!}
                        {!! Form::checkbox('Cstm_Active') !!}
                    </div>
                    <div class="col-md-12">
                        {!! Form::label('Internal_Invoice', trans('admin.Internal_Invoice')) !!}
                        {!! Form::checkbox('Internal_Invoice') !!}
                    </div>
                </div>


                <div class="form-group row col-md-12">
                    <div class="col-md-12">
                        <div class="col-md-2" style="margin-right: -48px;left: -19px;">{!!Form::label('Notes', trans('admin.Notes'))!!}</div>
                        <div class="col-md-10">{!!Form::textarea('Notes', null, ['class'=>'form-control', 'rows' => 4, 'cols' => 54])!!}</div>
                    </div>
                </div>


            </div>

            <div class="col-md-6">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="col-md-3" style="left: 11px;">{!!Form::label('Cntry_No', trans('admin.country'))!!}</div>
                        <div class="col-md-9" style="margin-bottom: 10px;">{!!Form::select('Cntry_No', $countries->pluck('country_name_'.session('lang'),'id')->toArray(),null,[
                                'class'=>'form-control', 'id'=>'countries','placeholder'=>trans('admin.select')
                        ])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-3" style="padding: 3px">{!!Form::label('City_No', trans('admin.city'))!!}</div>
                        <div class="col-md-9"  style="margin-bottom: 10px;">
                           <select class="form-control" name="City_No" id="cities">
                               <option>{{trans('admin.select')}}</option>
                           </select>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-3" style="padding: 1px;">{!!Form::label('Area_No', trans('admin.area'))!!}</div>
                        <div class="col-md-9" style="margin-bottom: 10px;"><select class="form-control" name="Area_No" id="area">
                        </select></div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-3" style="left:12px;">{!!Form::label('Slm_No', trans('admin.slm_no'))!!}</div>
                        <div class="col-md-9" style="margin-bottom: 10px;">{!!Form::select('Slm_No' ,$delegates->pluck('Slm_Nm'.ucfirst(session('lang')),'ID_No')->toArray(),null,[
                                'class'=>'form-control','placeholder'=>trans('admin.select')
                            ])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-3" style="left:13px;">{!!Form::label('Mrkt_No', trans('admin.mrkt_no'))!!}</div>
                        <div class="col-md-9" style="margin-bottom: 10px;">{!!Form::select('Mrkt_No' ,$supervisors->pluck('Mrkt_Nm'.ucfirst(session('lang')),'ID_No')->toArray(),null,[
                                'class'=>'form-control','placeholder'=>trans('admin.select')
                            ])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-3" style="left:12px;">{!!Form::label('Nutr_No', trans('admin.Nutr_No'))!!}</div>
                        <div class="col-md-9" style="margin-bottom: 10px;">{!!Form::select('Nutr_No' ,$activities->pluck('Nutr_Nm'.ucfirst(session('lang')),'ID_No')->toArray(),null,[
                                'class'=>'form-control','placeholder'=>trans('admin.select')
                            ])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-3" style="left:12px;">{!!Form::label('Fbal_Db', trans('admin.Fbal_Db'))!!}</div>
                        <div class="col-md-9" style="margin-bottom: 10px;">{!!Form::text('Fbal_Db', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-3" style="left:12px;">{!!Form::label('Fbal_CR', trans('admin.Fbal_CR'))!!}</div>
                        <div class="col-md-9" style="margin-bottom: 10px;">{!!Form::text('Fbal_CR', null, ['class'=>'form-control'])!!}</div>
                    </div>
                </div>

                <div class="col-md-6">

                <div class="form-group row">
                    <fieldset>
                        <legend>{{trans('admin.last_bill')}}</legend>
                        <div class="col-md-12">
                            <div class="col-md-3">{!!Form::label('Linv_No', trans('admin.Linv_No'))!!}</div>
                            <div class="col-md-9" style="margin-bottom: 10px;">{!!Form::text('Linv_No', null, ['class'=>'form-control'])!!}</div>
                        </div>
                        <div class="col-md-12">
                        <div class="col-md-3">{!!Form::label('Linv_Dt', trans('admin.Linv_Dt'))!!}</div>
                        <div class="col-md-9" style="margin-bottom: 10px;">{!!Form::date('Linv_Dt', null, ['class'=>'form-control'])!!}</div>
                        </div>
                        <div class="col-md-12">
                        <div class="col-md-3">{!!Form::label('Linv_Net', trans('admin.Linv_Net'))!!}</div>
                        <div class="col-md-9" style="margin-bottom: 10px;">{!!Form::text('Linv_Net', null, ['class'=>'form-control'])!!}</div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>{{trans('admin.last_mo')}}</legend>
                        <div class="col-md-12">
                            <div class="col-md-3">{!!Form::label('LRcpt_No', trans('admin.LRcpt_No'))!!}</div>
                            <div class="col-md-9" style="margin-bottom: 10px;">{!!Form::text('LRcpt_No', null, ['class'=>'form-control'])!!}</div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-3">{!!Form::label('LRcpt_Dt', trans('admin.LRcpt_Dt'))!!}</div>
                            <div class="col-md-9" style="margin-bottom: 10px;">{!!Form::date('LRcpt_Dt', null, ['class'=>'form-control'])!!}</div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-3">{!!Form::label('LRcpt_Db', trans('admin.LRcpt_Db'))!!}</div>
                            <div class="col-md-9" style="margin-bottom: 10px;">{!!Form::text('LRcpt_Db', null, ['class'=>'form-control'])!!}</div>
                        </div>
                    </fieldset>
                    </div>

                </div>
                <div class="col-md-12" style="margin-top: 15px;">

                    <div class="col-md-12" style="margin-bottom: 11px;">
                        <div class="col-md-4">{!!Form::label('Cstm_Ctg', trans('admin.customer_catg'))!!}</div>
                        <div class="col-md-8">{!!Form::select('Cstm_Ctg' ,$supctgs->pluck('Supctg_Nm'.session('lang'),'ID_No')->toArray(),null,[
                                    'class'=>'form-control','placeholder'=>trans('admin.select')
                                ])!!}
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-bottom: 11px;">
                        <div class="col-md-4">{!!Form::label('Acc_No', trans('admin.account_number'))!!}</div>
                        <div class="col-md-8" style="margin-right: 0px;">{!!Form::text('Acc_No', null, ['class'=>'form-control'])!!}</div>
                    </div>

                    <div class="col-md-12" style="margin-bottom: 11px;">
                        <div class="col-md-6">{!!Form::label('Tax_No', trans('admin.Tax_No'))!!}</div>
                        <div class="col-md-6" style="margin-right: 0px;">{!!Form::text('Tax_No', null, ['class'=>'form-control'])!!}</div>
                    </div>

                    <div class="row col-md-12">
                        <div class="col-md-12">
                            {!! Form::label('AgeNot_Calculate', trans('admin.AgeNot_Calculate')) !!}
                            {!! Form::checkbox('AgeNot_Calculate') !!}
                        </div>
                        <div class="col-md-12">
                            {!! Form::label('Deserve_Discount', trans('admin.Deserve_Discount')) !!}
                            {!! Form::checkbox('Deserve_Discount') !!}
                        </div>
                    </div>

                </div>
                </div>


            @else
                <div class="alert alert-danger">{{trans('admin.you_cannt_see_invoice_because_you_dont_have_role_to_access')}}</div>

            @endcan
            </div>



    </div>
    <div role="tabpanel" class="tab-pane" id="responsible_persons">
        <div>
            <div class="box-body">

            @can('single')



                <div class="form-group row col-md-3">
                    <div class="col-md-12" style="text-align: center;">
                        {!!Form::label('Cntct_Prsn1', trans('admin.person_dep_1'))!!}
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Cntct_Prsn1', old('Cntct_Prsn1'), ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">

                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Cntct_Prsn2', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">

                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Cntct_Prsn3', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Cntct_Prsn4', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Cntct_Prsn5', null, ['class'=>'form-control'])!!}</div>
                    </div>
                </div>
                <div class="form-group row col-md-3">
                    <div class="col-md-12" style="text-align: center;">
                        {!!Form::label('TitL1', trans('admin.Title_1'))!!}
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('TitL1', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('TitL2', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('TitL3', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('TitL4', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('TitL5', null, ['class'=>'form-control'])!!}</div>
                    </div>
                </div>
                <div class="form-group row col-md-3">
                    <div class="col-md-12" style="text-align: center;">
                        {!!Form::label('Mobile1', trans('admin.mobile_1'))!!}
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Mobile1', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Mobile2', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Mobile3', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Mobile4', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Mobile5', null, ['class'=>'form-control'])!!}</div>
                    </div>
                </div>
                <div class="form-group row col-md-3">
                    <div class="col-md-12" style="text-align: center;">
                        {!!Form::label('Email1', trans('admin.email_1'))!!}
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::email('Email1', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::email('Email2', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::email('Email3', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::email('Email4', null, ['class'=>'form-control'])!!}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::email('Email5', null, ['class'=>'form-control'])!!}</div>
                    </div>
                </div>


                </div>


            {{Form::close()}}
            @else
                <div class="alert alert-danger">{{trans('admin.you_cannt_see_invoice_because_you_dont_have_role_to_access')}}</div>

            @endcan


        </div>
    </div>

    </div>
    </div>

    @endhasrole
@endsection
