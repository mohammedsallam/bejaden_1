
@if($MtsCostcntr)
    <option>اختر</option>
    @foreach($MtsCostcntr as $MtsCost)
        <option value="{{$MtsCost}}">{{$MtsCost}}</option>
    @endforeach
@endif

