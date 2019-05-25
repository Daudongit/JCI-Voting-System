<?php

namespace App\Http\Controllers\Admin;

use App\Slot;
use App\Result;
use App\Nominee;
use App\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $voteCount = Result::count();
        $slotCount = Slot::count();
        $postCount = Position::count();
        $nomineeCount = Nominee::count();
        return view(
            'admin.dashboard',
            compact('voteCount','slotCount','postCount','nomineeCount')
        );
    }
}