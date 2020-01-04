@extends('admin.index')
@section('title',trans('admin.create_Notice_creditor'))
@section('content')

    @push('css')
        <style>
            .panel-H{
                border-color: #26333a !important;
            }
            .panel-A {
                background-color: #26333a !important;
                border-color: #26333a !important;
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

                //get branches of specific company selection
                $(document).on('change', '#Cmp_No', function(){
                    $.ajax({
                        url: "{{route('branchForEditN')}}",
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Cmp_No: $(this).val() },
                        success: function(data){
                            $('#Brn_No_content').html(data);
                        }
                    });

                    $.ajax({
                        url: "{{route('getTaxValueN')}}",
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Cmp_No: $(this).val() },
                        success: function(data){
                            $('#Tr_TaxVal').val(data);
                        }
                    });
                });

                //get salesmen of specific branch selection
                $(document).on('change', '#Dlv_Stor', function(){
                    var Cmp_No = $('#Cmp_No').children('option:selected').val();
                    $.ajax({
                        url: "{{route('createTrNoN')}}",
                        type: "POST",
                        dataType: 'json',
                        data: {"_token": "{{ csrf_token() }}", Brn_No: $(this).val(), Cmp_No: Cmp_No },
                        success: function(data){
                            $('#Tr_No').val(data);
                        }
                    });
                })

                // convert Tr_Dt ro hijry
                let Hijri = $('input#Tr_Dt').val();
                $.ajax({
                    url: "{{route('hijriNoti')}}",
                    type: 'get',
                    data:{Hijri: Hijri},
                    dataType: 'json',
                    success: function (data) {
                        $('#Tr_DtAr').val(data);
                    }
                });

                /**********************************************************************
                 // section 1
                 **********************************************************************/

                $(document).on('change', '.Ac_Ty', function(){
                    var Cmp_No = $('#Cmp_No').children('option:selected').val();
                    var Brn_No = $('#Dlv_Stor').children('option:selected').val();
                    var Acc_Ty = $(this).val();

                    //get all leaf accounts when selecting account type (leaf acounts: customers / suppliers / employees...)
                    $.ajax({
                        url: "{{route('getSubAccN')}}",
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Brn_No: Brn_No, Cmp_No: Cmp_No, Acc_Ty: Acc_Ty},
                        success: function(data){
                            $('.Acc_No_Select').html(data);
                        }
                    });
                });

                $(document).on('change', '.Acc_No_Select', function(){
                    var Cmp_No = $('#Cmp_No').children('option:selected').val();
                    var Brn_No = $('#Dlv_Stor').children('option:selected').val();
                    var Acc_Ty = $('.Ac_Ty').children('option:selected').val();
                    var Acc_No = $(this).val();
                    var Jr_Ty  = $('#Jr_Ty').val();

                    //get parent account number on account select
                    $.ajax({
                        url: "{{route('getMainAccNoN')}}",
                        type: "POST",
                        dataType: 'json',
                        data: {"_token": "{{ csrf_token() }}", Jr_Ty:Jr_Ty, Brn_No: Brn_No, Cmp_No: Cmp_No, Acc_Ty: Acc_Ty, Acc_No: Acc_No },
                        success: function(data) {
                            $('.Sysub_Account').each(function () {
                                $(this).val($('.Acc_No_Select').val())
                            });
                            $('.Acc_No').each(function () {
                                $(this).val(data.mainAccNo.acc_no);
                            });
                            $('.main_acc').each(function () {
                                $(this).val(data.mainAccNm.acc_name);
                            });

                            if (data.AccNm && data.AccNm.cc_flag && data.AccNm.cc_no) {
                                $('#Costcntr_No_content').removeClass('hidden');
                            } else {
                                $('#Costcntr_No_content').addClass('hidden');
                                $('#Costcntr_No').val(null);
                            }


                        }
                    });

                    //get salesman in case Acc_Ty == 2 (customers)
                    if(Acc_Ty == 2){
                        $.ajax({
                            url: "{{route('getSalesManN')}}",
                            type: "POST",
                            dataType: 'html',
                            data: {"_token": "{{ csrf_token() }}", Acc_No: Acc_No },
                            success: function(data){
                                $('#sales_man_content').html(data);
                            }
                        });
                    }
                });


                /**********************************************************************
                 // section 2
                 **********************************************************************/

                $(document).on('change', '.Ac_Ty1', function(){
                    var Cmp_No = $('#Cmp_No').children('option:selected').val();
                    var Brn_No = $('#Dlv_Stor').children('option:selected').val();
                    var Acc_Ty = $(this).val();

                    //get all leaf accounts when selecting account type (leaf acounts: customers / suppliers / employees...)
                    $.ajax({
                        url: "{{route('getSubAccN')}}",
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Brn_No: Brn_No, Cmp_No: Cmp_No, Acc_Ty: Acc_Ty},
                        success: function(data){
                            $('.Acc_No_Select1').html(data);
                        }
                    });
                });

                $(document).on('change', '.Acc_No_Select1', function(){
                    var Cmp_No = $('#Cmp_No').children('option:selected').val();
                    var Brn_No = $('#Dlv_Stor').children('option:selected').val();
                    var Acc_Ty = $('.Ac_Ty1').children('option:selected').val();
                    var Acc_No = $(this).val();
                    var Jr_Ty  = $('#Jr_Ty').val();

                    //get parent account number on account select
                    $.ajax({
                        url: "{{route('getMainAccNoN')}}",
                        type: "POST",
                        dataType: 'json',
                        data: {"_token": "{{ csrf_token() }}", Brn_No: Brn_No, Cmp_No: Cmp_No, Acc_Ty: Acc_Ty, Acc_No: Acc_No },
                        success: function(data) {
                            $('.Sysub_Account1').each(function () {
                                $(this).val($('.Acc_No_Select1').val())
                            });
                            $('.Acc_No1').each(function () {
                                $(this).val(data.mainAccNo.acc_no);
                            });
                            $('.main_acc1').each(function () {
                                $(this).val(data.mainAccNm.acc_name);
                            });

                            if (data.AccNm && data.AccNm.cc_flag && data.AccNm.cc_no) {
                                $('#Costcntr_No_content').removeClass('hidden');
                            } else {
                                $('#Costcntr_No_content').addClass('hidden');
                                $('#Costcntr_No').val(null);
                            }


                        }
                    });

                    //get salesman in case Acc_Ty == 2 (customers)
                    if(Acc_Ty == 2){
                        $.ajax({
                            url: "{{route('getSalesManN')}}",
                            type: "POST",
                            dataType: 'html',
                            data: {"_token": "{{ csrf_token() }}", Acc_No: Acc_No },
                            success: function(data){
                                $('#sales_man_content').html(data);
                            }
                        });
                    }
                });

//////////////////////////////

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
                        calcTax();
                    }
                    else{

                        var Jr_Ty = $('#Jr_Ty').val();

                        if ( Jr_Ty == 18){
                            $('#Tr_TaxVal').attr('disabled','disabled');
                            $('.Tr_Db').val($('#Tot_Amunt').val());
                        }else if(Jr_Ty == 19){
                            $('#Tr_TaxVal').attr('disabled','disabled');
                            $('.Tr_Cr').val($('#Tot_Amunt').val());
                        }



                    }

                    var Jr_Ty = $('#Jr_Ty').val();

                    if ( Jr_Ty == 18) {

                        $('.Tr_Db_Dbb').val(parseFloat(old) + parseFloat($('.Tr_Cr').val()) + parseFloat($('.Tr_Db').val()));
                        $('.Tr_Cr_Dbb').val(parseFloat(old) + parseFloat($('.Tr_Cr').val()) + parseFloat($('.Tr_Db').val()));
                        $('.Tr_Diff').val($('.Tr_Db_Dbb').val() - $('.Tr_Cr_Dbb').val());
                    }else if(Jr_Ty == 19){
                        $('.Tr_Db_Db').val(parseFloat(old) + parseFloat($('.Tr_Cr').val()) + parseFloat($('.Tr_Db').val()));
                        $('.Tr_Cr_Db').val(parseFloat(old) + parseFloat($('.Tr_Cr').val()) + parseFloat($('.Tr_Db').val()));
                        $('.Tr_Dif').val($('.Tr_Db_Db').val() - $('.Tr_Cr_Db').val());
                    }
                });

                //دائن
                $('#Tot_Amunt').change(function(){
                    calcTax();
                    var Jr_Ty = $('#Jr_Ty').val();
                    if ( Jr_Ty == 18){
                        $('.Tr_Db_Dbb').each(function () {
                            $(this).val(parseFloat(old) + parseFloat($('.Tr_Db').val()));
                        });
                        $('.Tr_Cr_Dbb').each(function () {
                            $(this).val(parseFloat(old) + parseFloat($('.Tr_Db').val()))
                        });
                        $('.Tr_Diff').each(function () {
                            $(this).val( $('.Tr_Db_Dbb').val() - $('.Tr_Cr_Dbb').val() );
                        });
                    }else if(Jr_Ty == 19){

                        $('.Tr_Db_Db').each(function () {
                            $(this).val(parseFloat(old) + parseFloat($('.Tr_Cr').val()));
                        });
                        $('.Tr_Cr_Db').each(function () {
                            $(this).val(parseFloat(old) + parseFloat($('.Tr_Cr').val()))
                        });
                        $('.Tr_Dif').each(function () {
                            $(this).val( $('.Tr_Db_Db').val() - $('.Tr_Cr_Db').val() );
                        });
                    }

                });




                //دائن
                $('#Tr_TaxVal').change(function(){
                    calcTax();

                    $('.Tr_Db_Db').each(function () {
                        $(this).val(parseFloat(old) + parseFloat($('.Tr_Cr').val()))
                    });
                    $('.Tr_Cr_Db').each(function () {
                        $(this).val(parseFloat(old) + parseFloat($('.Tr_Cr').val()))
                    });
                    $('.Tr_Dif').val( $('.Tr_Db_Db').val() - $('.Tr_Cr_Db').val() );
                });

                //مدين
                $('#Tr_TaxVal').change(function(){
                    calcTax();

                    $('.Tr_Db_Dbb').each(function () {
                        $(this).val(parseFloat(old) + parseFloat($('.Tr_Cr').val()))
                    });
                    $('.Tr_Cr_Dbb').each(function () {
                        $(this).val(parseFloat(old) + parseFloat($('.Tr_Cr').val()))
                    });
                    $('.Tr_Diff').val( $('.Tr_Db_Dbb').val() - $('.Tr_Cr_Dbb').val() );
                });

                var Jr_Ty = $('#Jr_Ty').val();


                $(document).on('change', '.Dc_No', function () {
                    $('.Dc_No_Db').each(function () {
                        $(this).val($('.Dc_No').val());
                    });
                });


                //مدين
                $(document).on('change', '.Dc_No_Dbb', function () {
                    $('.Dc_Nob').each(function () {
                        $(this).val($('.Dc_No_Dbb').val());
                    });
                });

                //دائن
                $('.Tr_Ds').change(function(){
                    $('.Tr_Ds_Db').each(function () {
                        $(this).val($('.Tr_Ds').val());
                    });
                });

                //مدين
                $('.Tr_Ds_Dbb').change(function(){
                    $('.Tr_Dsb').each(function () {
                        $(this).val($('.Tr_Ds_Dbb').val());
                    });
                });

                //رقم حساب الصندوق الرئيسى
                $('.Tr_Db_Acc_No').each(function () {
                    $(this).val($('.Tr_Db_Select').children('option:selected').val())
                });
                $('.Tr_Db_Select').change(function(){
                    $('.Tr_Db_Acc_No').val($('.Tr_Db_Select').val());
                });
                /****************************************************/
                //دائن
                /****************************************************/
                //اضافة سطر فى جدول الدائن
                $('.add_line').click(function(e) {
                    var Jr_Ty = $('#Jr_Ty').val();
                    if (Jr_Ty == 19) {
                        e.preventDefault();

                        Ln_No = Ln_No + 1;
                        $.ajax({
                            url: "{{route('validateCacheN')}}",
                            type: "post",
                            dataType: 'html',
                            data: {
                                "_token": "{{ csrf_token() }}", Brn_No: $('#Dlv_Stor').children('option:selected').val(),
                                Cmp_No: $('#Cmp_No').children('option:selected').val(),
                                Tr_No: $('#Tr_No').val(),
                                Tr_Dt: $('#Tr_Dt').val(),
                                Jr_Ty: $('#Jr_Ty').val(),
                                Tr_DtAr: $('#Tr_DtAr').val(),
                                Doc_Type: $('#Doc_Type').children('option:selected').val(),
                                Tr_Crncy: $('#Tr_Crncy').children('option:selected').val(),
                                Tr_ExchRat: $('#Tr_ExchRat').val(),
                                Tot_Amunt: $('#Tot_Amunt').val(),
                                Tr_TaxVal: $('#Tr_TaxVal').val(),
                                //Rcpt_By: $('#Rcpt_By').val(),
                                Salman_No: $('#Salman_No').val(),
                                Ac_Ty: $('.Ac_Ty').children('option:selected').val(),
                                Sysub_Account: $('.Sysub_Account').val(),
                                Tr_Cr: $('.Tr_Cr').val(),
                                Dc_No: $('.Dc_No').val(),
                                Dc_No_Db: $('.Dc_No_Db').val(),
                                Tr_Ds: $('.Tr_Ds').val(),
                                Tr_Ds1: $('#Tr_Ds1').val(),
                                Acc_No: $('.Acc_No').val(),
                                last_record: $('#last_record').val(),
                                Issue_Dt: $('#Issue_Dt').val(),
                                Due_Issue_Dt: $('#Due_Issue_Dt').val(),
                                //Rcpt_By: $('#Rcpt_By').val(),
                                Tr_Db_Acc_No: $('.Tr_Db_Acc_No').val(),
                                Tr_Db_Db: $('.Tr_Db_Db').val(),
                                Tr_Cr_Db: $('.Tr_Cr_Db').val(),
                                Ln_No: Ln_No
                            },
                            success: function (data) {
                                var response = JSON.parse(data);
                                if (response.success == true) {
                                    $('#table').append(`
                                    <tr>
                                        <td>` + $('#Tr_No').val() + `</td>
                                        <td>` + $('.Sysub_Account').val() + `</td>
                                        <td>` + $('#Acc_No_Select option:selected').html() + `</td>
                                        <td>0.00</td>
                                        <td>` + $('.Tr_Cr').val() + `</td>
                                        <td>` + $('.Tr_Ds').val() + `</td>
                                        <td>` + $('.Dc_No').val() + `</td>
                                    </tr>`);

                                    var item = {
                                        Brn_No: $('#Dlv_Stor').children('option:selected').val(),
                                        Cmp_No: $('#Cmp_No').children('option:selected').val(),
                                        Tr_No: $('#Tr_No').val(),
                                        Tr_Dt: $('#Tr_Dt').val(),
                                        Jr_Ty: $('#Jr_Ty').children('option:selected').val(),
                                        Tr_DtAr: $('#Tr_DtAr').val(),
                                        Doc_Type: $('#Doc_Type').children('option:selected').val(),
                                        Tr_Crncy: $('#Tr_Crncy').children('option:selected').val(),
                                        Tr_ExchRat: $('#Tr_ExchRat').val(),
                                        Tot_Amunt: $('#Tot_Amunt').val(),
                                        Tr_TaxVal: $('#Tr_TaxVal').val(),
                                        Salman_No: $('#Salman_No').val(),
                                        Ac_Ty: $('.Ac_Ty').children('option:selected').val(),
                                        Sysub_Account: $('.Sysub_Account').val(),
                                        Tr_Cr: $('.Tr_Cr').val(),
                                        Tr_Db: $('.Tr_Db').val(),
                                        Dc_No: $('.Dc_No').val(),
                                        Dc_No_Db: $('.Dc_No_Db').val(),
                                        Tr_Ds: $('.Tr_Ds').val(),
                                        Tr_Ds1: $('.Tr_Ds1').val(),
                                        Acc_No: $('.Acc_No').val(),
                                        last_record: $('#last_record').val(),
                                        //Chq_no: $('#Chq_no').val(),
                                        Bnk_Nm: $('#Bnk_Nm').val(),
                                        Issue_Dt: $('#Issue_Dt').val(),
                                        Due_Issue_Dt: $('#Due_Issue_Dt').val(),
                                        //Rcpt_By: $('#Rcpt_By').val(),
                                        Tr_Db_Acc_No: $('#Tr_Db_Acc_No').val(),
                                        Tr_Db_Db: $('.Tr_Db_Db').val(),
                                        Tr_Cr_Db: $('.Tr_Cr_Db').val(),
                                        Ln_No: Ln_No,
                                    };

                                    catch_data.push(item);
                                } else {
                                    $('#alert').removeClass('hidden');
                                    $('#alert').html(``);
                                    var errors = Object.values(response.data);
                                    for (var i = 0; i < errors.length; i++) {
                                        $('#alert').append(`<div class='alert alert-danger'>` + errors[i] + `</div>`);
                                    }
                                }
                            }
                        });

                        old = $('.Tr_Db_Db').val();
                    }
                });

                /****************************************************/
                //مدين
                /****************************************************/
                //اضافة سطر فى جدول المدين
                $('.add_line1').click(function(e){
                    var Jr_Ty = $('#Jr_Ty').val();
                    // alert(Jr_Ty);
                    if (Jr_Ty == 18) {
                        e.preventDefault();

                        Ln_No = Ln_No + 1;
                        $.ajax({
                            url: "{{route('validateCacheN')}}",
                            type: "post",
                            dataType: 'html',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                Brn_No: $('#Dlv_Stor').children('option:selected').val(),
                                Cmp_No: $('#Cmp_No').children('option:selected').val(),
                                Tr_No: $('#Tr_No').val(),
                                Tr_Dt: $('#Tr_Dt').val(),
                                Jr_Ty: $('#Jr_Ty').val(),
                                Tr_DtAr: $('#Tr_DtAr').val(),
                                Doc_Type: $('#Doc_Type').children('option:selected').val(),
                                Tr_Crncy: $('#Tr_Crncy').children('option:selected').val(),
                                Tr_ExchRat: $('#Tr_ExchRat').val(),
                                Tot_Amunt: $('#Tot_Amunt').val(),
                                Tr_TaxVal: $('#Tr_TaxVal').val(),
                                //Rcpt_By: $('#Rcpt_By').val(),
                                Salman_No: $('#Salman_No').val(),
                                Ac_Ty: $('.Ac_Ty1').children('option:selected').val(),
                                Sysub_Account: $('.Sysub_Account1').val(),
                                Tr_Cr: $('.Tr_Db').val(),
                                Dc_No: $('.Dc_Nob').val(),
                                Dc_No_Db: $('.Dc_No_Dbb').val(),
                                Tr_Ds: $('.Tr_Ds_Dbb').val(),
                                //Tr_Ds_Db: $('.Tr_Ds_Dbb').val(),
                                Tr_Ds1: $('#Tr_Ds1').val(),
                                Acc_No: $('.Acc_No1').val(),
                                last_record: $('#last_record').val(),
                                Issue_Dt: $('#Issue_Dt').val(),
                                Due_Issue_Dt: $('#Due_Issue_Dt').val(),
                                //Rcpt_By: $('#Rcpt_By').val(),
                                Tr_Db_Acc_No: $('.Tr_Db_Acc_No').val(),
                                Tr_Db_Db: $('.Tr_Db_Dbb').val(),
                                Tr_Cr_Db: $('.Tr_Cr_Dbb').val(),
                                Ln_No: Ln_No
                            },
                            success: function (data) {
                                var response = JSON.parse(data);
                                if (response.success == true) {
                                    $('#table').append(`
                                <tr>
                                    <td>` + $('#Tr_No').val() + `</td>
                                    <td>` + $('.Sysub_Account1').val() + `</td>
                                    <td>` + $('.Acc_No_Select1 option:selected').html() + `</td>
                                    <td>0.00</td>
                                    <td>` + $('.Tr_Db').val() + `</td>
                                    <td>` + $('.Tr_Ds_Dbb').val() + `</td>
                                    <td>` + $('.Dc_No_Dbb').val() + `</td>

                                </tr>`);

                                    var item = {
                                        Brn_No: $('#Dlv_Stor').children('option:selected').val(),
                                        Cmp_No: $('#Cmp_No').children('option:selected').val(),
                                        Tr_No: $('#Tr_No').val(),
                                        Tr_Dt: $('#Tr_Dt').val(),
                                        Jr_Ty: $('#Jr_Ty').children('option:selected').val(),
                                        Tr_DtAr: $('#Tr_DtAr').val(),
                                        Doc_Type: $('#Doc_Type').children('option:selected').val(),
                                        Tr_Crncy: $('#Tr_Crncy').children('option:selected').val(),
                                        Tr_ExchRat: $('#Tr_ExchRat').val(),
                                        Tot_Amunt: $('#Tot_Amunt').val(),
                                        Tr_TaxVal: $('#Tr_TaxVal').val(),
                                        Salman_No: $('#Salman_No').val(),
                                        Ac_Ty: $('.Ac_Ty1').children('option:selected').val(),
                                        Sysub_Account: $('.Sysub_Account1').val(),
                                        Tr_Cr: $('.Tr_Cr').val(),
                                        Tr_Db: $('.Tr_Db').val(),
                                        Dc_No: $('.Dc_Nob').val(),
                                        Dc_No_Db: $('.Dc_No_Dbb').val(),
                                        Tr_Ds: $('.Tr_Ds_Db').val(),
                                        Tr_Ds1: $('.Tr_Ds1').val(),
                                        Acc_No: $('.Acc_No1').val(),
                                        last_record: $('#last_record').val(),
                                        //Chq_no: $('#Chq_no').val(),
                                        Bnk_Nm: $('#Bnk_Nm').val(),
                                        Issue_Dt: $('#Issue_Dt').val(),
                                        Due_Issue_Dt: $('#Due_Issue_Dt').val(),
                                        //Rcpt_By: $('#Rcpt_By').val(),
                                        Tr_Db_Acc_No: $('.Tr_Db_Acc_No').val(),
                                        Tr_Db_Db: $('.Tr_Db_Dbb').val(),
                                        Tr_Cr_Db: $('.Tr_Cr_Dbb').val(),
                                        Ln_No: Ln_No,
                                    };

                                    catch_data.push(item);
                                } else {
                                    $('#alert').removeClass('hidden');
                                    $('#alert').html(``);
                                    var errors = Object.values(response.data);
                                    for (var i = 0; i < errors.length; i++) {
                                        $('#alert').append(`<div class='alert alert-danger'>` + errors[i] + `</div>`);
                                    }
                                }
                            }
                        });

                        old = $('.Tr_Db_Dbb').val();
                    }
                });


                //handle Jr_Ty = 18  عند اختيار مدين
                $(document).on('change', '#Jr_Ty', function () {


                    if($(this).val() == 18){
                        $('.Debit').removeClass('hidden');
                        $('#Creditor').addClass('hidden');
                        //$('#Creditor').attr('id','new');

                    }
                    else{
                        // $('#Creditor').attr('id','Creditor');
                        $('#Debit').addClass('hidden');
                        $('#Creditor').removeClass('hidden');
                    }
                });

                //الخصم المسموح به والمكتسب
                $(document).on('change', '#Jr_Ty', function () {
                    $.ajax({
                        url: "{{route('getSelect')}}",
                        type: "get",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}"},
                        success: function(data){
                            $('.Tr_Db_Select').html(data);
                        }
                    });
                });


                var calcTax = function(){
                    var amount = $('#Tot_Amunt').val();
                    if($('#create_cache :checkbox[id=Tr_TaxVal_check]').is(':checked')){
                        var Jr_Ty = $('#Jr_Ty').val();
                        if(Jr_Ty == 18) {
                            var tax = $('#Tr_TaxVal').val();
                            if (tax !== null) {
                                var total_amount = ((tax * amount) / 100);
                            } else {
                                var total_amount = amount;
                            }
                            $('.Tr_Db').each(function () {
                                $(this).val(parseFloat(amount) + parseFloat(total_amount))
                            });
                        }else if(Jr_Ty == 19){
                            var tax = $('#Tr_TaxVal').val();
                            if (tax !== null) {
                                var total_amount = ((tax * amount) / 100);
                            } else {
                                var total_amount = amount;
                            }
                            $('.Tr_Cr').each(function () {
                                $(this).val(parseFloat(amount) + parseFloat(total_amount))
                            });
                        }
                    }
                    else{
                        var Jr_Ty = $('#Jr_Ty').val();
                        if(Jr_Ty == 18){
                            $('.Tr_Db').each(function () {
                                $(this).val(parseFloat(amount))
                            });
                        }else if(Jr_Ty == 19){

                            $('.Tr_Cr').each(function () {
                                $(this).val(parseFloat(amount))
                            });

                        }


                    }

                    // var cr = $('#Tr_Cr').val();
                    // var old_db = $('#Tr_Db_Db').val();
                    // var old_cr = $('#Tr_Cr_Db').val();
                    // $('#Tr_Db_Db').val(parseFloat(old_db) + parseFloat($('#Tr_Cr').val()));
                    // $('#Tr_Cr_Db').val(parseFloat(old_cr) + parseFloat($('#Tr_Cr').val()));
                }

                /**********************************************/
                //  حفظ الاشعار فى قاعدة البيانات دائن
                /*********************************************/

                $('.save').click(function(e){
                    var Jr_Ty = $('#Jr_Ty').val();
                    if (Jr_Ty == 19) {
                        e.preventDefault();
                        if ($('#Tr_Dif').val() != 0) {
                            alert('القيد غير متزن');
                        } else {
                            catch_data = JSON.stringify(catch_data);
                            $.ajax({
                                url: "{{route('notice.store')}}",
                                type: "post",
                                dataType: 'html',
                                data: {"_token": "{{ csrf_token() }}", catch_data},
                                success: function (data) {
                                    $('#alert').html(`<div class='alert alert-info'>تمت الاضافة بنجاح</div>`);
                                    // $('#Cmp_No').val(null);
                                    // $('#Dlv_Stor').val(null);
                                    $('#Tr_No').val(null);
                                    $('#Jr_Ty').val(null);
                                    // $('#Doc_Type').val(1);
                                    $('#Tr_Crncy').val(0);
                                    $('#Tr_ExchRat').val(null);
                                    $('#Tot_Amunt').val(null);
                                    $('#Tr_TaxVal').val(null);
                                    //$('#Rcpt_By').val(null);
                                    $('#Salman_No').val(null);
                                    $('.Ac_Ty').val(null);
                                    $('.Sysub_Account').val(null);
                                    $('.Tr_Cr').val(null);
                                    $('.Tr_Db').val(null);
                                    $('.Dc_No').val(null);
                                    $('.Tr_Ds').val(null);
                                    $('.Tr_Ds1').val(null);
                                    $('.Acc_No').val(null);
                                    $('.Acc_No_Select').val(null);
                                    $('.Dc_No_Db').val(null);
                                    $('.Tr_Ds_Db').val(null);
                                    $('#Salman_No_Name').val(null);
                                    $('#Salman_No').val(null);
                                    //$('#Chq_no').val(null);
                                    //$('#Bnk_Nm').val(null);
                                    $('#Issue_Dt').val(null);
                                    $('#Due_Issue_Dt').val(null);
                                    //$('#Rcpt_By').val(null);
                                    $('.Tr_Db_Db').val(null);
                                    $('.Tr_Cr_Db').val(null);
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
                    }
                });


                /**********************************************/
                //  حفظ الاشعار فى قاعدة البيانات مدين
                /*********************************************/

                $('.save').click(function(e) {
                    var Jr_Ty = $('#Jr_Ty').val();
                    if (Jr_Ty == 18){
                        e.preventDefault();
                        if ($('#Tr_Dif').val() != 0) {
                            alert('القيد غير متزن');
                        } else {
                            catch_data = JSON.stringify(catch_data);
                            $.ajax({
                                url: "{{route('notice.store')}}",
                                type: "post",
                                dataType: 'html',
                                data: {"_token": "{{ csrf_token() }}", catch_data},
                                success: function (data) {
                                    $('#alert').html(`<div class='alert alert-info'>تمت الاضافة بنجاح</div>`);
                                    // $('#Cmp_No').val(null);
                                    // $('#Dlv_Stor').val(null);
                                    $('#Tr_No').val(null);
                                    $('#Jr_Ty').val(null);
                                    // $('#Doc_Type').val(1);
                                    $('#Tr_Crncy').val(0);
                                    $('#Tr_ExchRat').val(null);
                                    $('#Tot_Amunt').val(null);
                                    $('#Tr_TaxVal').val(null);
                                    //$('#Rcpt_By').val(null);
                                    $('#Salman_No').val(null);
                                    $('.Ac_Ty1').val(null);
                                    $('.Sysub_Account1').val(null);
                                    $('.Tr_Cr1').val(null);
                                    $('.Tr_Db1').val(null);
                                    $('.Dc_Nob').val(null);
                                    $('.Tr_Dsb').val(null);
                                    $('#Tr_Ds1').val(null);
                                    $('.Acc_No1').val(null);
                                    $('.Acc_No_Select1').val(null);
                                    $('.Dc_No_Dbb').val(null);
                                    $('.Tr_Ds_Dbb').val(null);
                                    $('#Salman_No_Name').val(null);
                                    $('#Salman_No').val(null);
                                    //$('#Chq_no').val(null);
                                    //$('#Bnk_Nm').val(null);
                                    $('#Issue_Dt').val(null);
                                    $('#Due_Issue_Dt').val(null);
                                    //$('#Rcpt_By').val(null);
                                    $('.Tr_Db_Dbb').val(null);
                                    $('.Tr_Cr_Dbb').val(null);
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
                    }
                });

            });
        </script>
    @endpush
    <div class="hidden" id="alert"></div>
    <form action="{{route('notice.store')}}" method="POST" id="create_cache">
        {{ csrf_field() }}
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary panel-A save" style="float:left;" id="save"><i class="fa fa-floppy-o"></i></button>
        </div>
        <input hidden type="text" name="last_record" id="last_record" value='{{$last_record ? $last_record->Tr_No : null}}'>
        <br>
        <br>
        <br>
        <div class="panel panel-primary panel-H">
            <div class="panel-heading panel-A">
                <div class="panel-title">
                    {{trans('admin.data_notice')}}
                </div>
            </div>
            <div class="panel-body">
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
                            <label for="Dlv_Stor">{{trans('admin.section')}}</label>
                            <div id="Brn_No_content">
                                <select name="Dlv_Stor" id="Dlv_Stor" class="form-control">
                                    <option value="{{null}}">{{trans('admin.select')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- نهاية الفرع --}}
                    {{-- رقم القيد --}}
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Tr_No">{{trans('admin.number_of_limitation')}}</label>
                            <input type="text" name="Tr_No" id="Tr_No" value="" class="form-control" disabled>
                        </div>
                    </div>
                    {{-- نهاية رقم القيد --}}
                    {{-- تاريخ القيد --}}
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Tr_Dt">{{trans('admin.noti_date')}}</label>
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
                </div>

                <div class="row">
                    {{-- نوع الاشعار دائـن / مديـن --}}
                    <div class="col-md-2">
                        <label for="Jr_Ty">{{trans('admin.noti_type')}}</label>
                        <select name="Jr_Ty" id="Jr_Ty" class="form-control">
                            <option value="19">{{trans('admin.Fbal_CR_cr')}}</option>
                            <option value="18">{{trans('admin.Fbal_Db_db')}}</option>
                        </select>
                    </div>
                    {{-- نهاية نوع الاشعار دائـن / مديـن --}}

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
                        <label for="Tot_Amunt">{{trans('admin.amount')}}</label>
                        <input type="text" name="Tot_Amunt" id="Tot_Amunt" class="form-control">
                    </div>
                    {{-- نهاية المبلغ المطلوب --}}
                    {{-- الضريبه --}}
                    <div class="col-md-1">
                        <input type="checkbox" id="Tr_TaxVal_check">
                        <label for="Tr_TaxVal">{{trans('admin.tax')}} %</label>

                        <input type="text" name="Tr_TaxVal" id="Tr_TaxVal" class="form-control" disabled>
                    </div>
                    {{-- نهاية الضريبه --}}
                    {{-- مندوب المبيعات --}}
                    <div id="sales_man_content">
                        <div class="col-md-2">
                            <label for="Salman_No_Name">{{trans('admin.sales_officer2')}}</label>
                            <input type="text" name="Salman_No_Name" id="Salman_No_Name" class="form-control" disabled>
                        </div>
                        <div class="col-md-1">
                            <label for=""></label>
                            <input type="text" name="Salman_No" id="Salman_No" class="form-control" disabled>
                            <br>
                        </div>
                    </div>
                    {{-- نهاية مندوب المبيعات --}}
                </div>
            </div>
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

        <div class="row"  id="Creditor">
            <br>
            {{--             بيانات الحساب الدائن--}}
            <div class="col-md-6">
                <div class="panel panel-primary panel-H">
                    <div class="panel-heading panel-A panel-A">
                        <div class="panel-title">
                            {{trans('admin.information_account')}}
                        </div>
                    </div>
                    <div class="panel-body">
                        {{--                         الحساب الرئيسى--}}
                        <div class="row">
                            <div class="col-md-8">
                                <label for="main_acc">{{trans('admin.main_account_chart')}}</label>
                                <input type="text" name="main_acc" id="main_acc" class="form-control main_acc" disabled>
                            </div>
                            <div class="col-md-4">
                                <label for="Acc_No"></label>
                                <input type="text" name="Acc_No" id="Acc_No" class="form-control Acc_No" disabled>
                            </div>
                        </div>
                        {{--                         نهاية الحساب الرئيسى--}}
                        {{--                         نوع الحساب--}}
                        <div class="row">
                            {{--                             نوع الحساب عملاء - موردين - موظفين - ....--}}
                            <div class="col-md-2">
                                <label for="Ac_Ty">{{trans('admin.account_type')}}</label>
                                <select name="Ac_Ty" id="Ac_Ty" class="form-control Ac_Ty">
                                    <option value="{{null}}">{{trans('admin.select')}}</option>
                                    @foreach(\App\Enums\AccountType::toSelectArray() as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{--                             رقم حساب العملاء - رقم حساب الموظفين - رقم حساب الموردين - ....--}}
                            <div class="col-md-7">
                                <label for="Acc_No_Select"></label>
                                <select name="Acc_No_Select" id="Acc_No_Select" class="form-control select2 Acc_No_Select">
                                    <option value="{{null}}">{{trans('admin.select')}}</option>
                                </select>
                            </div>
                            {{--                             رقم العميل - رقم المورد - رقم الموظف--}}
                            <div class="col-md-3">
                                <label for="Sysub_Account"></label>
                                <input type="text" name="Sysub_Account" id="Sysub_Account" class="form-control Sysub_Account">
                            </div>
                        </div>
                        {{--                         نهاية نوع الحساب--}}

                        <div class="row">
                            {{--                             المبلغ دائن--}}
                            <div class="col-md-4">
                                <label for="Tr_Cr">{{trans('admin.amount_cr')}}</label>
                                <input type="text" disabled name="Tr_Cr" id="Tr_Cr" class="form-control Tr_Cr">
                            </div>
                            {{--                             نهاية المبلغ دائن--}}
                            {{--                             رقم المستند--}}
                            <div class="col-md-4">
                                <label for="Dc_No">{{trans('admin.receipt_number')}}</label>
                                <input type="text" name="Dc_No" id="Dc_No" class="form-control Dc_No">
                            </div>
                            {{--                             نهاية رقم المستند--}}
                            {{--                             مركز التكلفه--}}
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
                            {{--                             نهاية مركز التكلفه--}}
                        </div>
                        <div class="row">
                            {{--                             البيان عربى--}}
                            <div class="col-md-12">
                                <br>
                                <label for="Tr_Ds" class="col-md-2">{{trans('admin.Statement_ar')}}</label>
                                <input type="text" name="Tr_Ds" id="Tr_Ds" class="form-control col-md-6 Tr_Ds">
                            </div>
                        </div>

                        {{--                         نهاية البيان عربى--}}
                        <div class="row">
                            {{--                             البيان انجليزى--}}
                            <div class="col-md-12">
                                <br>
                                <label for="Tr_Ds1" class="col-md-2">{{trans('admin.Statement_en')}}</label>
                                <input type="text" name="Tr_Ds1" id="Tr_Ds1" class="form-control col-md-6">
                                <button style="margin-right: 10px" class="btn btn-primary panel-A col-md-3 add_line" id="add_line">{{trans('admin.add_line')}}</button>
                            </div>
                            {{--                             نهاية البيان انجليزى--}}
                            {{--                             اضافة سطر--}}

                            {{--                             نهاية اضافة سطر--}}
                        </div>
                    </div>
                </div>
            </div>
            {{--             نهاية بيانات الحساب الدائن--}}
            {{--             بيانات الحساب المدين--}}
            <div class="col-md-6">
                <div class="panel panel-primary panel-H">
                    <div class="panel-heading panel-A">
                        <div class="panel-title">
                            {{trans('admin.dept_account')}}
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            {{--                             الصندوق الرئيسى--}}
                            <div class="col-md-6">
                                <label for="Tr_Db_Select">{{trans('admin.allowed')}}</label>
                                <select name="Tr_Db_Select" id="Tr_Db_Select" class="form-control Tr_Db_Select">
                                    <option>{{trans('admin.select')}}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="Tr_Db_Acc_No"></label>
                                <input type="text" name="Tr_Db_Acc_No" id="Tr_Db_Acc_No" class="form-control Tr_Db_Acc_No">
                            </div>
                            {{--                             بيانات الصندوق الرئيسى--}}
                            {{--                             رقم المستند--}}
                            <div class="col-md-3">
                                <label for="">{{trans('admin.receipt_number')}}</label>
                                <input type="text" name="Dc_No_Db" id="Dc_No_Db" class="form-control Dc_No_Db">
                            </div>
                            {{--                             نهاية رقم المستند--}}
                        </div>
                        {{--                         البيان--}}
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <label for="Tr_Ds" class="col-md-2">{{trans('admin.note_ar')}}</label>
                                <input type="text" name="Tr_Ds_Db" id="Tr_Ds_Db" class="form-control col-md-10 Tr_Ds_Db">
                            </div>
                        </div>
                        {{--                         البيان--}}
                    </div>
                    {{--                     اجمالى السند--}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        {{trans('admin.receipt_total')}}
                                    </div>
                                </div>
                                <div class="panel-body">
                                    {{--                                     مدين--}}
                                    <div class="col-md-3">
                                        <label for="Tr_Db_Db">{{trans('admin.Fbal_Db_')}}</label>
                                        <input type="text" name="Tr_Db_Db" id="Tr_Db_Db" class="form-control Tr_Db_Db" value='0.00'>
                                    </div>
                                    {{--                                     نهاية مدين--}}
                                    {{--                                     دائن--}}
                                    <div class="col-md-3">
                                        <label for="Tr_Cr_Db">{{trans('admin.Fbal_CR_')}}</label>
                                        <input type="text" name="Tr_Cr_Db" id="Tr_Cr_Db" class="form-control Tr_Cr_Db" value='0.00'>
                                    </div>
                                    {{--                                     نهاية دائن--}}
                                    {{--                                     الفرق--}}
                                    <div class="col-md-3">
                                        <label for="Tr_Dif">{{trans('admin.subtract')}}</label>
                                        <input type="text" name="Tr_Dif" id="Tr_Dif" class="form-control Tr_Dif" disabled>
                                    </div>
                                    {{--                                     نهاية الفرق--}}
                                    {{--                                     الرصيد الحالى--}}
                                    <div class="col-md-3">
                                        <label for="Crnt_Blnc">{{trans('admin.current_balance')}}</label>
                                        <input type="text" name="Crnt_Blnc" id="Crnt_Blnc" class="form-control">
                                    </div>
                                    {{--                                     نهاية الرصيد الحالى--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--                     نهاية اجمالى السند--}}
                </div>
            </div>
            {{--             نهاية بيانات الحساب المدين--}}
        </div>

        <div class="row hidden Debit" id="Debit">
            <br>
            {{-- بيانات الحساب المدين --}}
            <div class="col-md-6">
                <div class="panel panel-primary panel-H">
                    <div class="panel-heading panel-A panel-A">
                        <div class="panel-title">
                            {{trans('admin.dept_account')}}
                        </div>
                    </div>
                    <div class="panel-body">
                        {{-- الحساب الرئيسى --}}
                        <div class="row">
                            <div class="col-md-8">
                                <label for="main_acc">{{trans('admin.main_account_chart')}}</label>
                                <input type="text" name="main_acc" id="main_acc" class="form-control main_acc1" disabled>
                            </div>
                            <div class="col-md-4">
                                <label for="Acc_No"></label>
                                <input type="text" name="Acc_No" id="Acc_No" class="form-control Acc_No1" disabled>
                            </div>
                        </div>
                        {{-- نهاية الحساب الرئيسى --}}
                        {{-- نوع الحساب --}}
                        <div class="row">
                            {{-- نوع الحساب عملاء - موردين - موظفين - .... --}}
                            <div class="col-md-2">
                                <label for="Ac_Ty">{{trans('admin.account_type')}}</label>
                                <select name="Ac_Ty" id="Ac_Ty" class="form-control Ac_Ty1">
                                    <option value="{{null}}">{{trans('admin.select')}}</option>
                                    @foreach(\App\Enums\AccountType::toSelectArray() as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- رقم حساب العملاء - رقم حساب الموظفين - رقم حساب الموردين - .... --}}
                            <div class="col-md-7">
                                <label for="Acc_No_Select"></label>
                                <select name="Acc_No_Select" id="Acc_No_Select" class="form-control select2 Acc_No_Select1">
                                    <option value="{{null}}">{{trans('admin.select')}}</option>
                                </select>
                            </div>
                            {{-- رقم العميل - رقم المورد - رقم الموظف --}}
                            <div class="col-md-3">
                                <label for="Sysub_Account"></label>
                                <input type="text" name="Sysub_Account" id="Sysub_Account" class="form-control Sysub_Account1">
                            </div>
                        </div>
                        {{-- نهاية نوع الحساب --}}

                        <div class="row">
                            {{-- المبلغ مدين --}}
                            <div class="col-md-4">
                                <label for="Tr_Db">{{trans('admin.amount_db')}}</label>
                                <input type="text" disabled name="Tr_Db" id="Tr_Db" class="form-control Tr_Db">
                            </div>
                            {{-- نهاية المبلغ دائن --}}
                            {{-- رقم المستند --}}
                            <div class="col-md-4">
                                <label for="Dc_No_Db">{{trans('admin.receipt_number')}}</label>
                                <input type="text" name="Dc_No_Db" id="Dc_No_Db" class="form-control Dc_No_Dbb">
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
                                <label for="Tr_Ds_Db" class="col-md-2">{{trans('admin.Statement_ar')}}</label>
                                <input type="text" name="Tr_Ds_Db" id="Tr_Ds_Db" class="form-control col-md-6 Tr_Ds_Dbb">
                            </div>
                        </div>

                        {{-- نهاية البيان عربى --}}
                        <div class="row">
                            {{-- البيان انجليزى --}}
                            <div class="col-md-12">
                                <br>
                                <label for="Tr_Ds1" class="col-md-2">{{trans('admin.Statement_en')}}</label>
                                <input type="text" name="Tr_Ds1" id="Tr_Ds1" class="form-control col-md-6">
                                <button style="margin-right: 10px" class="btn btn-primary panel-A col-md-3 add_line1" id="add_line">{{trans('admin.add_line')}}</button>
                            </div>
                            {{-- نهاية البيان انجليزى --}}
                            {{-- اضافة سطر --}}

                            {{-- نهاية اضافة سطر --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- نهاية بيانات الحساب المدين --}}
            {{-- بيانات الحساب الدائن --}}
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
                                <label for="Tr_Db_Select">{{trans('admin.gain')}}</label>
                                <select name="Tr_Db_Select" id="Tr_Db_Select" class="form-control Tr_Db_Select">
                                    <option>{{trans('admin.select')}}</option>
                                    {{--                                    @if(count($banks) > 0)--}}
                                    {{--                                        @foreach($banks as $bnk)--}}
                                    {{--                                            <option value="{{$bnk->Acc_No}}">{{$bnk->{'Acc_Nm'.ucfirst(session('lang'))} }}</option>--}}
                                    {{--                                        @endforeach--}}
                                    {{--                                    @endif--}}
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="Tr_Db_Acc_No"></label>
                                <input type="text" name="Tr_Db_Acc_No" id="Tr_Db_Acc_No" class="form-control Tr_Db_Acc_No">
                            </div>
                            {{-- بيانات الصندوق الرئيسى --}}
                            {{-- رقم المستند --}}
                            <div class="col-md-3">
                                <label for="">{{trans('admin.receipt_number')}}</label>
                                <input type="text" name="Dc_No" id="Dc_No" class="form-control Dc_Nob">
                            </div>
                            {{-- نهاية رقم المستند --}}
                        </div>
                        {{-- البيان --}}
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <label for="Tr_Ds" class="col-md-2">{{trans('admin.note_ar')}}</label>
                                <input type="text" name="Tr_Ds" id="Tr_Ds" class="form-control col-md-10 Tr_Dsb">
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
                                        <input type="text" name="Tr_Db_Db" id="Tr_Db_Db" class="form-control Tr_Db_Dbb" value='0.00'>
                                    </div>
                                    {{-- نهاية مدين --}}
                                    {{-- دائن --}}
                                    <div class="col-md-3">
                                        <label for="Tr_Cr_Db">{{trans('admin.Fbal_CR_')}}</label>
                                        <input type="text" disabled name="Tr_Cr_Db" id="Tr_Cr_Db" class="form-control Tr_Cr_Dbb" value='0.00'>
                                    </div>
                                    {{-- نهاية دائن --}}
                                    {{-- الفرق --}}
                                    <div class="col-md-3">
                                        <label for="Tr_Dif">{{trans('admin.subtract')}}</label>
                                        <input type="text" name="Tr_Dif" id="Tr_Dif" class="form-control Tr_Diff" disabled>
                                    </div>
                                    {{-- نهاية الفرق --}}
                                    {{-- الرصيد الحالى --}}
                                    <div class="col-md-3">
                                        <label for="Crnt_Blnc">{{trans('admin.current_balance')}}</label>
                                        <input type="text" name="Crnt_Blnc" id="Crnt_Blnc" class="form-control">
                                    </div>
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
                    </thead>
                </table>
            </div>
        </div>
    </form>
@endsection
