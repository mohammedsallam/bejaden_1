@inject('customers', 'App\Models\Admin\MTsCustomer')
@inject('delegates', 'App\Models\Admin\AstSalesman')

<script>
    $(document).ready(function(){
        $('#delete_button').click(function(e){
            e.preventDefault();
            $('#delete_form').submit()
        });
    });

    $('#Clsacc_No1_Check').on('change', function(){
        if($(this).is(':checked')){
            $('#Clsacc_No1').removeClass('hidden');
        }
        else{
            $('#Clsacc_No1').addClass('hidden');
            $('#Clsacc_No1').val(null);
        }
    });

    $('#Clsacc_No2_Check').on('change', function(){
        if($(this).is(':checked')){
            $('#Clsacc_No2').removeClass('hidden');
        }
        else{
            $('#Clsacc_No2').addClass('hidden');
            $('#Clsacc_No2').val(null);
        }
    });

    $('#cc_type_Check').on('change', function(){
        if($(this).is(':checked')){
            $('#cc_type').removeClass('hidden');
        }
        else{
            $('#cc_type').addClass('hidden');
            $('#cc_type').val(null);
        }
    });

    $('#edit_form :radio[id=Level_Status]').change(function(){
        if($(this).is(':checked')){
            if($(this).val() == 1){
                $('.branch').removeClass('hidden');
            }
            else{
                $('.branch').addClass('hidden');
                $('#Acc_Ntr').val(null);
                $('#Fbal_DB').val(0);
                $('#Fbal_CR').val(0);
                $('#Cr_Blnc').val(0);
                $('#Acc_Typ').val(null);
                $('#Clsacc_No1').val(null);
                $('#Clsacc_No2').val(null);
                $('#cc_type').val(null);
            }
        }
    });
</script>


{!! Form::open(['method'=>'POST','route' => ['projects.update', $chart_item->Prj_No? $chart_item->Prj_No : null], 'id' => 'edit_form','files' => true]) !!}
{{csrf_field()}}
{{method_field('PUT')}}

    @if($children)
        @foreach($children as $child)
            <input type="hidden" name="children[]" value='{{$child}}'>
        @endforeach
    @endif



<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist"  style="margin-bottom: 15px;">
    <li role="presentation" class="active"><a href="#main_data" aria-controls="home" role="tab" data-toggle="tab">{{trans('admin.main_data')}}</a></li>
    <li role="presentation"><a href="#responsible_persons" aria-controls="profile" role="tab" data-toggle="tab">{{trans('admin.responsible_persons')}}</a></li>
</ul>

<!-- Tab panes -->

<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="main_data">


        <div class="col-md-3 pull-left">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
            <button type="submit" class="btn btn-danger" id="delete_button"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
        </div>

        {{-- رقم المشروع --}}
        <label for="Prj_No" class="col-md-2">{{trans('admin.project_number')}}:</label>
        <input type="text" name="Prj_No" id="Prj_No" class="form-control col-md-3" value="{{$chart_item->Prj_No}}">
        {{-- رقم المشروع --}}

        {{-- تصنيف الحساب --}}
        <div class="row">
            <div class="form-group col-md-4 col-md-offset-2">
                @foreach(\App\Enums\dataLinks\TypeAccountType::toSelectArray() as $key => $value)
                    <input class="checkbox-inline" type="radio"
                           name="Level_Status" id="Level_Status" value="{{$key}}"
                           style="margin: 3px;"
                           @if ($chart_item->Level_Status == $key) checked @endif>
                    <label>{{$value}}</label>
                @endforeach
            </div>

            <div class="form-group col-md-offset-3" @if($chart_item->Level_No == 1) hidden @endif>
                @foreach(\App\Enums\dataLinks\StatusTreeType::toSelectArray() as $key => $value)
                    <input class="checkbox-inline" type="radio"
                           name="Prj_Actv" id="Prj_Actv" value="{{$key}}"
                           style="margin: 3px;" @if($chart_item->Prj_Actv == $key) checked @endif>
                    <label>{{$value}}</label>
                @endforeach
            </div>
        </div>
        {{-- نهاية تصنيف الحساب --}}

        {{-- رقم المرجع المشروع --}}
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 branch">
                    <div class="form-group row">
                        <label for="Prj_Refno" class="col-md-5">{{trans('admin.Prj_Refno')}}</label>
                        <input type="text" name="Prj_Refno" id="Prj_Refno" class="form-control col-md-7"
                               value="">
                    </div>
                </div>
                {{-- نهاية رقم المرجع المشروع --}}

                {{-- سنة المشروع --}}
                <div class="col-md-12 branch">
                    <div class="form-group row">
                        <label for="Prj_Year" class="col-md-5">{{trans('admin.Prj_Year')}}</label>
                        <input type="text" name="Prj_Year" id="Prj_Year" class="form-control col-md-7"
                               value="">
                    </div>
                </div>
                {{-- نهاية سنة المشروع --}}

                {{-- العميل --}}
                <div class="col-md-12 branch">
                    <div class="form-group row">
                        <label class="col-md-5" for="">{{trans('admin.subscriper')}}:</label>
                        {!!Form::select('Cstm_No', $customers->pluck('Cstm_Nm'.ucfirst(session('lang')),'ID_No')->toArray(),null,[
                        'class'=>'form-control col-md-7','placeholder'=>trans('admin.select')
                        ])!!}
                    </div>
                </div>
                {{-- نهاية العميل --}}
            </div>

        </div>

        <div class="col-md-6">
            <div class="row">
                {{-- تاريخ المشروع --}}
                <div class="col-md-12 branch">
                    <div class="form-group row">
                        <label for="Tr_Dt" class="col-md-5">{{trans('admin.Tr_Dt')}}</label>
                        <input type="text" name="Tr_Dt" id="Tr_Dt" class="form-control col-md-7"
                               value="">
                    </div>
                </div>
                {{-- تاريخ المشروع --}}

                {{-- التاريخ الهجري --}}

                <div class="col-md-12 branch">
                    <div class="form-group row">
                        <label for="Tr_DtAr" class="col-md-5">{{trans('admin.Tr_DtAr')}}</label>
                        <input type="text" name="Tr_DtAr" id="Tr_DtAr" class="form-control col-md-7"
                               value="">
                    </div>
                </div>

                {{-- المندوب --}}
                <div class="col-md-12 branch">
                    <div class="form-group row">
                        <label class="col-md-5" for="Slm_No">{{trans('admin.slm_no')}}</label>
                        {!!Form::select('Slm_No', $delegates->pluck('Slm_Nm'.ucfirst(session('lang')),'ID_No')->toArray(),null,[
                        'class'=>'form-control col-md-7', 'placeholder'=>trans('admin.select')
                        ])!!}
                    </div>
                </div>
                {{-- نهاية المندوب --}}
            </div>
        </div>





        {{-- اسم الحساب عربى --}}
        <div class="form-group col-md-12 row">
            <label class="col-md-2" for="Prj_NmAr">{{trans('admin.project_name')}}:</label>
            <input type="text" name="Prj_NmAr" id="Prj_NmAr" class="col-md-10 form-control"
                   value="{{$chart_item->Prj_NmAr? $chart_item->Prj_NmAr : null}}">
        </div>
        {{-- نهاية اشم الحساب عربى --}}

        {{-- اسم الحساب انجليزى --}}
        <div class="form-group col-md-12 row">
            <label class="col-md-2" for="Prj_NmEn">{{trans('admin.project_name_en')}}:</label>
            <input type="text" name="Prj_NmEn" id="Prj_NmEn" class="col-md-10 form-control"
                   value="{{$chart_item->Prj_NmEn? $chart_item->Prj_NmEn : null}}">
        </div>
        {{-- نهاية اسم الحساب انجليزى --}}

        {{-- قيمة المشروع --}}
        <div class="form-group col-md-12 row">
            <label class="col-md-2" for="Prj_Value">{{trans('admin.Prj_Value')}}:</label>
            <input type="text" name="Prj_Value" id="Prj_Value" class="col-md-10 form-control"
                   value="{{$chart_item->Prj_Value? $chart_item->Prj_Value : null}}">
        </div>
        {{-- نهاية قيمة المشروع --}}

        {{-- العنوان --}}
        <div class="form-group col-md-12 row">
            <label class="col-md-2" for="Prj_Adr">{{trans('admin.Prj_Adr')}}:</label>
            <input type="text" name="Prj_Adr" id="Prj_Adr" class="col-md-10 form-control"
                   value="{{$chart_item->Prj_Adr? $chart_item->Prj_Adr : null}}">
        </div>
        {{-- نهاية العنوان --}}

        {{-- تليفون --}}
        <div class="form-group col-md-12 row">
            <label class="col-md-2" for="Prj_Tel">{{trans('admin.Prj_Tel')}}:</label>
            <input type="text" name="Prj_Tel" id="Prj_Tel" class=" col-md-10 form-control"
                   value="{{$chart_item->Prj_Tel? $chart_item->Prj_Tel : null}}">
        </div>
        {{-- نهاية التليفون --}}

        {{-- الموبايل --}}
        <div class="form-group col-md-12 row">
            <label class="col-md-2" for="Prj_Mobile">{{trans('admin.Prj_Mobile')}}:</label>
            <input type="text" name="Prj_Mobile" id="Prj_Mobile" class="col-md-10 form-control"
                   value="{{$chart_item->Prj_Mobile? $chart_item->Prj_Mobile : null}}">
        </div>
        {{-- نهاية الموبايل --}}

        <div class="col-md-6">
            <div class="row">
                {{-- الدوله --}}
                <div class="col-md-12 branch">
                    <div class="form-group row">
                        <label for="Country_No" class="col-md-5">{{trans('admin.country')}}</label>
                        <input type="text" name="Country_No" id="Country_No" value=''
                               class="form-control col-md-7">
                    </div>
                </div>
                {{-- نهاية الدوله --}}

                {{-- المدينه --}}
                <div class="col-md-12 branch">
                    <div class="form-group row">
                        <label for="City_No" class="col-md-5">{{trans('admin.city')}}</label>
                        <input type="text" name="City_No" id="City_No" value=''
                               class="form-control col-md-7">
                    </div>
                </div>
                {{-- نهاية المدينه --}}

                {{-- المنطقه --}}
                <div class="col-md-12 branch">
                    <div class="form-group row">
                        <label for="Area_No" class="col-md-5">{{trans('admin.area')}}</label>
                        <input type="text" name="Area_No" id="Area_No" value=''
                               class="form-control col-md-7">
                    </div>
                </div>
                {{-- نهاية المنطقه --}}

                {{-- حساب المصاريف للمشاريع --}}
                <div class="col-md-12 branch">
                    <div class="form-group row">
                        <label for="Acc_DB" class="col-md-5">{{trans('admin.Acc_DB')}}</label>
                        <input type="text" name="Acc_DB" id="Acc_DB"
                               value='{{$chart_item->Acc_DB? $chart_item->Acc_DB : null}}'
                               class="form-control col-md-7">
                    </div>
                </div>
                {{-- نهاية حساب المصاريف للمشاريع --}}

                {{-- حساب الايرادات للمشاريع --}}
                <div class="col-md-12 branch">
                    <div class="form-group row">
                        <label for="Acc_CR" class="col-md-5">{{trans('admin.Acc_CR')}}</label>
                        <input type="text" name="Acc_CR" id="Acc_CR"
                               value='{{$chart_item->Acc_CR? $chart_item->Acc_CR : null}}'
                               class="form-control col-md-7">
                    </div>
                </div>
                {{-- نهاية حساب الايرادات للمشاريع --}}


                {{-- رصيد اول المده مدين --}}
                <div class="col-md-12 branch">
                    <div class="form-group row">
                        <label for="Fbal_DB" class="col-md-5">{{trans('admin.first_date_debtor')}}</label>
                        <input type="text" name="Fbal_DB" id="Fbal_DB"
                               value='{{$chart_item->Fbal_DB? $chart_item->Fbal_DB : null}}'
                               class="form-control col-md-7">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">

                {{-- فئة المشروع --}}
                <div class="col-md-12 branch">
                    <label for="Prj_Categ" class="col-md-5 col-md-offset-1">{{trans('admin.Prj_Categ')}}</label>
                    <div class="form-group">
                        <select name="Prj_Categ" id="Prj_Categ" class="form-control col-md-6">
                            <option value="{{null}}">{{trans('admin.select')}}</option>
                        </select>
                    </div>
                </div>
                {{-- نهاية فئة المشروع --}}

                {{-- وضع المشروع --}}
                <div class="col-md-12 branch">
                    <label for="Prj_Status" class="col-md-5 col-md-offset-1">{{trans('admin.Prj_Status')}}</label>
                    <div class="form-group">
                        <select name="Prj_Status" id="Prj_Status" class="form-control col-md-6"
                            {{-- @if($chart_item->Level_No == 1) disabled @endif--}}
                        >
                            <option value="{{null}}">{{trans('admin.select')}}</option>
                            @foreach(\App\Enums\PrjStatus::toSelectArray() as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- نهاية وضع المشروع --}}

                {{-- رقم الفرع و المستودع --}}


                <div class="col-md-12 branch">
                    <label for="Brn_No" class="col-md-5 col-md-offset-1">{{trans('admin.Brn_No')}}</label>
                    <select name="Brn_No" id="Brn_No" class="form-control col-md-6">
                        <option value="">{{trans('admin.select')}}</option>

                    </select>
                </div>
                <div class="col-md-12 branch">
                    <label for="Dlv_Stor" class="col-md-5 col-md-offset-1">{{trans('admin.Dlv_Stor')}}</label>
                    <select name="Dlv_Stor" id="Dlv_Stor" class="form-control col-md-6">
                        <option value="">{{trans('admin.select')}}</option>

                    </select>
                </div>

                {{-- امر التوريد --}}
                <div class="col-md-12 branch">
                    <label for="Ordr_No" class="col-md-5 col-md-offset-1">{{trans('admin.Ordr_No')}}</label>
                    <div class="form-group">
                        <select name="Ordr_No" id="Ordr_No" class="form-control col-md-6">
                            <option value="{{null}}">{{trans('admin.select')}}</option>
                            @foreach(\App\Enums\AccountType::toSelectArray() as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- نهاية امر التوريد --}}

                {{-- قيمة التوريد --}}
                <div class="col-md-12 branch">

                    <label for="Ordr_Value" class="col-md-5 col-md-offset-1">{{trans('admin.Ordr_Value')}}</label>
                    <input type="text" name="Ordr_Value" id="Ordr_Value" class="form-control col-md-6"
                           value="">
                    <div class="form-group">

                    </div>
                </div>
                {{-- نهاية قيمة التوريد --}}


                {{-- مركز التكلفه --}}
                <div class="col-md-12 branch">
                    <input class="checkbox-inline col-md-1 checks" type="checkbox" id='cc_type_Check'
                    >
                    <label for="cc_type" class="col-md-5">{{trans('admin.with_cc')}}</label>

                    <div class="form-group">
                        <select name="cc_type" id="cc_type" class="form-control col-md-6">
                            <option value="{{null}}">{{trans('admin.select')}}</option>
                            {{-- @foreach(\App\Enums\dataLinks\IncomeListType::toSelectArray() as $key => $value)
                                <option value="{{$key}}" @if($chart_item->Clsacc_No == $key) selected @endif>{{$value}}</option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
                {{-- نهاية مركز التكلفه --}}


                {{-- رصيد اول المده دائن --}}
                <div class="col-md-12 branch" style="top: 22px;">
                    <label for="Fbal_CR" class="col-md-6">{{trans('admin.first_date_creditor')}}</label>
                    <input type="text" disabled name="Fbal_CR" id="Fbal_CR" value=''
                           class="form-control col-md-6">
                </div>
                {{-- نهاية رصيد اول المده دائن --}}


            </div>
        </div>
        <div class="row col-md-12">
            <div class="col-md-6"></div>
            <div class="col-md-6"></div>
        </div>

        {!! Form::close() !!}

        {{-- الحركات --}}
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">الشهر</th>
                    <th scope="col">الحركة مدين</th>
                    <th scope="col">الحركة دائن</th>
                    <th scope="col">الرصيد الحالى</th>
                    <th scope="col"> رصيد تقديرى</th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <th scope="row">يناير</th>
                    <td>
                        0.00
                    </td>
                    <td>
                        0.00
                    </td>
                    <td>
                        0
                    </td>
                </tr>
                <tr>
                    <th scope="row">فبراير</th>
                    <td>
                        0.00
                    </td>
                    <td>
                        0.00
                    </td>
                    <td>
                        0
                    </td>
                </tr>
                <tr>
                    <th scope="row">مارس</th>
                    <td>
                        0.00
                    </td>
                    <td>
                        0.00
                    </td>
                    <td>
                        0
                    </td>
                </tr>
                <tr>
                    <th scope="row">ابريل</th>
                    <td>
                        0.00
                    </td>
                    <td>
                        0.00
                    </td>
                    <td>
                        0
                    </td>
                </tr>
                <tr>
                    <th scope="row">مايو</th>
                    <td>
                        0.00
                    </td>
                    <td>
                        0.00
                    </td>
                    <td>
                        0
                    </td>
                </tr>
                <tr>
                    <th scope="row">يونيو</th>
                    <td>
                        0.00
                    </td>
                    <td>
                        0.00
                    </td>
                    <td>
                        0
                    </td>
                </tr>
                <tr>
                    <th scope="row">يوليو</th>
                    <td>
                        0.00
                    </td>
                    <td>
                        0.00
                    </td>
                    <td>
                        0
                    </td>
                </tr>
                <tr>
                    <th scope="row">اغسطس</th>

                    <td>
                        0.0
                    </td>
                    <td>
                        0.00
                    </td>
                    <td>
                        0
                    </td>
                </tr>
                <tr>
                    <th scope="row">سبتمبر</th>

                    <td>
                        0.00
                    </td>
                    <td>
                        0.00
                    </td>
                    <td>
                        0
                    </td>
                </tr>
                <tr>
                    <th scope="row">أكتوبر</th>

                    <td>
                        0.00
                    </td>
                    <td>
                        0.00
                    </td>
                    <td>
                        0
                    </td>
                </tr>
                <tr>
                    <th scope="row">نوفمبر</th>

                    <td>
                        0.00
                    </td>
                    <td>
                        0.00
                    </td>
                    <td>
                        0
                    </td>
                </tr>
                <tr>
                    <th scope="row">ديسمبر</th>

                    <td>
                        0.00
                    </td>
                    <td>
                        0.00
                    </td>
                    <td>
                        0
                    </td>
                </tr>

                <tr style="background-color: #d3d9df">
                    <th scope="row">الإجمالى</th>

                    <td>
                        0
                    </td>
                    <td>
                        0
                    </td>
                    <td>
                        0
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        {{-- نهاية الحركات --}}
    </div>
    <div role="tabpanel" class="tab-pane active" id="responsible_persons">
        <div>
            <div class="box-body">

                @can('single')



                    <div class="form-group row col-md-6">
                        <div class="col-md-12" style="text-align: center;">
                            {!!Form::label('Cntct_Prsn1', trans('admin.person_dep_1'))!!}
                            <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Cntct_Prsn1', null, ['class'=>'form-control'])!!}</div>
                        </div>
                        <div class="col-md-12">

                            <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Cntct_Prsn2', null, ['class'=>'form-control'])!!}</div>
                        </div>
                    </div>
                    <div class="form-group row col-md-6">
                        <div class="col-md-12" style="text-align: center;">
                            {!!Form::label('TitL1', trans('admin.Title_1'))!!}
                            <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('TitL1', null, ['class'=>'form-control'])!!}</div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('TitL2', null, ['class'=>'form-control'])!!}</div>
                        </div>

                    </div>
                    <div class="form-group row col-md-6">
                        <div class="col-md-12" style="text-align: center;">
                            {!!Form::label('Mobile1', trans('admin.mobile_1'))!!}
                            <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Mobile1', null, ['class'=>'form-control'])!!}</div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::text('Mobile2', null, ['class'=>'form-control'])!!}</div>
                        </div>
                    </div>
                    <div class="form-group row col-md-6">
                        <div class="col-md-12" style="text-align: center;">
                            {!!Form::label('Email1', trans('admin.email_1'))!!}
                            <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::email('Email1', null, ['class'=>'form-control'])!!}</div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-10" style="margin-bottom: 10px;">{!!Form::email('Email2', null, ['class'=>'form-control'])!!}</div>
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



{{-- form end --}}
{!! Form::close() !!}
<form action="{{route('projects.destroy', $chart_item->Prj_No? $chart_item->Prj_No : null)}}" method="POST" id="delete_form">
    {{csrf_field()}}
    {{method_field('DELETE')}}
</form>
 {{-- الحركات --}}
 <div class="col-md-12">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">الشهر</th>
            <th scope="col">الحركة مدين</th>
            <th scope="col">الحركة دائن</th>
            <th scope="col">الرصيد الحالى</th>
            <th scope="col"> رصيد تقديرى</th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <th scope="row">يناير</th>
            <td>
                @if($chart_item->DB11 == null)
                    0.00
                @else
                    {{$chart_item->DB11}}
                @endif
            </td>
            <td>
                @if($chart_item->CR11 == null )
                    0.00
                @else
                    {{$chart_item->CR11}}
                @endif
            </td>
            <td>
                {{$chart_item->DB11 - $chart_item->CR11}}
            </td>
        </tr>
        <tr>
            <th scope="row">فبراير</th>
            <td>
                @if($chart_item->DB12 == null )
                    0.00
                @else
                    {{$chart_item->DB12}}
                @endif
            </td>
            <td>
                @if($chart_item->CR12 == null )
                    0.00
                @else
                    {{$chart_item->CR12}}
                @endif
            </td>
            <td>
                {{$chart_item->DB12 - $chart_item->CR12}}
            </td>
        </tr>
        <tr>
            <th scope="row">مارس</th>
            <td>
                @if($chart_item->DB13 == null )
                    0.00
                @else
                    {{$chart_item->DB13}}
                @endif
            </td>
            <td>
                @if($chart_item->CR13 == null )
                    0.00
                @else
                    {{$chart_item->CR13}}
                @endif
            </td>
            <td>
                {{$chart_item->DB13 - $chart_item->CR13}}
            </td>
        </tr>
        <tr>
            <th scope="row">ابريل</th>
            <td>
                @if($chart_item->DB14 == null )
                    0.00
                @else
                    {{$chart_item->DB14}}
                @endif
            </td>
            <td>
                @if($chart_item->CR14 == null )
                    0.00
                @else
                    {{$chart_item->CR14}}
                @endif
            </td>
            <td>
                {{$chart_item->DB14 - $chart_item->CR14}}
            </td>
        </tr>
        <tr>
            <th scope="row">مايو</th>
            <td>
                @if($chart_item->DB15 == null )
                    0.00
                @else
                    {{$chart_item->DB15}}
                @endif
            </td>
            <td>
                @if($chart_item->CR15 == null )
                    0.00
                @else
                    {{$chart_item->CR15}}
                @endif
            </td>
            <td>
                {{$chart_item->DB15 - $chart_item->CR15}}
            </td>
        </tr>
        <tr>
            <th scope="row">يونيو</th>
            <td>
                @if($chart_item->DB16 == null )
                    0.00
                @else
                    {{$chart_item->DB16}}
                @endif
            </td>
            <td>
                @if($chart_item->CR16 == null )
                    0.00
                @else
                    {{$chart_item->CR16}}
                @endif
            </td>
            <td>
                {{$chart_item->DB16 - $chart_item->CR16}}
            </td>
        </tr>
        <tr>
            <th scope="row">يوليو</th>
            <td>
                @if($chart_item->DB17 == null )
                    0.00
                @else
                    {{$chart_item->DB17}}
                @endif
            </td>
            <td>
                @if($chart_item->CR17 == null )
                    0.00
                @else
                    {{$chart_item->CR17}}
                @endif
            </td>
            <td>
                {{$chart_item->DB17 - $chart_item->CR17}}
            </td>
        </tr>
        <tr>
            <th scope="row">اغسطس</th>

            <td>
                @if($chart_item->DB18 == null )
                    0.00
                @else
                    {{$chart_item->DB18}}
                @endif
            </td>
            <td>
                @if($chart_item->CR18 == null )
                    0.00
                @else
                    {{$chart_item->CR18}}
                @endif
            </td>
            <td>
                {{$chart_item->DB18 - $chart_item->CR18}}
            </td>
        </tr>
        <tr>
            <th scope="row">سبتمبر</th>

            <td>
                @if($chart_item->DB19 == null )
                    0.00
                @else
                    {{$chart_item->DB19}}
                @endif
            </td>
            <td>
                @if($chart_item->CR19 == null )
                    0.00
                @else
                    {{$chart_item->CR19}}
                @endif
            </td>
            <td>
                {{$chart_item->DB19 - $chart_item->CR19}}
            </td>
        </tr>
        <tr>
            <th scope="row">أكتوبر</th>

            <td>
                @if($chart_item->DB20 == null )
                    0.00
                @else
                    {{$chart_item->DB20}}
                @endif
            </td>
            <td>
                @if($chart_item->CR20 == null )
                    0.00
                @else
                    {{$chart_item->CR20}}
                @endif
            </td>
            <td>
                {{$chart_item->DB20 - $chart_item->CR20}}
            </td>
        </tr>
        <tr>
            <th scope="row">نوفمبر</th>

            <td>
                @if($chart_item->DB21 == null )
                    0.00
                @else
                    {{$chart_item->DB21}}
                @endif
            </td>
            <td>
                @if($chart_item->CR21 == null )
                    0.00
                @else
                    {{$chart_item->CR21}}
                @endif
            </td>
            <td>
                {{$chart_item->DB21 - $chart_item->CR21}}
            </td>
        </tr>
        <tr>
            <th scope="row">ديسمبر</th>

            <td>
                @if($chart_item->DB22 == null )
                    0.00
                @else
                    {{$chart_item->DB22}}
                @endif
            </td>
            <td>
                @if($chart_item->CR22 == null )
                    0.00
                @else
                    {{$chart_item->CR22}}
                @endif
            </td>
            <td>
                {{$chart_item->DB22 - $chart_item->CR22}}
            </td>
        </tr>

        <tr style="background-color: #d3d9df">
            <th scope="row">الإجمالى</th>

            <td>
                {{count($total) > 0? $total[0]->total_debit : 0.00}}
            </td>
            <td>
                {{count($total) > 0? $total[0]->total_credit : 0.00}}

            </td>
            <td>
                {{count($total) > 0? $total[0]->total_balance : 0.00}}
            </td>
        </tr>
        </tbody>
    </table>
</div>
{{-- نهاية الحركات --}}
