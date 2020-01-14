@extends('admin.index')
@section('title','الأنشطه التجاريه للعملاء')
@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">الأنشطه التجاريه للعملاء</h3>
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

    {{--<a href="#" class="btn btn-danger"  data-toggle="modal" data-target="#myModal"><i class="fa fa-trash"></i> {{trans('admin.delete')}}</a>--}}





@push('js')
    {!! $dataTable->scripts() !!}
@endpush
@endsection
