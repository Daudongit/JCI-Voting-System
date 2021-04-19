@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{asset('assets/css/widget.css')}}">
@endpush
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    <div class="col-md-6">            
                        <div class="widget navy-bg p-lg text-center">
                            <div class="m-b-md">
                                <i class="fa fa-users fa-4x"></i>
                                <h1 class="m-xs">{{$nomineeCount}}</h1>
                                <h3 class="font-bold no-margins">Honorees</h3>
                                <small>Number of candidate</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"> 
                        <div class="widget lazur-bg p-lg text-center">
                            <div class="m-b-md">
                                <i class="fa fa-sitemap fa-4x"></i>
                                <h1 class="m-xs">{{$voteCount.'/'.$electionCount}}</h1>
                                <h3 class="font-bold no-margins">Votes/Years</h3>
                                <small>Number of votes in years</small>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-6"> 
                        <div class="widget yellow-bg p-lg text-center">
                            <div class="m-b-md">
                                <i class="fa fa-pencil-square-o fa-4x"></i>
                                <h1 class="m-xs">{{$postCount}}</h1>
                                <h3 class="font-bold no-margins">Categories</h3>
                                <small>Number of office for candidate</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"> 
                        <div class="widget red-bg p-lg text-center">
                            <div class="m-b-md">
                                <i class="fa fa-list-alt fa-4x"></i>
                                <h1 class="m-xs">{{$slotCount}}</h1>
                                <h3 class="font-bold no-margins">Slots</h3>
                                <small>Number of slot</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
