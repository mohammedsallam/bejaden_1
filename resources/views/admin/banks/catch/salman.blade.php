@if(count($salesman) > 0)
<select name="Salman_No_select" id="Salman_No_select" class="form-control">
    <option value="{{null}}">{{trans('admin.select')}}</option>
    @foreach($salesman as $man)
        <option value="{{$man->Slm_No}}">{{$man->{'Slm_Nm'.ucfirst(session('lang'))} }}</option>
    @endforeach
</select>
@else
    <select name="Salman_No_select" id="Salman_No_select" class="form-control">
        <option value="{{null}}">{{trans('admin.nodata')}}</option>
    </select>   
@endif