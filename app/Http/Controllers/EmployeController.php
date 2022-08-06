<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;
use App\Models\Company;
class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $companies = Company::all();
        return view('employe.index', compact('companies'));
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
        $employes = Employe::all();
        $datatables = datatables()->of($employes)->addIndexColumn();

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
            'firstname'=>'required',
            'lastname'=>'required',
            'company_id'=>'required',
            'email'=>'required',
            'phone'=>'required',
            
        ]);

        
       
        $employe = new Employe();
        $employe->firstname = $request->firstname;
        $employe->lastname = $request->lastname;
        $employe->company_id = $request->company_id;
        $employe->email = $request->email;
        $employe->phone = $request->phone;
        $employe->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function show(Employe $employe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function edit(Employe $employe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employe $employe)
    {
        //
        $this->validate($request,[
            'firstname'=>'required',
            'lastname'=>'required',
            'company_id'=>'required',
            'email'=>'required',
            'phone'=>'required',
            
        ]);

        
       
        
        $employe->firstname = $request->firstname;
        $employe->lastname = $request->lastname;
        $employe->company_id = $request->company_id;
        $employe->email = $request->email;
        $employe->phone = $request->phone;
        $employe->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employe $employe)
    {
        //
        $employe->delete();
    }
}
