@push('js')
<script>
    $(document).ready(function(){

        $('.MainBranch').on('change',function(){
            // $("#loadingmessage").css("display","block");
            // $(".branch_data").css("display","none");
            //
            // var MainBranch = $('.MainBranch').val();

            alert(15);
            if (this){
                $.ajax({
                    url: '{{route('acc_state')}}',
                    type:'get',
                    dataType:'html',
                    data:{mainCompany : mainCompany,MainBranch : MainBranch},
                    success: function (data) {
                        $("#loadingmessage").css("display","none");
                        $('.branch_data').css("display","block").html(data);

                    }
                });
            }else{
                $('.branch_data').html('');
            }


        });
    });
</script>
@endpush

<div class="col-md-12">
    {{ Form::label('MainBranch','الفروع', ['class' => 'control-label']) }}
    {{ Form::select('MainBranch',$MainBranch,null, array_merge(['class' => 'form-control MainCompany e2 fromtree','placeholder'=> trans('admin.select') ])) }}
</div>
<div id='loadingmessage-1' style='display:none; margin-top: 20px' class="text-center">
    <img src="{{ url('/') }}/images/ajax-loader.gif"/>
</div>

<div class="branch_data row">

</div>
