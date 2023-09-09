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
        $data = $this->data($request);

        $validator = $this->dataValidation($data, null);
        if ($validator->fails()) {
            return response()->json([
                "status" => "fail",
                "message" => "Input data is invalid."
            ]);
        }
        $validator->validated();

        Employee::create($data);

        return response()->json([
            "status" => "success",
            "message" => "One Employee is created."
        ]);
    }

    public function updateData(Request $request, string $id)
    {

        $data = $this->data($request);

        $validator = $this->dataValidation($data, $id);
        if ($validator->fails()) {
            return response()->json([
                "status" => "fail",
                "message" => "Input data is invalid."
            ]);
        }
        $validator->validated();

        Employee::where('id',$id)->update($data);

        return response()->json([
            "status" => "success",
            "message" => "One Employee is updated."
        ]);
    }

    public function destroy(string $id)
    {
        $employee = Employee::find($id);
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
}
