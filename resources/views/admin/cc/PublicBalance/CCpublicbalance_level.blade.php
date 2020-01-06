<?php
$level = App\levels::where('type','1')->pluck('levelId','id');
//;
?>

{{$glcc_id= App\glcc::findORfail($glcc)}}

{{ $start_level= $glcc_id->levels->first()->levelId}}

@if(count($glcc_id->parents) == 0)



    {{ Form::select('level',$level,null, array_merge(['class' => 'form-control level','placeholder'=>  trans('admin.select')])) }}

@else
{{--    {{dd($glcc->levels->levelId)}}--}}


    <select class="form-control level">

        <option >{{trans('admin.select')}}</option>
        @for($start =$start_level ; $start<= count($level);$start ++)

            <option value="{{$start}}">{{$start}}</option>
        @endfor
    </select>
@endif



{{--if($glcc ==15 || $department == 18 ||$department == 35 ||$department == 61||$department == 69||--}}
{{--$department == 72||$department == 74||$department == 76||$department == 80--}}
{{--||$department == 82||$department == 83||$department == 84||$department == 85--}}
{{--||$department == 86||$department == 87||$department == 88||$department == 89||--}}
{{--$department == 96||$department == 98||$department == 99||$department == 128||$department == 145--}}
{{--||$department == 145--}}
{{--)--}}
