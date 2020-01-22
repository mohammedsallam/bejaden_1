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
                    }
                    else if(tableBody.children().length > 1){
                        count = parseInt($('.delete_row').parent('tr').siblings('tr:last-child').children('td:first-child').html());
                    }
                    $(this).parent('tr').remove();

                });

                $('tfoot').click(function () {

                    if(tableBody.children().length === 0){
                        count = 1;
                    }
                    else if(tableBody.children().length > 1){
                        count = parseInt($('.delete_row').parent('tr').siblings('tr:last-child').children('td:first-child').html())+1;
                    }

                    let row = `<tr>
                    <td class="delete_row bg-red">`+count+`</td>
                    <td style="width: 11%"><input type="text"></td>
                    <td style="width: 20%">
                        <select name="" >
                            <option value=""></option>
                        </select>
                    </td>
                    <td style="width: 9%">
                        <select name="" >
                            <option value=""></option>
                        </select>
                    </td>
                    <td><input type="text"></td>
                    <td><input type="number" min="1"></td>
                    <td><input type="number" min="1"></td>
                    <td><input type="text"></td>
                    <td style="width: 11%;"><input type="text" class="datepicker" style="padding: 0; border-radius: 0"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text" class="last_td"></td>
                </tr>`;

                    tableBody.append(row);
                    count +=1;

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
                    {{ Form::label('admin.Branches', trans('admin.Branches') , ['class' => 'control-label']) }}
                    <select name="Brn_No" id="Brn_No" class="form-control">
                        <option value="">{{trans('admin.select')}}</option>
                        @foreach($branches as $branch)
                            <option value="{{$branch->ID_No}}">{{$branch->{'Brn_Nm'.ucfirst(session('lang'))} }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="" class="control-label">مستودع</label>
                    <select name="Brn_No" id="Brn_No" class="form-control">
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
                    <label for="" class="control-label">ميلادي</label>
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
                    <label for="" class="control-label">طريقة الدفع</label>
                    <select name=""  class="form-control">
                        <option value="">{{trans('admin.select')}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="" class="control-label">نوع المرجع</label>
                    <select name=""  class="form-control">
                        <option value="">{{trans('admin.select')}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="" class="control-label">رقم المرجع</label>
                    <select name=""  class="form-control">
                        <option value="">{{trans('admin.select')}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="" class="control-label">العميل</label>
                    <select name=""  class="form-control">
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
                    <label for="" class="control-label">مبيعات مكتب</label>
                    <select name=""  class="form-control">
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
                        <label for="" class="control-label">مدة السداد</label>
                        <input type="text" class="form-control" placeholder="يوم">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="">تاريخ السداد</label>
                    <input type="text" class="form-control datepicker" style="direction: rtl">
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
            </tr>
            <tbody class="table_body"></tbody>
            <tfoot class="bg-primary" style="cursor: pointer">
                <tr>
                    <td colspan="20" style="height: 40px; text-align: center"><i class="fa fa-plus"></i> <b>أضف</b></td>
                </tr>
            </tfoot>
        </table>

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
