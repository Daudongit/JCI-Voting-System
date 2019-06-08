<?php

namespace App\Http\Controllers\Admin;

use App\Election;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ElectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $elections = Election::with('slots')
            ->withCount('results')->paginate(20);

        return view('admin.election.index',compact('elections'));
    }
 
    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Election $election
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Election $election)
    {   
        $this->validateRequest($request);

        $election->title = $request->title;
        $election->start = $request->start_date;
        $election->end = $request->end_date;
        $election->save();
        $election->slots()->attach($request->slots);

        return redirect(route('admin.elections.index'))->withSuccess(
            __('Election successfully created.')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Election  $election
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Election $election)
    {
        $this->validateRequest($request);

        $election->title = $request->title;
        $election->start = $request->start_date;
        $election->end = $request->end_date;
        $election->save();
        $election->slots()->sync($request->slots);

        return redirect(route('admin.elections.index'))->withSuccess(
            __('Election successfully updated.')
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Election  $election
     * @return \Illuminate\Http\Response
     */
    public function destroy(Election $election)
    {
        if($election->delete())
        {
            return redirect(route('admin.elections.index'))->withSuccess(
                __('Election successfully deleted.')
            );
        }
    }

    public function toggle(Election $election)
    {
        $election->status = $election->status == 1?0:1;
        $election->save();

        return redirect(route('admin.elections.index'))->withSuccess(
            __('Election successfully updated.')
        );
    }
    
    private function validateRequest($request)
    {
        $this->validate(
            $request,
            [
              'title'=>'required|string|min:3',
              'end_date' => 'required|date|after:start_date'
            ]
        );
    }
}
