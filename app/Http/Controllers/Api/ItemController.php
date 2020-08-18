<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Item;
use App\Http\Resources\ItemResource;
class ItemController extends Controller
{
  public function __construct($value='')
  {
    // $this->middleware('auth:api');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items= Item::all();
        return ItemResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //dd($request);
       $request->validate([
        'item_code'=>'required|min:4',
        'item_name'=>'required',
        'item_photo'=>'required',
        'item_price'=>'required',
        'item_discount'=>'required',
        'item_brand'=>'required',
        'item_subcategory'=>'required',
        'item_des'=>'required'
       ]);
       $imageName=time().'.'.$request->item_photo->extension();
       $request->item_photo->move(public_path('backend/itemimg/'),$imageName);
       $myfile='backend/itemimg/'.$imageName;

       // insert data
       // $item->column name=$request->form name

       $item=new Item;
       $item->codeno=$request->item_code;
       $item->name=$request->item_name;
       $item->photo=$myfile;
       $item->price=$request->item_price;
       $item->discount=$request->item_discount;
       $item->description=$request->item_des;
       $item->brand_id=$request->item_brand;
       $item->subcategory_id=$request->item_subcategory;
       $item->save();

       // redirect
       return new ItemResource($item);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item=Item::findOrFail($id);
        return new ItemResource($item);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
