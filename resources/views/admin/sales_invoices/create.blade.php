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
                        $(this).children('td:first-child').html(parseInt($(this).index())+1)

                    });
                });

                tableBody.keypress(function (e) {

                    if(e.keyCode  === 13){
                        if(tableBody.children().length === 1){
                            count = 2;
                        }

                        tableBody.children().each(function () {
                            $(this).children('td:first-child').html(parseInt($(this).index())+1)

                        });

                        let row = `<tr>
                    <td class="delete_row bg-red">`+count+`</td>
                    <td style="width: 11%"><input name="Itm_No[]" id="Itm_No" class="Itm_No" type="text"></td>
                    <td style="width: 20%">
                        <select name="" >
                            <option value=""></option>
                        </select>
                    </td>
                    <td style="width: 9%">
                        <select name="Unit_No[]" id="Unit_No" class="Unit_No" >
                            <option value=""></option>
                        </select>
                    </td>
                    <td><input type="text" name="Loc_No[]" id="Loc_No" class="Loc_No"></td>
                    <td><input type="number" min="1" name="Qty[]" id="Qty" class="Qty"></td>
                    <td><input type="number" min="1" name="Itm_Sal[]" id="Itm_Sal" class="Itm_Sal"></td>
                    <td><input type="text"></td>
                    <td style="width: 11%;"><input type="text" name="Exp_Date[]" id="Exp_Date" class="Exp_Date" style="padding: 0; border-radius: 0"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text" class="last_td"></td>
                    <td><input type="text" class="last_td"></td>
                    <td><input type="text" class="last_td"></td>
                </tr>`;

                        tableBody.append(row);
                        count +=1;
                    }





                });
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

        <div>
            <div class="col-md-3">
                <div class="form-group">
                    {{ Form::label('Brn_No', trans('admin.Branches') , ['class' => 'control-label']) }}
                    <select name="Brn_No" id="Brn_No" class="form-control Brn_No">
                        <option value="">{{trans('admin.select')}}</option>
                        @foreach($branches as $branch)
                            <option value="{{$branch->ID_No}}">{{$branch->{'Brn_Nm'.ucfirst(session('lang'))} }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="Dlv_Stor" class="control-label">مستودع</label>
                    <select name="Dlv_Stor" id="Dlv_Stor" class="form-control Dlv_Stor">
                        <option value="">{{trans('admin.select')}}</option>
                        @foreach($branches as $branch)
                            <option value="{{$branch->ID_No}}">{{$branch->{'Brn_Nm'.ucfirst(session('lang'))} }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="" class="control-label"> ر/فاتورة</label>
                    <input type="text" name="" class="form-control" >
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
                    <input type="text" name="Doc_DtAr"  class="form-control" >
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="Pym_No" class="control-label">طريقة الدفع</label>
                    <select name="Pym_No"  id="Pym_No" class="form-control Pym_No">
                        <option value="">{{trans('admin.select')}}</option>
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
                <div class="form-group">
                    <label for="Cstm_No" class="control-label">العميل</label>
                    <select name="Cstm_No" id="Cstm_No"  class="form-control Cstm_No">
                        <option value="">{{trans('admin.select')}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="">رقم</label>
                    <input type="text" name="Doc_DtAr" class="form-control" >
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
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <div>
                        <input type="checkbox" class="checkbox-inline" id="cache">
                        <label for="cache" class="control-label">نقداً خلال</label>
                    </div>
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
        <div class="row" style="max-height: 400px; overflow: auto;">
            <table class="table table-bordered">
                <tr class="bg-aqua">
                    <th>م</th>
                    <th>رقم الصنف</th>
                    <th>إسم الصنف</th>
                    <th>الوحدة</th>
                    <th>رقم الموقع</th>
                    <th>الكمية</th>
                    <th>سعر البيع</th>
                    <th>إجمالي القيمة</th>
                    <th>تاريخ الصلاحية</th>
                    <th>رقم الباتش</th>
                    <th>خصم بيع%</th>
                    <th>خصم قيمة1</th>
                    <th>الضريبة%</th>
                    <th>قيمة الضريبة</th>
                </tr>
                <tbody class="table_body">
                <tr class="first_row">
                    <td class="delete_row bg-red">1</td>
                    <td style="width: 11%"><input name="Itm_No[]" id="Itm_No" class="Itm_No" type="text"></td>
                    <td style="width: 20%">
                        <select name="" >
                            <option value=""></option>
                        </select>
                    </td>
                    <td style="width: 9%">
                        <select name="Unit_No[]" id="Unit_No" class="Unit_No" >
                            <option value=""></option>
                        </select>
                    </td>
                    <td><input type="text" name="Loc_No[]" id="Loc_No" class="Loc_No"></td>
                    <td><input type="number" min="1" name="Qty[]" id="Qty" class="Qty"></td>
                    <td><input type="number" min="1" name="Itm_Sal[]" id="Itm_Sal" class="Itm_Sal"></td>
                    <td><input type="text" name="" id="sum" class="sum"></td>
                    <td style="width: 11%;"><input type="text" name="Exp_Date[]" id="Exp_Date" class="Exp_Date" style="padding: 0; border-radius: 0"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text" class="last_td"></td>
                    <td><input type="text" class="last_td"></td>
                    <td><input type="text" class="last_td"></td>
                </tr>
                </tbody>
                <tfoot class="bg-primary" style="cursor: pointer">
{{--                <tr>--}}
{{--                    <td colspan="20" style="height: 40px; text-align: center"><i class="fa fa-plus"></i> <b>أضف</b></td>--}}
{{--                </tr>--}}
                </tfoot>
            </table>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">الإجمالي</label>
                    <input type="text" name="" id="" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">بعد الخصم</label>
                    <input type="text" name="" id="" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">خصم إضافي</label>
                    <input type="text" name="" id="" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">خصم أصناف</label>
                    <input type="text" name="" id="" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">قيمة الضريبة</label>
                    <input type="text" name="" id="" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">الصافي</label>
                    <input type="text" name="" id="" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">حد الائتمان</label>
                    <input type="text" name="" id="" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">الرصيد الحالي</label>
                    <input type="text" name="" id="" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">الفرق</label>
                    <input type="text" name="" id="" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">رصيد الصنف</label>
                    <input type="text" name="" id="" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">رصيد المستودعات</label>
                    <input type="text" name="" id="" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" style="display: flex">
                    <label for="">سعر البيع</label>
                    <input type="text" name="" id="" class="form-control">
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
