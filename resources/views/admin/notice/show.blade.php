@extends('admin.index')
@section('title',trans('admin.catch_receipt'))
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

                    $.ajax({
                        url: "{{route('getCatchRecpt')}}",
                        type: "POST",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Cmp_No: $(this).val() },
                        success: function(data){
                            $('#rcpt_content').html(data);
                        }
                    });
                });
            });
        </script>
    @endpush
    {{-- header start --}}
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
                <label for="Tr_Dt">{{trans('admin.receipt_date')}}</label>
                <input type="text" name="Tr_Dt" id="Tr_Dt" class="form-control" disabled>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="Tr_DtAr">{{trans('admin.higri_date')}}</label>
                <input type="text" name="Tr_DtAr" id="Tr_DtAr" class="form-control" disabled>
            </div>
        </div>
        {{-- نهاية تاريخ القيد --}}
    </div>
    <div class="row">
        {{-- نوع السند نقدى \ شيك --}}
        <div class="col-md-1">
            <label for="Doc_Type">{{trans('admin.receipts_type')}}</label>
            <select name="Doc_Type" id="Doc_Type" class="form-control" disabled>
                @foreach(App\Enums\PayType::toSelectArray() as $key => $value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
        {{-- نهاية نوع السند نقدى \ شيك --}}
        {{-- العمله --}}
        <div class="col-md-2">
            <label for="Tr_Crncy">{{trans('admin.currency')}}</label>
            <select name="Tr_Crncy" id="Tr_Crncy" class="form-control" disabled>
                @foreach(App\Enums\CurrencyType::toSelectArray() as $key => $value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
        {{-- نهاية العمله --}}
        {{-- سعر الصرف --}}
        <div class="col-md-1">
            <label for="Tr_ExchRat">{{trans('admin.exchange_rate')}}</label>
            <input type="text" name="Tr_ExchRat" id="Tr_ExchRat" class="form-control" disabled>
        </div>
        {{-- نهاية سعر الصرف --}}
        {{-- المبلغ المطلوب --}}
        <div class="col-md-2">
            <label for="Tot_Amunt">{{trans('admin.amount')}}</label>
            <input type="text" name="Tot_Amunt" id="Tot_Amunt" class="form-control" disabled>
        </div>
        {{-- نهاية المبلغ المطلوب --}}
        {{-- الضريبه --}}
        <div class="col-md-1">
            <input type="checkbox" id="Tr_TaxVal_check">
            <label for="Tr_TaxVal">{{trans('admin.tax')}} %</label>
            <input type="text" name="Tr_TaxVal" id="Tr_TaxVal" class="form-control" disabled>
        </div>
        {{-- نهاية الضريبه --}}
        {{-- مقبوض بواسطة --}}
        <div class="col-md-2">
            <label for="Rcpt_By">{{trans('admin.Rcpt_By')}}</label>
            <input type="text" name="Rcpt_By" id="Rcpt_By" class="form-control" disabled>
        </div>
        {{-- نهاية مقبوض بواسطة --}}
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
    {{-- header end --}}
    <div class="row">
        <div class="col-md-12" id="rcpt_content">
            <table class="table table-striped" style=" display: block;  overflow-x: auto; white-space: nowrap;">
                <thead>
                <tr>
                    <th>{{trans('admin.id')}}</th>
                    <th>{{trans('admin.account_number')}}</th>
                    <th>{{trans('admin.account_name')}}</th>
                    <th>{{trans('admin.amount_debtor')}}</th>
                    <th>{{trans('admin.amount_creditor')}}</th>
                    <th>{{trans('admin.note_ar')}}</th>
                    <th>{{trans('admin.single_cc')}}</th>
                    <th>{{trans('admin.Tr_Ds1')}}</th>
                    <th>{{trans('admin.amount_paied_from_start')}}</th>
                    <th>{{trans('admin.revision_cost')}}</th>
                    <th>{{trans('admin.currency_debt')}}</th>
                    <th>{{trans('admin.currency_credit')}}</th>
                    <th>{{trans('admin.currency_cost')}}</th>
                    <th>{{trans('admin.currency')}}</th>
                    <th>{{trans('admin.cheq_status')}}</th>
                    <th>{{trans('admin.check_number')}}</th>
                    <th>{{trans('admin.Payment_date')}}</th>
                    <th>{{trans('admin.Bnk_Nm')}}</th>
                    <th>{{trans('admin.first_analysis')}}</th>
                    <th>{{trans('admin.second_analysis')}}</th>
                    <th>{{trans('admin.View')}}</th>
                    <th>{{trans('admin.print')}}</th>
                    <th>{{trans('admin.edit')}}</th>
                    {{-- <th>{{trans('admin.delete')}}</th> --}}
                </tr>
                </thead>
                <tbody>
                @if(count($gls) > 0)
                    @foreach($gls as $gl)
                        <tr>
                            <td>{{$gl->Tr_No}}</td>
                            <td>
                                @if($gl->Cstm_No) {{$gl->Cstm_No}} @endif
                                @if($gl->Sup_No) {{$gl->Sup_No}} @endif
                                @if($gl->Emp_No) {{$gl->Emp_No}} @endif
                                @if($gl->Chrt_No) {{$gl->Chrt_No}} @endif
                            </td>
                            <td>
                                @if($gl->Cstm_No)
                                    {{\App\Models\Admin\MTsCustomer::where('Cstm_No', $gl->Cstm_No)->pluck('Cstm_Nm'.ucfirst(session('lang')))->first()}}
                                @endif
                                @if($gl->Sup_No)
                                    {{\App\Models\Admin\MtsSuplir::where('Sup_No', $gl->Sup_No)->pluck('Sup_Nm'.ucfirst(session('lang')))->first()}}
                                @endif
                                @if($gl->Emp_No)
                                    {{\App\Models\Admin\MTsCustomer::where('Cstm_No', $gl->Cstm_No)->pluck('Cstm_Nm'.ucfirst(session('lang')))->first()}}
                                @endif
                                @if($gl->Chrt_No)
                                    {{\App\Models\Admin\MtsChartAc::where('Acc_No', $gl->Acc_No)->pluck('Acc_Nm'.ucfirst(session('lang')))->first()}}
                                @endif
                            </td>
                            <td>{{$gl->Tr_Db}}</td>
                            <td>{{$gl->Tr_Cr}}</td>
                            <td>{{$gl->Tr_Ds}}</td>
                            <td>{{\App\Models\Admin\GLjrnTrs::where('Tr_No', $gl->Tr_No)->pluck('Costcntr_No')->first()}}</td>
                            <td>{{$gl->Tr_Ds1}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{$gl->Tr_ExchRat}}</td>
                            <td>{{$gl->Tr_Crncy}}</td>
                            <td></td>
                            <td>{{$gl->Chq_no}}</td>
                            <td>{{$gl->Issue_Dt}}</td>
                            <td>{{$gl->Bnk_Nm}}</td>
                            <td></td>
                            <td></td>
                            <td>
                                <a href="{{route('rcatchs.show', $gl->Tr_No)}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                            </td>
                            <td>
                                <a href="../../receipts/print/{{$gl->Tr_No}}" class="btn btn-info"><i class="fa fa-print"></i></a>
                            </td>
                            <td>
                                <a href="{{route('rcatchs.edit', $gl->Tr_No)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                            </td>
                            {{-- <td>
                                <form action="{{route('rcatchs.destroy', $gl->Tr_No)}}" method="POST">
                                    {{csrf_field()}}
                                    {{method_field('DELETE')}}
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </td> --}}
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <div>
        {{$gls->links()}}
    </div>
@endsection
