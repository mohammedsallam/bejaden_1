<!DOCTYPE html>
<html>
<head>
    <title>glcc Report</title>
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
    .table td, .table th {
        padding: .5rem;
        vertical-align: middle;
        border: 1px solid #000000 !important;
        text-align:center;
    }
    .table .th-empty{
        border: none !important;
        background: none
    }
</style>

<body>
<div>
    <div style="float:right;font-weight:bold;width:50%">{{setting()->sitename_ar}}</div>
    <div style="float:left;font-weight:bold;width:50%;text-align:left">{{setting()->sitename_en}}</div>
</div>
<div style="text-align:center">
    <img src="{{asset('../storage/app/public/' . setting()->icon)}}" style="max-width:70px;margin:15px 0">
</div>

<div class="el-no3">
    <span>{{trans('admin.motion_detection')}} {{$ccname}}</span>
    {{--<span>{{$typeLimitationReceipts->name_ar}}</span>--}}
</div>

<div class="clearfix"></div>
<div class="el-date">

</div>


<div class="clearfix"></div>


{{--<div>--}}
    {{--<div style="float:right">رقم مركز التكلفة : </div>--}}
    {{--<div style="float:left">اسم مركز التكلفة : </div>--}}
{{--</div>--}}

<div class="hidden">{{ $i = 1 }}
    {{$balance = 0}}
    {{$dataDebtor = 0}}
    {{$dataCredit = 0}}
</div>
<div class="table-responsive">
    <table style="border:none" class="table table-bordered table-striped table-hover">
        <tr>
            <th rowspan="2">التاريخ</th>
            <th rowspan="2">القيد</th>
            <th rowspan="2">{{trans('admin.account_number')}}</th>
            <th rowspan="2">{{trans('admin.note_for')}}</th>
            <th colspan="2" style="vertical-align: middle;">الرصيد</th>
        </tr>

        <tr>
            <th>{{trans('admin.debtor')}}</th>
            <th>{{trans('admin.creditor')}}</th>
        </tr>


        <tr>
        </tr>
        {{--by level--}}
        @if($hastask || $hastask2)
            {{--{{dd($value_merged)}}--}}

            @foreach($value_merged as $merged)

                <tr>
                    <td>{{ date('Y-m-d',strtotime($merged->created_at)) }}</td>
                    <td>{{ $merged->limitations['limitationId'] }}
                        {{ $merged->receipts['receiptId'] }}</td>
                    <td>{{ $merged->departments->code }}</td>
                    <td>{{session_lang($merged->name_en,$merged->name_ar)}}</td>
                    <td>{{$merged->debtor}}
                        <div class="hidden">{{$dataDebtor += $merged->debtor}}</div>
                    </td>
                    <td>{{$merged->creditor}}
                    <div class="hidden">{{$dataCredit += $merged->creditor}}</div>
                    </td>
                </tr>

            @endforeach
            <tr>
                <th colspan="3" class="th-empty"></th>
                <th>{{trans('admin.Total_motion')}}</th>
                <th style="text-align: center">{{$dataDebtor}} </th>
                <th style="text-align: center">{{$dataCredit}} </th>
            </tr>
        @endif

    </table>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</body>
</html>
