@extends('admin.index')
@section('title',trans('admin.create_new_cc'))
@section('content')
    @push('js')
        <script>
            $(document).ready(function () {
                $('#jstree').jstree({
                    "core" : {
                        'data' : {!! load_cc(old('parent_id')) !!},
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
                    var i, j, r =[];
                    for (i=0,j=data.selected.length;i < j;i++){
                        r.push(data.instance.get_node(data.selected[i]).id);
                    }
                    $('.parent_id').val(r.join(', '));
                });

            });
            $(document).ready(function () {
                $('#type').on('change',function () {
                    var type = $('#type option:selected').val();
                    console.log(type);
                    if (type > 0){
                        $('.cc').removeAttr("disabled")
                    }else{
                        $('.cc').attr('disabled','disabled')
                    }
                });
            });

        </script>
    @endpush
    <div class="box">
        @include('admin.layouts.message')
        @include('admin.layouts.error')
        <div class="box-header">
            <h3 class="box-title">{{$title}}</h3>
        </div>
        <div class="box-body">
            {!! Form::open(['method'=>'POST','route' => 'cc.store','files' => true]) !!}
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group row">
                        <div class="col-md-6">
                            {{ Form::label(trans('admin.arabic_name'), null, ['class' => 'control-label']) }}
                            {{ Form::text('name_ar', old('name_ar'), array_merge(['class' => 'form-control'])) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label(trans('admin.english_name'), null, ['class' => 'control-label']) }}
                            {{ Form::text('name_en', old('name_en'), array_merge(['class' => 'form-control'])) }}
                        </div>
                        {{ Form::hidden('levelType', 2) }}
                    </div>
                    <div class="clearfix"></div>
                    <div id="jstree"></div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('type', trans('admin.cc_type'), ['class' => 'control-label']) }}
                        {{ Form::select('type', \App\Enums\dataLinks\TypeAccountType::toSelectArray(),old('type'), array_merge(['class' => 'form-control','placeholder'=>trans('admin.select')])) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('creditor', trans('admin.first_date_creditor'), ['class' => 'control-label']) }}
                        {{ Form::text('creditor',0, array_merge(['class' => 'form-control'])) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('debtor', trans('admin.first_date_debtor'), ['class' => 'control-label']) }}
                        {{ Form::text('debtor',0, array_merge(['class' => 'form-control'])) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('estimite', trans('admin.credit_balance'), ['class' => 'control-label']) }}
                        {{ Form::text('estimite',0, array_merge(['class' => 'form-control'])) }}
                    </div>
                </div>
            </div>
            <input type="hidden" class="parent_id" name="parent_id" value="{{old('parent_id')}}">
            {{Form::submit(trans('admin.send'),['class'=>'btn btn-primary'])}}
            {!! Form::close() !!}
        </div>
    </div>









@endsection