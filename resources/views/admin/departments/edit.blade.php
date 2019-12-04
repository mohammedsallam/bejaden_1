<script>
    $(document).ready(function(){
        $('#delete_button').click(function(e){
            e.preventDefault();
            $('#delete_form').submit()
        })
    })
</script>


{!! Form::open(['method'=>'POST','route' => ['departments.update', $chart_item->Acc_No],'files' => true]) !!}
    {{csrf_field()}}
    {{method_field('PUT')}}
    {{-- رقم الشركه --}}
    <div class="col-md-4">
        <div class="form-group">
            <label for="Cmp_No">{{trans('admin.cmp_no')}}</label>
            <select name="Cmp_No" id="Cmp_No" class="form-control">
                <option value="">{{trans('admin.select')}}</option>
                @if(count($cmps) > 0)
                    @foreach($cmps as $cmp)
                        <option value="{{$cmp->Cmp_No}}" @if($chart_item->Cmp_No == $cmp->Cmp_No) selected @endif>{{$cmp->{'Cmp_Nm'.ucfirst(session('lang'))} }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    {{-- نهاية رقم الشركه --}}

    {{-- اسم الحساب عربى --}}
    <div class="col-md-4">
        <div class="form-group">
            <label for="Acc_NmAr">{{trans('admin.arabic_name')}}</label>
            <input type="text" name="Acc_NmAr" id="Acc_NmAr" class="form-control" value="{{$chart_item->Acc_NmAr}}">
        </div>
    </div>
    {{-- نهاية اشم الحساب عربى --}}

    {{-- اسم الحساب انجليزى --}}
    <div class="col-md-4">
        <div class="form-group">
            <label for="Acc_NmEn">{{trans('admin.english_name')}}</label>
            <input type="text" name="Acc_NmEn" id="Acc_NmEn" class="form-control" value="{{$chart_item->Acc_NmEn}}">
        </div>
    </div>
    {{-- نهاية اسم الحساب انجليزى --}}

    {{-- تصنيف الحساب --}}
    <div class="col-md-4">
        <div class="form-group">
            <label for="Level_Status">{{trans('admin.department_type')}}</label>
            <select name="Level_Status" id="Level_Status" class="form-control">
                <option value="{{null}}">{{trans('admin.select')}}</option>
                @foreach(\App\Enums\dataLinks\TypeAccountType::toSelectArray() as $key => $value)
                    <option value="{{$key}}" @if($chart_item->Level_Status == $key) selected @endif>{{$value}}</option>
                @endforeach
            </select>
        </div>
    </div>
    {{-- نهاية تصنيف الحساب --}}

    {{-- الحساب الرئيسى --}}
    <div class="col-md-4 hidden" id="main_chart">
        <div class="form-group">
            <label for="Parnt_Acc">{{trans('admin.main_account_chart')}}</label>
            <select name="Parnt_Acc" id="Parnt_Acc" class="form-control">
                <option value="{{null}}">{{trans('admin.select')}}</option>
                @if(count($chart) > 0)
                    @foreach($chart as $ch)
                        <option value="{{$ch->Acc_No}}" @if($chart_item->Parnt_Acc == $ch->Acc_No) selected @endif>{{$ch->{'Acc_Nm'.ucfirst(session('lang'))} }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    {{-- نهاية الحساب الرئيسى --}}

    {{-- نوع الحساب --}}
    <div class="col-md-4">
        <div class="form-group">
            <label for="Acc_Typ">{{trans('admin.account_type')}}</label>
            <select name="Acc_Typ" id="Acc_Typ" class="form-control">
                <option value="{{null}}">{{trans('admin.select')}}</option>
                @foreach(\App\Enums\AccountType::toSelectArray() as $key => $value)
                    <option value="{{$key}}" @if($chart_item->Acc_Typ == $key) selected @endif>{{$value}}</option>
                @endforeach
            </select>
        </div>
    </div>
    {{-- نهاية نوع الحساب --}}

    {{-- التصنيف بالحسابات الختاميه --}}
    <div class="col-md-4">
        <div class="form-group">
            <label for="Clsacc_No">{{trans('admin.final_counting_classfication')}}</label>
            <select name="Clsacc_No" id="Clsacc_No" class="form-control">
                <option value="{{null}}">{{trans('admin.select')}}</option>
                @foreach(\App\Enums\dataLinks\IncomeListType::toSelectArray() as $key => $value)
                    <option value="{{$key}}" @if($chart_item->Clsacc_No == $key) selected @endif>{{$value}}</option>
                @endforeach
            </select>
        </div>
    </div>
    {{-- نهاية التصنيف بالحسابات الختاميه --}}

    {{-- مركز التكلفه --}}
    {{-- <div class="col-md-4" style="padding-top: 30px">
        <div class="form-group">
            {{ Form::label('cc_type',trans('admin.with_cc') , ['class' => 'control-label']) }}
            {{ Form::checkbox('cc_type', 1) }}
        </div>
    </div> --}}
    {{-- نهاية مركز التكلفه --}}

    {{-- طبيعة الحساب --}}
    <div class="col-md-4">
        <div class="form-group">
            <label for="Acc_Ntr">{{trans('admin.category')}}</label>
            <select name="Acc_Ntr" id="Acc_Ntr" class="form-control">
                <option value="{{null}}">{{trans('admin.select')}}</option>
                @foreach(\App\Enums\dataLinks\CategoryAccountType::toSelectArray() as $key => $value)
                    <option value="{{$key}}" @if($chart_item->Acc_Ntr == $key) selected @endif>{{$value}}</option>
                @endforeach
            </select>
        </div>
    </div>
    {{-- نهاية طبيعة الحساب --}}

    {{-- رصيد اول المده مدين --}}
    <div class="col-md-4">
        <div class="form-group">
            <label for="Fbal_DB">{{trans('admin.first_date_debtor')}}</label>
            <input type="text" name="Fbal_DB" id="Fbal_DB" value={{$chart_item->Fbal_DB}} class="form-control">
        </div>
    </div>
    {{-- نهايةرصيد اول المده مدين --}}

    {{-- رصيد اول المده دائن --}}
    <div class="col-md-4">
        <div class="form-group">
            <label for="Fbal_CR">{{trans('admin.first_date_creditor')}}</label>
            <input type="text" name="Fbal_CR" id="Fbal_CR" value={{$chart_item->Fbal_CR}} class="form-control">
        </div>
    </div>
    {{-- نهاية رصيد اول المده دائن --}}

    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
    <button type="submit" class="btn btn-danger pull-left" id="delete_button"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
{!! Form::close() !!}

<form action="{{route('departments.destroy', $chart_item->Acc_No)}}" method="POST" id="delete_form">
    {{csrf_field()}}
    {{method_field('DELETE')}}
</form>
