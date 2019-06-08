<?php

namespace App\Http\Controllers\Admin;

use App\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $positions = Position::paginate(20);

        return view('admin.position.index',compact('positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Position $position)
    {
        $this->validate(
            $request,
            ['name'=>'required|string|min:3']
        );
        
        $position->name = $request->name;

        $position->save();

        return redirect(route('admin.positions.index'))->withSuccess(
            __('Position successfully created.')
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        $this->validate(
            $request,
            ['name'=>'required|string|min:3']
        );
        
        $position->name = $request->name;

        $position->save();

        return redirect(route('admin.positions.index'))->withSuccess(
            __('Position successfully updated.')
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {   
        if($position->delete())
        {
            return redirect(route('admin.positions.index'))->withSuccess(
                __('Position successfully deleted.')
            );
        }
    }
}
