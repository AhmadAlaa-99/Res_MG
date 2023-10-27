<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cuisine;

class CuisineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cuisines=Cuisine::all();
        return view('Admin.cuisines',compact('cuisines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Cuisine::create(['name'=>$request->name,'desc'=>$request->description]);
        return redirect()->route('cuisines.index');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Cuisine::where('id',$id)->update([
            'name'=>$request->name,
            'desc'=>$request->description,
        ]);
        return route('cuisines.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cuisine::where('id',$id)->destroy();
        return route('cuisines.index');
    }
}
