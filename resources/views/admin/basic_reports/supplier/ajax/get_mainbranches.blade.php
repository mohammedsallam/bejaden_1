
@if($MainBranch != null)

    {{ Form::select('MainBranch',$MainBranch,null, array_merge(['class' => 'form-control e2 MainBranch col-md-9','placeholder'=> trans('admin.select') ])) }}


@endif
