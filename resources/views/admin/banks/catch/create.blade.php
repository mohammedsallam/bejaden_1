@extends('admin.index')
@section('title',trans('admin.create_catch_receipt'))
@section('content')
    @push('js')
        <script>
        </script>
    @endpush
    <div class="row">
        <div class="col-md-12">
            {{-- الشركه --}}
            <div class="form-group">
                <label for="Cmp_No" class="col-md-1">{{trans('admin.company')}}</label>
                <select name="Cmp_No" id="Cmp_No" class="form-control col-md-5">
                    <option value="{{null}}">{{trans('admin.select')}}</option>
                    @if(count($companies) > 0)
                            @foreach($companies as $cmp)
                                <option value="{{$cmp->Cmp_No}}">{{$cmp->{'Cmp_Nm'.ucfirst(session('lang'))} }}</option>
                            @endforeach
                    @endif
                </select>
            </div>
            {{-- نهاية الشركه --}}
        </div>
    </div>
@endsection
