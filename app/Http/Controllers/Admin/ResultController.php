<?php

namespace App\Http\Controllers\Admin;

use App\Result;
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
}