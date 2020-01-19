<script>
    $(function () {
        'use strict'

        $(function(){
            $('.select').change(function(){ // when one changes
                var selected = $('.select').children('option:selected').text();

                $('.totree').val($('.select').val()); // they all change
            });
        })
        $(".from,.to,.fromtree,.totree,.acc_fromtree,.acc_totree").on("change",function(){

            var maincompany = '{{$mainCompany}}';


            var totree = $('.totree').val();

            var fromtree = $('.ee').val();
            var acc_fromtree = $('.acc_fromtree').val();
            var acc_totree = $('.acc_totree').val();

            var from = $('.from').val();

            var to = $('.to').val();



            $("#loadingmessage_1").css("display","block");
            $(".button_print").css("display","none");
            if (this){
                $.ajax({
                    url: '{{route('accountStatement.details')}}',
                    type:'get',
                    dataType:'html',
                    data:{maincompany: maincompany,totree: totree,from: from,to : to,fromtree:fromtree,acc_fromtree:acc_fromtree,acc_totree:acc_totree},
                    success: function (data) {
                        $("#loadingmessage_1").css("display","none");
                        $('.button_print').css("display","block").html(data);

                    }
                });
            }else{
                $('.button_print').html('');
            }
        });




    });

{{--<script>--}}
{{--    $(document).ready(function(){--}}
{{--        var minDate = '{{\Carbon\Carbon::today()->format('Y-m-d')}}';--}}

{{--        $('.date').datepicker({--}}
{{--            format: 'yyyy-mm-dd',--}}
{{--            rtl: true,--}}
{{--            language: '{{session('lang')}}',--}}
{{--            autoclose:true,--}}
{{--            todayBtn:true,--}}
{{--            clearBtn:true,--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}

    $(function () {
        'use strict'
        $('.e2').select2({
            {{--placeholder: "{{trans('admin.select')}}",--}}
            dir: '{{direction()}}'
        });
    });


    $('.fromtreee').change(function () {
        var fromtreee = $(this).val(),

            selectHtml = $('.fromtreee option[value="'+fromtreee+'"]'),
            selectHtml2 = $('#totree option[value="'+fromtreee+'"]'),


            optionSelected = '<option value="'+fromtreee+'" selected>'+selectHtml.html()+'</option>';

        $('.totree option:not([value="'+fromtreee+'"])').removeAttr('selected');
        $('.fromtreee').prepend(optionSelected);
        $('#totree').prepend(optionSelected);

        if (selectHtml.length === 1){
            $('#totree ul.select2-results__options').prepend(`
            <li class="select2-results__option" role="treeitem" aria-selected="true" data-select2-id="`+selectHtml.val()+`">`+selectHtml.html()+`</li>
        `);

            $('.fromtreee ul.select2-results__options').prepend(`
            <li class="select2-results__option" role="treeitem" aria-selected="true" data-select2-id="`+selectHtml.val()+`">`+selectHtml.html()+`</li>
        `);

        }
        selectHtml.remove();
        selectHtml2.remove();
    });

    $('.fromtreee'). change(function () {
        var formTree = $(this).val();
        var formTreeText = $(this).attr('name');
        // alert(formTreeText);
        $.ajax({
            url: "{{route('fromtreeToSelect')}}",
            type: "get",
            dataType: 'html',
            data: {"_token": "{{ csrf_token() }}", formTree:formTree, formTreeText:formTreeText},
            success: function(data){
                $('#fromtree_Acc_No').html(data);
            }
        });
    });
</script>

<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        background-color: #333;
    }
    @if(session('lang') == 'ar')
                .datepicker{
        direction: rtl
    }
    @endif

</style>


<div class="row">
    <div class="col-md-10">
        {{ Form::label('tree','من حساب', ['class' => 'col-md-3']) }}
        <select name="fromtree" id="fromtree" class="col-md-8 form-control select e2  fromtreee">
            @foreach($mtschartac as $mts)
                <option value="{{$mts->ID_No}}">{{$mts->Acc_NmAr}}</option>
            @endforeach
        </select>
    </div>

        <input type="text" name="fromtree_Acc_No" id="fromtree_Acc_No" class="col-md-2 form-control  acc_fromtree">
{{--        <select name="fromtree_Acc_No" id="fromtree" class="col-md-2 form-control e2 acc_fromtree">--}}
{{--            @foreach($mtschartac_Acc_No as $mts)--}}
{{--                <option value="{{$mts->ID_No}}">{{$mts->Acc_No}}</option>--}}
{{--            @endforeach--}}
{{--        </select>--}}


</div>
<br>
<div class="row">
    <div class="col-md-10">
        {{ Form::label('tree','الى حساب', ['class' => 'col-md-3']) }}
        <select name="totree" id="totree" class="col-md-8">
            @foreach($mtschartac as $mts)
                <option value="{{$mts->ID_No}}">{{$mts->Acc_NmAr}}</option>
            @endforeach
        </select>
    </div>



            <select name="totree_Acc_No" id="acc_totree" class="col-md-2 form-control e2 acc_totree">
                @foreach($mtschartac_Acc_No as $mts)
                    <option value="{{$mts->ID_No}}">{{$mts->Acc_No}}</option>
                @endforeach
            </select>



</div>
