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
                                <h3 class="font-bold no-margins">Nominees</h3>
                                <small>Number of Nominee</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"> 
                        <div class="widget lazur-bg p-lg text-center">
                            <div class="m-b-md">
                                <i class="fa fa-sitemap fa-4x"></i>
                                <h1 class="m-xs">{{$voteCount.'/'.$electionCount}}</h1>
                                <h3 class="font-bold no-margins">Vote/Election</h3>
                                <small>Number of election</small>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-6"> 
                        <div class="widget yellow-bg p-lg text-center">
                            <div class="m-b-md">
                                <i class="fa fa-pencil-square-o fa-4x"></i>
                                <h1 class="m-xs">{{$postCount}}</h1>
                                <h3 class="font-bold no-margins">Post</h3>
                                <small>Number of post for nominee</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"> 
                        <div class="widget red-bg p-lg text-center">
                            <div class="m-b-md">
                                <i class="fa fa-list-alt fa-4x"></i>
                                <h1 class="m-xs">{{$slotCount}}</h1>
                                <h3 class="font-bold no-margins">Slot</h3>
                                <small>Number of slot</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
