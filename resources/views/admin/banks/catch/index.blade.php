@extends('admin.index')
@section('title',trans('admin.catch_receipt'))
@section('content')
    @push('js')
        <script>

            $(document).ready(function() {
                $('#example').DataTable();
            } );


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
                        url: "{{route('rcatchs.index')}}",
                        type: "get",
                        dataType: 'html',
                        data: {"_token": "{{ csrf_token() }}", Cmp_No: $(this).val() },
                        success: function(data){
                            $('#tableFilter').html(data);
                        }
                    });
                });

                $(document).on('change', '#Dlv_Stor', function(){
                    var Cmp_No = $('#Cmp_No').children('option:selected').val();
                    $.ajax({
                        url: "{{route('rcatchs.index')}}",
                        type: "get",
                        dataType: 'html',
                        data: { pranch: $(this).val() , Cmp_No: Cmp_No },
                        success: function(data){
                            $('#tableFilter').html(data);
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
        <br>
        <br>
        <br>

        <div class="content">
            <div class="box">
                <div class="box-header">


                    {{-- header end --}}
                    <div class="row">
                            <a class="btn btn-info" style="float: left;margin-left: 20px" href="{{route('rcatchs.create')}}">{{trans('admin.create_catch_receipt')}}</a>
                        <div class="col-md-12" id="rcpt_content">
                            <div id="tableFilter">
                                <table id="example" class="table table-striped display" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>{{trans('admin.id')}}</th>
                                        <th>{{trans('admin.number_of_receipt')}}</th>
                                        <th>{{trans('admin.receipts_type')}}</th>
                                        <th>{{trans('admin.receipt_date')}}</th>
                                        <th>{{trans('admin.note_for')}}</th>
                                        <th>حالة السند</th>


                                        <th>{{trans('admin.View')}}</th>
                                        <th>{{trans('admin.print')}}</th>
                                        <th>{{trans('admin.edit')}}</th>
                                        <th>{{trans('admin.delete')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($gls) > 0)
                                        @foreach($gls as $gl)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>


                                                <td>{{$gl->Tr_No}}</td>
                                                <td>
                                                    {{\App\Enums\dataLinks\ReceiptType::getDescription($gl->Doc_Type) }}
                                                </td>
                                                <td>{{$gl->Entr_Dt}}</td>
                                                <td>{{$gl->Acc_Nm}}</td>

                                                <td>
                                                    @if($gl->status == 1)
                                                        تم الحذف
                                                    @else
                                                       فعال
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="{{route('rcatchs.show', $gl->Tr_No)}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                                </td>
                                                <td>
                                                    <a href="../../rcatchs/print/{{$gl->Tr_No}}" class="btn btn-info"><i class="fa fa-print"></i></a>
                                                </td>
                                                <td>
                                                    <a href="{{route('rcatchs.edit', $gl->Tr_No)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                                </td>
                                                <td>
                                                    <form action="{{route('rcatchs.destroy', $gl->Tr_No)}}" method="POST">
                                                        {{csrf_field()}}
                                                        {{method_field('DELETE')}}
                                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div>
                        {{$gls->links()}}
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection













































{{--@extends('admin.index')--}}
{{--@section('title',trans('admin.companies'))--}}
{{--@section('content')--}}
{{--@push('js')--}}
{{--    @hasrole('reader')--}}
{{--    <script src="{{url('/')}}/js/dataTables.buttons.min.js"></script>--}}
{{--    @endhasrole--}}
{{--    <script>--}}
{{--        $(document).ready(function(){--}}
{{--            $('#Cmp_No').change(function(){--}}
{{--                $.ajax({--}}
{{--                    url: "{{route('branchForEdit')}}",--}}
{{--                    type: "POST",--}}
{{--                    dataType: 'html',--}}
{{--                    data: {"_token": "{{ csrf_token() }}", Cmp_No: $(this).val() },--}}
{{--                    success: function(data){--}}
{{--                        $('#Brn_No').html(data);--}}
{{--                    }--}}
{{--                });--}}

{{--                $.ajax({--}}
{{--                    url: "{{route('getRecieptByCmp')}}",--}}
{{--                    type: "GET",--}}
{{--                    dataType: 'html',--}}
{{--                    data: {"_token": "{{ csrf_token() }}", Cmp_No: $(this).val() },--}}
{{--                    success: function(data){--}}

{{--                    }--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endpush--}}
{{--    <div class="box">--}}
{{--        <div class="box-header">--}}
{{--            <h3 class="box-title">{{trans('admin.catch_receipt')}}</h3>--}}
{{--        </div>--}}
{{--    @include('admin.layouts.message')--}}
{{--    <!-- /.box-header -->--}}
{{--        <div class="box-body table-responsive">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-3">--}}
{{--                    <label for="Cmp_No">{{trans('admin.cmp_no')}}</label>--}}
{{--                    <select name="Cmp_No" id="Cmp_No" class="form-control">--}}
{{--                        <option value="{{null}}">{{trans('admin.select')}}</option>--}}
{{--                        @if(count($companies) > 0)--}}
{{--                            @foreach($companies as $cmp)--}}
{{--                                <option value="{{$cmp->Cmp_No}}">{{$cmp->{'Cmp_Nm'.ucfirst(session('lang'))} }}</option>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--                <div class="col-md-3">--}}
{{--                    <label for="Brn_No">{{trans('admin.Brn_No')}}</label>--}}
{{--                    <select name="Brn_No" id="Brn_No" class="form-control">--}}
{{--                        <option value="{{null}}">{{trans('admin.select')}}</option>--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            {!! $dataTable->table([--}}
{{--             'class' => 'table table-bordered table-striped table-hover'--}}
{{--             ],true) !!}--}}
{{--        </div>--}}
{{--        <!-- /.box-body -->--}}
{{--    </div>--}}








{{--    @push('js')--}}
{{--        {!! $dataTable->scripts() !!}--}}
{{--    @endpush--}}
{{--@endsection--}}
