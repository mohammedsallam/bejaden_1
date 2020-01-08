<?php

namespace App\Http\Controllers\Admin\employees;

use App\Branches;
use App\DataTables\employeeDataTable;
use App\Department;
use App\drivers;
use App\employee;
use App\glcc;
use App\Http\Controllers\Controller;
use App\Models\Admin\MainBranch;
use App\Models\Admin\MainCompany;
use App\state;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Up;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(employeeDataTable $driver)
    {
//        $drivers = drivers::all();
//        $branches = Branches::pluck('id')->toArray();
//        foreach ($drivers as $d){
//            $d->branches()->sync($branches);
//        }
        return $driver->render('admin.employees.index',['title'=>trans('admin.employees')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(employee $employee)
    {
        $branches = Branches::pluck('name_'.session('lang'),'id');
        $glccs = glcc::where('type','=','1')->pluck('name_'.session('lang'),'id');
        $departments = Department::where('operation_id',5)->where('type','1')->pluck('dep_name_'.session('lang'),'id');
        $departmentsbanks = Department::where('operation_id',7)->where('type','1')->pluck('dep_name_'.session('lang'),'id');
        return view('admin.employees.create',['title'=> trans('admin.Create_new_employees'),'employee' => $employee,'departments'=>$departments,'departmentsbanks'=>$departmentsbanks,'branches'=>$branches,'glccs'=>$glccs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,employee $employee)
    {
        $data = $this->validate($request,[
            'name_ar' => 'required',
            'name_en' => 'required',
            'beginning_date' => 'sometimes',
            'end_date' => 'sometimes',
            'renew_date' => 'sometimes',
            'salary_type' => 'sometimes',
            'salary' => 'sometimes',
            'transition_allowance' => 'sometimes',
            'housing_allowance' => 'sometimes',
            'food_allowance' => 'sometimes',
            'other_allowances' => 'sometimes',
            'work_type' => 'sometimes',
            'number_rest' => 'sometimes',
            'work_status' => 'sometimes',
            'payment_methods' => 'sometimes',
            'workhour_count' => 'sometimes',
            'hour_payment' => 'sometimes',
            'employee_ticket' => 'sometimes',
            'ticket_class' => 'sometimes',
            'children_ticket' => 'sometimes',
            'sales_officer' => 'sometimes',
            'sales_number' => 'sometimes',
            'percentage' => 'sometimes',
            'branches_id' => 'sometimes',
            'companybanks_id' => 'sometimes',
            'company_banks_num' => 'sometimes',
            'employeebanks_id' => 'sometimes',
            'employee_banks_num' => 'sometimes',
            'employee_banks_branches' => 'sometimes',
            'debtor' => 'required',
            'creditor' => 'required',
            'accounts_receivable' => 'sometimes',
            'tree_id' => 'required',
            'cc_id' => 'sometimes',
            'operation_id' => 'sometimes',
            'status' => 'sometimes',
            'statusreport' => 'sometimes',
//            'cc_type' => 'sometimes',
        ],[],[
            'name_ar' => trans('admin.arabic_name'),
            'name_en' => trans('admin.english_name'),
            'debtor' => trans('admin.debtor'),
            'creditor' => trans('admin.creditor'),
        ]);
        if ($request->sales_officer){
            $data['sales_officer'] = $request->sales_officer;
        }else{
            $data['sales_officer'] = 0;
        }

//        if ($request->cc_type){
//            $data['cc_type'] = $request->cc_type;
//        }else{
//            $data['cc_type'] = 0;
//        }
        $employee = employee::findOrFail($employee->create($data)->id);
        $branches = Branches::pluck('id')->toArray();
        $employee->branches()->sync($branches);
        return redirect(aurl('employees'))->with(session()->flash('message',trans('admin.success_add')));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = employee::findOrFail($id);
        return view('admin.employees.show',['title'=> trans('employee') ,'employee'=>$employee]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = employee::findOrFail($id);
        $branches = Branches::pluck('name_'.session('lang'),'id');
        $glccs = glcc::where('type','=','1')->pluck('name_'.session('lang'),'id');
        $departments = Department::where('operation_id',5)->where('type','1')->pluck('dep_name_'.session('lang'),'id');
        $departmentsbanks = Department::where('operation_id',7)->where('type','1')->pluck('dep_name_'.session('lang'),'id');
        return view('admin.employees.edit',['title'=> trans('admin.edit_employee') ,'departments' => $departments,'employee'=>$employee,'branches'=>$branches,'departmentsbanks'=>$departmentsbanks,'glccs'=>$glccs]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request,[
            'name_ar' => 'required',
            'name_en' => 'required',
            'beginning_date' => 'sometimes',
            'end_date' => 'sometimes',
            'renew_date' => 'sometimes',
            'salary_type' => 'sometimes',
            'salary' => 'sometimes',
            'transition_allowance' => 'sometimes',
            'housing_allowance' => 'sometimes',
            'food_allowance' => 'sometimes',
            'other_allowances' => 'sometimes',
            'work_type' => 'sometimes',
            'number_rest' => 'sometimes',
            'work_status' => 'sometimes',
            'payment_methods' => 'sometimes',
            'workhour_count' => 'sometimes',
            'hour_payment' => 'sometimes',
            'employee_ticket' => 'sometimes',
            'ticket_class' => 'sometimes',
            'children_ticket' => 'sometimes',
            'sales_officer' => 'sometimes',
            'sales_number' => 'sometimes',
            'percentage' => 'sometimes',
            'branches_id' => 'sometimes',
            'companybanks_id' => 'sometimes',
            'company_banks_num' => 'sometimes',
            'employeebanks_id' => 'sometimes',
            'employee_banks_num' => 'sometimes',
            'employee_banks_branches' => 'sometimes',
            'debtor' => 'required',
            'creditor' => 'required',
            'accounts_receivable' => 'sometimes',
            'tree_id' => 'required',
            'cc_id' => 'sometimes',
            'operation_id' => 'sometimes',
            'status' => 'sometimes',
            'statusreport' => 'sometimes',
//            'cc_type' => 'sometimes',
        ],[],[
            'name_ar' => trans('admin.arabic_name'),
            'name_en' => trans('admin.english_name'),
            'debtor' => trans('admin.debtor'),
            'creditor' => trans('admin.creditor'),
        ]);
        $employee = employee::findOrFail($id);
        if ($request->sales_officer){
            $data['sales_officer'] = $request->sales_officer;
        }else{
            $data['sales_officer'] = 0;
        }

//        if ($request->cc_type){
//            $data['cc_type'] = $request->cc_type;
//        }else{
//            $data['cc_type'] = 0;
//        }
        $employee->update($data);
        return redirect(aurl('employees'))->with(session()->flash('message',trans('admin.success_update')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = employee::findOrFail($id);
        DB::table('branche_employee')->where('employee_id',$id)->delete();
        $employee->delete();
        return redirect(aurl('employees'));
    }

    public function stuff_data(){
        $mainCompany = MainCompany::pluck('Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No');
        return view('admin.basic_data.stuff.stuff_data',compact('mainCompany'));
    }

    public function get_Branches(Request $request){

        if($request->ajax())
        {
            $mainCompany =  $request->mainCompany;
            $MainBranch = MainBranch::where('Cmp_No',$request->mainCompany)->get();
            return view('admin.basic_reports.stuff.bran' ,['MainBranch' => $MainBranch,'mainCompany' => $mainCompany]);

        }

    }

    public function get_data_redio (Request $request){
        if($request->ajax())
        {

            return view('admin.basic_reports.stuff.data_redio');
        }
    }

    public function employees_report(){

        $mainCompany = MainCompany::pluck('Cmp_Nm'.ucfirst(session('lang')), 'Cmp_No');
        return view('admin.basic_reports.stuff.stuff_report',['title'=> trans('admin.edit_employee') ,'mainCompany' => $mainCompany]);

    }
}
