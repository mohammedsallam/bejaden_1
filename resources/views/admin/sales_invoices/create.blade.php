@extends('admin.index')
@section('title', trans('admin.delay_bill'))
@section('content')
    @push('css')
        <style>
            .datepicker{
                direction: rtl;
            }
        </style>
    @endpush

    @push('js')
        <script>

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
                <input type="text" name="" class="form-control" id="">
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
                <input type="text" name="Doc_DtAr"  class="form-control Doc_DtAr" id="Doc_DtAr">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="">مستند</label>
                <input type="text" name="Doc_DtAr"  class="form-control" id="Doc_DtAr">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="" class="control-label">طريقة الدفع</label>
                <select name="" id="" class="form-control">
                    <option value="">{{trans('admin.select')}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="" class="control-label">نوع المرجع</label>
                <select name="" id="" class="form-control">
                    <option value="">{{trans('admin.select')}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="" class="control-label">رقم المرجع</label>
                <select name="" id="" class="form-control">
                    <option value="">{{trans('admin.select')}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="" class="control-label">العميل</label>
                <select name="" id="" class="form-control">
                    <option value="">{{trans('admin.select')}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="">رقم</label>
                <input type="text" name="Doc_DtAr" class="form-control" id="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="" class="control-label">مبيعات مكتب</label>
                <select name="" id="" class="form-control">
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
                <input name="" class="form-control" id="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">ملاحظات1</label>
                <input name="" class="form-control" id="">
            </div>
        </div>



{{--        {{Form::submit(trans('admin.create'),['class'=>'btn btn-primary'])}}--}}
{{--        {!! Form::close() !!}--}}
    </div>
</div>
    @endcan
@else
    <div class="alert alert-danger">{{trans('admin.you_cannt_see_invoice_because_you_dont_have_role_to_access')}}</div>

    @endhasrole







@endsection
