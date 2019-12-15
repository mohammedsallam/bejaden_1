@if(count($salesman) > 0)
<select name="Salman_No" id="Salman_No" class="form-control">
    @foreach($salesman as $man)
        <option value="{{$man->Slm_No}}">{{$man->{'Slm_Nm'.ucfirst(session('lang'))} }}</option>
    @endforeach
</select>
@else
    <option value="{{null}}">{{trans('admin.nodata')}}</option>
@endif