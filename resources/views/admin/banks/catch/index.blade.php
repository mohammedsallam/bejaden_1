@extends('admin.index')
@section('title',trans('admin.companies'))
@section('content')
@push('js')
    @hasrole('reader')
    <script src="{{url('/')}}/js/dataTables.buttons.min.js"></script>
    @endhasrole
    <script>
        $(document).ready(function(){
            $('#Cmp_No').change(function(){
                $.ajax({
                    url: "{{route('branchForEdit')}}",
                    type: "POST",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}", Cmp_No: $(this).val() },
                    success: function(data){
                        $('#Brn_No').html(data);
                    }
                });

                $.ajax({
                    url: "{{route('getRecieptByCmp')}}",
                    type: "GET",
                    dataType: 'html',
                    data: {"_token": "{{ csrf_token() }}", Cmp_No: $(this).val() },
                    success: function(data){
                       
                    }
                });
            });
        });
    </script>
@endpush
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{trans('admin.catch_receipt')}}</h3>
        </div>
    @include('admin.layouts.message')
    <!-- /.box-header -->
        <div class="box-body table-responsive">
            <div class="row">
                <div class="col-md-3">
                    <label for="Cmp_No">{{trans('admin.cmp_no')}}</label>
                    <select name="Cmp_No" id="Cmp_No" class="form-control">
                        <option value="{{null}}">{{trans('admin.select')}}</option>
                        @if(count($companies) > 0)
                            @foreach($companies as $cmp)
                                <option value="{{$cmp->Cmp_No}}">{{$cmp->{'Cmp_Nm'.ucfirst(session('lang'))} }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="Brn_No">{{trans('admin.Brn_No')}}</label>
                    <select name="Brn_No" id="Brn_No" class="form-control">
                        <option value="{{null}}">{{trans('admin.select')}}</option>
                    </select>
                </div>
            </div>
            {!! $dataTable->table([
             'class' => 'table table-bordered table-striped table-hover'
             ],true) !!}
        </div>
        <!-- /.box-body -->
    </div>








    @push('js')
        {!! $dataTable->scripts() !!}
    @endpush
@endsection