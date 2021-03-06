<!DOCTYPE html>
<html>
<head>
    <title></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
</head>
<style>
    body {
        font-family: 'dejavu sans', sans-serif;
        direction:rtl;
        text-align:right;
        padding:0;
        margin: 0;
    }
    .el-date{
        float: right;
        width: 40%
    }
    .el-date p{
        font-size: 12px;
        margin: 0 20px -25px;
        padding: 15px 0;
    }
    .el-no3{
        width:100%;
        display:block;
        margin:0 auto;
        text-align:center;
    }
    .el-no3 span{
        padding: 5px 20px !important;
        font-weight: bold;
        font-size: 12px;
    }
    .clearfix{
        clear:both;
    }
    table{
        width: 100%;
        text-align: center;
        font-size: 10px;
        margin-top: 20px;
    }
    .table th{
        background-color: #f3f3f3;
        text-align: center;
        font-size: 11px;
    }
    .table td{
        text-align: right;
    }
    table td, table th {
        padding: .5rem;
        vertical-align: middle;
        border: 1px solid #000000 !important;
    }
    table .th-empty{
        border: none !important;
        background: none
    }
</style>
<body>
<div style="display: none">
    {{$allCredit = 0}}
    {{$allDebtor = 0}}</div>
<div>
    <div style="float:right;font-weight:bold;width:50%">{{setting()->sitename_ar}}</div>
    <div style="float:left;font-weight:bold;width:50%;text-align:left">{{setting()->sitename_en}}</div>
</div>
<div style="text-align:center">
    <img src="{{asset('storage/'. setting()->icon)}}" style="max-width:70px;margin:15px 0">
</div>

<div class="el-no3">
    <span>{{trans('admin.trial_balance')}}</span>
</div>

<div class="clearfix"></div>
<div class="el-date">
    <p>من تاريخ : {{$From}}</p>
    <p>الى تاريخ : {{$to}}</p>
</div>


<div class="clearfix"></div>
<div class="table-responsive">
    <table style="border: none" class="table table-bordered table-striped table-hover text-center">
        <tr>
            <th colspan="2">{{trans('admin.account_name')}}</th>
            <th colspan="2">{{trans('admin.first_date')}}</th>
            <th colspan="2">{{trans('admin.motion')}}</th>
            <th colspan="2">{{trans('admin.last_date')}}</th>
        </tr>
        <tr>
            <th>{{trans('admin.number_account')}}</th>
            <th>{{trans('admin.description')}}</th>
            <th>{{trans('admin.debtor')}}</th>
            <th>{{trans('admin.creditor')}}</th>
            <th>{{trans('admin.debtor')}}</th>
            <th>{{trans('admin.creditor')}}</th>
            <th>{{trans('admin.debtor')}}</th>
            <th>{{trans('admin.creditor')}}</th>
        </tr>
        <div style="display: none">{{ $i = 1 }}
            {{$balance = 0}}
            {{$sum = 0}}
            {{$dataDebtor = 0}}
            {{$dataCredit = 0}}
            {{$dataDebtor1 = 0}}
            {{$dataDebtor3  = 0}}
            {{$dataCredit1 = 0}}
            {{$dataDebtor2 = 0}}
            {{$dataCredit2 = 0}}
        </div>
        @foreach($data as $merged)
{{--            @dd($data)--}}
            <tr>
                <td>
                    {{$merged->Acc_No}}
                </td>
                <td>
                    {{session_lang($merged->Acc_NmEn,$merged->Acc_NmAr)}}
                    {{-- {{App\Models\Admin\MTsCustomer::where('Cstm_No',$merged->Sysub_Account)->pluck('Cstm_Nm'. ucfirst(session('lang')))->first()}}--}}
                </td>
                <td>
                    <div style="display:none">
                        {{ $debtor = $merged->Fbal_DB +
                        FbalanceCust($merged->Cmp_No,$merged->Sysub_Account,$From,$to,'Tr_Db','<') }}

                        {{ $creditor =  $merged->Fbal_CR  +
                         FbalanceCust($merged->Cmp_No,$merged->Sysub_Account,$From,$to,'Tr_Cr','<')}}
                        @if(($debtor - $creditor) > 0)
                            {{ $dataDebtor += $debtor - $creditor}}
                        @else
                            {{$dataDebtor += 0}}
                        @endif
                    </div>


                    @if(($debtor - $creditor) > 0)
                        {{ $value_debtor = $debtor - $creditor}}
                    @else
                        {{$value_debtor = 0}}
                    @endif
                </td>
                <td>
                    <div style="display:none">
                        {{ $debtor1 = $merged->Fbal_DB +
                        FbalanceCust($merged->Cmp_No,$merged->Sysub_Account,$From,$to,'Tr_Db','<')  }}

                        {{ $creditor1 =  $merged->Fbal_CR  +
                         FbalanceCust($merged->Cmp_No,$merged->Sysub_Account,$From,$to,'Tr_Cr','<')}}


                        @if(($creditor1 - $debtor1) > 0)
                            {{ $dataCredit +=  $creditor1 - $debtor1}}
                        @else
                            {{$dataCredit += 0}}
                        @endif


                    </div>

                    @if(( $creditor1 -$debtor1) > 0)
                        {{ $value_creditor =  $creditor1-  $debtor1 }}
                    @else
                        {{$value_creditor = 0}}
                    @endif

                </td>
                <td>
                    {{$value_debtor2 = getTransCust($merged->Cmp_No,$merged->Acc_No,$From,$to,'Tr_Db','>=')}}
                    <div style="display:none">
                        {{$dataDebtor1 += getTransCust($merged->Cmp_No,$merged->Acc_No,$From,$to,'Tr_Db','>=')}}
                    </div>
                </td>
                <td>
                    {{$value_creditor2 =getTransCust($merged->Cmp_No,$merged->Acc_No,$From,$to,'Tr_Cr','>=')}}
                    <div style="display:none">
                        {{$dataCredit1 += getTransCust($merged->Cmp_No,$merged->Acc_No,$From,$to,'Tr_Cr','>=')}}
                    </div>
                </td>
                <td>
                    @if(($value_debtor2 + $value_debtor) - ($value_creditor2 + $value_creditor) > 0)
                        {{($value_debtor2 + $value_debtor) - ($value_creditor2 + $value_creditor)}}
                    @else
                        0
                    @endif

                    <div style="display:none">
                        @if(($value_debtor2 + $value_debtor) - ($value_creditor + $value_creditor2) > 0)
                            {{$dataDebtor2 += ($value_debtor2 + $value_debtor) - ($value_creditor + $value_creditor2)}}
                        @else
                            {{$dataDebtor2 += 0}}
                        @endif
                    </div>
                </td>
                <td>
                    @if(($value_creditor2 + $value_creditor) - ($value_debtor + $value_debtor2) > 0)
                        {{($value_creditor2 + $value_creditor) - ($value_debtor + $value_debtor2)}}
                    @else
                        0
                    @endif
                    <div style="display:none">
                        @if(($value_creditor2 + $value_creditor) - ($value_debtor + $value_debtor2) > 0)
                            {{$dataCredit2 += ($value_creditor2 + $value_creditor) - ($value_debtor + $value_debtor2)}}
                        @else
                            {{$dataCredit2 += 0}}
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach

        <tr>
            <th class="th-empty"></th>
            <th>{{trans('admin.Total_motion')}}</th>
            <th>{{$dataDebtor}} </th>
            <th>{{$dataCredit}} </th>
            <th>{{$dataDebtor1}} </th>
            <th>{{$dataCredit1}} </th>
            <th>{{$dataDebtor2}} </th>
            <th>{{$dataCredit2}} </th>
        </tr>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</body>
</html>
