<?php

namespace App\Http\Controllers;

use App\Investigation;
use\App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class investigationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //List all available investigations
        $investigations = Investigation::all();
        $services = Service::all();
        return view('investigations/index')->with('investigations', $investigations)->with('services', $services);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();
        return view('investigations/create')->with('services', $services);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Request validation
        $this->validate($request, [
        'name' => 'required|unique:investigations|max:50',
        'price' => 'required|integer|max:900000',
        ]);
        // The investigation is valid, store in database
        $investigation = new Investigation;
        $investigation->name = $request->name;
        $investigation->price = $request->price;
        $investigation->user = Auth::user()->name;
        $investigation->save();
        $investigations = Investigation::all();
        $services = Service::all();
        return view('investigations/index')->with('investigations', $investigations)->with('services', $services);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Investigation  $investigation
     * @return \Illuminate\Http\Response
     */
    public function show(Investigation $investigation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Investigation  $investigation
     * @return \Illuminate\Http\Response
     */
    public function edit($investigation)
    {
        //the form for editing available investigations ilishaundwa ile
        $investigation = Investigation::find($investigation);
        $services = Service::all();
        return view('investigations/edit')->with('investigation', $investigation)->with('services', $services);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Investigation  $investigation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $investigation)
    {
        // Validate the request...
        $this->validate($request, [
            'name' => 'required|max:50',
            'price' => 'required|integer|max:900000',
        ]);
        // The investigation is valid, store in database...
        $investigation = Investigation::find($investigation);
        $investigation->name = $request->name;
        $investigation->price = $request->price;
        $investigation->user = $request->user;
        $investigation->created_at = $request->created_at;
        $investigation->updated_at = date("Y-m-d H:i:s");
        $investigation->save();
        $investigations = Investigation::all();
        $services = Service::all();
        return view('investigations/index')->with('investigations', $investigations)->with('services', $services);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Investigation  $investigation
     * @return \Illuminate\Http\Response
     */
    public function destroy($investigation)
    {
        //Deletes data from the Database BEWARE OF THIS DOG
        $investigation = Investigation::destroy($investigation);
        $investigations = Investigation::all();
        $services = Service::all();
        return view('investigations/index')->with('investigations', $investigations)->with('services', $services);
    }
}