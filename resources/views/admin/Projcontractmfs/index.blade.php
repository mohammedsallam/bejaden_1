@extends('admin.index')
@section('title',trans('admin.project_contract'))
@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{trans('admin.project_contract')}}</h3>
        </div>
        @include('admin.layouts.message')
        <!-- /.box-header -->
        <div class="box-body table-responsive">
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
