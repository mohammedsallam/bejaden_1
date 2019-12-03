@extends('admin.index')
@section('title',trans('admin.edit_department'))
@section('content')
    @hasrole('writer')
    @push('js')
        <script>
            function calculatedept() {
                var creditor = $('input[name=\'creditor\']').val(),
                    debtor = $('input[name=\'debtor\']').val(),
                    minus = debtor - creditor;
                $('#subtract').text(minus);

            }
        </script>
    @endpush
    <div class="box">
        @include('admin.layouts.message')
        <div class="box-header">
            <h3 class="box-title">{{$title}}</h3>
        </div>
        <div class="box-body">
            {!! Form::model($cc,['method'=>'PUT','route' => ['cc.update',$cc->id]]) !!}
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group row">
                        <div class="col-md-6">
                            {{ Form::label(trans('admin.arabic_name'), null, ['class' => 'control-label']) }}
                            {{ Form::text('name_ar', $cc->name_ar, array_merge(['class' => 'form-control'])) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label(trans('admin.english_name'), null, ['class' => 'control-label']) }}
                            {{ Form::text('name_en', $cc->name_en, array_merge(['class' => 'form-control'])) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(trans('admin.description'), null, ['class' => 'control-label']) }}
                        {{ Form::text('description',$cc->description, array_merge(['class' => 'form-control'])) }}
                    </div>
                    <div class="hidden">
                        {{$balance = 0}}
                        {{$dataDebtor = 0}}
                        {{$dataCredit = 0}}
                        {{$balance1 = 0}}
                        {{$balance2 = 0}}
                        {{$balance3 = 0}}
                        {{$balance4 = 0}}
                        {{$balance5 = 0}}
                        {{$estimated = null}}
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <tr>
                                <th>الشهر</th>
                                <th>الحركه دائن</th>
                                <th>الحركه مدين</th>
                                <th>رصيد حالي</th>
                                <th>رصيد تقديري</th>
                                @for($date = \Carbon\Carbon::today()->format('Y')-1;$date > \Carbon\Carbon::today()->format('Y')-6;$date--)
                                    <th>رصيد {{$date}}</th>
                                @endfor
                            </tr>
                            @for($i = 1;$i < 13;$i++)
                                <tr>
                                    <td>{{\App\Enums\dataLinks\MonthType::getDescription($i)}}</td>
                                    <td>
                                        @if($cc->type == '0')
                                            {{ $creditor= sumallcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.\Carbon\Carbon::today()->format('Y')) ) , date("Y-m-t", strtotime('1-'.$i.'-'.\Carbon\Carbon::today()->format('Y')) ) ,'creditor','>=')}}
                                        @else

                                            {{$creditor =allcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.\Carbon\Carbon::today()->format('Y')) ) , date("Y-m-t", strtotime('1-'.$i.'-'.\Carbon\Carbon::today()->format('Y')) ) ,'creditor','>=')}}

                                        @endif
                                        <div class="hidden">{{$dataCredit += $creditor}}</div>

{{--                                        {{getpjitmmsflcc($cc->id,$i,\Carbon\Carbon::today()->format('Y'))['creditor']}}--}}
{{--                                        <div class="hidden">{{$dataCredit += getpjitmmsflcc($cc->id,$i,\Carbon\Carbon::today()->format('Y'))['creditor']}}</div>--}}

                                    </td>
                                    <td>

                                        @if($cc->type== '0')
                                        {{$debtor = sumallcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.\Carbon\Carbon::today()->format('Y')) ) , date("Y-m-t", strtotime('1-'.$i.'-'.\Carbon\Carbon::today()->format('Y')) ) ,'debtor','>=')}}

                                        @else

                                            {{$debtor = allcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.\Carbon\Carbon::today()->format('Y')) ) , date("Y-m-t", strtotime('1-'.$i.'-'.\Carbon\Carbon::today()->format('Y')) ) ,'debtor','>=')}}

                                        @endif
                                        <div class="hidden">{{$dataDebtor += $debtor}}</div>
{{--                                        {{getpjitmmsflcc($cc->id,$i,\Carbon\Carbon::today()->format('Y'))['debtor']}}--}}
{{--                                        <div class="hidden">{{$dataDebtor += getpjitmmsflcc($cc->id,$i,\Carbon\Carbon::today()->format('Y'))['debtor']}}</div>--}}

                                    </td>

                                    <td>
                                        {{ $creditor -$debtor }}
                                        <div class="hidden">  {{$balance +=$creditor -$debtor }}</div>
{{--                                        {{getpjitmmsflcc($cc->id,$i,\Carbon\Carbon::today()->format('Y'))['current_balance']}}--}}
{{--                                        <div class="hidden">{{$balance += getpjitmmsflcc($cc->id,$i,\Carbon\Carbon::today()->format('Y'))['current_balance']}}</div>--}}
                                    </td>
                                    <td>
{{--                                        {{getpjitmmsflcc($cc->id,$i,\Carbon\Carbon::today()->format('Y'))['estimated_balance']}}--}}
{{--                                        <div class="hidden">{{$estimated += getpjitmmsflcc($cc->id,$i,\Carbon\Carbon::today()->format('Y'))['estimated_balance']}}</div>--}}
                                    </td>

                                    <td>

                                        <?php
                                        $lastyear = \Carbon\Carbon::today()->format('Y')-1;
                                        ?>

                                        <div class="hidden">
                                            @if($cc->type== '0')
                                                {{ $creditor8= sumallcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear)) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear)) ,'creditor','>=')}}

                                            @else

                                                {{$creditor8 =allcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear)) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear)) ,'creditor','>=')}}

                                            @endif
                                            @if($cc->type==  '0')
                                                {{$debtor8 = sumallcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear)) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear) ) ,'debtor','>=')}}

                                            @else

                                                {{$debtor8 = allcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear)) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear) ) ,'debtor','>=')}}

                                            @endif

                                        </div>
                                            <div class="hidden">
                                                {{$balance1 +=$creditor8 - $debtor8}}
                                            </div>
                                            {{$creditor8 - $debtor8}}

{{--                                        {{getpjitmmsflcc($cc->id,$i,\Carbon\Carbon::today()->format('Y')-1)['current_balance']}}--}}
{{--                                        <div class="hidden">{{$balance1 += getpjitmmsflcc($cc->id,$i,\Carbon\Carbon::today()->format('Y')-1)['current_balance']}}</div>--}}
                                    </td>
                                    <td>
                                        <?php
                                        $lastyear2 = \Carbon\Carbon::today()->format('Y')-2;
                                        ?>

                                        <div class="hidden">
                                            @if($cc->type== '0')
                                                {{ $creditor7= sumallcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear2) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear2)) ,'creditor','>=')}}
                                            @else

                                                {{$creditor7 =allcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear2) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear2)) ,'creditor','>=')}}

                                            @endif
                                            @if($cc->type==  '0')
                                                {{$debtor7 = sumallcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear2) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear2) ) ,'debtor','>=')}}

                                            @else

                                                {{$debtor7 = allcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear2) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear2) ) ,'debtor','>=')}}

                                            @endif

                                        </div>
                                        <div class="hidden">  {{$balance2 += $creditor7 - $debtor7}}</div>
                                        <div>  {{$creditor7 - $debtor7}}</div>

{{--                                        {{getpjitmmsflcc($cc->id,$i,\Carbon\Carbon::today()->format('Y')-2)['current_balance']}}--}}
{{--                                        <div class="hidden">{{$balance2 += getpjitmmsflcc($cc->id,$i,\Carbon\Carbon::today()->format('Y')-2)['current_balance']}}</div>--}}

                                    </td>
                                    <td>
                                        <?php
                                        $lastyear3 = \Carbon\Carbon::today()->format('Y')-3;
                                        ?>

                                        <div class="hidden">
                                            @if($cc->type== '0')
                                                {{ $creditor6= sumallcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear3) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear3)) ,'creditor','>=')}}
                                            @else

                                                {{$creditor6 =allcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear3) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear3)) ,'creditor','>=')}}

                                            @endif
                                            @if($cc->type==  '0')
                                                {{$debtor6 = sumallcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear3) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear3) ) ,'debtor','>=')}}

                                            @else

                                                {{$debtor6 = allcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear3) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear3) ) ,'debtor','>=')}}

                                            @endif

                                        </div>
                                        <div class='hidden'> {{ $balance3 +=$creditor6 - $debtor6}}</div>

                                        <div>  {{$creditor6 - $debtor6}}</div>


                                        {{--                                        {{getpjitmmsflcc($cc->id,$i,\Carbon\Carbon::today()->format('Y')-3)['current_balance']}}--}}
{{--                                        <div class="hidden">{{$balance3 += getpjitmmsflcc($cc->id,$i,\Carbon\Carbon::today()->format('Y')-3)['current_balance']}}</div>--}}

                                    </td>

                                    <td>
                                        <?php
                                        $lastyear4 = \Carbon\Carbon::today()->format('Y')-4;
                                        ?>

                                        <div class="hidden">
                                            @if($cc->type== '0')
                                                {{ $creditor5= sumallcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear4) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear4)) ,'creditor','>=')}}
                                            @else

                                                {{$creditor5 =allcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear4) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear4)) ,'creditor','>=')}}

                                            @endif
                                            @if($cc->type==  '0')
                                                {{$debtor5 = sumallcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear4) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear4)),'debtor','>=')}}

                                            @else

                                                {{$debtor5 = allcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear4) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear4)),'debtor','>=')}}

                                            @endif

                                        </div>
                                        <div class='hidden'>  {{ $balance4 +=$creditor5- $debtor5}}</div>

                                        <div>  {{$creditor5- $debtor5}}</div>
{{--                                        {{getpjitmmsflcc($cc->id,$i,\Carbon\Carbon::today()->format('Y')-4)['current_balance']}}--}}
{{--                                        <div class="hidden">{{$balance4 += getpjitmmsflcc($cc->id,$i,\Carbon\Carbon::today()->format('Y')-4)['current_balance']}}</div>--}}

                                    </td>

                                    <td>

                                        <?php
                                        $lastyear4 = \Carbon\Carbon::today()->format('Y')-5;
                                        ?>

                                        <div class="hidden">
                                            @if($cc->type== '0')
                                                {{ $creditor5= sumallcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear4)) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear4)) ,'creditor','>=')}}
                                            @else

                                                {{$creditor5 =allcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear4)) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear4)) ,'creditor','>=')}}

                                            @endif
                                            @if($cc->type==  '0')
                                                {{$debtor5 = sumallcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear4)) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear4) ) ,'debtor','>=')}}

                                            @else

                                                {{$debtor5 = allcc($cc->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear4)) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear4) ) ,'debtor','>=')}}

                                            @endif

                                        </div>

                                        <div class='hidden'>  {{ $balance5 +=$creditor5- $debtor5}}</div>
                                        <div>  {{$creditor5- $debtor5}}</div>
{{--                                        {{getpjitmmsflcc($cc->id,$i,\Carbon\Carbon::today()->format('Y')-5)['current_balance']}}--}}
{{--                                        <div class="hidden">{{$balance5 += getpjitmmsflcc($cc->id,$i,\Carbon\Carbon::today()->format('Y')-5)['current_balance']}}</div>--}}
                                    </td>
                                </tr>
                            @endfor
                            <tr>
                                <td>الاجمالي</td>
                                <td>{{$dataCredit}}</td>
                                <td>{{$dataDebtor}}</td>
                                <td>{{$balance}}</td>
                                <td>{{$estimated}}</td>
                                <td>{{$balance1}}</td>
                                <td>{{$balance2}}</td>
                                <td>{{$balance3}}</td>
                                <td>{{$balance4}}</td>
                                <td>{{$balance5}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('type', trans('admin.type'), ['class' => 'control-label']) }}
                        {{ Form::select('type', \App\Enums\dataLinks\TypeAccountType::toSelectArray(),$cc->type, array_merge(['class' => 'form-control','placeholder'=>trans('admin.select'),'disabled'=>'disabled'])) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('creditor', trans('admin.first_date_creditor'), ['class' => 'control-label']) }}
                        {{ Form::text('creditor',$dataCredit, array_merge(['class' => 'form-control','disabled'=>'disabled'])) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('debtor', trans('admin.first_date_debtor'), ['class' => 'control-label']) }}
                        {{ Form::text('debtor',$dataDebtor, array_merge(['class' => 'form-control','disabled'=>'disabled'])) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('estimite', trans('admin.credit_balance'), ['class' => 'control-label']) }}
                        {{ Form::text('estimite',0, array_merge(['class' => 'form-control','disabled'=>'disabled'])) }}
                    </div>
                </div>
            </div>
            {{Form::submit(trans('admin.save'),['class'=>'btn btn-primary'])}}
            <a href="{{aurl('cc')}}" class="btn btn-danger">{{trans('admin.back')}}</a>
            {!! Form::close() !!}
        </div>
    </div>
    @else
        <div class="alert alert-danger">{{trans('admin.you_cannt_see_invoice_because_you_dont_have_role_to_access')}}</div>

        @endhasrole
@endsection
