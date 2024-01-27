<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CompanyDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\CompanyUpdateRequest;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dataTable = new CompanyDataTable();
            $query = Company::query();
            return $dataTable->dataTable($query)->make(true);
        }
        return view('companies.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        try {
            $logoPath = $request->file('logo')->store('logos', 'public');

            $company = new Company();
            $company->name = $request->name;
            $company->email = $request->email;
            $company->logo = $logoPath;
            $company->website = $request->website;
            $company->save();
    
            return redirect()->route('companies.index')->with('success', 'Company created successfully.');
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->route('companies.index')->with('error', $th);
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
        $company = Company::findOrFail($id);
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyUpdateRequest $request, $id)
    {
        try {
            $company = Company::findOrFail($id);
    
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
                $company->logo = $logoPath;
            }
            $company->name = $request->name;
            $company->email = $request->email;
            $company->website = $request->website;
            $company->save();
    
            return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
        } catch (\Throwable $th) {
            \Log::error('Error updating company: ' . $th->getMessage());
            return redirect()->route('companies.index')->with('error', 'An error occurred while updating the company.');
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
            $company = Company::findOrFail($id);
            $company->delete();
    
            return response()->json(['message' => 'Company deleted successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred while deleting the company'], 500);
        }
    }
}
