@extends('admin.index')
@section('title',trans('admin.invoices'))
@section('content')
@push('js')
@endpush
<div class="row" style="text-align:center">
    <h2>{{trans('admin.RcpCsh_Voucher')}}</h2>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-1">
        <h3>
            <i class="fa fa-globe"></i>
            {{trans('admin.Inc')}} {{ $cmp->{'Cmp_Nm'.ucfirst(session('lang'))} }} 
            {{trans('admin.No_of_license')}} {{$cmp->License_No}} {{ $brn->{'Brn_Nm'.ucfirst(session('lang'))} }}
        </h3>
    </div>
    <div class="col-md-3 pull-left">
        <small>{{trans('admin.date')}}: {{$gl->Entr_Dt}}</small>
        <img src="{{asset('storage/companies/logo.png')}}" style="max-width:100px;margin:15px 0">
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{trans('admin.From')}}</th>
                            <th>{{trans('admin.To')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                @if($gl->Cstm_No)
                                    <strong>
                                        {{\App\Models\Admin\MTsCustomer::where('Cstm_No', $gl->Cstm_No)->pluck('Cstm_Nm'.ucfirst(session('lang')))->first()}}
                                    </strong>
                                @endif
                                @if($gl->Sup_No)
                                    <strong>
                                        {{\App\Models\Admin\MtsSuplir::where('Sup_No', $gl->Sup_No)->pluck('Sup_Nm'.ucfirst(session('lang')))->first()}}
                                    </strong>
                                @endif
                                @if($gl->Emp_No)
                                    <strong>
                                        {{\App\Models\Admin\MTsCustomer::where('Cstm_No', $gl->Cstm_No)->pluck('Cstm_Nm'.ucfirst(session('lang')))->first()}}
                                    </strong>
                                @endif
                                @if($gl->Chrt_No)
                                    <strong>
                                        {{\App\Models\Admin\MtsChartAc::where('Acc_No', $gl->Acc_No)->pluck('Acc_Nm'.ucfirst(session('lang')))->first()}}
                                    </strong>
                                @endif
                            </td>
                            <td><strong>{{$debt}}</strong></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table">
                    <thead>
                        <tr>
                            <th>{{trans('admin.account_name')}}</th>
                            <th>{{trans('admin.motion_debtor')}}</th>
                            <th>{{trans('admin.motion_creditor')}}</th>
                            <th>{{trans('admin.note_for')}}</th>
                            <th>{{trans('admin.amount')}}</th>
                            {{-- <th>{{trans('admin.Add_or_subtract')}}</th> --}}
                            <th>{{trans('admin.receipt_total')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @if(count($gltrns) > 0)
                                @foreach($gltrns as $trns)
                                    <tr>
                                        @if($trns->Sysub_Account != 0)
                                            <td>
                                                @if($gl->Cstm_No)
                                                    {{\App\Models\Admin\MTsCustomer::where('Cstm_No', $trns->Sysub_Account)->pluck('Cstm_Nm'.ucfirst(session('lang')))->first()}}
                                                @endif
                                                @if($gl->Sup_No)
                                                    {{\App\Models\Admin\MtsSuplir::where('Sup_No', $trns->Sysub_Account)->pluck('Sup_Nm'.ucfirst(session('lang')))->first()}}
                                                @endif
                                                @if($gl->Emp_No)
                                                    {{\App\Models\Admin\MTsCustomer::where('Cstm_No', $trns->Sysub_Account)->pluck('Cstm_Nm'.ucfirst(session('lang')))->first()}}
                                                @endif
                                                @if($gl->Chrt_No)
                                                    {{\App\Models\Admin\MtsChartAc::where('Acc_No', $trns->Sysub_Account)->pluck('Acc_Nm'.ucfirst(session('lang')))->first()}}
                                                @endif
                                            </td>
                                            <td>
                                                {{$trns->Tr_Db}}
                                            </td>
                                            <td>
                                                {{$trns->Tr_Cr}}
                                            </td>
                                            <td>
                                                {{$trns->Tr_Ds}}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    {{$gl->Tot_Amunt}}
                                </td>
                                <td>
                                    {{$gl->Tr_Db}}
                                </td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel-body">
                <strong>{{trans('admin.number')}}{{$gl->Tr_No}}</strong> <br><br>
                <strong>{{trans('admin.Payment_date')}}: </strong>{{$gl->Issue_Dt == '0000-00-00 00:00:00' ? $gl->Entr_Dt : $gl->Issue_Dt}} <br><br>
                <strong>{{trans('admin.assigned_by')}}: </strong> {{\Auth::user()->name }} 
                <br><br><br><br><br>
                <div class="col-md-6">
                    <strong>{{trans('admin.Total')}}:</strong><br><br>
                    <strong>{{trans('admin.payments')}}:</strong><br><br>
                    <strong>{{trans('admin.subtract')}}:</strong><br><br>
                </div>
                <div class="col-md-6">
                    <div>{{$gl->Tr_Db}}</div><br>
                    <div>{{trans('admin.payments')}}</div><br>
                    <div>{{$gl->Tr_Db - $gl->Tr_Cr}}</div><br>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" style="text-align:center;">
    <a href="{{route('printCatchRecpt',$gl->Tr_No)}}" class="btn btn-primary" style="width:90px; height:60px;">
        <i class="fa fa-print" style="font-size:40px;"></i>
    </a>
</div>
@endsection