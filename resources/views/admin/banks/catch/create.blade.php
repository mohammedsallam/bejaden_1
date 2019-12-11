@extends('admin.index')
@section('title',trans('admin.create_catch_receipt'))
@section('content')
    @push('js')
        <script>
            $(document).ready(function(){
                //get branches of specific company selection
                $(document).on('change', '#Cmp_No', function(){  
                    $.ajax({
                        url: "{{route('getBranchesAndStores')}}",
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Cmp_No: $(this).val() },
                        success: function(data){
                            $('#Brn_No_content').html(data);
                        }
                    });

                    //get salesmen of specific company selection
                    $.ajax({
                        url: "{{route('getSalesMan')}}",
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Cmp_No: $(this).val() },
                        success: function(data){
                            $('#Salman_No_content').html(data);
                        }
                    });
                });

                //get number of selected salesman
                $(document).on('change', '#Salman_No_select', function(){
                    var Salman_No = $(this).val();
                    $('#Salman_No').val(Salman_No);
                }); 

                // convert Tr_Dt ro hijry
                let Hijri = $('input#Tr_Dt').val();
                $.ajax({
                    url: "{{route('hijri')}}",
                    type: 'get',
                    data:{Hijri: Hijri},
                    dataType: 'json',
                    success: function (data) {
                        $('#Tr_DtAr').val(data);
                    }
                });
            });
        </script>
    @endpush
    {{-- الشركه --}}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="Cmp_No">{{trans('admin.company')}}</label>
                <select name="Cmp_No" id="Cmp_No" class="form-control">
                    <option value="{{null}}">{{trans('admin.select')}}</option>
                    @if(count($companies) > 0)
                            @foreach($companies as $cmp)
                                <option value="{{$cmp->Cmp_No}}">{{$cmp->{'Cmp_Nm'.ucfirst(session('lang'))} }}</option>
                            @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
    {{-- نهاية الشركه --}}

    <div class="row">
        {{-- الفرع --}}
        <div class="col-md-2">
            <div class="form-group">
                <label for="Brn_No">{{trans('admin.section')}}</label>
                <div id="Brn_No_content">
                    <select name="Brn_No" id="Brn_No" class="form-control">
                        <option value="{{null}}">{{trans('admin.select')}}</option>
                    </select>
                </div>
            </div>
        </div>
        {{-- نهاية الفرع --}}
        {{-- رقم السند --}}
        <div class="col-md-1">
            <div class="form-group">
                <label for="Tr_No">{{trans('admin.number_of_receipt')}}</label>
                <input type="text" name="Tr_No" id="Tr_No" value="" class="form-control">
            </div>
        </div>
        {{-- نهايو رقم السند --}}
        {{-- تاريخ السند --}}
        <div class="col-md-2">
            <div class="form-group">
                <label for="Tr_Dt">{{trans('admin.receipt_date')}}</label>
                <input type="text" name="Tr_Dt" id="Tr_Dt" class="form-control" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="Tr_DtAr">{{trans('admin.higri_date')}}</label>
                <input type="text" name="Tr_DtAr" id="Tr_DtAr" class="form-control">
            </div>
        </div>
        {{-- نهاية تاريخ السند --}}
        {{-- نوع السند نقدى \ شيك --}}
        <div class="col-md-1">
            <label for="Jr_Ty">{{trans('admin.receipts_type')}}</label>
            <select name="Jr_Ty" id="Jr_Ty" class="form-control">
                <option value="{{2}}">{{trans('admin.cash_reciept')}}</option>
                <option value="{{3}}">{{trans('admin.cheque_reciept')}}</option>
            </select>
        </div>
        {{-- نهاية نوع السند نقدى \ شيك --}}
        {{-- العمله --}}
        <div class="col-md-2">
            <label for="Tr_Crncy">{{trans('admin.currency')}}</label>
            <select name="Tr_Crncy" id="Tr_Crncy" class="form-control">
                @foreach(App\Enums\CurrencyType::toSelectArray() as $key => $value) 
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
        {{-- نهاية العمله --}}
        {{-- سعر الصرف --}}
        <div class="col-md-2">
            <label for="Tr_ExchRat">{{trans('admin.exchange_rate')}}</label>
            <input type="text" name="Tr_ExchRat" id="Tr_ExchRat" class="form-control">
        </div>
        {{-- نهاية سعر الصرف --}}
    </div>

    <div class="row">
        {{-- المبلغ المطلوب --}}
        <div class="col-md-2">
            <label for="Tr_Cr">{{trans('admin.amount')}}</label>
            <input type="text" name="Tr_Cr" id="Tr_Cr" class="form-control">
        </div>
        {{-- نهاية المبلغ المطلوب --}}
        {{-- الضريبه --}}
        <div class="col-md-1">
            <label for="Tr_TaxVal">{{trans('admin.tax')}} %</label>
            <input type="text" name="Tr_TaxVal" id="Tr_TaxVal" class="form-control">
        </div>
        {{-- نهاية الضريبه --}}
        {{-- منصرف بواسطة --}}
        <div class="col-md-3">
            <label for="Pymt_By">{{trans('admin.Pymt_By')}}</label>
            <input type="text" name="Pymt_By" id="Pymt_By" class="form-control">
        </div>
        {{-- نهاية منصرف بواسطة --}}
        {{-- مندوب المبيعات --}}
        <div class="col-md-3">
            <label for="Salman_No_select">{{trans('admin.sales_officer2')}}</label>
            <div id="salman_No_content">
                <select name="Salman_No_select" id="Salman_No_select" class="form-control">
                    <option value="{{null}}">{{trans('admin.select')}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <label for=""></label>
            <input type="text" name="Salman_No" id="Salman_No" class="form-control">
            <br>
        </div>
        {{-- نهاية مندوب المبيعات --}}
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        {{trans('admin.information_account')}}
                    </div>
                </div>
                <div class="panel-body">
                    {{-- الحساب الرئيسى --}}
                    <div class="row">
                        <div class="col-md-8">
                            <label for="main_acc">{{trans('admin.main_account_chart')}}</label>
                            <input type="text" name="main_acc" id="main_acc" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for=""></label>
                            <input type="text" name="TrAcc_No" id="TrAcc_No" class="form-control">
                        </div>
                    </div>
                    {{-- نهاسة الحساب الرئيسى --}}
                    {{-- نوع الحساب --}}
                    <div class="row">
                        <div class="col-md-2">
                            <label for="Ac_Ty">{{trans('admin.account_type')}}</label>
                            <select name="Ac_Ty" id="Ac_Ty" class="form-control">
                                <option value="{{null}}">{{trans('admin.select')}}</option>
                                @foreach(\App\Enums\AccountType::toSelectArray() as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label for="Ac_Ty_children"></label>
                            <select name="Ac_Ty_children" id="Ac_Ty_children" class="form-control">
                                <option value="{{null}}">{{trans('admin.select')}}</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="sub_sys_acc_no"></label> <!--sub_sys_acc_no for Cstm_No, Sup_No, or Emp_No -->
                            <input type="text" name="sub_sys_acc_no" id="sub_sys_acc_no" class="form-control">
                        </div>
                    </div>
                    {{-- نهاية نوع الحساب --}}

                    <div class="row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6"></div>
    </div>
@endsection
