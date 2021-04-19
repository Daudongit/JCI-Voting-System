@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @php
                $class = count($elections)>1?'col-md-4':'col-md-6 col-md-offset-3';
            @endphp
            @forelse ($elections as $election)
                <!-- item -->
                <div class="{{$class}} text-center">
                    <div class="panel panel-info panel-pricing">
                        <div class="panel-heading">
                            <i class="fa fa-sitemap"></i>
                            <h4>{{str_limit($election->title,30)}}</h4>
                        </div>
                        <div class="panel-body text-center">
                            <p>Start Date:
                                <strong>
                                    {{$election->start->toDayDateTimeString()}}
                                </strong>
                            </p>
                            <p>End Date:
                                <strong>
                                    {{$election->end->toDayDateTimeString()}}
                                </strong>
                            </p>
                        </div>
                        <ul class="list-group text-center">
                            <li class="list-group-item"><i class="fa fa-check"></i>Number of Category: {{$election->slots_count}}		                            </li>
                            {{-- <li class="list-group-item"><i class="fa fa-check"></i>Votes count: {{$election->results_count}}		                            </li> --}}
                            <li class="list-group-item">
                                <i class="fa fa-check"></i>
                                Status: 
                                @if($election->isEnd())
                                    <span class="label label-danger">Closed</span>
                                @elseif($election->isLocked())
                                    <span class="label label-danger">Locked</span>
                                @elseif($election->isComingSoon())
                                    <span class="label label-info">Soon</span>
                                @elseif($election->isRunning())
                                    <span class="label label-success">Ongoing</span>
                                @endif		                            
                            </li>
                        </ul>
                        <div class="panel-footer">				 
                            <button  
                                onClick="window.location.href='{{route('front.vote.show',$election->id)}}'" 
                                class="btn btn-info btn-md" 
                                {{$election->isRunning() && !$election->isEnd()?'':'disabled'}}>
                                ...<b>Vote</b>...
                            </button> 
                            {{-- <form action="{{route('front.vote.show',$election->id)}}" method="POST" 
                                target="_blank" id="vote_{{$election->id}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="signature" value="{{$signature}}">
                                <button type="submit" class="btn btn-info btn-md"
                                    onclick="event.preventDefault();
                                    document.getElementById('vote_{{$election->id}}').submit();"
                                    {{$election->isRunning() && !$election->isEnd()?'':'disabled'}}>
                                    ...<b>Vote</b>...
                                </button>
                            </form> --}}
                        </div>
                    </div>
                </div>
                <!-- /item -->
            @empty
                <p class="text-center"><strong>No  election  has been found. </strong></p>
            @endforelse
            {{$elections->render()}}
        </div>
    </div>
</div>
@endsection
