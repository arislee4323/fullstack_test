<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('company.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

     public function api()
    {
        $companies = Company::all();
        $datatables = datatables()->of($companies)->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required',
            
        ]);

        $logo = $request->file;
        $logoname= time().'.'.$logo->getClientOriginalExtension();
        $request->file->move('storage/app/public',$logoname);

       
        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->logo = $logoname;
        $company->save();

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //

        $companies = Company::find($company);
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required',
            
        ]);

        $logo = $request->file;
        $logoname= time().'.'.$logo->getClientOriginalExtension();
        $request->file->move('storage/app/public',$logoname);

        
        $companies->name = $request->name;
        $companies->email = $request->email;
        $companies->logo = $logoname;
        $companies->save();

        return redirect('company');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
        $company->delete();
    }
}
