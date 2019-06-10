@extends('layouts.app')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/MultiFileUpload.css')}}"> 
@endpush
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Nominees </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Profile</th>
                                    <th>Edit</th>
                                    <th>Remove</th>
                                    <th>Add</th>
                                </tr>
                            </thead>
                            @forelse ($nominees as $nominee)
                                <tr>
                                    <td scope="row">{{ $nominee->id }}</td>
                                    <td>{{$nominee->first_name.' '.$nominee->last_name}}</td>
                                    <td>{{$nominee->description}}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="#modalComponet" data-toggle="modal"
                                            data-action="Edit" data-content="{{$nominee->toJson()}}">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.nominees.destroy', $nominee->id) }}" method="POST"
                                            id="delete_{{$nominee->id}}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="
                                                    event.preventDefault();
                                                    sweet_alert(()=>{
                                                        document.getElementById('delete_{{$nominee->id}}').submit();  
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
                                    <td colspan="5">
                                        <div class="text-center">No nominee has been found. Try to add one </div>
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
                        <div class="text-center">{{$nominees->render()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal_component')
	@component('components.modal')
		@slot('modalTitle','Create Nominee')
		@slot('modalFormAction',route('admin.nominees.store'))
		@slot('modalBody')
			<label for="recipient-name" class="control-label">First Name:</label>
			<input type="text" class="form-control" id="first_name" name="first_name">
			<label for="recipient-name" class="control-label">Last Name:</label>
            <input type="text" class="form-control" id="last_name" name="last_name">
			<label for="recipient-name" class="control-label">Email:</label>
            <input type="text" class="form-control" id="email" name="email">
            <label for="description" class="control-label"> Description:</label>
			<input type="text" class="form-control" id="description" name="description"/>
			<div class="file-upload-previews">
				<div class="MultiFile-label">
					<a class="MultiFile-remove" href="#" id="removeAdImg">x</a> 
					<span>
						<span class="MultiFile-label" 
							title="File selected: image.jpg">
							<span class="MultiFile-title">Image</span>
							<img class="MultiFile-preview" 
								style="max-height:100px;product max-width:100px;" 
								src="img.jpg">
						</span>
					</span>
					<input type="hidden" name="previousImage" value="" />
				</div>
			</div>
			<div class="file-upload">
				<input type="file" name="image" class="file-upload-input with-preview"  
					title="Click to add files" maxlength="1" accept="jpg|jpeg|png" 
					onchange="checkFile(this)" id="img">
				<span style="color:#000">CLICK OR DRAG IMAGE HERE</span>
			</div>
		@endslot
	@endcomponent
@endsection
@push('js')
    <script type="text/javascript">
        const $realUrl = "{{route('admin.nominees.store')}}"
    </script>
    <script type="text/javascript" src="{{asset('assets/js/jQuery.MultiFile.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/MultiFileUpload.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/nominee.modal.js')}}"></script>
@endpush