<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeApiController extends Controller
{
    public function index()
    {
        return Employee::all();
    }

    public function store(Request $request)
    {
        $this->dataValidation($request, null);

        $employee = new Employee();
        $this->dataInserting($employee, $request);
        $employee->created_at = Carbon::now();
        $employee->save();

        return response()->json([
            "status" => "success",
            "message" => "One Employee is created."
        ]);
    }

    public function update(Request $request, string $id)
    {
        $this->dataValidation($request, $id);

        $employee = Employee::find($id);
        $this->dataInserting($employee, $request);
        $employee->updated_at = Carbon::now();
        $employee->save();

        return response()->json([
            "status" => "success",
            "message" => "One Employee is updated."
        ]);
    }

    public function destroy(string $id)
    {
        $employee = Employee::find($id);
        $employee->destroy();
        return response()->json([
            "status" => "success",
            "message" => "One Employee is deleted."
        ]);
    }

    private function dataValidation($request, $id){
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

    private function dataInserting($employee, $request){
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->age = $request->age;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->position = $request->position;
    }
}
