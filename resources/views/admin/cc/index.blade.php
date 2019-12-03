@extends('admin.index')
@section('title',trans('admin.cc'))
@section('content')
@push('js')

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{trans('admin.delete')}}</h4>
                </div>
                {!! Form::open(['method' => 'DELETE', 'url' => '','id'=>'modal-delete']) !!}
                <div class="modal-body">
                    <p>{{trans('admin.You_Want_You_Sure_Delete_This_Record')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('admin.close')}}</button>
                    {!! Form::submit(trans('admin.delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>

    <script>
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
                $('#modal-delete').attr('action','{{aurl('cc')}}/'+r.join(', '));
                if(r.join(', ') != ''){
                    $('.showbtn_control').removeClass('hidden');
                    $('.edit_dep').attr('href','{{aurl('cc')}}/'+r.join(', ')+'/edit');
                }else{
                    $('.showbtn_control').addClass('hidden');
                }
            });

        });

    </script>
@endpush
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{trans('admin.cc')}}</h3>
            <a href="{{url('/admin/cc/create')}}" class="btn btn-primary" style="float: left">{{trans('admin.create_new_cc')}} </a>
        </div>
        @include('admin.layouts.message')
        @include('admin.layouts.error')
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            <a href="#" class="btn btn-info edit_dep showbtn_control hidden" ><i class="fa fa-edit"></i> {{trans('admin.edit')}}</a>
            <a href="#" class="btn btn-danger delete_dep showbtn_control hidden"  data-toggle="modal" data-target="#myModal"><i class="fa fa-trash"></i> {{trans('admin.delete')}}</a>

            <div id="jstree" style="margin-top: 20px"></div>
        </div>
        <!-- /.box-body -->
    </div>







@endsection
