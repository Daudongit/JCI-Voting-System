@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.stepy.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fbwall.css') }}">
@endpush
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="stepy-tab">
                        <ul id="default-titles" class="stepy-titles clearfix">
                            @foreach ($election->slots as $slot)
                                <li id="default-title-{{$loop->index}}" 
                                    class="{{$loop->index == 0?'current-step':''}}">
                                    <div>{{str_limit($slot->position->name,5)}}</div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="panel-body">
                    <form method="POST" action="/test" id="default">
                        {{csrf_field()}}
                        <input type="hidden" name="election" value="{{$election->id}}">
                        @foreach ($election->slots as $slot)
                            <fieldset title="{{str_limit($slot->position->name,5)}}" 
                                class="step" id="default-step-{{$loop->index}}">
                                <legend> </legend>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            {{-- <span class="glyphicon glyphicon-arrow-right"></span>  --}}
                                            Vote your choice for <b>{{ $slot->position->name }}</b> position
                                        </h3>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <ul class="list-group">
                                        @foreach ($slot->nominees as $nominee)
                                            <li class="list-group-item">
                                                <div class="fb-user-thumb">
                                                    <img src="/assets/image/profile-avatar.jpg" alt="">
                                                </div>
                                                <div class="fb-user-details">
                                                    <h3><a href="#" class="#">{{$nominee->first_name.' '.$nominee->last_name}}</a></h3>
                                                    <p>for {{$slot->position->name}}</p>
                                                </div>
                                                <div class="clearfix"></div>
                                                <p class="fb-user-status">{{$nominee->discription}}</p>
                                                <div class="fb-status-container fb-border">
                                                    <div class="fb-time-action">
                                                        <input value="{{ $nominee->id }}" type="radio" 
                                                            name="{{$slot->position->id}}">
                                                        <span>-</span>
                                                            Click to vote for <b>{{$nominee->first_name.' '.$nominee->last_name}}</b>
                                                        <span>-</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </fieldset>
                        @endforeach
                        <div class="panel-footer finish">
                            <input type="submit" class="btn btn-danger btn-sm" value="Submit Vote" />
                        </div>
                    </form> 
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script src="{{ asset('assets/js/jquery.stepy.js') }}"></script>
    <script>
        //step wizard
        $(function() {
            $('#default').stepy({
                backLabel: 'Previous',
                block: true,
                nextLabel: 'Next',
                titleClick: true,
                titleTarget: '.stepy-tab'
            });
        });
    </script>
@endpush
