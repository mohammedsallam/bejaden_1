@extends('admin.index')
@section('title',trans('admin.cc'))
@section('content')
@push('js')
    <script>
        var timer = 0;
        var delay = 200;
        var prevent = false;
        $(document).ready(function () {

            $('#jstree').jstree({
                "core" : {
                    'data' : {!! load_cc('parent_id') !!},
                    "themes" : {
                        "variant" : "large"
                    },
                    "multiple" : false,
                    "animation" : 300
                },
                "checkbox" : {
                    "keep_selected_style" : false
                },
                "plugins" : [ "themes","html_data","dnd","ui","types" ]
            });

            $('#jstree').on('loaded.jstree', function() {
                $('#jstree').jstree('open_all');
            });

            $('#jstree').on("changed.jstree", function (e, data) {
                var i, j, r = [];
                var name = [];
                for (i=0,j=data.selected.length;i < j;i++){
                    r.push(data.instance.get_node(data.selected[i]).id);
                    name.push(data.instance.get_node(data.selected[i]).text);
                }
                $('#parent_name').text(name);
            });

            //handle tree click vent
            $('#jstree').on("click.jstree", function (e){
                timer = setTimeout(function() {
                if (!prevent) {
                    handle_click(e);
                }
                prevent = false;
                }, delay);
            });

            //handle tree double click event
            $('#jstree').on("dblclick.jstree", function (e){
                clearTimeout(timer);
                prevent = true;
                handle_dbclick(e);
            });


            function handle_click(e){
                var node = $(e.target).closest("li");
                var type = node.attr('rel');
                var Costcntr_No = node[0].id;
                $.ajax({
                    url: "{{route('getCcEditBlade')}}",
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}", Costcntr_No: Costcntr_No },
                    success: function(data){
                        $('#chart_form').html(data);
                    }
                });
            }

            function handle_dbclick(e){
                var node = $(e.target).closest("li");
                var type = node.attr('rel');
                var parent = node[0].id;
                $.ajax({
                    url: "{{route('createCcNewAcc')}}",
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}", parent: parent },
                    success: function(data){
                        $('#chart_form').html(data);
                    }
                });
            }

            $('#Level_Status').on('change', function(){
                if($(this).val() == 1){
                    $('#main_chart').removeClass('hidden');
                }
                else{
                    $('#main_chart').addClass('hidden');
                    $('#main_chart').val(null);
                }
            });

            $('#delete_button').click(function(e){
                e.preventDefault();
                $('#delete_form').submit()
            });

            $('#initChartAcc').on('click', function(){
                $.ajax({
                    url: "{{route('initCcChartAcc')}}",
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}"},
                    success: function(data){
                        $('#chart_form').html(data);
                    }
                });
            });


            $(document).on('change', '#cc_type_Check', function(){
                if($(this).is(':checked')){
                    $('#cc_type').removeClass('hidden');
                }
                else{
                    $('#cc_type').addClass('hidden');
                    $('#cc_type').val(null);
                }
            });

            $(document).on('change', '#edit_form :radio[id=Level_Status]', function(){
                if($(this).is(':checked')){
                    if($(this).val() == 1){
                        $('.branch').removeClass('hidden');
                    }
                    else{
                        $('.branch').addClass('hidden');
                        $('#Acc_Ntr').val(null);
                        $('#Fbal_DB').val(0);
                        $('#Fbal_CR').val(0);
                        $('#Cr_Blnc').val(0);
                        $('#Acc_Typ').val(null);
                        // $('#ClsCostcntr_No1').val(null);
                        $('#ClsCostcntr_No2').val(null);
                        $('#cc_type').val(null);
                    }
                }
            });

        });

    </script>
@endpush
    <div class="box">
        @include('admin.layouts.message')
        <!-- /.box-header -->
        <div class="box-body table-responsive" id="create_chart">
            <div class="row">

                {{-- chart tree start --}}
                <div class="col-md-6">
                    <div class="box-header">
                        <h3 class="box-title" style="display: inline-block">{{$title}}</h3>
                        @if(count($cmps) > 0)
                            @foreach($cmps as $cmp)
                                @if($cmp->Cmp_No == $chart_item->Cmp_No)
                                    <div id="Cmp_No" style="display: inline-block">{{$cmp->{'Cmp_Nm'.ucfirst(session('lang'))} }}</div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div id="parent_name" style="display: inline-block"></div>
                                <a class="btn btn-primary" id="initChartAcc">{{trans('admin.Create_New_cc')}}</a>
                            <div id="jstree" style="margin-top: 20px"></div>
                        </div>
                    </div>
                </div>
                {{-- chart tree end --}}

                {{-- form start --}}
                <div class="col-md-6" id="chart_form">
                    {!! Form::open(['method'=>'POST','route' => ['cc.update', $chart_item->Costcntr_No? $chart_item->Costcntr_No : null], 'id' => 'edit_form','files' => true]) !!}
                        {{csrf_field()}}
                        {{method_field('PUT')}}

                        <div class="col-md-3 pull-left">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                            <button type="submit" class="btn btn-danger" id="delete_button"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                        </div>

                        {{-- رقم الحساب --}}
                        <label for="Costcntr_No" class="col-md-2">{{trans('admin.account_number')}}:</label>
                        <input type="text" name="Costcntr_No" id="Costcntr_No" class="form-control col-md-1" value="{{$chart_item->Costcntr_No}}">
                        {{-- رقم الحساب --}}

                        {{-- تصنيف الحساب --}}
                        <div class="form-group">
                           <div class="row">
                               <div class="col-md-4">
                                    @foreach(\App\Enums\dataLinks\TypeAccountType::toSelectArray() as $key => $value)
                                        <input class="checkbox-inline" type="radio"
                                            name="Level_Status" id="Level_Status" value="{{$key}}"
                                            style="margin: 3px;" disabled
                                            @if ($chart_item->Level_Status == $key) checked @endif>
                                        <label>{{$value}}</label>
                                    @endforeach
                               </div>
                           </div>
                        </div>
                        {{-- نهاية تصنيف الحساب --}}

                        {{-- رقم الشركه --}}
                        <input type="text" name="Cmp_No" id="Cmp_No" value="{{$chart_item->Cmp_No}}" hidden>
                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="Cmp_No">{{trans('admin.cmp_no')}}</label>
                                <select name="Cmp_No" id="Cmp_No" class="form-control">
                                    <option value="">{{trans('admin.select')}}</option>
                                    @if(count($cmps) > 0)
                                        @foreach($cmps as $cmp)
                                            <option value="{{$cmp->Cmp_No? $cmp->Cmp_No : null}}" @if($chart_item->Cmp_No == $cmp->Cmp_No) selected @endif>{{$cmp->{'Cmp_Nm'.ucfirst(session('lang'))} }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div> --}}
                        {{-- نهاية رقم الشركه --}}

                        {{-- اسم الحساب عربى --}}
                        <div class="form-group row">
                            <label class="col-md-2" for="Costcntr_Nmar">{{trans('admin.account_name')}}:</label>
                                <input type="text" name="Costcntr_Nmar" id="Costcntr_Nmar" class="col-md-9 form-control"
                                value="{{$chart_item->Costcntr_Nmar? $chart_item->Costcntr_Nmar : null}}">
                            </div>
                        {{-- نهاية اشم الحساب عربى --}}

                        {{-- اسم الحساب انجليزى --}}
                        <div class="form-group row">
                            <label class="col-md-2" for="Costcntr_Nmen">{{trans('admin.account_name_en')}}:</label>
                            <input type="text" name="Costcntr_Nmen" id="Costcntr_Nmen" class=" col-md-9 form-control"
                                value="{{$chart_item->Costcntr_Nmen? $chart_item->Costcntr_Nmen : null}}">
                        </div>
                        {{-- نهاية اسم الحساب انجليزى --}}

                        <div class="col-md-6">
                            <div class="row">
                                {{-- طبيعة الحساب --}}
                                <div class="form-group col-md-12 branch">
                                    <label for="Acc_Ntr" style="margin-left:15px;">{{trans('admin.category')}}:</label>
                                    @foreach(\App\Enums\dataLinks\CategoryAccountType::toSelectArray() as $key => $value)
                                        <input class="checkbox-inline" type="radio"
                                            name="Acc_Ntr" id="Acc_Ntr" value="{{$key}}"
                                            style="margin: 3px;"
                                            @if($chart_item->Level_No == 1) disabled @endif
                                            @if ($chart_item->Acc_Ntr == $key) checked @endif>
                                        <label>{{$value}}</label>
                                    @endforeach
                                </div>
                                {{-- نهاية طبيعة الحساب --}}

                                {{-- رصيد اول المده مدين --}}
                                <div class="col-md-12 branch">
                                    <div class="form-group row">
                                        <label for="Fbal_DB" class="col-md-5">{{trans('admin.first_date_debtor')}}</label>
                                        <input type="text" name="Fbal_DB" id="Fbal_DB" value='{{$chart_item->Fbal_DB? $chart_item->Fbal_DB : 0}}'
                                        class="form-control col-md-7"
                                        @if($chart_item->Level_No == 1) disabled @endif>
                                    </div>
                                </div>
                                {{-- نهايةرصيد اول المده مدين --}}

                                {{-- رصيد اول المده دائن --}}
                                <div class="col-md-12 branch">
                                    <div class="form-group row">
                                        <label for="Fbal_CR" class="col-md-5">{{trans('admin.first_date_creditor')}}</label>
                                        <input type="text" disabled name="Fbal_CR" id="Fbal_CR" value='{{$chart_item->Fbal_CR? $chart_item->Fbal_CR : 0}}'
                                        class="form-control col-md-7"
                                        @if($chart_item->Level_No == 1) disabled @endif>
                                    </div>
                                </div>
                                {{-- نهاية رصيد اول المده دائن --}}

                                {{-- رصيد اول المده دائن --}}
                                <div class="col-md-12 branch">
                                    <div class="form-group row">
                                        <label for="Cr_Blnc" class="col-md-5">{{trans('admin.credit_balance')}}</label>
                                        <input type="text" disabled name="Cr_Blnc" id="Cr_Blnc" value='{{$chart_item->Cr_Blnc? $chart_item->Cr_Blnc : 0}}'
                                        class="form-control col-md-7"
                                        @if($chart_item->Level_No == 1) disabled @endif>
                                    </div>
                                </div>
                                {{-- نهاية رصيد اول المده دائن --}}
                            </div>
                        </div>





                    {!! Form::close() !!}
                    <form action="{{route('cc.destroy', $chart_item->Costcntr_No? $chart_item->Costcntr_No : null)}}" method="POST" id="delete_form">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                    </form>
                    {{-- الحركات --}}
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">الشهر</th>
                                <th scope="col">الحركة مدين</th>
                                <th scope="col">الحركة دائن</th>
                                <th scope="col">الرصيد الحالى</th>
                                <th scope="col"> رصيد تقديرى</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <th scope="row">يناير</th>
                                <td>
                                    @if($chart_item->DB11 == null)
                                        0.00
                                    @else
                                        {{$chart_item->DB11}}
                                    @endif
                                </td>
                                <td>
                                    @if($chart_item->CR11 == null )
                                        0.00
                                    @else
                                        {{$chart_item->CR11}}
                                    @endif
                                </td>
                                <td>
                                    {{$chart_item->DB11 - $chart_item->CR11}}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">فبراير</th>
                                <td>
                                    @if($chart_item->DB12 == null )
                                        0.00
                                    @else
                                        {{$chart_item->DB12}}
                                    @endif
                                </td>
                                <td>
                                    @if($chart_item->CR12 == null )
                                        0.00
                                    @else
                                        {{$chart_item->CR12}}
                                    @endif
                                </td>
                                <td>
                                    {{$chart_item->DB12 - $chart_item->CR12}}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">مارس</th>
                                <td>
                                    @if($chart_item->DB13 == null )
                                        0.00
                                    @else
                                        {{$chart_item->DB13}}
                                    @endif
                                </td>
                                <td>
                                    @if($chart_item->CR13 == null )
                                        0.00
                                    @else
                                        {{$chart_item->CR13}}
                                    @endif
                                </td>
                                <td>
                                    {{$chart_item->DB13 - $chart_item->CR13}}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">ابريل</th>
                                <td>
                                    @if($chart_item->DB14 == null )
                                        0.00
                                    @else
                                        {{$chart_item->DB14}}
                                    @endif
                                </td>
                                <td>
                                    @if($chart_item->CR14 == null )
                                        0.00
                                    @else
                                        {{$chart_item->CR14}}
                                    @endif
                                </td>
                                <td>
                                    {{$chart_item->DB14 - $chart_item->CR14}}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">مايو</th>
                                <td>
                                    @if($chart_item->DB15 == null )
                                        0.00
                                    @else
                                        {{$chart_item->DB15}}
                                    @endif
                                </td>
                                <td>
                                    @if($chart_item->CR15 == null )
                                        0.00
                                    @else
                                        {{$chart_item->CR15}}
                                    @endif
                                </td>
                                <td>
                                    {{$chart_item->DB15 - $chart_item->CR15}}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">يونيو</th>
                                <td>
                                    @if($chart_item->DB16 == null )
                                        0.00
                                    @else
                                        {{$chart_item->DB16}}
                                    @endif
                                </td>
                                <td>
                                    @if($chart_item->CR16 == null )
                                        0.00
                                    @else
                                        {{$chart_item->CR16}}
                                    @endif
                                </td>
                                <td>
                                    {{$chart_item->DB16 - $chart_item->CR16}}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">يوليو</th>
                                <td>
                                    @if($chart_item->DB17 == null )
                                        0.00
                                    @else
                                        {{$chart_item->DB17}}
                                    @endif
                                </td>
                                <td>
                                    @if($chart_item->CR17 == null )
                                        0.00
                                    @else
                                        {{$chart_item->CR17}}
                                    @endif
                                </td>
                                <td>
                                    {{$chart_item->DB17 - $chart_item->CR17}}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">اغسطس</th>

                                <td>
                                    @if($chart_item->DB18 == null )
                                        0.00
                                    @else
                                        {{$chart_item->DB18}}
                                    @endif
                                </td>
                                <td>
                                    @if($chart_item->CR18 == null )
                                        0.00
                                    @else
                                        {{$chart_item->CR18}}
                                    @endif
                                </td>
                                <td>
                                    {{$chart_item->DB18 - $chart_item->CR18}}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">سبتمبر</th>

                                <td>
                                    @if($chart_item->DB19 == null )
                                        0.00
                                    @else
                                        {{$chart_item->DB19}}
                                    @endif
                                </td>
                                <td>
                                    @if($chart_item->CR19 == null )
                                        0.00
                                    @else
                                        {{$chart_item->CR19}}
                                    @endif
                                </td>
                                <td>
                                    {{$chart_item->DB19 - $chart_item->CR19}}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">أكتوبر</th>

                                <td>
                                    @if($chart_item->DB20 == null )
                                        0.00
                                    @else
                                        {{$chart_item->DB20}}
                                    @endif
                                </td>
                                <td>
                                    @if($chart_item->CR20 == null )
                                        0.00
                                    @else
                                        {{$chart_item->CR20}}
                                    @endif
                                </td>
                                <td>
                                    {{$chart_item->DB20 - $chart_item->CR20}}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">نوفمبر</th>

                                <td>
                                    @if($chart_item->DB21 == null )
                                        0.00
                                    @else
                                        {{$chart_item->DB21}}
                                    @endif
                                </td>
                                <td>
                                    @if($chart_item->CR21 == null )
                                        0.00
                                    @else
                                        {{$chart_item->CR21}}
                                    @endif
                                </td>
                                <td>
                                    {{$chart_item->DB21 - $chart_item->CR21}}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">ديسمبر</th>

                                <td>
                                    @if($chart_item->DB22 == null )
                                        0.00
                                    @else
                                        {{$chart_item->DB22}}
                                    @endif
                                </td>
                                <td>
                                    @if($chart_item->CR22 == null )
                                        0.00
                                    @else
                                        {{$chart_item->CR22}}
                                    @endif
                                </td>
                                <td>
                                    {{$chart_item->DB22 - $chart_item->CR22}}
                                </td>
                            </tr>

                            <tr style="background-color: #d3d9df">
                                <th scope="row">الإجمالى</th>

                                <td>
                                    {{count($total) > 0? $total[0]->total_debit : 0.00}}
                                </td>
                                <td>
                                    {{count($total) > 0? $total[0]->total_credit : 0.00}}

                                </td>
                                <td>
                                    {{count($total) > 0? $total[0]->total_balance : 0.00}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- نهاية الحركات --}}
                </div>
                {{-- form end --}}

            </div>
        </div>
        <!-- /.box-body -->
    </div>







@endsection
