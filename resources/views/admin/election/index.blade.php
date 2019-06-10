@extends('layouts.app')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/select2.min.css')}}"> 
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/datetimepicker.css')}}"> 
@endpush
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Election</div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>End</th>
                                    <th>Votes</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Remove</th>
                                    <th>Lock/Unlock</th>
                                    <th>Add</th>
                                </tr>
                            </thead>
                            @forelse ($elections as $election)
                                <tr>
                                    <td scope="row">{{ $election->id }}</td>
                                    <td>
                                        <a href="{{route('admin.results.show',$election->id)}}">
                                            {{$election->title}}
                                        </a>
                                    </td>
                                    <td>{{$election->end->diffForHumans()}}</td>
                                    <td>{{$election->results_count}}</td>
                                    <td>
                                        @if($election->isEnd())
                                            <span class="label label-danger">Closed</span>
                                        @elseif($election->isLocked())
                                            <span class="label label-danger">Locked</span>
                                        @elseif($election->isComingSoon())
                                            <span class="label label-info">Soon</span>
                                        @elseif($election->isRunning())
                                            <span class="label label-success">Started</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="#modalComponet" 
                                            data-toggle="modal" data-action="Edit" 
                                            data-content="{{$election->toJson()}}">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.elections.destroy', $election->id) }}" method="POST"
                                            id="delete_{{$election->id}}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="
                                                event.preventDefault();
                                                sweet_alert(()=>{
                                                        document.getElementById('delete_{{$election->id}}').submit();  
                                                    }
                                                );">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        @php $fa = $election->isLocked()? 'fa fa-unlock': 'fa fa-lock' @endphp
                                        <form action="{{ route('admin.elections.toggle', $election->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <button type="submit" class="btn btn-sm">
                                                <i class="{{ $fa }}" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </td>
                                    @if($loop->index == 0)
                                        <td>
                                            <a class="btn btn-success btn-sm" href="#modalComponet" 
                                                data-toggle="modal" data-action="Create">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    @else
                                        <td>
                                            <button type="submit" class="btn btn-sm" disabled>
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="text-center">No election has been found. Try to add one </div>
                                    </td>
                                    <td>
                                        <a class="btn btn-success btn-sm" href="#modalComponet" 
                                            data-toggle="modal" data-action="Create">
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </table>
                        <div class="text-center">{{$elections->render()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal_component')
	@component('components.modal')
		@slot('modalTitle','Create year')
		@slot('modalFormAction',route('admin.elections.store'))
        @slot('modalBody')
                <label for="title" class="control-label"> Title:</label>
                <input type="text" class="form-control" id="title" name="title" required/>
                <label for="name" class="control-label"> Slots:</label>
                <select name="slots[]" id="slot" class="select2 form-control" 
                    multiple required>
                    @foreach ($slots as $slot)
                        <option value="{{$slot->id}}">
                            {{$slot->position->name.'-slot-'.$slot->id}}
                        </option>
                    @endforeach
                </select>
                <div class="form-group">
                    <label class="control-label col-md-">Start Date</label>
                    <div class="col-md-">
                        <div class="input-group date form_datetime">
                            <input type="text" class="form-control" 
                                readonly="" size="16" name="start_date" required>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-danger date-set">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-">End Date</label>
                    <div class="col-md-">
                        <div class="input-group date form_datetime">
                            <input type="text" class="form-control" 
                                readonly="" size="16" name="end_date" required>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-danger date-set">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
		@endslot
	@endcomponent
@endsection
@push('js')
    <script type="text/javascript">
        const $realUrl = "{{route('admin.elections.store')}}"
    </script>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/election.modal.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/select2_init.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/datetime_init.js')}}"></script>
@endpush