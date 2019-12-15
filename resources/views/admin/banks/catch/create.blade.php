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
                });

                //get salesmen of specific branch selection
                $(document).on('change', '#Dlv_Stor', function(){
                    $.ajax({
                        url: "{{route('getSalesMan')}}",
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Brn_No: $(this).val() },
                        success: function(data){
                            $('#salman_No_content').html(data);
                        }
                    });

                    $.ajax({
                        url: "{{route('createTrNo')}}",
                        type: "POST",
                        dataType: 'json',
                        data: {"_token": "{{ csrf_token() }}", Brn_No: $(this).val() },
                        success: function(data){
                            $('#Tr_No').val(data);
                        }
                    });
                })

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

                //add transaction row to table
                $('#Tr_Ds1').keyup(function(e){
                    if(e.keyCode == 13){
                        $('#table tr:last').after(`<tr>
                                                <td>id</td>
                                                <td>acc_no</td>
                                                <td>acc_nm</td>
                                                <td>db</td>
                                                <td>cr</td>
                                                <td>note_ar</td>
                                                <td>doc_no</td>
                                                <td>note_en</td>
                                                </tr>`);
                    }
                });

                $(document).on('change', '#Ac_Ty', function(){
                    var Cmp_No = $('#Cmp_No').children('option:selected').val();
                    var Brn_No = $('#Dlv_Stor').children('option:selected').val();

                    if($(this).val() == 1){
                        alert('accounts');
                    }
                    else if($(this).val() == 2){
                        $.ajax({
                            url: "{{route('getCustomers')}}",
                            type: "POST",
                            dataType: 'json',
                            data: {"_token": "{{ csrf_token() }}", Brn_No: Brn_No, Cmp_No: Cmp_No },
                            success: function(data){
                                console.log(data);
                            }
                        });
                    }
                    else if($(this).val() == 3){
                        alert('suppliers');
                    }
                    else if($(this).val() == 4){
                        alert('employees');
                    }
                });

                function addRowHandlers() {
                    var table = document.getElementById('table');
                    console.log(table);
                    var rows = table.getElementsByTagName('tr');
                    for (i = 0; i < rows.length; i++) {
                        var currentRow = table.rows[i];
                        currentRow.id=i;
                        var createClickHandler = function(row) {
                        return function() {
                                var cell = row.getElementsByTagName("td")[0];
                                var id = cell[j].innerHTML;
                                alert("id:" + id);
                                currentRow.remove();
                            };
                        };
                        currentRow.onclick = createClickHandler(currentRow);
                    }
                }
                window.onload = addRowHandlers();

                //add tax
                $('#create_cache :checkbox[id=Tr_TaxVal_check]').change(function(){
                    if($(this).is(':checked')){
                        $('#Tr_TaxVal').removeAttr('disabled');
                    }
                    else{
                        $('#Tr_TaxVal').attr('disabled','disabled');
                        $('#Tr_TaxVal').val(null);
                    }
                });

            });
        </script>
    @endpush

    <form action="{{route('rcatchs.store')}}" method="POST" id="create_cache">
        {{ csrf_field() }}
        <div class="row">
            {{-- الشركه --}}
            <div class="col-md-4">
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
            {{-- نهاية الشركه --}}
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
            <div class="col-md-2">
                <div class="form-group">
                    <label for="Tr_No">{{trans('admin.number_of_receipt')}}</label>
                    <input type="text" name="Tr_No" id="Tr_No" value="" class="form-control">
                </div>
            </div>
            {{-- نهاية رقم السند --}}
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
        </div>
    
        <div class="row">
            {{-- نوع السند نقدى \ شيك --}}
            <div class="col-md-1">
                <label for="Jr_Ty">{{trans('admin.receipts_type')}}</label>
                <select name="Jr_Ty" id="Jr_Ty" class="form-control">
                    @foreach(App\Enums\PayType::toSelectArray() as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                    @endforeach
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
            <div class="col-md-1">
                <label for="Tr_ExchRat">{{trans('admin.exchange_rate')}}</label>
                <input type="text" name="Tr_ExchRat" id="Tr_ExchRat" class="form-control">
            </div>
            {{-- نهاية سعر الصرف --}}
            {{-- المبلغ المطلوب --}}
            <div class="col-md-2">
                <label for="Tr_Cr">{{trans('admin.amount')}}</label>
                <input type="text" name="Tr_Cr" id="Tr_Cr" class="form-control">
            </div>
            {{-- نهاية المبلغ المطلوب --}}
            {{-- الضريبه --}}
            <div class="col-md-1">
                <input type="checkbox" id="Tr_TaxVal_check">
                <label for="Tr_TaxVal">{{trans('admin.tax')}} %</label>
                <input type="text" name="Tr_TaxVal" id="Tr_TaxVal" class="form-control" disabled>
            </div>
            {{-- نهاية الضريبه --}}
            {{-- منصرف بواسطة --}}
            <div class="col-md-2">
                <label for="Rcpt_By">{{trans('admin.Rcpt_By')}}</label>
                <input type="text" name="Rcpt_By" id="Rcpt_By" class="form-control">
            </div>
            {{-- نهاية منصرف بواسطة --}}
            {{-- مندوب المبيعات --}}
            <div class="col-md-2">
                <label for="Salman_No_select">{{trans('admin.sales_officer2')}}</label>
                <div id="salman_No_content">
                    <select name="Salman_No_select" id="Salman_No_select" class="form-control">
                        <option value="{{null}}">{{trans('admin.select')}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <label for=""></label>
                <input type="text" name="Salman_No" id="Salman_No" class="form-control">
                <br>
            </div>
            {{-- نهاية مندوب المبيعات --}}
        </div>
    
        <div class="row">
            {{-- بيانات الحساب الدائن --}}
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
                            {{-- نوع الحساب عملاء - موردين - موظفين - .... --}}
                            <div class="col-md-2">
                                <label for="Ac_Ty">{{trans('admin.account_type')}}</label>
                                <select name="Ac_Ty" id="Ac_Ty" class="form-control">
                                    <option value="{{null}}">{{trans('admin.select')}}</option>
                                    @foreach(\App\Enums\AccountType::toSelectArray() as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- رقم حساب العملاء - رقم حساب الموظفين - رقم حساب الموردين - .... --}}
                            <div class="col-md-8">
                                <label for="Acc_No"></label>
                                <select name="Acc_No" id="Acc_No" class="form-control">
                                    <option value="{{null}}">{{trans('admin.select')}}</option>
                                </select>
                            </div>
                            {{-- رقم العميل - رقم المورد - رقم الموظف --}}
                            <div class="col-md-2">
                                <label for="Sysub_Account"></label>
                                <input type="text" name="Sysub_Account" id="Sysub_Account" class="form-control">
                            </div>
                        </div>
                        {{-- نهاية نوع الحساب --}}
    
                        <div class="row">
                            {{-- المبلغ دائن --}}
                            <div class="col-md-4">
                                <label for="Rcpt_Value">{{trans('admin.amount_cr')}}</label>
                                <input type="text" name="Rcpt_Value" id="Rcpt_Value" class="form-control">
                            </div>
                            {{-- نهاية المبلغ دائن --}}
                            {{-- رقم المستند --}}
                            <div class="col-md-4">
                                <label for="Dc_No">{{trans('admin.receipt_number')}}</label>
                                <input type="text" name="Dc_No" id="Dc_No" class="form-control">
                            </div>
                            {{-- نهاية رقم المستند --}}
                            {{-- مركز التكلفه --}}
                            <div class="col-md-4">
                                <label for="Costcntr_No">{{trans('admin.with_cc')}}</label>
                                <select name="Costcntr_No" id="Costcntr_No" class="form-control">
                                    <option value="{{null}}">{{trans('admin.select')}}</option>
                                </select>
                            </div>
                            {{-- نهاية مركز التكلفه --}}
                        </div>
                        <div class="row">
                            {{-- البيان عربى --}}
                            <div class="col-md-12">
                                <label for="Tr_Ds">{{trans('admin.Statement_ar')}}</label>
                                <input type="text" name="Tr_Ds" id="Tr_Ds" class="form-control">
                            </div>
                            {{-- نهاية البيان عربى --}}
                            {{-- البيان انجليزى --}}
                            <div class="col-md-12">
                                <label for="Tr_Ds1">{{trans('admin.Statement_en')}}</label>
                                <input type="text" name="Tr_Ds1" id="Tr_Ds1" class="form-control">
                            </div>
                            {{-- نهاية البيان انجليزى --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- نهاية بيانات الحساب الدائن --}}
            {{-- بيانات الحساب المدين --}}
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-title">
                            {{trans('admin.dept_account')}}
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            {{-- الصندوق الرئيسى --}}
                            <div class="col-md-6">
                                <label for="">{{trans('admin.main_cache')}}</label>
                                <select name="" id="" class="form-control">
                                    <option value="{{null}}">{{trans('admin.select')}}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for=""></label>
                                <input type="text" name="" id="" class="form-control">
                            </div>
                            {{-- بيانات الصندوق الرئيسى --}}
                            {{-- رقم المستند --}}
                            <div class="col-md-3">
                                <label for="">{{trans('admin.receipt_number')}}</label>
                                <input type="text" name="" id="" class="form-control">
                            </div>
                            {{-- نهاية رقم المستند --}}
                        </div>
                        {{-- البيان --}}
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">{{trans('admin.note_ar')}}</label>
                                <input type="text" name="" id="" class="form-control">
                            </div>
                        </div>
                        {{-- البيان --}}
                    </div>
                    {{-- اجمالى السند --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        {{trans('admin.receipt_total')}}
                                    </div>
                                </div>
                                <div class="panel-body">
                                    {{-- مدين --}}
                                    <div class="col-md-6">
                                        <label for="Tr_Db">{{trans('admin.Fbal_Db_')}}</label>
                                        <input type="text" name="Tr_Db" id="Tr_Db" class="form-control">
                                    </div>
                                    {{-- نهاية مدين --}}
                                    {{-- دائن --}}
                                    <div class="col-md-6">
                                        <label for="Tr_Cr">{{trans('admin.Fbal_CR_')}}</label>
                                        <input type="text" name="Tr_Cr" id="Tr_Cr" class="form-control">
                                    </div>
                                    {{-- نهاية دائن --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- نهاية اجمالى السند --}}
                </div>
            </div>
            {{-- نهاية بيانات الحساب المدين --}}
        </div>
    
        <div class="row">
            <div class="col-md-12">
                <table class="table" id="table">
                    <thead>
                        <th>{{trans('admin.id')}}</th>
                        <th>{{trans('admin.account_number')}}</th>
                        <th>{{trans('admin.account_name')}}</th>
                        <th>{{trans('admin.motion_debtor')}}</th>
                        <th>{{trans('admin.motion_creditor')}}</th>
                        <th>{{trans('admin.note_ar')}}</th>
                        <th>{{trans('admin.receipt_number')}}</th>
                        <th>{{trans('admin.note_en')}}</th>
                    </thead> 
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>5</td>
                        <td>6</td>
                        <td>7</td>
                        <td>8</td>
                    </tr>  
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>5</td>
                        <td>6</td>
                        <td>7</td>
                        <td>8</td>
                    </tr>  
                </table>
            </div>
        </div>
    </form>
@endsection
