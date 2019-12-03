@if($branches)
    <option>{{trans('admin.select')}}</option>
    @foreach($branches as $branch)
        <option value="{{$branch->ID_No}}">{{$branch->{'Brn_Nm_'.ucfirst(session('lang'))} }}</option>
     @endforeach
@endif
