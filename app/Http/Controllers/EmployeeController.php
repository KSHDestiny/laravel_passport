<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $employees = Employee::all();
        return view("index",compact("employees"));
    }

    public function create()
    {
        return view("create");
    }

    public function store(Request $request)
    {
        $this->employeeValidation($request, null);

        $employee = new Employee();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->age = $request->age;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->position = $request->position;
        $employee->created_at = Carbon::now();
        $employee->save();

        Toastr::success("One Employee is successfully created.", "Success Message", ["closeButton" => true, "progressBar" => true, "positionClass" => "toast-bottom-right"]);
        return redirect()->route("employee.index");
    }

    public function edit(string $id)
    {
        $employee = Employee::find($id);
        return view("create",compact("employee"));
    }

    public function update(Request $request, string $id)
    {
        $this->employeeValidation($request, $id);

        $employee = Employee::find($id);
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->age = $request->age;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->position = $request->position;
        $employee->updated_at = Carbon::now();
        $employee->save();

        Toastr::success("One Employee is successfully updated.", "Success Message", ["closeButton" => true, "progressBar" => true, "positionClass" => "toast-bottom-right"]);
        return redirect()->route("employee.index");
    }

    public function destroy(string $id)
    {
        $employee = Employee::find($id);
        $employee->delete();

        return response()->json([
            "status" => "success",
            "message" => "One Employee data has been deleted."
        ]);
    }

    private function employeeValidation($request, $id){
        $request->validate([
            "name" => "required|max:50",
            "email"=> "required|email|unique:employees,email,{$id}",
            "age" => "required|integer|min:16|max:60",
            "phone" => "required",
            "address" => "required",
            "position" => "required"
        ],[
            "age.min" => "An applicant is not old enough to be employee.",
            "age.max" => "An applicant's age exceeds our limitation."
        ]);
    }
}
