<?php

namespace App\Http\Controllers;

use App\Models\Reinstatement;
use Illuminate\Http\Request;
use DB;
class ReinstatementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reinstatement  $reinstatement
     * @return \Illuminate\Http\Response
     */
    public function show(Reinstatement $reinstatement)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reinstatement  $reinstatement
     * @return \Illuminate\Http\Response
     */
    public function edit(Reinstatement $reinstatement)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reinstatement  $reinstatement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reinstatement $reinstatement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reinstatement  $reinstatement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reinstatement $reinstatement)
    {
        //
    }
}
