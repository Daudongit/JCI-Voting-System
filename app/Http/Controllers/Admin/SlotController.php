<?php

namespace App\Http\Controllers\Admin;

use App\Slot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $slots = Slot::with('nominees')->paginate(10);

        return view('admin.slot.index',compact('slots'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slot    $slot
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Slot $slot)
    {   
        $slot->position_id = $request->position;
        $slot->save();
        $slot->nominees()->attach($request->nominees);

        return redirect(route('admin.slots.index'))->withSuccess(
            __('Slot successfully created.')
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Slot $slot)
    {
        $slot->position_id = $request->position;
        $slot->save();
        $slot->nominees()->sync($request->nominees);

        return redirect(route('admin.slots.index'))->withSuccess(
            __('Slot successfully updated.')
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slot $slot)
    {
        if($slot->delete())
        {
            return redirect(route('admin.slots.index'))->withSuccess(
                __('Slot successfully deleted.')
            );
        }
    }
}
