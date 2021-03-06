@extends('admin.index')
@section('title',trans('admin.create_caching_receipt'))
@section('content')

    @push('css')
        <style>
            .panel-H{
                border-color: #0cc399 !important;
            }
            .panel-A {
                background-color: #0cc399 !important;
                border-color: #0cc399 !important;
            }
        </style>

    @endpush
    @push('js')
        <script>
            $(document).ready(function(){
                $('#Acc_No_Select').select2({});
                $('#Costcntr_No').select2({});

                var catch_data = [];
                var old = 0;
                var Ln_No = 1;
                var tax = false;

                //get branches of selected company on page load
                $.ajax({
                    url: "{{route('branchForEditC')}}",
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}", Cmp_No: $('#Cmp_No').children('option:selected').val() },
                    success: function(data){
                        $('#Dlv_Stor').html(data);
                        $.ajax({
                            //create transaction  number according to selected branch on page load
                            url: "{{route('createTrNo')}}",
                            type: "POST",
                            dataType: 'json',
                            data: {"_token": "{{ csrf_token() }}",
                                Brn_No: $('#Dlv_Stor').children('option:selected').val(),
                                Cmp_No: $('#Cmp_No').children('option:selected').val() },
                            success: function(data){
                                $('#Tr_No').val(data);
                            }
                        });
                    }
                });

                //get companies on page load
                $.ajax({
                    url: "{{route('getCmpSalesMen')}}",
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}", Cmp_No: $('#Cmp_No').children('option:selected').val() },
                    success: function(data){
                        $('#Slm_No_Name').html(data);
                        $('#Slm_No').val($('#Slm_No_Name').children('option:selected').val());
                    }
                });

                $(document).on('change', '#Slm_No_Name', function(){
                    $('#Slm_No').val($('#Slm_No_Name').children('option:selected').val());
                });

                //get tax value according to selected company on page load
                $.ajax({
                    url: "{{route('getTaxValue')}}",
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}", Cmp_No: $('#Cmp_No').children('option:selected').val() },
                    success: function(data){
                        $('#Taxp_Extra').val(data);
                    }
                });

                //get branches of selected company on company select
                $(document).on('change', '#Cmp_No', function(){
                    $.ajax({
                        url: "{{route('branchForEdit')}}",
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Cmp_No: $(this).val() },
                        success: function(data){
                            $('#Dlv_Stor').html(data);
                            //create transaction number accoriding to selected branch
                            $.ajax({
                                url: "{{route('createTrNo')}}",
                                type: "POST",
                                dataType: 'json',
                                data: {"_token": "{{ csrf_token() }}",
                                    Brn_No: $('#Dlv_Stor').children('option:selected').val(),
                                    Cmp_No: $('#Cmp_No').children('option:selected').val() },
                                success: function(data){
                                    $('#Tr_No').val(data);
                                }
                            });
                        }
                    });

                    $.ajax({
                        url: "{{route('getTaxValueC')}}",
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Cmp_No: $(this).val() },
                        success: function(data){
                            $('#Taxp_Extra').val(data);
                        }
                    });

                    $.ajax({
                        url: "{{route('getCmpSalesMen')}}",
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Cmp_No: $('#Cmp_No').children('option:selected').val() },
                        success: function(data){
                            $('#Slm_No_Name').html(data);
                            $('#Slm_No').val($('#Slm_No_Name').children('option:selected').val());
                        }
                    });
                });

                //انشاء رقم الحركه حسب اختيار الفرع
                $(document).on('change', '#Dlv_Stor', function(){
                    var Cmp_No = $('#Cmp_No').children('option:selected').val();
                    $.ajax({
                        url: "{{route('createTrNoC')}}",
                        type: "POST",
                        dataType: 'json',
                        data: {"_token": "{{ csrf_token() }}", Brn_No: $(this).val(), Cmp_No: Cmp_No },
                        success: function(data){
                            $('#Tr_No').val(data);
                        }
                    });
                });

                // convert Tr_Dt ro hijry
                let Hijri = $('input#Tr_Dt').val();
                $.ajax({
                    url: "{{route('hijriC')}}",
                    type: 'get',
                    data:{Hijri: Hijri},
                    dataType: 'json',
                    success: function (data) {
                        $('#Tr_DtAr').val(data);
                    }
                });

                //get all leaf accounts when selecting account type (leaf acounts: customers / suppliers / employees...)
                $(document).on('change', '#Ac_Ty', function(){
                    var Cmp_No = $('#Cmp_No').children('option:selected').val();
                    var Brn_No = $('#Dlv_Stor').children('option:selected').val();
                    var Acc_Ty = $(this).val();
                    $.ajax({
                        url: "{{route('getSubAccC')}}",
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Brn_No: Brn_No, Cmp_No: Cmp_No, Acc_Ty: Acc_Ty},
                        success: function(data){
                            $('#Acc_No_Select').html(data);
                        }
                    });
                });

                //get parent account number on account select (when selecting customer / supplier / employee ..)
                $(document).on('change', '#Acc_No_Select', function(){
                    var Cmp_No = $('#Cmp_No').children('option:selected').val();
                    var Brn_No = $('#Dlv_Stor').children('option:selected').val();
                    var Acc_Ty = $('#Ac_Ty').children('option:selected').val();
                    var Acc_No = $(this).val();
                    $.ajax({
                        url: "{{route('getMainAccNoC')}}",
                        type: "POST",
                        dataType: 'json',
                        data: {"_token": "{{ csrf_token() }}", Brn_No: Brn_No, Cmp_No: Cmp_No, Acc_Ty: Acc_Ty, Acc_No: Acc_No },
                        success: function(data){
                            $('#Sysub_Account').val($('#Acc_No_Select').val());
                            $('#Acc_No').val(data.mainAccNo.acc_no);
                            $('#main_acc').val(data.mainAccNm.acc_name);

                            if(data.AccNm && data.AccNm.cc_flag && data.AccNm.cc_no){
                                $('#Costcntr_No_content').removeClass('hidden');
                            }
                            else{
                                $('#Costcntr_No_content').addClass('hidden');
                                $('#Costcntr_No').val(null);
                            }
                        }
                    });

                    //get salesman in case Acc_Ty == 2 (customers)
                    if(Acc_Ty == 2){
                        $.ajax({
                            url: "{{route('getSalesManC')}}",
                            type: "POST",
                            dataType: 'html',
                            data: {"_token": "{{ csrf_token() }}", Acc_No: Acc_No },
                            success: function(data){
                                $('#Slm_No_Name').html(data);
                                $('#Slm_No').val($('#Slm_No_Name').children('option:selected').val());
                            }
                        });
                    }
                });

                //add tax
                $('#create_cache :checkbox[id=Taxp_Extra_check]').change(function(){
                    if($(this).is(':checked')){
                        $('#Taxp_Extra').removeAttr('disabled');
                        calcTax();
                    }
                    else{
                        $('#Taxp_Extra').attr('disabled','disabled');
                        // $('#Taxp_Extra').val(null);
                        $('#Tr_Db').val($('#Tot_Amunt').val());
                        $('#Taxv_Extra').val(parseFloat($('#Tr_Db').val()) - parseFloat($('#Tot_Amunt').val()));
                    }
                    $('#Tr_Db_Db').val(parseFloat(old) + parseFloat($('#Tr_Db').val()));
                    $('#Tr_Cr_Db').val(parseFloat(old) + parseFloat($('#Tr_Db').val()));
                    $('#Tr_Dif').val( $('#Tr_Db_Db').val() - $('#Tr_Cr_Db').val() );
                });

                //حساب اجمالى المبلغ المطلوب عند ادخال مبلغ جديد
                $('#Tot_Amunt').change(function(){
                    calcTax();
                    $('#Tr_Db_Db').val(parseFloat(old) + parseFloat($('#Tr_Db').val()));
                    $('#Tr_Cr_Db').val(parseFloat(old) + parseFloat($('#Tr_Db').val()));
                    $('#Tr_Dif').val( $('#Tr_Db_Db').val() - $('#Tr_Cr_Db').val() );
                });

                //حساب اجمالى المبلغ المطلوب عند اختيار الضريبه
                $('#Taxp_Extra').change(function(){
                    calcTax();
                    $('#Tr_Db_Db').val(parseFloat(old) + parseFloat($('#Tr_Db').val()));
                    $('#Tr_Cr_Db').val(parseFloat(old) + parseFloat($('#Tr_Db').val()));
                    $('#Tr_Dif').val( $('#Tr_Db_Db').val() - $('#Tr_Cr_Db').val() );
                });

                $('#Dc_No').change(function(){
                    $('#Dc_No_Db').val($('#Dc_No').val());
                });
                $('#Tr_Ds').change(function(){
                    $('#Tr_Ds_Db').val($('#Tr_Ds').val());
                });

                //رقم حساب الصندوق الرئيسى
                $('#Tr_Db_Acc_No').val($('#Tr_Db_Select').children('option:selected').val());
                $('#Tr_Db_Select').change(function(){
                    $('#Tr_Db_Acc_No').val($('#Tr_Db_Select').val());
                });

                //اضافة سطر فى الجدول
                $('#add_line').click(function(e){
                    e.preventDefault();
                    if($('#create_cache :checkbox[id=Taxp_Extra_check]').is(':checked'))
                    {
                        tax = true;
                    }else{
                        tax = false;
                    }

                    if($('#Ln_No').val() == -1){
                        Ln_No = Ln_No + 1;
                        $('#Ln_No').val(Ln_No);
                    }

                    $.ajax({
                        url: "{{route('validateCacheC')}}",
                        type: "post",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}",Brn_No: $('#Dlv_Stor').children('option:selected').val(),
                            Cmp_No: $('#Cmp_No').children('option:selected').val(),
                            Tr_No: $('#Tr_No').val(),
                            Tr_Dt: $('#Tr_Dt').val(),
                            Tr_DtAr: $('#Tr_DtAr').val(),
                            Doc_Type: $('#Doc_Type').children('option:selected').val(),
                            Curncy_No: $('#Curncy_No').children('option:selected').val(),
                            Curncy_Rate: $('#Curncy_Rate').val(),
                            Tot_Amunt: $('#Tot_Amunt').val(),
                            Taxp_Extra: $('#Taxp_Extra').val(),
                            Rcpt_By: $('#Rcpt_By').val(),
                            Slm_No: $('#Slm_No').val(),
                            Ac_Ty: $('#Ac_Ty').children('option:selected').val(),
                            Sysub_Account: $('#Sysub_Account').val(),
                            Tr_Db: $('#Tr_Db').val(),
                            Dc_No: $('#Dc_No').val(),
                            Tr_Ds: $('#Tr_Ds').val(),
                            Tr_Ds1: $('#Tr_Ds1').val(),
                            Acc_No: $('#Acc_No').val(),
                            last_record : $('#last_record').val(),
                            Chq_no: $('#Chq_no').val(),
                            Bnk_Nm: $('#Bnk_Nm').val(),
                            Issue_Dt: $('#Issue_Dt').val(),
                            Due_Issue_Dt: $('#Due_Issue_Dt').val(),
                            Rcpt_By: $('#Rcpt_By').val(),
                            Tr_Db_Acc_No: $('#Tr_Db_Acc_No').val(),
                            Tr_Db_Db: $('#Tr_Db_Db').val(),
                            Tr_Cr_Db: $('#Tr_Cr_Db').val(),
                            Ln_No: $('#Ln_No').val(),
                            Tr_Ds_Db: $('#Tr_Ds_Db').val(),
                            FTot_Amunt: $('#FTot_Amunt').val(),
                            Taxv_Extra: $('#Taxv_Extra').val(), },

                        success: function(data){
                            var response = JSON.parse(data);
                            if(response.success == true){
                                $('#table').append(`
                                <tr class='tr'>
                                    <td>`+$('#Ln_No').val()+`</td>
                                    <td>`+$('#Sysub_Account').val()+`</td>
                                    <td>`+$('#Acc_No_Select option:selected').html()+`</td>
                                    <td>`+$('#Tr_Db').val()+`</td>
                                    <td>0.00</td>
                                    <td>`+$('#Tr_Ds').val()+`</td>
                                    <td>`+$('#Dc_No').val()+`</td>
                                    <td>`+$('#Tr_Ds1').val()+`</td>
                                </tr>`);

                                var rows = document.getElementById('table').rows;
                                var sum = 0.0;
                                for (var i=1; i<rows.length; i++){
                                    if(rows[i].cells.length > 0){
                                        sum += parseFloat(rows[i].cells[3].innerHTML);
                                    }
                                }
                                $('#Tr_Db_Db').val(sum);
                                $('#Tr_Cr_Db').val(sum);

                                var item = {
                                    Brn_No: $('#Dlv_Stor').children('option:selected').val(),
                                    Cmp_No: $('#Cmp_No').children('option:selected').val(),
                                    Tr_No: $('#Tr_No').val(),
                                    Tr_Dt: $('#Tr_Dt').val(),
                                    Tr_DtAr: $('#Tr_DtAr').val(),
                                    Doc_Type: $('#Doc_Type').children('option:selected').val(),
                                    Curncy_No: $('#Curncy_No').children('option:selected').val(),
                                    Curncy_Rate: $('#Curncy_Rate').val(),
                                    Tot_Amunt: $('#Tot_Amunt').val(),
                                    Taxp_Extra: $('#Taxp_Extra').val(),
                                    Rcpt_By: $('#Rcpt_By').val(),
                                    Slm_No: $('#Slm_No').val(),
                                    Ac_Ty: $('#Ac_Ty').children('option:selected').val(),
                                    Sysub_Account: $('#Sysub_Account').val(),
                                    Tr_Db: $('#Tr_Db').val(),
                                    Dc_No: $('#Dc_No').val(),
                                    Tr_Ds: $('#Tr_Ds').val(),
                                    Tr_Ds1: $('#Tr_Ds1').val(),
                                    Acc_No: $('#Acc_No').val(),
                                    last_record : $('#last_record').val(),
                                    Chq_no: $('#Chq_no').val(),
                                    Bnk_Nm: $('#Bnk_Nm').val(),
                                    Issue_Dt: $('#Issue_Dt').val(),
                                    Due_Issue_Dt: $('#Due_Issue_Dt').val(),
                                    Rcpt_By: $('#Rcpt_By').val(),
                                    Tr_Db_Acc_No: $('#Tr_Db_Acc_No').val(),
                                    Tr_Db_Db: $('#Tr_Db_Db').val(),
                                    Tr_Cr_Db: $('#Tr_Cr_Db').val(),
                                    Ln_No: $('#Ln_No').val(),
                                    Tr_Ds_Db: $('#Tr_Ds_Db').val(),
                                    main_acc: $('#main_acc').val(),
                                    FTot_Amunt: $('#FTot_Amunt').val(),
                                    Taxv_Extra: $('#Taxv_Extra').val(),
                                    tax: tax,
                                };

                                catch_data.push(item);

                                $('#Curncy_No').val(1);
                                $('#Tot_Amunt').val(null);
                                $('#main_acc').val(null);
                                $('#Rcpt_By').val(null);
                                $('#Slm_No').val(null);
                                $('#Ac_Ty').val(null);
                                $('#Sysub_Account').val(null);
                                $('#Tr_Db').val(null);
                                $('#Dc_No').val(null);
                                $('#Tr_Ds').val(null);
                                $('#Tr_Ds1').val(null);
                                $('#Acc_No').val(null);
                                $('#Acc_No_Select').val(null);
                                $('#Dc_No_Db').val(null);
                                $('#Tr_Ds_Db').val(null);
                                $('#Slm_No_Name').val(null);
                                $('#Chq_no').val(null);
                                $('#Bnk_Nm').val(null);
                                $('#Issue_Dt').val(null);
                                $('#Due_Issue_Dt').val(null);
                                $('#Rcpt_By').val(null);
                                $('#Ln_No').val(-1);
                                $('#FTot_Amunt').val(null)
                                $('#Taxv_Extra').val(null)

                                // handle click table rows click
                                var table = document.getElementById("table");
                                if (table != null) {
                                    for (var i = 0; i < table.rows.length; i++) {
                                        for (var j = 0; j < table.rows[i].cells.length; j++)
                                            table.rows[i].onclick = function () {
                                                tableText(this, catch_data);
                                                this.innerHTML = '';
                                            };
                                    }
                                }

                            }
                            else{
                                $('#alert').removeClass('hidden');
                                $('#alert').html(``);
                                var errors = Object.values(response.data);
                                for(var i = 0; i < errors.length; i++){
                                    $('#alert').append(`<div class='alert alert-danger'>`+errors[i]+`</div>`);
                                }
                            }
                        }
                    });

                    old = $('#Tr_Db_Db').val();
                });

                //-----------------
                //handle Tr_Ty = 2 سند قبض شيك
                $('#Doc_Type').change(function(){
                    if($(this).val() == 2){
                        $('#cheq_data').removeClass('hidden');
                    }
                    else{
                        $('#cheq_data').addClass('hidden');
                        $('#Chq_no').val(null);
                        $('#Bnk_Nm').val(null);
                        $('#Issue_Dt').val(null);
                        $('#Due_Issue_Dt').val(null);
                        $('#Rcpt_By').val(null);
                    }
                });

                //حساب الضريبه
                var calcTax = function(){
                    var amount = $('#Tot_Amunt').val();
                    if($('#create_cache :checkbox[id=Taxp_Extra_check]').is(':checked')){
                        var tax = $('#Taxp_Extra').val();
                        if(tax !== null){
                            var total_amount = ((tax * amount) / 100);
                        }
                        else{
                            var total_amount = amount;
                        }
                        $('#Tr_Db').val(parseFloat(amount) + parseFloat(total_amount));
                    }
                    else{
                        $('#Tr_Db').val(parseFloat(amount));
                        $('#Taxv_Extra').val(parseFloat($('#Tr_Db').val()) - parseFloat($('#Tot_Amunt').val()));
                    }

                    $('#Taxv_Extra').val(parseFloat($('#Tr_Db').val()) - parseFloat($('#Tot_Amunt').val()));

                }

                //حفظ السند فى قاعدة البيانات
                $('#save').click(function(e){
                    e.preventDefault();
                    if($('#Tr_Dif').val() != 0){
                        alert('القيد غير متزن');
                    }
                    else{
                        catch_data = JSON.stringify(catch_data);
                        $.ajax({
                            url: "{{route('receiptCash.store')}}",
                            type: "post",
                            dataType: 'html',
                            data: {"_token": "{{ csrf_token() }}", catch_data},
                            success: function(data){
                                $('#alert').removeClass('hidden');
                                $('#alert').html(`<div class='alert alert-info'>تمت الاضافة بنجاح</div>`);
                                // $('#Cmp_No').val(null);
                                // $('#Dlv_Stor').val(null);
                                $('#Tr_No').val(null);
                                // $('#Doc_Type').val(1);
                                $('#Curncy_No').val(1);
                                $('#Curncy_Rate').val(null);
                                $('#Tot_Amunt').val(null);
                                $('#Taxp_Extra').val(null);
                                $('#Rcpt_By').val(null);
                                $('#Slm_No').val(null);
                                $('#Ac_Ty').val(null);
                                $('#Sysub_Account').val(null);
                                $('#Tr_Db').val(null);
                                $('#Dc_No').val(null);
                                $('#Tr_Ds').val(null);
                                $('#Tr_Ds1').val(null);
                                $('#Acc_No').val(null);
                                $('#Acc_No_Select').val(null);
                                $('#Dc_No_Db').val(null);
                                $('#Tr_Ds_Db').val(null);
                                $('#Slm_No_Name').val(null);
                                $('#Chq_no').val(null);
                                $('#Bnk_Nm').val(null);
                                $('#Issue_Dt').val(null);
                                $('#Due_Issue_Dt').val(null);
                                $('#Rcpt_By').val(null);
                                $('#Tr_Db_Db').val(null);
                                $('#Tr_Cr_Db').val(null);
                                $('#FTot_Amunt').val(null);
                                $('#Taxv_Extra').val(null);
                                $('#table_view').html(`<table class="table" id="table">
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
                                                </table>`);
                            }
                        });
                    }
                });


                //handle table lines click

                function tableText(tableCell, data) {
                    var Ln_No = tableCell.cells[0].innerHTML;
                    var updated_sum = parseFloat($('#Tr_Cr_Db').val()) - parseFloat(tableCell.cells[3].innerHTML);
                    old = updated_sum;
                    $('#Tr_Db_Db').val(updated_sum);
                    $('#Tr_Cr_Db').val(updated_sum);

                    for(var i = 0; i < data.length; i++){
                        if(data[i].Ln_No == Ln_No){
                            $('#Ln_No').val(data[i].Ln_No);
                            $('#Tr_No').val(data[i].Tr_No);
                            $('#Tr_Dt').val(data[i].Tr_Dt);
                            $('#Tr_DtAr').val(data[i].Tr_DtAr);
                            $('#Doc_Type').val(data[i].Doc_Type);
                            $('#Curncy_No').val(data[i].Curncy_No);
                            $('#Curncy_Rate').val(data[i].Curncy_Rate);
                            $('#Tot_Amunt').val(data[i].Tot_Amunt);
                            $('#Taxp_Extra').val(data[i].Taxp_Extra);
                            $('#Rcpt_By').val(data[i].Rcpt_By);
                            $('#Slm_No').val(data[i].Slm_No);
                            $('#Ac_Ty').val(data[i].Ac_Ty);
                            $('#Sysub_Account').val(data[i].Sysub_Account);
                            $('#Tr_Db').val(data[i].Tr_Db);
                            $('#Dc_No').val(data[i].Dc_No);
                            $('#Tr_Ds').val(data[i].Tr_Ds);
                            $('#Tr_Ds1').val(data[i].Tr_Ds1);
                            $('#Acc_No').val(data[i].Acc_No);
                            $('#Chq_no').val(data[i].Chq_no);
                            $('#Bnk_Nm').val(data[i].Bnk_Nm);
                            $('#Tr_Db_Acc_No').val(data[i].Tr_Db_Acc_No);
                            $('#Tr_Ds_Db').val(data[i].Tr_Ds_Db);
                            $('#main_acc').val(data[i].main_acc);
                            $('#Acc_No_Select').val(data[i].Acc_No_Select);
                            catch_data.splice(i, 1);
                            break;
                        }
                    }
                }


                //سعر الصرف حسب اختيار العمله
                $.ajax({
                    url: "{{route('getCurencyRate')}}",
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}", Curncy_No: $('#Curncy_No').children('option:selected').val() },
                    success: function(data){
                        $('#Curncy_Rate').val(data);
                    }
                });
                $(document).on('change', '#Curncy_No', function(){
                    $.ajax({
                        url: "{{route('getCurencyRate')}}",
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Curncy_No: $(this).val() },
                        success: function(data){
                            $('#Curncy_Rate').val(data);
                            if($('#FTot_Amunt').val() && $('#Curncy_Rate').val()){
                                $('#Tot_Amunt').val(parseFloat($('#Curncy_Rate').val()) * parseFloat($('#FTot_Amunt').val()));
                                calcTax();
                                $('#Tr_Db_Db').val(parseFloat(old) + parseFloat($('#Tr_Db').val()));
                                $('#Tr_Cr_Db').val(parseFloat(old) + parseFloat($('#Tr_Db').val()));
                                $('#Tr_Dif').val( $('#Tr_Db_Db').val() - $('#Tr_Cr_Db').val() );
                            }
                        }
                    });
                });

                //حسال اجمالى المبلغ المطلوب بالعمله الاجنبيه
                $('#FTot_Amunt').change(function(){
                    if($('#FTot_Amunt').val() != null && $('#Curncy_Rate').val() != null){
                        $('#Tot_Amunt').val(parseFloat($('#Curncy_Rate').val()) * parseFloat($('#FTot_Amunt').val()));
                        calcTax();
                        $('#Tr_Db_Db').val(parseFloat(old) + parseFloat($('#Tr_Db').val()));
                        $('#Tr_Cr_Db').val(parseFloat(old) + parseFloat($('#Tr_Db').val()));
                        $('#Tr_Dif').val( $('#Tr_Db_Db').val() - $('#Tr_Cr_Db').val() );
                    }
                });

                // Modal - ها تريد طباعة السند؟
                $('#myModal').on('shown.bs.modal', function () {
                    $('#myInput').trigger('focus')
                });

                $('#modal_no').click(function(){
                    location.reload();
                });

            });
        </script>

    @endpush
    <div class="hidden" id="alert"></div>
    <form action="{{route('receiptCash.store')}}" method="POST" id="create_cache">
        {{ csrf_field() }}
        <div style="display:flex; justify-content: flex-end; margin-bottom: 10px">
            <div>
                <button type="submit" class="btn btn-danger panel-A" id="save" data-toggle="modal" data-target="#saveChangesModal"><i class="fa fa-floppy-o"></i></button>
            </div>
        </div>
        <input hidden type="text" name="last_record" id="last_record" value='{{$last_record ? $last_record->Tr_No : null}}'>
        <div class="panel panel-primary panel-H">
            <div class="panel-heading panel-A">
                <div class="panel-title">
                    {{trans('admin.data_Cach')}}
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    {{-- الشركه --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Cmp_No">{{trans('admin.company')}}</label>
                            <select name="Cmp_No" id="Cmp_No" class="form-control">
                                @if(count($companies) > 0)
                                    @foreach($companies as $cmp)
                                        <option value="{{$cmp->Cmp_No}}" @if($last_record && $cmp->Cmp_No == $last_record->Cmp_No) selected @endif>{{$cmp->{'Cmp_Nm'.ucfirst(session('lang'))} }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    {{-- نهاية الشركه --}}
                    {{-- الفرع --}}
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Dlv_Stor">{{trans('admin.section')}}</label>
                            <select name="Dlv_Stor" id="Dlv_Stor" class="form-control">
                                <option value="{{null}}">{{trans('admin.select')}}</option>
                            </select>
                        </div>
                    </div>
                    {{-- نهاية الفرع --}}
                    {{-- رقم السند --}}
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Tr_No">{{trans('admin.number_of_receipt')}}</label>
                            <input type="text" name="Tr_No" id="Tr_No" value="" class="form-control" disabled>
                        </div>
                    </div>
                    {{-- نهاية رقم السند --}}
                    {{-- تاريخ القيد --}}
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
                    {{-- نهاية تاريخ القيد --}}
                    {{-- نوع السند نقدى \ شيك --}}
                    <div class="col-md-1">
                        <label for="Doc_Type">{{trans('admin.receipts_type')}}</label>
                        <select name="Doc_Type" id="Doc_Type" class="form-control">
                            @foreach(App\Enums\PayType::toSelectArray() as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- نهاية نوع السند نقدى \ شيك --}}
                </div>

                <div class="row">
                    {{-- العمله --}}
                    <div class="col-md-2">
                        <label for="Curncy_No">{{trans('admin.currency')}}</label>
                        <select name="Curncy_No" id="Curncy_No" class="form-control">
                            @foreach($crncy as $crn)
                                <option value="{{$crn->Curncy_No}}">{{$crn->{'Curncy_Nm'.ucfirst(session('lang'))} }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- نهاية العمله --}}
                    {{-- المبلغ بالعمله الاجنبيه --}}
                    <div class="col-md-1">
                        <label for="FTot_Amunt">{{trans('admin.Linv_Net')}}</label>
                        <input type="text" name="FTot_Amunt" id="FTot_Amunt" class="form-control">
                    </div>
                    {{-- نهاية المبلغ بالعمله الاجنبيه --}}
                    {{-- سعر الصرف --}}
                    <div class="col-md-1">
                        <label for="Curncy_Rate">{{trans('admin.exchange_rate')}}</label>
                        <input type="text" name="Curncy_Rate" id="Curncy_Rate" class="form-control">
                    </div>
                    {{-- نهاية سعر الصرف --}}
                    {{-- المبلغ المطلوب --}}
                    <div class="col-md-1">
                        <label for="Tot_Amunt">{{trans('admin.amount')}}</label>
                        <input type="text" name="Tot_Amunt" id="Tot_Amunt" class="form-control">
                    </div>
                    {{-- نهاية المبلغ المطلوب --}}
                    {{-- الضريبه --}}
                    <div class="col-md-1">
                        <input type="checkbox" id="Taxp_Extra_check">
                        <label for="Taxp_Extra">{{trans('admin.tax')}} %</label>
                        <input type="text" name="Taxp_Extra" id="Taxp_Extra" class="form-control" disabled>
                    </div>
                    {{-- نهاية الضريبه --}}
                    {{-- قيمة الضريبه --}}
                    <div class="col-md-1">
                        <label for="Taxv_Extra">{{trans('admin.Taxv_Extra')}}</label>
                        <input type="text" name="Taxv_Extra" id="Taxv_Extra" class="form-control">
                    </div>
                    {{-- نهاية قيمة الضريبه --}}
                    {{-- مقبوض بواسطة --}}
                    <div class="col-md-2">
                        <label for="Rcpt_By">{{trans('admin.Rcpt_By')}}</label>
                        <input type="text" name="Rcpt_By" id="Rcpt_By" class="form-control">
                    </div>
                    {{-- نهاية مقبوض بواسطة --}}
                    {{-- مندوب المبيعات --}}
                    <div class="col-md-2">
                        <label for="Slm_No_Name">{{trans('admin.sales_officer2')}}</label>
                        <select name="Slm_No_Name" id="Slm_No_Name" class="form-control">
                        </select>
                        {{-- <label for="Slm_No_Name">{{trans('admin.sales_officer2')}}</label>
                        <input type="text" name="Slm_No_Name" id="Slm_No_Name" class="form-control" disabled> --}}
                    </div>
                    <div class="col-md-1">
                        <label for=""></label>
                        <input type="text" name="Slm_No" id="Slm_No" class="form-control" disabled>
                        <br>
                    </div>
                    {{-- نهاية مندوب المبيعات --}}
                </div>
                {{-- بيانات الشيك فى سند قبض شيك --}}
                <div class="row hidden" id="cheq_data">
                    {{-- رقم الشيك --}}
                    <div class="col-md-2">
                        <label for="Chq_no">{{trans('admin.check_number')}}</label>
                        <input type="text" name="Chq_no" id="Chq_no" class="form-control">
                    </div>
                    {{-- نهاية رقم الشيك --}}
                    {{-- اسم البنك --}}
                    <div class="col-md-2">
                        <label for="Bnk_Nm">{{trans('admin.Bnk_Nm')}}</label>
                        <input type="text" id="Bnk_Nm" name="Bnk_Nm" class="form-control">
                    </div>
                    {{-- نهاية اسم البنك --}}
                    {{-- تاريخ استحقاق الشيك --}}
                    <div class="col-md-2">
                        <label for="Issue_Dt">{{trans('admin.Issue_Dt')}}</label>
                        <input type="text" name="Issue_Dt" id="Issue_Dt" class="form-control datepicker">
                    </div>
                    {{-- نهاية تاريخ استحقاق الشيك --}}
                    {{-- تاريخ استلام الشيك --}}
                    <div class="col-md-2">
                        <label for="Due_Issue_Dt">{{trans('admin.Due_Issue_Dt')}}</label>
                        <input type="text" name="Due_Issue_Dt" id="Due_Issue_Dt" class="form-control datepicker">
                    </div>
                    {{-- نهاية تاريخ استلام الشيك --}}
                </div>
                {{-- نهاية بيانات الشيك فى سند قبض شيك --}}
            </div>
        </div>
        {{-- نهاية بيانات اساسيه سند الصرف --}}

        <div class="row">
            <br>
            {{-- بيانات الحساب الدائن --}}
            <div class="col-md-6">
                <div class="panel panel-primary panel-H">
                    <div class="panel-heading panel-A ">
                        <div class="panel-title">
                            {{trans('admin.dept_account')}}
                        </div>
                    </div>
                    <div class="panel-body">
                        <input type="text" name="Ln_No" id="Ln_No" value="{{-1}}" hidden>
                        {{-- الحساب الرئيسى --}}
                        <div class="row">
                            <div class="col-md-8">
                                <label for="main_acc">{{trans('admin.main_account_chart')}}</label>
                                <input type="text" name="main_acc" id="main_acc" class="form-control" disabled>
                            </div>
                            <div class="col-md-4">
                                <label for="Acc_No"></label>
                                <input type="text" name="Acc_No" id="Acc_No" class="form-control" disabled>
                            </div>
                        </div>
                        {{-- نهاية الحساب الرئيسى --}}
                        {{-- نوع الحساب --}}
                        <div class="row">
                            {{-- نوع الحساب عملاء - موردين - موظفين - .... --}}
                            <div class="col-md-3">
                                <label for="Ac_Ty">{{trans('admin.account_type')}}</label>
                                <select name="Ac_Ty" id="Ac_Ty" class="form-control">
                                    <option value="{{null}}">{{trans('admin.select')}}</option>
                                    @foreach(\App\Enums\AccountType::toSelectArray() as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- رقم حساب العملاء - رقم حساب الموظفين - رقم حساب الموردين - .... --}}
                            <div style="margin-top: 7px" class="col-md-6">
                                <label for="Acc_No_Select"></label>
                                <select  name="Acc_No_Select" id="Acc_No_Select" class="form-control select2">
                                    <option class="form-control" value="{{null}}">{{trans('admin.select')}}</option>
                                </select>
                            </div>
                            {{-- رقم العميل - رقم المورد - رقم الموظف --}}
                            <div class="col-md-3">
                                <label for="Sysub_Account"></label>
                                <input type="text" name="Sysub_Account" id="Sysub_Account" class="form-control">
                            </div>
                        </div>
                        {{-- نهاية نوع الحساب --}}

                        <div class="row">
                            {{-- المبلغ دائن --}}
                            {{--                        //Tr_Db--}}
                            <div class="col-md-4">
                                <label for="Tr_Db">{{trans('admin.amount_db')}}</label>
                                <input type="text" name="Tr_Db" id="Tr_Db" class="form-control">
                            </div>
                            {{-- نهاية المبلغ دائن --}}
                            {{-- رقم المستند --}}
                            <div class="col-md-4">
                                <label for="Dc_No">{{trans('admin.receipt_number')}}</label>
                                <input type="text" name="Dc_No" id="Dc_No" class="form-control">
                            </div>
                            {{-- نهاية رقم المستند --}}
                            {{-- مركز التكلفه --}}
                            <div class="col-md-4 hidden" id="Costcntr_No_content">
                                <label for="Costcntr_No">{{trans('admin.with_cc')}}</label>
                                <select name="Costcntr_No" id="Costcntr_No" class="form-control select2">
                                    <option value="{{null}}">{{trans('admin.select')}}</option>
                                    @if(count($cost_center) > 0)
                                        @foreach($cost_center as $cc)
                                            <option value="{{$cc->Costcntr_No}}">{{ $cc->{'Costcntr_Nm'.session('lang')} }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            {{-- نهاية مركز التكلفه --}}
                        </div>
                        <div class="row">
                            {{-- البيان عربى --}}
                            <div class="col-md-12">
                                <br>
                                <label for="Tr_Ds" class="col-md-2">{{trans('admin.Statement_ar')}}</label>
                                <input type="text" name="Tr_Ds" id="Tr_Ds" class="form-control col-md-6">
                            </div>
                        </div>

                        {{-- نهاية البيان عربى --}}
                        <div class="row">
                            {{-- البيان انجليزى --}}
                            <div class="col-md-12">
                                <br>
                                <label for="Tr_Ds1" class="col-md-2">{{trans('admin.Statement_en')}}</label>
                                <input type="text" name="Tr_Ds1" id="Tr_Ds1" class="form-control col-md-6">
                                <button style="margin-right: 10px" class="btn btn-primary panel-A col-md-3" id="add_line">{{trans('admin.add_line')}}</button>
                            </div>
                            {{-- نهاية البيان انجليزى --}}
                            {{-- اضافة سطر --}}

                            {{-- نهاية اضافة سطر --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- نهاية بيانات الحساب الدائن --}}
            {{-- بيانات الحساب المدين --}}
            <div class="col-md-6">
                <div class="panel panel-primary panel-H">
                    <div class="panel-heading panel-A">
                        <div class="panel-title">
                            {{trans('admin.information_account')}}

                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            {{-- الصندوق الرئيسى --}}
                            <div class="col-md-6">
                                <label for="Tr_Db_Select">{{trans('admin.main_cache')}}</label>
                                <select name="Tr_Db_Select" id="Tr_Db_Select" class="form-control">
                                    @if(count($banks) > 0)
                                        @foreach($banks as $bnk)
                                            <option value="{{$bnk->Acc_No}}">{{$bnk->{'Acc_Nm'.ucfirst(session('lang'))} }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="Tr_Db_Acc_No"></label>
                                <input type="text" name="Tr_Db_Acc_No" id="Tr_Db_Acc_No" class="form-control">
                            </div>
                            {{-- بيانات الصندوق الرئيسى --}}
                            {{-- رقم المستند --}}
                            <div class="col-md-3">
                                <label for="">{{trans('admin.receipt_number')}}</label>
                                <input type="text" name="Dc_No_Db" id="Dc_No_Db" class="form-control">
                            </div>
                            {{-- نهاية رقم المستند --}}
                        </div>
                        {{-- البيان --}}
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <label for="Tr_Ds" class="col-md-2">{{trans('admin.note_ar')}}</label>
                                <input type="text" name="Tr_Ds_Db" id="Tr_Ds_Db" class="form-control col-md-10">
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
                                    <div class="col-md-3">
                                        <label for="Tr_Db_Db">{{trans('admin.Fbal_Db_')}}</label>
                                        <input type="text" name="Tr_Db_Db" id="Tr_Db_Db" class="form-control" value='0.00'>
                                    </div>
                                    {{-- نهاية مدين --}}
                                    {{-- دائن --}}
                                    <div class="col-md-3">
                                        <label for="Tr_Cr_Db">{{trans('admin.Fbal_CR_')}}</label>
                                        <input type="text" name="Tr_Cr_Db" id="Tr_Cr_Db" class="form-control" value='0.00'>
                                    </div>
                                    {{-- نهاية دائن --}}
                                    {{-- الفرق --}}
                                    <div class="col-md-3">
                                        <label for="Tr_Dif">{{trans('admin.subtract')}}</label>
                                        <input type="text" name="Tr_Dif" id="Tr_Dif" class="form-control" disabled>
                                    </div>
                                    {{-- نهاية الفرق --}}
                                    {{-- الرصيد الحالى --}}
                                    {{-- <div class="col-md-3">
                                        <label for="Crnt_Blnc">{{trans('admin.current_balance')}}</label>
                                        <input type="text" name="Crnt_Blnc" id="Crnt_Blnc" class="form-control">
                                    </div> --}}
                                    {{-- نهاية الرصيد الحالى --}}
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
            <div class="col-md-12" id="table_view">
                <table class="table" id="table">
                    <thead>
                    <th>{{trans('admin.Ln_No')}}</th>
                    <th>{{trans('admin.account_number')}}</th>
                    <th>{{trans('admin.account_name')}}</th>
                    <th>{{trans('admin.motion_debtor')}}</th>
                    <th>{{trans('admin.motion_creditor')}}</th>
                    <th>{{trans('admin.note_ar')}}</th>
                    <th>{{trans('admin.receipt_number')}}</th>
                    <th>{{trans('admin.note_en')}}</th>
                    </thead>
                </table>
            </div>
        </div>
    </form>


    {{-- Modal --}}
    <div class="modal fade" id="saveChangesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> --}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{trans('admin.close_ask')}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('admin.yes')}}</button>
                    <button type="button" class="btn btn-primary" id="modal_no">{{trans('admin.no')}}</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal end --}}
@endsection
