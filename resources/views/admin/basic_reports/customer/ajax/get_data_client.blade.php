
    <style>
.vertical-menu{
    padding-top: 46px;

}
        .myradio__input {
            opacity: 0;
            position: absolute;
        }
        .myradio__label {
            border-radius: 9999px;
            padding: 5px 15px 5px 40px;
            cursor: pointer;
            position: relative;
            transition: all .5s;
        }
        .myradio__label::before, .myradio__label::after {
            content: "";
            border-radius: 9999px;
            width: 16px;
            height: 16px;
            margin: 3px 0;
            position: absolute;
            z-index: 1;
        }
        .myradio__label::before {
            background-color: #FFFFFF;
            border: 2px solid #DCDCDC;
            top: 4px;
            left: 10px;
            transition: all .5s;
        }
        .myradio__label::after {
            background-color: transparent;
            top: 6px;
            left: 12px;
            transition: all .2s;
            transition-timing-function: ease-out;
        }
        .myradio__label:hover::after {
            background-color: rgba(51, 170, 221, 0.08);
            transform: scale(2.5);
        }
        .myradio__input:checked ~ .myradio__label::before {
            background-color: #FFFFFF;
            border: 2px solid #33aadd;
        }
        .myradio__input:checked ~ .myradio__label::after {
            background-color: #33aadd;
            border: 2px solid transparent;
            top: 4px;
            left: 10px;
            transform: scale(0.6);
        }
        .myradio__input:checked ~ .myradio__label:hover::after {
            transform: scale(0.6);
        }
        .container {
            display: grid;
            grid-template-rows: 1fr auto;
            height: 95vh;
            min-height: 10rem;
            text-align: center;
        }
        .form {
            margin: 0;
        }
        .form {
            font-size: 1.8rem;
            margin: 5rem 0;
        }


        .vertical-menu a ,.custom_radio{

            color: black;
            display: block;
            padding: 12px;
            text-decoration: none;
        }

        .right
        {
            float: right;
            clear: right;
            padding-right: 270px;

        }

.left
{
    float: left;
    clear: left;
    padding-left: 230px;
}
    </style>
<script>

        $('.myradio__input').on('click',function () {
            var value = $(this).val();
            var mainCompany ='{{$mainCompany}}';
            var MainBranch ='{{$MainBranch}}';
        console.log(mainCompany,MainBranch,value);
        if(this){
            $.ajax({
                dataType: 'html',
                data:{value:value,mainCompany:mainCompany,MainBranch:MainBranch},
                type:'get',
                url:'{{route('cust_report_select')}}',
                success:function (data) {
                    $("#loadingmessage").css("display","none");
                    $('.column_input').css("display","block").html(data);
                }

            })
        }else
        {
            $('.column_input').html('');

        }


        })

</script>



<div class="row">

    <div class="vertical-menu right col-md-6">

        <div class="custom_radio">
            <input   value="country" type="radio" name="myRadio" id="one"  class="myradio__input" >
            <label  for="one" class="myradio__label">الدول</label>
        </div>
        <div class="custom_radio">
            <input   value="city" type="radio" name="myRadio" id="two"  class="myradio__input" >
            <label  for="two" class="myradio__label">المدينة</label>
        </div>
        <div class="custom_radio">
            <input   value="AstSalesman" type="radio" name="myRadio" id="three"  class="myradio__input" >
            <label  for="three" class="myradio__label">المندوب</label>
        </div>

    </div>
    <div class="vertical-menu  col-md-6">

        <div class="custom_radio">
            <input   value="AstMarket" type="radio" name="myRadio" id="four"  class="myradio__input" >
            <label  for="four" class="myradio__label">المشرف</label>
        </div>
        <div class="custom_radio">
            <input   value="ActivityTypes" type="radio" name="myRadio" id="five"  class="myradio__input" >
            <label  for="five" class="myradio__label">رقم النشاط</label>
        </div>
        <div class="custom_radio">
            <input   value="Astsupctg" type="radio" name="myRadio" id="six"  class="myradio__input" >
            <label  for="six" class="myradio__label">تصنيف العميل</label>
        </div>

    </div>
</div>



<div class="column_input">

</div>

