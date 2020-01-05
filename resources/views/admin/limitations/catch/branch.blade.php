@if(count($branches) > 0)
    <option value="">{{trans('admin.select')}}</option>
@foreach($branches as $brn)
    <option value="{{$brn->Brn_No}}" @if($gl && $gl->Brn_No == $brn->Brn_No) selected @endif>
        {{$brn->{'Brn_Nm'.ucfirst(session('lang'))} }}
    </option>
@endforeach

@else
    <option value="">{{trans('admin.nodata')}}</option>
@endif
