<?php

namespace App\Http\Controllers\Admin;

use App\Result;
use App\Election;
use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $results = Result::paginate(20);

        return view('admin.votes',compact('results'));
    }


    public function show(Election $election)
    {
        //dd($election->slots[1]->nomineesWithResultCount($election->id)->get());
        $slots = $election->slots()->paginate(20);

        return view('admin.results',compact('election','slots'));
    }
} 

