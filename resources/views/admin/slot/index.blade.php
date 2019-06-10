@extends('layouts.app')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/select2.min.css')}}"> 
@endpush
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @forelse ($slots as $slot)
                    <div class="panel panel-default">
                        <div class="panel-heading level">
                                {{$slot->id}} <span>{{$slot->position->name}}</span>
                            <div class="level">
                                <a class="btn btn-info btn-sm" href="#modalComponet" 
                                    data-toggle="modal" data-action="Edit" 
                                    data-content="{{$slot->toJson()}}">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <form action="{{ route('admin.slots.destroy', $slot->id) }}" method="POST"
                                    id="delete_{{$slot->id}}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="
                                            event.preventDefault();
                                            sweet_alert(()=>{
                                                document.getElementById('delete_{{$slot->id}}').submit();  
                                            }
                                        );">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                </form>
                                @if ($loop->first)
                                    <a class="btn btn-success btn-sm ml04" href="#modalComponet" 
                                        data-toggle="modal" data-action="Create">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                @forelse ($slot->nominees as $nominee)
                                    <tr>
                                        <td>{{$nominee->id}}</td>
                                        <td>{{$nominee->first_name.' '.$nominee->last_name}}</td>
                                        <td>{{$nominee->email}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">
                                            <div class="text-center">No nominee has been found for this slot.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                    </div> 
                @empty
                    <div class="panel panel-default">
                        <div class="panel-heading level">
                            No election slot has been found.
                            <div class="level">
                                <a class="btn btn-success btn-sm" href="#modalComponet" 
                                    data-toggle="modal" data-action="Create">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
                <div class="text-center">{{$slots->render()}}</div>
            </div>
        </div>
    </div>
@endsection
@section('modal_component')
	@component('components.modal')
		@slot('modalTitle','Create slot')
		@slot('modalFormAction',route('admin.slots.store'))
        @slot('modalBody')
            <div class="form-group">
                <label for="name" class="control-label"> Position:</label>
                <select name="position" id="" class="form-control" required>
                    @foreach ($positions as $position)
                        <option value="{{$position->id}}">
                            {{$position->name}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="name" class="control-label"> Nominees:</label>
                <select name="nominees[]" id="nominees" class="select2 form-control" 
                    multiple required>
                    {{-- <option value="">..select nominees..</option> --}}
                    @foreach ($nominees as $nominee)
                        <option value="{{$nominee->id}}">
                                {{$nominee->first_name.' '.$nominee->last_name}}
                        </option>
                    @endforeach
                </select>
            </div>
		@endslot
	@endcomponent
@endsection
@push('js')
    <script type="text/javascript">
        const $realUrl = "{{route('admin.slots.store')}}"
    </script>
    <script type="text/javascript" src="{{asset('assets/js/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/select2_init.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/slot.modal.js')}}"></script>
@endpush
