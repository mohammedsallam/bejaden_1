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

{!! Form::open(['method'=>'POST','route' => ['departments.store'], 'id' => 'edit_form','files' => true]) !!}
    {{csrf_field()}}
    {{-- Parnt_Acc --}}
    <input type="text" name="Parnt_Acc" id="Parnt_Acc" value="{{$parent? $parent->Acc_No : null}}" hidden>
    <input type="text" name="Cmp_No" id="Cmp_No" value="{{$parent? $parent->Cmp_No : null}}" hidden>
    <input type="text" name="Level_No" id="Level_No" value="{{$parent? $parent->Level_No : null}}" hidden>
    {{-- Parnt_Acc end --}}

    <div class="col-md-1 pull-left">
        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
    </div>

    {{-- رقم الشركه --}}
    <div class="form-group col-md-5">
        <label for="Cmp_No" class="col-md-5">{{trans('admin.cmp_no')}}</label>
        <select name="Cmp_No" id="Cmp_No" class="form-control col-md-7">
            <option value="{{$cmps->Cmp_No? $cmps->Cmp_No : null}}">{{$cmps->{'Cmp_Nm'.ucfirst(session('lang'))} }}</option>
        </select>
    </div>
    {{-- نهاية رقم الشركه --}}

    <div class="col-md-3">
        <label>{{trans('admin.account_number')}}:{{$parent->Acc_No}}</label>
    </div>

    {{-- تصنيف الحساب --}}
    <div class="form-group">
        @foreach(\App\Enums\dataLinks\TypeAccountType::toSelectArray() as $key => $value)
            <input class="checkbox-inline" type="radio" 
                name="Level_Status" id="Level_Status" value="{{$key}}"
                style="margin: 3px;" @if($key == 1) checked @endif>
            <label>{{$value}}</label>
        @endforeach
    </div>
    {{-- نهاية تصنيف الحساب --}}

    {{-- اسم الحساب عربى --}}
    <div class="form-group col-md-12">
        <label class="col-md-3" for="Acc_NmAr">{{trans('admin.account_name')}}:</label>
        <input type="text" name="Acc_NmAr" id="Acc_NmAr" class="col-md-9 form-control">
    </div>
    {{-- نهاية اشم الحساب عربى --}}

    {{-- اسم الحساب انجليزى --}}
    <div class="form-group col-md-12">
        <label class="col-md-3" for="Acc_NmEn">{{trans('admin.account_name_en')}}:</label>
        <input type="text" name="Acc_NmEn" id="Acc_NmEn" class=" col-md-9 form-control">
    </div>
    {{-- نهاية اسم الحساب انجليزى --}}

    <div class="col-md-6">
        <div class="row">
            {{-- طبيعة الحساب --}}
            <div class="form-group col-md-12 branch">
                <label for="Acc_Ntr" style="margin-left:15px;">{{trans('admin.category')}}:</label>
                @foreach(\App\Enums\dataLinks\CategoryAccountType::toSelectArray() as $key => $value)
                    <input class="checkbox-inline" type="radio" 
                        name="Acc_Ntr" id="Acc_Ntr" value="{{$key}}"
                        style="margin: 3px;">
                    <label>{{$value}}</label>
                @endforeach
            </div>
            {{-- نهاية طبيعة الحساب --}}

            {{-- رصيد اول المده مدين --}}
            <div class="col-md-12 branch">
                <div class="form-group row">
                    <label for="Fbal_DB" class="col-md-5">{{trans('admin.first_date_debtor')}}</label>
                    <input type="text" name="Fbal_DB" id="Fbal_DB" class="form-control col-md-7" value="{{0}}">
                </div>
            </div>
            {{-- نهايةرصيد اول المده مدين --}}

            {{-- رصيد اول المده دائن --}}
            <div class="col-md-12 branch">
                <div class="form-group row">
                    <label for="Fbal_CR" class="col-md-5">{{trans('admin.first_date_creditor')}}</label>
                    <input type="text" name="Fbal_CR" id="Fbal_CR" value='{{0}}' class="form-control col-md-7">
                </div>
            </div>
            {{-- نهاية رصيد اول المده دائن --}}

            {{-- رصيد اول المده دائن --}}
            <div class="col-md-12 branch">
                <div class="form-group row">
                    <label for="Cr_Blnc" class="col-md-5">{{trans('admin.credit_balance')}}</label>
                    <input type="text" name="Cr_Blnc" id="Cr_Blnc" value='{{0}}' class="form-control col-md-7">
                </div>
            </div>
            {{-- نهاية رصيد اول المده دائن --}}
        </div>
    </div>

    {{-- الحساب الرئيسى --}}
    {{-- <div class="col-md-4 hidden" id="main_chart">
        <div class="form-group">
            <label for="Parnt_Acc">{{trans('admin.main_account_chart')}}</label>
            <select name="Parnt_Acc" id="Parnt_Acc" class="form-control">
                <option value="{{null}}">{{trans('admin.select')}}</option>
                @if(count($chart) > 0)
                    @foreach($chart as $ch)
                        <option value="{{$ch->Acc_No? $ch->Acc_No : null}}" @if($chart_item->Parnt_Acc == $ch->Acc_No) selected @endif>{{$ch->{'Acc_Nm'.ucfirst(session('lang'))} }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div> --}}
    {{-- نهاية الحساب الرئيسى --}}

    <div class="col-md-6">
        <div class="row">
            {{-- نوع الحساب --}}
            <div class="col-md-12 branch">
                <label for="Acc_Typ" class="col-md-5 col-md-offset-1">{{trans('admin.account_type')}}</label>
                <div class="form-group">
                    <select name="Acc_Typ" id="Acc_Typ" class="form-control col-md-6">
                        <option value="{{null}}">{{trans('admin.select')}}</option>
                        @foreach(\App\Enums\AccountType::toSelectArray() as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- نهاية نوع الحساب --}}

            {{-- حسابات ميزانيه --}}
            <div class="col-md-12 branch">
                <input class="checkbox-inline col-md-1" type="checkbox" id='Clsacc_No1_Check'>
                <label for="Clsacc_No1" class="col-md-5">{{trans('admin.Clsacc_No1')}}</label>

                <div class="form-group">
                    <select name="Clsacc_No1" id="Clsacc_No1" class="form-control col-md-6 hidden">
                        <option value="{{null}}">{{trans('admin.select')}}</option>
                        {{-- @foreach(\App\Enums\dataLinks\IncomeListType::toSelectArray() as $key => $value)
                            <option value="{{$key}}" @if($chart_item->Clsacc_No == $key) selected @endif>{{$value}}</option>
                        @endforeach --}}
                    </select>
                </div>
            </div>
            {{-- نهاية الحسابات ميزانيه--}}

            {{-- حسابات قائمة الدخل --}}
            <div class="col-md-12 branch">
                <input class="checkbox-inline col-md-1 checks" type="checkbox" id='Clsacc_No2_Check'>
                <label for="Clsacc_No2" class="col-md-5">{{trans('admin.Clsacc_No2')}}</label>

                <div class="form-group">
                    <select name="Clsacc_No2" id="Clsacc_No2" class="form-control col-md-6 hidden">
                        <option value="{{null}}">{{trans('admin.select')}}</option>
                        {{-- @foreach(\App\Enums\dataLinks\IncomeListType::toSelectArray() as $key => $value)
                            <option value="{{$key}}" @if($chart_item->Clsacc_No == $key) selected @endif>{{$value}}</option>
                        @endforeach --}}
                    </select>
                </div>
            </div>
            {{-- نهاية الحسابات قائمة الدخل --}}
            

            {{-- مركز التكلفه --}}
            <div class="col-md-12 branch">
                <input class="checkbox-inline col-md-1 checks" type="checkbox" id='cc_type_Check'>
                <label for="cc_type" class="col-md-5">{{trans('admin.with_cc')}}</label>

                <div class="form-group">
                    <select name="cc_type" id="cc_type" class="form-control col-md-6 hidden">
                        <option value="{{null}}">{{trans('admin.select')}}</option>
                        {{-- @foreach(\App\Enums\dataLinks\IncomeListType::toSelectArray() as $key => $value)
                            <option value="{{$key}}" @if($chart_item->Clsacc_No == $key) selected @endif>{{$value}}</option>
                        @endforeach --}}
                    </select>
                </div>
            </div>
            {{-- نهاية مركز التكلفه --}}
        </div>
    </div>                            

{!! Form::close() !!}
