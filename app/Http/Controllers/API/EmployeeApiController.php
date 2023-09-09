<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EmployeeApiController extends Controller
{
    public function index()
    {
        return Employee::all();
    }

    public function store(Request $request)
    {
        $employee = new Employee();

        $data = $this->data($request);

        $validator = $this->dataValidation($data, null);
        if ($validator->fails()) {
            return response()->json([
                "status" => "fail",
                "message" => "Input data is invalid."
            ]);
        }
        $validator->validated();

        $this->dataInserting($employee, $request);
        $employee->created_at = Carbon::now();
        $employee->save();

        return response()->json([
            "status" => "success",
            "message" => "One Employee is created."
        ]);
    }

    public function updateData(Request $request, string $id)
    {
        $employee = Employee::find($id);

        if(empty($employee)){
            return response()->json([
                "status" => "fail",
                "message" => "There is no data in id:{$id}."
            ]);
        }

        $data = $this->data($request);

        $validator = $this->dataValidation($data, $id);
        if ($validator->fails()) {
            return response()->json([
                "status" => "fail",
                "message" => "Input data is invalid."
            ]);
        }
        $validator->validated();

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
        if(empty($employee)){
            return response()->json([
                "status" => "fail",
                "message" => "There is no data in id:{$id}."
            ]);
        }
        $employee->delete();
        return response()->json([
            "status" => "success",
            "message" => "One Employee is deleted."
        ]);
    }

    private function data($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'age' => $request->age,
            'phone' => $request->phone,
            'address' => $request->address,
            'position' => $request->position,
        ];
    }

    private function dataValidation($data, $id){
        return Validator::make($data,[
            "name" => "required|max:50",
            "email"=> "required|email|unique:employees,email,{$id}",
            "age" => "required|integer|between:18,30",
            "phone" => "required",
            "address" => "required",
            "position" => "required"
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
