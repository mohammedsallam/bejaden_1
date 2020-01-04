{{--@extends('admin.index')--}}
{{--@section('title',trans('admin.create_limitations'))--}}
{{--@section('content')--}}

{{--    @push('js')--}}
{{--        <script>--}}
{{--            $(function () {--}}
{{--                'use strict'--}}
{{--                $('.e2').select2({--}}
{{--                    placeholder: "{{trans('admin.select')}}",--}}
{{--                    dir: '{{direction()}}'--}}
{{--                });--}}
{{--            });--}}

{{--        </script>--}}
{{--    @endpush--}}


{{--<limitations-component invoice="{{generateBarcodeNumber2()}}"></limitations-component>--}}
{{--<vue-progress-bar></vue-progress-bar>--}}



{{--@endsection--}}


@extends('admin.index')
@section('title',trans('admin.create_limitations'))
@section('content')
    @push('js')
        <script>
            $(document).ready(function(){
                $('#Acc_No_Select').select2({});
                $('#Costcntr_No').select2({});

                var catch_data = [];
                var old = 0;
                var Ln_No = 1;

                //get branches and salesmen of specific company selection
                $.ajax({
                    url: "{{route('branchForEdit')}}", //ReceiptCatchController
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}", Cmp_No: $('#Cmp_No').children('option:selected').val() },
                    success: function(data){
                        $('#Brn_No_content').html(data);
                    }
                });
                $.ajax({
                    url: "{{route('getCmpSalesMen')}}", //ReceiptCatchController
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}", Cmp_No: $('#Cmp_No').children('option:selected').val() },
                    success: function(data){
                        $('#Slm_No_Name').html(data);
                        $('#Slm_No').val($('#Slm_No_Name').children('option:selected').val());
                    }
                });

                $('#Slm_No_Name').change(function () {
                    $('#Slm_No').val($(this).val())
                });

                $(document).on('change', '#Cmp_No', function(){
                    $.ajax({
                        url: "{{route('branchForEdit')}}", // ReceiptCatchController
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Cmp_No: $(this).val() },
                        success: function(data){
                            $('#Brn_No_content').html(data);
                            $.ajax({
                                url: "{{route('createTrNo')}}", //ReceiptCatchController
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

                    {{--$.ajax({--}}
                    {{--    url: "{{route('getTaxValue')}}", //ReceiptCatchController--}}
                    {{--    type: "POST",--}}
                    {{--    dataType: 'html',--}}
                    {{--    data: {"_token": "{{ csrf_token() }}", Cmp_No: $(this).val() },--}}
                    {{--    success: function(data){--}}
                    {{--        $('#Taxp_Extra').val(data);--}}
                    {{--    }--}}
                    {{--});--}}

                    $.ajax({
                        url: "{{route('getCmpSalesMen')}}", //ReceiptCatchController
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
                $.ajax({
                    url: "{{route('createTrNo')}}", // ReceiptCatchController
                    type: "POST",
                    dataType: 'json',
                    data: {"_token": "{{ csrf_token() }}",
                        Brn_No: $('#Dlv_Stor').children('option:selected').val(),
                        Cmp_No: $('#Cmp_No').children('option:selected').val() },
                    success: function(data){
                        $('#Tr_No').val(data);
                    }
                });
                $(document).on('change', '#Dlv_Stor', function(){
                    var Cmp_No = $('#Cmp_No').children('option:selected').val();
                    $.ajax({
                        url: "{{route('createTrNo')}}", //ReceiptCatchController
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
                    url: "{{route('hijri')}}",
                    type: 'get',
                    data:{Hijri: Hijri},
                    dataType: 'json',
                    success: function (data) {
                        $('#Tr_DtAr').val(data);
                    }
                });

                $(document).on('change', '#Ac_Ty', function(){
                    var Cmp_No = $('#Cmp_No').children('option:selected').val();
                    var Brn_No = $('#Dlv_Stor').children('option:selected').val();
                    var Acc_Ty = $(this).val();

                    if (Acc_Ty === '2' || Acc_Ty === '3'){
                        $('.main_account_chart').removeClass('hidden');
                    } else {
                        $('.main_account_chart').addClass('hidden');
                    }

                    $('#main_acc').val('');
                    $('#Acc_No').val('');
                    $('#Sysub_Account').val('');

                    //get all leaf accounts when selecting account type (leaf acounts: customers / suppliers / employees...)
                    $.ajax({
                        url: "{{route('getSubAcc')}}", // ReceiptCatchController
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Brn_No: Brn_No, Cmp_No: Cmp_No, Acc_Ty: Acc_Ty},
                        success: function(data){
                            $('#Acc_No_Select').html(data);
                        }
                    });
                });

                $(document).on('change', '#Acc_No_Select', function(){
                    var Cmp_No = $('#Cmp_No').children('option:selected').val();
                    var Brn_No = $('#Dlv_Stor').children('option:selected').val();
                    var Acc_Ty = $('#Ac_Ty').children('option:selected').val();
                    var Acc_No = $(this).val();

                    if (Acc_No === 2 || Acc_No === 3){
                        $('.main_account_chart').removeClass('hidden')
                    }

                    //get parent account number on account select
                    $.ajax({
                        url: "{{route('getMainAccNo')}}", //ReceiptCatchController
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
                            url: "{{route('getSalesMan')}}", //ReceiptCatchController
                            type: "POST",
                            dataType: 'html',
                            data: {"_token": "{{ csrf_token() }}", Acc_No: Acc_No },
                            success: function(data){
                                $('#sales_man_content').html(data);
                            }
                        });
                    }
                });

                //add tax
                $('#create_cache :checkbox[id=Taxp_Extra_check]').change(function(){
                    if($(this).is(':checked')){
                        // $('#Taxp_Extra').removeAttr('disabled');
                        // calcTax();
                    }
                    else{
                        // $('#Taxp_Extra').attr('disabled','disabled');
                        $('#Tr_Cr').val($('#Tot_Amunt').val());
                        // $('#Taxv_Extra').val(parseFloat($('#Tr_Cr').val()) - parseFloat($('#Tot_Amunt').val()));
                    }

                    $('#Tr_Db_Db').val(parseFloat(old) + parseFloat($('#Tr_Cr').val()));
                    $('#Tr_Cr_Db').val(parseFloat(old) + parseFloat($('#Tr_Cr').val()));
                    $('#Tr_Dif').val( $('#Tr_Db_Db').val() - $('#Tr_Cr_Db').val() );
                });

                $('#Tot_Amunt').change(function(){
                    calcTax();
                    $('#Tr_Db_Db').val(parseFloat(old) + parseFloat($('#Tr_Cr').val()));
                    $('#Tr_Cr_Db').val(parseFloat(old) + parseFloat($('#Tr_Cr').val()));
                    $('#Tr_Dif').val( $('#Tr_Db_Db').val() - $('#Tr_Cr_Db').val() );
                });

                // $('#Taxp_Extra').change(function(){
                //     calcTax();
                //
                //     $('#Tr_Db_Db').val(parseFloat(old) + parseFloat($('#Tr_Cr').val()));
                //     $('#Tr_Cr_Db').val(parseFloat(old) + parseFloat($('#Tr_Cr').val()));
                //     $('#Tr_Dif').val( $('#Tr_Db_Db').val() - $('#Tr_Cr_Db').val() );
                // });

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
                    if($('#Ln_No').val() == -1){
                        Ln_No = Ln_No + 1;
                        $('#Ln_No').val(Ln_No);
                    }

                    $.ajax({
                        url: "{{route('validateCache')}}", // ReceiptCatchController
                        type: "post",
                        dataType: 'html',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            Brn_No: $('#Dlv_Stor').children('option:selected').val(),
                            Cmp_No: $('#Cmp_No').children('option:selected').val(),
                            Tr_No: $('#Tr_No').val(),
                            Tr_Dt: $('#Tr_Dt').val(),
                            Tr_DtAr: $('#Tr_DtAr').val(),
                            // Doc_Type: $('#Doc_Type').children('option:selected').val(),
                            Curncy_No: $('#Curncy_No').children('option:selected').val(),
                            Curncy_Rate: $('#Curncy_Rate').val(),
                            Tot_Amunt: $('#Tot_Amunt').val(),
                            // Taxp_Extra: $('#Taxp_Extra').val(),
                            Rcpt_By: $('#Rcpt_By').val(),
                            Slm_No: $('#Slm_No').val(),
                            Ac_Ty: $('#Ac_Ty').children('option:selected').val(),
                            Sysub_Account: $('#Sysub_Account').val(),
                            Tr_Cr: $('#Tr_Cr').val(),
                            Dc_No: $('#Dc_No').val(),
                            Tr_Ds: $('#Tr_Ds').val(),
                            Tr_Ds1: $('#Tr_Ds1').val(),
                            Acc_No: $('#Acc_No').val(),
                            last_record : $('#last_record').val(),
                            // Chq_no: $('#Chq_no').val(),
                            // Bnk_Nm: $('#Bnk_Nm').val(),
                            // Issue_Dt: $('#Issue_Dt').val(),
                            // Due_Issue_Dt: $('#Due_Issue_Dt').val(),
                            Rcpt_By: $('#Rcpt_By').val(),
                            Tr_Db_Acc_No: $('#Tr_Db_Acc_No').val(),
                            Tr_Db_Db: $('#Tr_Db_Db').val(),
                            Tr_Cr_Db: $('#Tr_Cr_Db').val(),
                            Ln_No: $('#Ln_No').val(),
                            Tr_Ds_Db: $('#Tr_Ds_Db').val(),
                            FTot_Amunt: $('#FTot_Amunt').val(),
                            // Taxv_Extra: $('#Taxv_Extra').val(),
                            },

                        success: function(data){
                            var response = JSON.parse(data);
                            if(response.success == true){
                                $('#table').append(`
                                <tr class='tr'>
                                    <td>`+$('#Ln_No').val()+`</td>
                                    <td>`+$('#Sysub_Account').val()+`</td>
                                    <td>`+$('#Acc_No_Select option:selected').html()+`</td>
                                    <td>0.00</td>
                                    <td>`+$('#Tr_Cr').val()+`</td>
                                    <td>`+$('#Tr_Ds').val()+`</td>
                                    <td>`+$('#Dc_No').val()+`</td>
                                    <td>`+$('#Tr_Ds1').val()+`</td>
                                </tr>`);

                                var rows = document.getElementById('table').rows;
                                var sum = 0.0;
                                for (var i=1; i<rows.length; i++){
                                    if(rows[i].cells.length > 0){
                                        sum += parseFloat(rows[i].cells[4].innerHTML);
                                        console.log(sum);
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
                                    // Doc_Type: $('#Doc_Type').children('option:selected').val(),
                                    Curncy_No: $('#Curncy_No').children('option:selected').val(),
                                    Curncy_Rate: $('#Curncy_Rate').val(),
                                    Tot_Amunt: $('#Tot_Amunt').val(),
                                    // Taxp_Extra: $('#Taxp_Extra').val(),
                                    Rcpt_By: $('#Rcpt_By').val(),
                                    Slm_No: $('#Slm_No').val(),
                                    Ac_Ty: $('#Ac_Ty').children('option:selected').val(),
                                    Sysub_Account: $('#Sysub_Account').val(),
                                    Tr_Cr: $('#Tr_Cr').val(),
                                    Dc_No: $('#Dc_No').val(),
                                    Tr_Ds: $('#Tr_Ds').val(),
                                    Tr_Ds1: $('#Tr_Ds1').val(),
                                    Acc_No: $('#Acc_No').val(),
                                    last_record : $('#last_record').val(),
                                    // Chq_no: $('#Chq_no').val(),
                                    // Bnk_Nm: $('#Bnk_Nm').val(),
                                    // Issue_Dt: $('#Issue_Dt').val(),
                                    // Due_Issue_Dt: $('#Due_Issue_Dt').val(),
                                    Rcpt_By: $('#Rcpt_By').val(),
                                    Tr_Db_Acc_No: $('#Tr_Db_Acc_No').val(),
                                    Tr_Db_Db: $('#Tr_Db_Db').val(),
                                    Tr_Cr_Db: $('#Tr_Cr_Db').val(),
                                    Ln_No: $('#Ln_No').val(),
                                    Tr_Ds_Db: $('#Tr_Ds_Db').val(),
                                    main_acc: $('#main_acc').val(),
                                    FTot_Amunt: $('#FTot_Amunt').val(),
                                    // Taxv_Extra: $('#Taxv_Extra').val(),
                                };

                                catch_data.push(item);

                                // $('#Cmp_No').val(null);
                                // $('#Dlv_Stor').val(null);
                                // $('#Tr_No').val(null);
                                // $('#Doc_Type').val(1);
                                $('#Curncy_No').val(1);
                                $('#Curncy_Rate').val(null);
                                $('#Tot_Amunt').val(null);
                                // $('#Taxp_Extra').val(null);
                                $('#main_acc').val(null);
                                $('#Rcpt_By').val(null);
                                $('#Slm_No').val(null);
                                $('#Ac_Ty').val(null);
                                $('#Sysub_Account').val(null);
                                $('#Tr_Cr').val(null);
                                $('#Dc_No').val(null);
                                $('#Tr_Ds').val(null);
                                $('#Tr_Ds1').val(null);
                                $('#Acc_No').val(null);
                                $('#Acc_No_Select').val(null);
                                // $('#Acc_No_Select option:eq(0)').attr('selected','selected');
                                $('#Dc_No_Db').val(null);
                                $('#Tr_Ds_Db').val(null);
                                $('#Slm_No_Name').val(null);
                                // $('#Chq_no').val(null);
                                // $('#Bnk_Nm').val(null);
                                // $('#Issue_Dt').val(null);
                                // $('#Due_Issue_Dt').val(null);
                                $('#Rcpt_By').val(null);
                                // $('#Tr_Db_Db').val(null);
                                // $('#Tr_Cr_Db').val(null);
                                $('#Ln_No').val(-1);
                                $('#FTot_Amunt').val(null)
                                // $('#Taxv_Extra').val(null)

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

                //حساب الضريبه
                var calcTax = function(){
                    var amount = $('#Tot_Amunt').val();
                    if($('#create_cache :checkbox[id=Taxp_Extra_check]').is(':checked')){
                        // var tax = $('#Taxp_Extra').val();
                        if(tax !== null){
                            // var total_amount = ((tax * amount) / 100);
                        }
                        else{
                            var total_amount = amount;
                        }
                        $('#Tr_Cr').val(parseFloat(amount) + parseFloat(total_amount));
                    }
                    else{
                        $('#Tr_Cr').val(parseFloat(amount));
                        // $('#Taxv_Extra').val(parseFloat($('#Tr_Cr').val()) - parseFloat($('#Tot_Amunt').val()));
                    }

                    // $('#Taxv_Extra').val(parseFloat($('#Tr_Cr').val()) - parseFloat($('#Tot_Amunt').val()));

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
                            url: "{{route('rcatchs.store')}}",
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
                                // $('#Taxp_Extra').val(null);
                                $('#Rcpt_By').val(null);
                                $('#Slm_No').val(null);
                                $('#Ac_Ty').val(null);
                                $('#Sysub_Account').val(null);
                                $('#Tr_Cr').val(null);
                                $('#Dc_No').val(null);
                                $('#Tr_Ds').val(null);
                                $('#Tr_Ds1').val(null);
                                $('#Acc_No').val(null);
                                $('#Acc_No_Select').val(null);
                                $('#Dc_No_Db').val(null);
                                $('#Tr_Ds_Db').val(null);
                                $('#Slm_No_Name').val(null);
                                // $('#Chq_no').val(null);
                                // $('#Bnk_Nm').val(null);
                                // $('#Issue_Dt').val(null);
                                // $('#Due_Issue_Dt').val(null);
                                $('#Rcpt_By').val(null);
                                $('#Tr_Db_Db').val(null);
                                $('#Tr_Cr_Db').val(null);
                                $('#FTot_Amunt').val(null);
                                // $('#Taxv_Extra').val(null);
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

                function tableText(tableCell, data) {
                    var Ln_No = tableCell.cells[0].innerHTML;
                    var updated_sum = parseFloat($('#Tr_Db_Db').val()) - parseFloat(tableCell.cells[4].innerHTML);
                    old = updated_sum;
                    $('#Tr_Db_Db').val(updated_sum);
                    $('#Tr_Cr_Db').val(updated_sum);

                    for(var i = 0; i < data.length; i++){
                        if(data[i].Ln_No == Ln_No){
                            $('#Ln_No').val(data[i].Ln_No);
                            $('#Tr_No').val(data[i].Tr_No);
                            $('#Tr_Dt').val(data[i].Tr_Dt);
                            $('#Tr_DtAr').val(data[i].Tr_DtAr);
                            // $('#Doc_Type').val(data[i].Doc_Type);
                            $('#Curncy_No').val(data[i].Curncy_No);
                            $('#Curncy_Rate').val(data[i].Curncy_Rate);
                            $('#Tot_Amunt').val(data[i].Tot_Amunt);
                            // $('#Taxp_Extra').val(data[i].Taxp_Extra);
                            $('#Rcpt_By').val(data[i].Rcpt_By);
                            $('#Slm_No').val(data[i].Slm_No);
                            $('#Ac_Ty').val(data[i].Ac_Ty);
                            $('#Sysub_Account').val(data[i].Sysub_Account);
                            $('#Tr_Cr').val(data[i].Tr_Cr);
                            $('#Dc_No').val(data[i].Dc_No);
                            $('#Tr_Ds').val(data[i].Tr_Ds);
                            $('#Tr_Ds1').val(data[i].Tr_Ds1);
                            $('#Acc_No').val(data[i].Acc_No);
                            // $('#Chq_no').val(data[i].Chq_no);
                            $('#Bnk_Nm').val(data[i].Bnk_Nm);
                            $('#Tr_Db_Acc_No').val(data[i].Tr_Db_Acc_No);
                            $('#Ln_No').val(data[i].Ln_No);
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
                    url: "{{route('getCurencyRate')}}", //ReceiptCatchController
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}", Curncy_No: $('#Curncy_No').children('option:selected').val() },
                    success: function(data){
                        $('#Curncy_Rate').val(data);
                    }
                });
                $(document).on('change', '#Curncy_No', function(){
                    $.ajax({
                        url: "{{route('getCurencyRate')}}", // ReceiptCatchController
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Curncy_No: $(this).val() },
                        success: function(data){
                            $('#Curncy_Rate').val(data);
                            if($('#FTot_Amunt').val() != null && $('#Curncy_Rate').val() != null){
                                $('#Tot_Amunt').val(parseFloat($('#Curncy_Rate').val()) * parseFloat($('#FTot_Amunt').val()));
                                calcTax();
                                $('#Tr_Db_Db').val(parseFloat(old) + parseFloat($('#Tr_Cr').val()));
                                $('#Tr_Cr_Db').val(parseFloat(old) + parseFloat($('#Tr_Cr').val()));
                                $('#Tr_Dif').val( $('#Tr_Db_Db').val() - $('#Tr_Cr_Db').val() );
                            }
                        }
                    });
                });

                $('#FTot_Amunt, #Curncy_Rate').change(function(){
                    if($('#FTot_Amunt').val() != null && $('#Curncy_Rate').val() != null){
                        $('#Tot_Amunt').val(parseFloat($('#Curncy_Rate').val()) * parseFloat($('#FTot_Amunt').val()));
                        calcTax();
                        $('#Tr_Db_Db').val(parseFloat(old) + parseFloat($('#Tr_Cr').val()));
                        $('#Tr_Cr_Db').val(parseFloat(old) + parseFloat($('#Tr_Cr').val()));
                        $('#Tr_Dif').val( $('#Tr_Db_Db').val() - $('#Tr_Cr_Db').val() );
                    }
                });

                $('#Tr_Db, #Tr_Cr').change(function () {
                    if ($(this).val() !== ''){
                        $(''+$(this).data("db-cr")+'').attr('readonly', 'readonly');
                    } else {
                        $(''+$(this).data("db-cr")+'').removeAttr('readonly');
                    }
                })

            });
        </script>
    @endpush

    @push('css')

        <style>
            .select2-container .select2-selection--single{
                height: 34px !important;
            }
        </style>

    @endpush
    <div class="row">
        <div class="col-md-12">
            <div class="" style="display: flex; justify-content: flex-end; margin-bottom: 10px">
                <button type="submit" class="btn btn-success" id="save"><i class="fa fa-floppy-o"></i></button>
            </div>
        </div>
    </div>

    <div class="hidden" id="alert"></div>
    <form action="{{route('rcatchs.store')}}" method="POST" id="create_cache">
        {{ csrf_field() }}

        <input hidden type="text" name="last_record" id="last_record" value='{{$last_record ? $last_record->Tr_No : null}}'>
        {{-- بيانات اساسيه سند قبض --}}
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">
                    {{trans('admin.create_limitations')}}
                </div>
            </div>
            <div class="panel-body">
                    {{-- الشركه --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Cmp_No">{{trans('admin.company')}}</label>
                            <select name="Cmp_No" id="Cmp_No" class="form-control">
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Dlv_Stor">{{trans('admin.section')}}</label>
                            <div id="Brn_No_content">
                                <select name="Dlv_Stor" id="Dlv_Stor" class="form-control">
                                    <option value="{{null}}">{{trans('admin.select')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- نهاية الفرع --}}

                    {{-- نوع القيد --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Jr_Ty">{{trans('admin.Jr_Ty')}}</label>
                            <input type="text" name="Jr_Ty" id="Jr_Ty" value="" class="form-control" disabled>
                        </div>
                    </div>
                    {{-- نهاية نوع القيد --}}

                    {{-- رقم القيد --}}
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Tr_No">{{trans('admin.Tr_No')}}</label>
                            <input type="text" name="Tr_No" id="Tr_No" value="" class="form-control" disabled>
                        </div>
                    </div>
                    {{-- نهاية رقم القيد --}}

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

                    {{-- العمله --}}
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Curncy_No">{{trans('admin.currency')}}</label>
                            <select name="Curncy_No" id="Curncy_No" class="form-control">
                                @foreach($crncy as $crn)
                                    <option value="{{$crn->Curncy_No}}">{{$crn->{'Curncy_Nm'.ucfirst(session('lang'))} }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- نهاية العمله --}}
                    {{-- المبلغ بالعمله الاجنبيه --}}
                    <div class="col-md-2">
                       <div class="form-group">
                           <label for="FTot_Amunt">{{trans('admin.Linv_Net')}}</label>
                           <input type="text" name="FTot_Amunt" id="FTot_Amunt" class="form-control">
                       </div>
                    </div>
                    {{-- نهاية المبلغ بالعمله الاجنبيه --}}
                    {{-- سعر الصرف --}}
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Curncy_Rate">{{trans('admin.exchange_rate')}}</label>
                            <input type="text" name="Curncy_Rate" id="Curncy_Rate" class="form-control">
                        </div>
                    </div>
                    {{-- نهاية سعر الصرف --}}
                    {{-- المبلغ المطلوب --}}
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Tot_Amunt">{{trans('admin.amount')}}</label>
                            <input type="text" name="Tot_Amunt" id="Tot_Amunt" class="form-control">
                        </div>
                    </div>
                    {{-- نهاية المبلغ المطلوب --}}
                    {{-- مندوب المبيعات --}}
                    <div id="sales_man_content">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="Slm_No_Name">{{trans('admin.sales_officer2')}}</label>
                                <select name="Slm_No_Name" id="Slm_No_Name" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="Slm_No">{{trans('admin.Slm_No')}}</label>
                                <input type="text" name="Slm_No" id="Slm_No" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    {{-- نهاية مندوب المبيعات --}}

                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <input type="text" name="Ln_No" id="Ln_No" value="{{-1}}" hidden>
                                {{-- الحساب الرئيسى --}}
                                <div class="row main_account_chart hidden">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="main_acc">{{trans('admin.main_account_chart')}}</label>
                                            <input type="text" name="main_acc" id="main_acc" class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="Acc_No">{{trans('admin.Acc_No')}}</label>
                                            <input type="text" name="Acc_No" id="Acc_No" class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>
                                {{-- نهاية الحساب الرئيسى --}}
                                {{-- نوع الحساب --}}
                                {{-- نوع الحساب عملاء - موردين - موظفين - .... --}}
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="Ac_Ty">{{trans('admin.account_type')}}</label>
                                        <select name="Ac_Ty" id="Ac_Ty" class="form-control">
                                            <option value="{{null}}">{{trans('admin.select')}}</option>
                                            @foreach(\App\Enums\AccountType::toSelectArray() as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- رقم حساب العملاء - رقم حساب الموظفين - رقم حساب الموردين - .... --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Acc_No_Select">{{trans('admin.account_name')}}</label>
                                        <select name="Acc_No_Select" id="Acc_No_Select" class="form-control select2">
                                            <option value="{{null}}">{{trans('admin.select')}}</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- رقم العميل - رقم المورد - رقم الموظف --}}
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="Sysub_Account">{{trans('admin.account_number')}}</label>
                                        <input type="text" name="Sysub_Account" id="Sysub_Account" class="form-control">
                                    </div>
                                </div>
                                {{-- نهاية نوع الحساب --}}

                                {{-- المبلغ مدين --}}
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="Tr_Db">{{trans('admin.amount_db')}}</label>
                                        <input data-db-cr="#Tr_Cr" type="text" name="Tr_Db" id="Tr_Db" class="form-control">
                                    </div>
                                </div>
                                {{-- نهاية المبلغ مدين --}}
                                {{-- المبلغ دائن --}}
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="Tr_Cr">{{trans('admin.amount_cr')}}</label>
                                        <input data-db-cr="#Tr_Db" type="text" name="Tr_Cr" id="Tr_Cr" class="form-control">
                                    </div>
                                </div>
                                {{-- نهاية المبلغ دائن --}}

                                {{-- رقم المستند --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Dc_No">{{trans('admin.receipt_number')}}</label>
                                        <input type="text" name="Dc_No" id="Dc_No" class="form-control">
                                    </div>
                                </div>
                                {{-- نهاية رقم المستند --}}

                                {{-- مركز التكلفه --}}
                                <div class="col-md-6" id="Costcntr_No_content">
                                    <div class="form-group">
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
                                </div>
                                {{-- نهاية مركز التكلفه --}}

                                {{-- البيان عربى --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Tr_Ds">{{trans('admin.Statement_ar')}}</label>
                                        <input type="text" name="Tr_Ds" id="Tr_Ds" class="form-control">
                                    </div>
                                </div>
                                {{-- نهاية البيان عربى --}}
                                {{-- البيان انجليزى --}}
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Tr_Ds1">{{trans('admin.Statement_en')}}</label>
                                        <input type="text" name="Tr_Ds1" id="Tr_Ds1" class="form-control">
                                    </div>
                                </div>
                               <div class="col-md-12">
                                   <div class="" style="display: flex; justify-content: space-between">
                                       <input id="add_line" type="submit" class="btn btn-primary" value="{{trans('admin.add_line')}}">
                                   </div>
                               </div>
                                {{-- نهاية البيان انجليزى --}}
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        {{-- نهاية بيانات اساسيه سند قبض --}}

        <div class="row">
            <div class="col-md-12" id="table_view">
                <table class="table" id="table" style="cursor: pointer;">
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
@endsection
