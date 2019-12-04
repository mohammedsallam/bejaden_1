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
            {!! Form::model($department,['method'=>'PUT','route' => ['departments.update',$department->id]]) !!}
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group row">
                        <div class="col-md-6">
                            {{ Form::label(trans('admin.arabic_name'), null, ['class' => 'control-label']) }}
                            {{ Form::text('dep_name_ar',$department->dep_name_ar , array_merge(['class' => 'form-control'])) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label(trans('admin.english_name'), null, ['class' => 'control-label']) }}
                            {{ Form::text('dep_name_en', $department->dep_name_en , array_merge(['class' => 'form-control'])) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            {{ Form::label('نوع الحساب', null, ['class' => 'control-label']) }}
                            {{ Form::select('operation_id',  $operations,$department->operation_id, array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                        </div>
                        <div class="col-md-4">
                            {{ Form::label('التصنيف بالحسابات الختاميه', null, ['class' => 'control-label']) }}
                            {{ Form::select('budget', \App\Enums\dataLinks\IncomeListType::toSelectArray(),$department->budget, array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                        </div>
                        <div class="col-md-4">
                            @if($department->type == 0)
                                <div style="padding-top: 30px">
                                    {{ Form::label('cc_type',trans('admin.with_cc') , ['class' => 'control-label']) }}
                                    {{ Form::checkbox('cc_type', 1,$department->cc_type,['disabled']) }}
                                </div>
                            @else
                                <div style="padding-top: 30px">
                                    {{ Form::label('cc_type',trans('admin.with_cc') , ['class' => 'control-label']) }}
                                    {{ Form::checkbox('cc_type', 1,$department->cc_type) }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="hidden">
                        {{$balance = 0}}
                        {{$dataDebtor = 0}}
                        {{$dataCredit = 0}}
                        {{$allcreditor = 0}}
                        {{$alldebtor = 0}}
                        {{$balance1 = 0}}
                        {{$balance2 = 0}}
                        {{$balance3 = 0}}
                        {{$balance4 = 0}}
                        {{$balance5 = 0}}
                        {{$estimated = null}}
                        {{$balance5  = 0}}
                        {{$balance6 = 0}}
                        {{$balance7 = 0}}
                        {{$balance8 = 0}}

                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <tr>
                                <th>الشهر</th>
                                <th>الحركه مدين</th>
                                <th>الحركه دائن</th>

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



                                        @if($department->type==  "0")

                                            {{$debtor = departmentsum($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.\Carbon\Carbon::today()->format('Y')) ) , date("Y-m-t", strtotime('1-'.$i.'-'.\Carbon\Carbon::today()->format('Y')) ) ,'debtor','>=')}}

                                        @else

                                            {{$debtor = departmentsum3($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.\Carbon\Carbon::today()->format('Y')) ) , date("Y-m-t", strtotime('1-'.$i.'-'.\Carbon\Carbon::today()->format('Y')) ) ,'debtor','>=')}}

                                        @endif
                                        <div class="hidden">{{$alldebtor += $debtor}}</div>

                                    </td>
                                    <td>

                                        @if($department->type== '0')
                                            {{ $creditor= departmentsum($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.\Carbon\Carbon::today()->format('Y')) ) , date("Y-m-t", strtotime('1-'.$i.'-'.\Carbon\Carbon::today()->format('Y')) ) ,'creditor','>=')}}
                                        @else

                                            {{$creditor =departmentsum3($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.\Carbon\Carbon::today()->format('Y')) ) , date("Y-m-t", strtotime('1-'.$i.'-'.\Carbon\Carbon::today()->format('Y')) ) ,'creditor','>=')}}

                                        @endif
                                        <div class="hidden">{{$allcreditor += $creditor}}</div>
                                    </td>

                                    <td>


                                        {{ $debtor - $creditor }}


                                        <div class="hidden">
                                            @if($department->type == '1')
                                                {{$balance =($department->debtor + $alldebtor)  - ($department->creditor + $allcreditor) }}
                                            @else
                                                {{$balance =(totaldepartment($department->id,'debtor') + $alldebtor)  - (totaldepartment($department->id,'creditor') + $allcreditor) }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        {{$estimated }}

                                        {{--                                        {{getpjitmmsfl($department->id,$i,\Carbon\Carbon::today()->format('Y'))['estimated_balance']}}--}}
                                        {{--                                        <div class="hidden">{{$estimated += getpjitmmsfl($department->id,$i,\Carbon\Carbon::today()->format('Y'))['estimated_balance']}}</div>--}}
                                    </td>
                                    <td>

                                        <?php
                                        $lastyear = \Carbon\Carbon::today()->format('Y')-1;
                                        ?>

                                        <div class="hidden">
                                            @if($department->type== '0')
                                                {{ $creditor8= departmentsum($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear)) ,'creditor','>=')}}
                                            @else

                                                {{$creditor8 =departmentsum3($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear)),'creditor','>=')}}

                                            @endif

                                            @if($department->type==  "0")
                                                {{$debtor8 = departmentsum($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear) ) ,'debtor','>=')}}

                                            @else

                                                {{$debtor8 = departmentsum3($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear) ) ,'debtor','>=')}}

                                            @endif
                                        </div>

                                        <div class="hidden">{{$balance8 +=$debtor8 -$creditor8 }}</div>
                                        {{$debtor8 -$creditor8}}


                                    </td>
                                    <td>
                                        <?php
                                        $lastyear2 = \Carbon\Carbon::today()->format('Y')-2;
                                        ?>

                                        <div class="hidden">
                                            @if($department->type== '0')
                                                {{ $creditor7= departmentsum($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear2) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear2)) ,'creditor','>=')}}
                                            @else

                                                {{$creditor7 =departmentsum3($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear2) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear2)) ,'creditor','>=')}}

                                            @endif
                                            @if($department->type==  "0")
                                                {{$debtor7 = departmentsum($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear2) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear2) ) ,'debtor','>=')}}

                                            @else

                                                {{$debtor7 = departmentsum3($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear2) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear2) ) ,'debtor','>=')}}

                                            @endif

                                        </div>

                                        <div class="hidden">  {{$balance7 +=  $debtor7 - $creditor7 }}</div>
                                        <div>  {{ $debtor7 - $creditor7 }}</div>

                                    </td>
                                    <td>
                                        <?php
                                        $lastyear3 = \Carbon\Carbon::today()->format('Y')-3;
                                        ?>

                                        <div class="hidden">
                                            @if($department->type== '0')
                                                {{ $creditor6= departmentsum($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear3) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear3)) ,'creditor','>=')}}
                                            @else

                                                {{$creditor6 =departmentsum3($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear3) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear3)) ,'creditor','>=')}}

                                            @endif
                                            @if($department->type==  "0")
                                                {{$debtor6 = departmentsum($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear3) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear3) ) ,'debtor','>=')}}

                                            @else

                                                {{$debtor6 = departmentsum3($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear3) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear3) ) ,'debtor','>=')}}

                                            @endif

                                        </div>
                                        <div class='hidden'> {{ $balance6 += $debtor6-$creditor6 }}</div>


                                        <div>  {{$debtor6-$creditor6}}</div>

                                    </td>
                                    <td>
                                        <?php
                                        $lastyear4 = \Carbon\Carbon::today()->format('Y')-4;
                                        ?>

                                        <div class="hidden">
                                            @if($department->type== '0')
                                                {{ $creditor5= departmentsum($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear4) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear4)) ,'creditor','>=')}}
                                            @else

                                                {{$creditor5 =departmentsum3($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear4) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear4)) ,'creditor','>=')}}

                                            @endif
                                            @if($department->type==  "0")
                                                {{$debtor5 = departmentsum($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear4) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear4) ) ,'debtor','>=')}}

                                            @else

                                                {{$debtor5 = departmentsum3($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear4) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear4) ) ,'debtor','>=')}}

                                            @endif

                                        </div>


                                        <div class='hidden'>  {{ $balance5 +=  $debtor5 - $creditor5}}</div>
                                        <div>  {{$debtor5 - $creditor5}}</div>


                                    </td>
                                    <td>
                                        <?php
                                        $lastyear5 = \Carbon\Carbon::today()->format('Y')-5;
                                        ?>

                                        <div class="hidden">
                                            @if($department->type== '0')
                                                {{ $creditor6= departmentsum($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear4) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear4)) ,'creditor','>=')}}
                                            @else

                                                {{$creditor6 =departmentsum3($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear4) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear4)) ,'creditor','>=')}}

                                            @endif
                                            @if($department->type==  "0")
                                                {{$debtor6 = departmentsum($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear4) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear4) ) ,'debtor','>=')}}

                                            @else

                                                {{$debtor6 = departmentsum3($department->id,date("Y-m-1", strtotime('1-'.$i.'-'.$lastyear4) ) , date("Y-m-t", strtotime('1-'.$i.'-'.$lastyear4) ) ,'debtor','>=')}}

                                            @endif

                                        </div>


                                        <div class='hidden'>  {{ $balance6 += $debtor5 -$creditor5}}</div>
                                        <div>  {{$debtor5 -$creditor5}}</div>


                                    </td>

                                </tr>
                            @endfor
                            <tr>
                                <td>الاجمالي</td>
                                @if($department->type == '0')
                                    <td>{{$alldebtor +(totaldepartment($department->id,'debtor'))}}</td>
                                    <td>{{$allcreditor + (totaldepartment($department->id,'creditor'))}} </td>
                                @else
                                    <td>{{$alldebtor + $department->debtor}}</td>
                                    <td>{{$allcreditor + $department->creditor}}</td>
                                    {{--                                    {{dd($alldebtor,$department->debtor)}}--}}
                                @endif


                                <td class="balance">{{$balance}}</td>
                                <td>{{$estimated}}</td>
                                <td>{{$balance8}}</td>
                                <td>{{$balance7}}</td>
                                <td>{{$balance6}}</td>
                                <td>{{$balance5}}</td>

                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-3">


                        <div class="form-group">
                            {{ Form::label('type', trans('admin.department_type'), ['class' => 'control-label']) }}
                            {{ Form::select('type', \App\Enums\dataLinks\TypeAccountType::toSelectArray(),$department->type, array_merge(['class' => 'form-control','placeholder'=>trans('admin.select'),'disabled'=>'disabled'])) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('category', trans('admin.category'), ['class' => 'control-label']) }}
                            {{ Form::select('category', \App\Enums\dataLinks\CategoryAccountType::toSelectArray(),$department->category, array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('debtor', trans('admin.first_date_debtor'), ['class' => 'control-label']) }}
                            @if($department->type =='0')

                                {{ Form::text('debtor',totaldepartment($department->id,'debtor'), array_merge(['class' => 'form-control','readonly'=>'readonly'])) }}
                            @else

                                {{ Form::text('debtor',$department->debtor, array_merge(['class' => 'form-control'])) }}

                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('creditor', trans('admin.first_date_creditor'), ['class' => 'control-label']) }}
                            @if($department->type =='0')
                                {{ Form::text('creditor',totaldepartment($department->id,'creditor'), array_merge(['class' => 'form-control','readonly'=>'readonly'])) }}
                            @else
                                {{ Form::text('creditor',$department->creaditor, array_merge(['class' => 'form-control'])) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('estimite', trans('admin.credit_balance'), ['class' => 'control-label']) }}
                            {{ Form::text('estimite',0, array_merge(['class' => 'form-control'])) }}
                        </div>

                </div>
            </div>
            {{Form::submit(trans('admin.save'),['class'=>'btn btn-primary'])}}
            <a href="{{aurl('departments')}}" class="btn btn-danger">{{trans('admin.back')}}</a>
            {!! Form::close() !!}
        </div>
    </div>
    @else
        <div class="alert alert-danger">{{trans('admin.you_cannt_see_invoice_because_you_dont_have_role_to_access')}}</div>

        @endhasrole
@endsection
