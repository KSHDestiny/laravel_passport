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
        $this->dataValidation($request);

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
        // $data = [
        //     'name' => "Moe Moe",
        //     'email' => "moemoe@gmail.com",
        //     'age' => 23,
        //     'phone' => "091234567332",
        //     'address' => "Yangon",
        //     'position' => "Junior Developer",
        // ];

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'age' => $request->age,
            'phone' => $request->phone,
            'address' => $request->address,
            'position' => $request->position,
        ];


        Validator($data,[
            "name" => "required|max:50",
            "email"=> "required|email|unique:employees,email,{$id}",
            "age" => "required|integer|min:16|max:60",
            "phone" => "required",
            "address" => "required",
            "position" => "required"
        ]);

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

    private function dataValidation($request){
        $request->validate([
            "name" => "required|max:50",
            "email"=> "required|email|unique:employees,email",
            "age" => "required|integer|min:16|max:60",
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
