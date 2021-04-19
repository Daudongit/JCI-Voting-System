@extends('layouts.app')
@section('content')
    <div class="container">
        @component('components.search-form',
            ['route'=>route('admin.positions.index'),'col'=>'col-md-8 col-md-offset-2']
        )@endcomponent
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Candidate Possible Office</div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Edit</th>
                                    <th>Remove</th>
                                    <th>Add</th>
                                </tr>
                            </thead>
                            @forelse ($positions as $position)
                                <tr>
                                    <td scope="row">{{ $position->id }}</td>
                                    <td>{{$position->name}}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="#modalComponet" 
                                            data-toggle="modal" data-action="Edit" 
                                            data-content="{{$position->toJson()}}">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.positions.destroy', $position->id) }}" method="POST"
                                            id="delete_{{$position->id}}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="
                                                    event.preventDefault();
                                                    sweet_alert(()=>{
                                                        document.getElementById('delete_{{$position->id}}').submit();  
                                                    }
                                                );">
                                                <i class="fa fa-times" aria-hidden="true"></i>
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
                                    <td colspan="4">
                                        <div class="text-center">No office found yet. Try to add one</div>
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
                        <div class="text-center">{{$positions->render()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal_component')
	@component('components.modal')
		@slot('modalTitle','Create Category')
		@slot('modalFormAction',route('admin.positions.store'))
		@slot('modalBody')
            <label for="name" class="control-label"> Name:</label>
			<input type="text" class="form-control" id="name" name="name"/>
		@endslot
	@endcomponent
@endsection
@push('js')
    <script type="text/javascript">
         const $realUrl = "{{route('admin.positions.store')}}"
    </script>
    <script type="text/javascript" src="{{asset('assets/js/position.modal.js')}}"></script>
@endpush
