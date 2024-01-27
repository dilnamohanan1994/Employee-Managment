<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\EmployeeDataTable;
use App\Models\Employee;
use App\Models\Company;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dataTable = new EmployeeDataTable();
            return $dataTable->ajax();
        }
        return view('employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();
        return view('employee.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        try {
            $employee = new Employee();
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->company_id = $request->company_id;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->save();
    
            return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->route('employees.index')->with('error', $th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $companies = Company::all();
        return view('employee.edit', compact('employee', 'companies'));
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
        try {
            $employee = Employee::findOrFail($id);
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->company_id = $request->company_id;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->save();
    
            return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
        } catch (\Throwable $th) {
            \Log::error('Error updating employee: ' . $th->getMessage());
            return redirect()->route('employees.index')->with('error', 'An error occurred while updating the employee.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();
    
            return response()->json(['message' => 'Employee deleted successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred while deleting the Employee'], 500);
        }
    }
}
