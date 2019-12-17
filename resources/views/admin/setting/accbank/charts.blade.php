<option value="{{null}}">{{trans('admin.select')}}</option>
@if(count($charts) > 0)
    @foreach($charts as $ch)    
        <option value="{{$ch->Acc_No}}">{{$ch->{'Acc_Nm'.ucfirst(session('lang'))} }}</option>
    @endforeach
@endif