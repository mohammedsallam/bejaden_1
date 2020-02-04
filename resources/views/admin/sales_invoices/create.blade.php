@extends('admin.index')
@section('title', trans('admin.delay_bill'))
@section('content')
    @push('css')
        <style>
            .datepicker{direction: rtl;}
            .delete_row{cursor: pointer;}
            table tr td input, table tr td select{width: 100%;}
        </style>
    @endpush

    @push('js')
        <script>

            $(document).ready(function () {
                let count = 1, tableBody = $('.table_body');
                $('input.Doc_Dt').change(function () {
                    let Hijri = $(this).val();
                    $.ajax({
                        url: "{{route('hijri')}}",
                        type: 'get',
                        data:{Hijri: Hijri} ,
                        dataType: 'json',
                        success: function (data) {
                            $('.Doc_DtAr').val(data);
                        }
                    })
                });

                $(document).on('click', '.delete_row', function () {
                    if(tableBody.children().length === 1){
                        count = 1;
                        return false;
                    }
                    $(this).parent('tr').remove();
                    tableBody.children().each(function () {
                        $(this).children('td:first-child').children('span').html(parseInt($(this).index())+1)
                        $(this).children('td:first-child').children('input').val(parseInt($(this).index())+1)
                    });
                });

                tableBody.keypress(function (e) {

                    if($('.items_table').height() > 500){
                        $('.items_table').css({
                            maxHeight: "300px",
                            overflow: "auto"
                        })
                    }

                    if(e.keyCode  === 13){
                        if(tableBody.children().length === 1){
                            count = 2;
                        }

                        let row = `<tr>
                    <td class="delete_row bg-red"><span>`+count+`</span><input type="hidden" name="Ln-No" value="`+count+`"></td>
                    <td style="width: 11%"><input id="itm_no_input" class="itm_no_input" type="text"></td>
                    <td style="width: 20%">
                        <select name="Itm_No" id="Itm_No" class="Itm_No" >
                            <option value=""></option>
                        </select>
                    </td>
                    <td style="width: 9%">
                        <select name="Unit_No" id="Unit_No" class="Unit_No" >
                            <option value=""></option>
                        </select>
                    </td>
                    <td><input type="text" name="Loc_No" id="Loc_No" class="Loc_No"></td>
                    <td><input type="number" min="1" name="Qty" id="Qty" class="Qty"></td>
                    <td><input type="number" min="1" name="Itm_Sal" id="Itm_Sal" class="Itm_Sal"></td>
                    <td><input type="text" id="item_tot_sal" class="item_tot_sal"></td>
                    <td style="width: 11%;"><input type="text" name="Exp_Date" id="Exp_Date" class="Exp_Date" style="padding: 0; border-radius: 0"></td>
                    <td><input type="text" name="Batch_No" class="Batch_No" id="Batch_No"></td>
                    <td><input type="text" name="Disc1_Prct" id="Disc1_Prct" class="Disc1_Prct"></td>
                    <td><input type="text" name="Disc1_Val" id="Disc1_Val" class="Disc1_Val"></td>
                    <td><input type="text" name="Taxp_Extra" id="Taxp_Extra" class="Taxp_Extra"></td>
                    <td><input type="text" name="Taxv_Extra" id="Taxv_Extra" class="Taxv_Extra"></td>
                </tr>`;

                        tableBody.append(row);

                        tableBody.children().each(function () {
                            $(this).children('td:first-child').children('span').html(parseInt($(this).index())+1)
                            $(this).children('td:first-child').children('input').val(parseInt($(this).index())+1)

                        });
                        count +=1;
                    }

                });

                $('.Cmp_No').change(function () {
                    $('.Brn_No, .Cstm_No, .Dlv_Stor').html('');
                    if($(this).val() !== ''){
                        $.ajax({
                            url: "{{route('getActivityCustomer')}}",
                            type: 'get',
                            dataType: 'json',
                            data:{Cmp_No:$('.Cmp_No option:selected').val()},
                            success:function (data) {
                                $('.Brn_No, .Cstm_No, .Dlv_Stor').html('');

                                $('.Brn_No').append("<option>{{trans('admin.select')}}</option>");
                                $('.Cstm_No').append("<option>{{trans('admin.select')}}</option>");

                                $('.Actvty_No').html("<option value='"+data.activity_id+"'>"+data.activity_name+"</option>");

                                for (let i =0; i < data.customers.length; i++){
                                    $('.Cstm_No').append("<option value='"+data.customers[i]['ID_No']+"'>"+data.customers[i]['Cstm_Nm'+"{{ucfirst(session('lang'))}}"]+"</option>");
                                }


                                for (let i =0; i < data.branches.length; i++){
                                    $('.Brn_No').append("<option value='"+data.branches[i]['ID_No']+"'>"+data.branches[i]['Brn_NmEn']+"</option>");
                                }
                            }
                        })
                    }
                });
                $('.Brn_No').change(function () {
                    if($(this).val()){
                        $.ajax({
                            url: "{{route('getActivityCustomer')}}",
                            type: 'get',
                            dataType: 'json',
                            data:{Brn_No:$('.Brn_No option:selected').val()},
                            success:function (data) {
                                $('.Dlv_Stor, .Slm_No').html('');
                                for (let i =0; i < data.stores.length; i++){
                                    $('.Dlv_Stor').append("<option value='"+data.stores[i]['ID_No']+"'>"+data.stores[i]['Dlv_Nm'+"{{ucfirst(session('lang'))}}"]+"</option>");
                                }

                                $('.Slm_No').append("<option>{{trans('admin.select')}}</option>");
                                for (let i =0; i < data.stores.length; i++){
                                    $('.Slm_No').append("<option value='"+data.salesMan[i]['Slm_No']+"'>"+data.salesMan[i]['Slm_Nm'+"{{ucfirst(session('lang'))}}"]+"</option>");
                                }
                            }
                        })
                    }
                });
                $('.Cstm_No').change(function () {
                    $('.cstm_no_input').val($(this).val())
                })

                $('table td input').focus(function () {
                   console.log('hello')
                })
            })

        </script>
    @endpush
@hasrole('admin')
@can('create')
<div class="box">
    @include('admin.layouts.message')
{{--    <div class="box-header">--}}
{{--        <h3 class="box-title">{{trans('admin.delay_bill')}}</h3>--}}
{{--    </div>--}}
    <div class="box-body">
{{--        {!! Form::open(['method'=>'POST','route' => 'salesInvoices.store','files'=>true]) !!}--}}

        <div class="row">
            <div class="col-md-6">
                <div class="form-group" style="display: flex">
                    <label style="width: 25%" for="Cmp_No">{{trans('admin.companies')}}</label>
                    {{--@if($cmp->ID_No == session('updatedComNo')) selected @endif--}}
                    <select name="Cmp_No" id="Cmp_No" class="form-control Cmp_No">
                        <option value="">{{trans('admin.select')}}</option>
                        @if(count($companies ) > 0)
                            @foreach($companies as $company)
                                <option @if(session('Cmp_No') == $company->Cmp_No) selected @endif value="{{$company->Cmp_No}}">{{$company->{'Cmp_Nm'.ucfirst(session('lang'))} }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                {{--@if($active->ID_No == session('updatedActiveNo')) selected @endif--}}
                <div class="form-group" style="display: flex">
                    <label style="width: 25%" for="Actvty_No" >{{trans('admin.activity')}}</label>
                    <select name="Actvty_No" id="Actvty_No" class="form-control Actvty_No">
                        <option value="">{{trans('admin.select')}}</option>
{{--                        @if(count($activity) > 0)--}}
{{--                            @foreach($activity as $active)--}}
{{--                                <option @if(session('Cmp_No') == $active->ID_No) selected @endif value="{{$active->ID_No}}">{{$active->{'Name_'.ucfirst(session('lang'))} }}</option>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
                    </select>
                </div>
            </div>
        </div>
        <div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('Brn_No', trans('admin.Branches') , ['class' => 'control-label']) }}
                    <select name="Brn_No" id="Brn_No" class="form-control Brn_No">
                        <option value="">{{trans('admin.select')}}</option>
{{--                        @foreach($branches as $branch)--}}
{{--                            <option value="{{$branch->ID_No}}">{{$branch->{'Brn_Nm'.ucfirst(session('lang'))} }}</option>--}}
{{--                        @endforeach--}}
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="Slm_No" class="control-label">مندوب المبيعات</label>
                    <select name="Slm_No" id="Slm_No"  class="form-control Slm_No">
                        <option value="">{{trans('admin.select')}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="Cstm_No" class="control-label">العميل</label>
                    <select name="Cstm_No" id="Cstm_No"  class="form-control Cstm_No">
                        <option value="">{{trans('admin.select')}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label for="">رقم</label>
                    <input type="text" class="form-control cstm_no_input" >
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="" class="control-label"> ر/فاتورة</label>
                    <input readonly style="background: #fff" type="text" name="Custm_Inv" id="Custm_Inv" class="form-control Custm_Inv" value="{{$last != null ? $last->Custm_Inv+1:1}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="Dlv_Stor" class="control-label">مستودع</label>
                    <select name="Dlv_Stor" id="Dlv_Stor" class="form-control Dlv_Stor">
                        <option value="">{{trans('admin.select')}}</option>
                        {{--                        @foreach($branches as $branch)--}}
                        {{--                            <option value="{{$branch->ID_No}}">{{$branch->{'Brn_Nm'.ucfirst(session('lang'))} }}</option>--}}
                        {{--                        @endforeach--}}
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="Doc_Dt" class="control-label">ميلادي</label>
                    <input type="text" name="Doc_Dt" class="form-control Doc_Dt datepicker" id="Doc_Dt">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="" class="control-label">هجري</label>
                    <input type="text" name="Doc_DtAr"  class="form-control Doc_DtAr" >
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="">مستند</label>
                    <input type="text" name="SubCstm_Filno" class="form-control SubCstm_Filno" id="SubCstm_Filno">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="Pym_No" class="control-label">طريقة الدفع</label>
                    <select name="Pym_No"  id="Pym_No" class="form-control Pym_No">
                        <option value="">{{trans('admin.select')}}</option>
                        @foreach(\App\Enums\PayType::toSelectArray() as $key => $type)
                            <option value="{{$key}}">{{$type}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="Reftyp_No" class="control-label">نوع المرجع</label>
                    <select name="Reftyp_No" id="Reftyp_No" class="form-control Reftyp_No">
                        <option value="">{{trans('admin.select')}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="Ref_No" class="control-label">رقم المرجع</label>
                    <select name="Ref_No" id="Ref_No"  class="form-control Ref_No">
                        <option value="">{{trans('admin.select')}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
{{--                    <div>--}}
{{--                        <input type="checkbox" class="checkbox-inline" id="cache">--}}
{{--                        <label for="cache" class="control-label">نقداً خلال</label>--}}
{{--                    </div>--}}
                    <div style="width: 62%">
                        <label for="Credit_Days" class="control-label">مدة السداد</label>
                        <input type="text" name="Credit_Days" id="Credit_Days" class="form-control Credit_Days" placeholder="يوم">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="Pym_Dt">تاريخ السداد</label>
                    <input type="text" name="Pym_Dt" id="Pym_Dt" class="form-control Pym_Dt datepicker" style="direction: rtl">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="Tax_Allow">الضريبة المضافة</label>
                    <br>
                    <input value="1" type="checkbox" name="Tax_Allow" id="Tax_Allow" class="checkbox-inline Tax_Allow" style="width: 20px; height: 20px;">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">ملاحظات</label>
                    <input name="" class="form-control" >
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">ملاحظات1</label>
                    <input name="" class="form-control note_1" >
                </div>
            </div>
        </div>

        {{--Start table--}}
        <div class="row items_table">
            <div class="col-md-12">
                <table class="table table-bordered table-responsive">
                    <tr class="bg-aqua">
                        <th>م</th>
                        <th>رقم الصنف</th>
                        <th>إسم الصنف</th>
                        <th>الوحدة</th>
                        <th>رقم </th>
                        <th>الكمية</th>
                        <th>سعر البيع</th>
                        <th>إجمالي القيمة</th>
                        <th>تاريخ الصلاحية</th>
                        <th> الباتش</th>
                        <th>خصم بيع%</th>
                        <th>قيمة الخصم1</th>
                        <th>الضريبة%</th>
                        <th>قيمة الضريبة</th>
                    </tr>
                    <tbody class="table_body">
                    <tr class="first_row">
                        <td class="delete_row bg-red"><span>1</span><input type="hidden" name="Ln-No" value="1"></td>
                        <td style="width: 11%"><input type="text" class="itm_no_input"></td>
                        <td style="width: 20%">
                            <select name="Itm_No" id="Itm_No" class="Itm_No">
                                <option value=""></option>
                            </select>
                        </td>
                        <td style="width: 9%">
                            <select name="Unit_No" id="Unit_No" class="Unit_No" >
                                <option value=""></option>
                            </select>
                        </td>
                        <td><input type="text" name="Loc_No" id="Loc_No" class="Loc_No"></td>
                        <td><input type="number" min="1" name="Qty" id="Qty" class="Qty"></td>
                        <td><input type="number" min="1" name="Itm_Sal" id="Itm_Sal" class="Itm_Sal"></td>
                        <td><input type="text" id="item_tot_sal" class="item_tot_sal"></td>
                        <td style="width: 11%;"><input type="text" name="Exp_Date" id="Exp_Date" class="Exp_Date" style="padding: 0; border-radius: 0"></td>
                        <td><input type="text" name="Batch_No" class="Batch_No" id="Batch_No"></td>
                        <td><input type="text" name="Disc1_Prct" id="Disc1_Prct" class="Disc1_Prct"></td>
                        <td><input type="text" name="Disc1_Val" id="Disc1_Val" class="Disc1_Val"></td>
                        <td><input type="text" name="Taxp_Extra" id="Taxp_Extra" class="Taxp_Extra"></td>
                        <td><input type="text" name="Taxv_Extra" id="Taxv_Extra" class="Taxv_Extra"></td>
                    </tr>
                    </tbody>
                    <tfoot class="bg-primary" style="cursor: pointer">
                    {{--                <tr>--}}
                    {{--                    <td colspan="20" style="height: 40px; text-align: center"><i class="fa fa-plus"></i> <b>أضف</b></td>--}}
                    {{--                </tr>--}}
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">الإجمالي</label>
                    <input type="text" name="Tot_Sal" id="Tot_Sal" class="form-control Tot_Sal">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">بعد الخصم</label>
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">خصم أصناف</label>
                    <input type="text" name="Tot_Disc" id="Tot_Disc" class="form-control Tot_Disc">
                    <input type="text" name="Tot_Prct" id="Tot_Prct" class="form-control Tot_Prct">
                    <label>%</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">خصم إضافي</label>
                    <input type="text" name="Tot_ODisc" id="Tot_ODisc" class="form-control Tot_ODisc">
                    <input type="text" name="Tot_OPrct" id="Tot_OPrct" class="form-control Tot_OPrct">
                    <label>%</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">قيمة الضريبة</label>
                    <input type="text" class="form-control tax_val">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">الصافي</label>
                    <input type="text" name="Net" id="Net" class="form-control Net">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">حد الائتمان</label>
                    <input type="text" class="form-control secure_limit">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">الرصيد الحالي</label>
                    <input type="text" class="form-control current_balance">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">الفرق</label>
                    <input type="text" class="form-control diff">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">رصيد الصنف</label>
                    <input type="text" class="form-control item_balance">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">رصيد المستودعات</label>
                    <input type="text" class="form-control store_balance">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">سعر البيع</label>
                    <input type="text" class="form-control sale_price">
                </div>
            </div>
        </div>

        {{--End table--}}



{{--        {{Form::submit(trans('admin.create'),['class'=>'btn btn-primary'])}}--}}
{{--        {!! Form::close() !!}--}}
    </div>
</div>
    @endcan
@else
    <div class="alert alert-danger">{{trans('admin.you_cannt_see_invoice_because_you_dont_have_role_to_access')}}</div>

    @endhasrole







@endsection
