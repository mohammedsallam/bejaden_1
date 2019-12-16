@extends('admin.index')
@section('title',trans('admin.accbanks'))
@section('content')
    <form action="{{route('accbanks.store')}}" method="POST">
        {{ csrf_field() }}
        <div class="panel panel-primary" style="width:50%; margin:auto auto;    ">
            <div class="panel-heading">
                <div class="panel-title">
                    {{trans('admin.accbanks')}}
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <label for="Acc_No" class="col-md-2">{{trans('admin.account_number')}}</label>
                    <input type="text" name="Acc_No" id="Acc_No" class="form-control col-md-3">
                    <select name="Acc_No_Select" id="Acc_No_Select" class="form-control col-md-6">
                        <option value="{{null}}">{{trans('admin.select')}}</option>
                        @if(count($charts) > 0)
                            @foreach($charts as $ch)    
                                <option value="{{$ch->Acc_No}}">{{$ch->{'Acc_Nm'.ucfirst(session('lang'))} }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="row">
                    <br>
                    <label for="Acc_NmAr" class="col-md-2">{{trans('admin.account_name')}}</label>
                    <input type="text" name="Acc_NmAr" id="Acc_NmAr" class="form-control col-md-9">
                </div>
                <div class="row">
                    <br>
                    <label for="Acc_NmEn" class="col-md-2">{{trans('admin.subscriber_name_en')}}</label>
                    <input type="text" name="Acc_NmEn" id="Acc_NmEn" class="form-control col-md-9">
                </div>
            </div>
        </div>
    </form>
@endsection