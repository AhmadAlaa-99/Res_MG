<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\offer;
use App\Models\images_offer;
class OfferController extends Controller
{
    // images - price_old -   price_new - desc - name - featured - res_id
    /**
     * Display a listing of the resource.
     */
    public function offers_index($id)
    {   
        $offers=offer::where('resturant_id',$id)->with('images')->get();
        $res_id=$id;
        return view('Admin.Offers.index',compact('offers','res_id'));
    }
    public function index()
    {
        //
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
        offer::create([
                   'price_old'=>$request->price_old,
                   'price_new'=>$request->price_new,
                   'desc'=>$request->desc,
                   'name'=>$request->name,
                   'featured'=>$request->featured,
                   'resturant_id'=>$request->res_id
        ]);
        $offer=Offer::latest()->first();
        if($request->hasfile('cover'))
        {
            foreach($request->file('cover') as $file)
            {
                $name = $file->getClientOriginalName();
                $file->storeAs('attachments/offers/cover/'.$offer->name, $file->getClientOriginalName(),'upload_images');
                // insert in image_table
                $images= new images_offer();
                $images->filename=$name;
                $images->imageable_id= $offer->id;
                $images->type='cover';
                $images->imageable_type='App\Models\offer';
                $images->save();
            }
        }
        if($request->hasfile('main'))
        {
            foreach($request->file('main') as $file)
            {
                $name = $file->getClientOriginalName();
                $file->storeAs('attachments/offers/main/'.$offer->name, $file->getClientOriginalName(),'upload_images');
                // insert in image_table
                $images= new images_offer();
                $images->filename=$name;
                $images->imageable_id= $offer->id;
                $images->type='main';
                $images->imageable_type='App\Models\offer';
                $images->save();
            }
        }
        if($request->hasfile('others'))
        {
            foreach($request->file('others') as $file)
            {
                $name = $file->getClientOriginalName();
                $file->storeAs('attachments/offers/others/'.$offer->name, $file->getClientOriginalName(),'upload_images');
                // insert in image_table
                $images= new images_offer();
                $images->filename=$name;
                $images->imageable_id= $offer->id;
                $images->type='others';
                $images->imageable_type='App\Models\offer';
                $images->save();
            }
        }
        return redirect()->route('offers_index',$offer->resturant_id);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function act_inact__offer($id)
    {}
}
