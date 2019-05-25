@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Nominees </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Edit</th>
                                    <th>Remove</th>
                                    <th>Add</th>
                                </tr>
                            </thead>
                            @forelse ($nominees as $nominee)
                                <tr>
                                    <td scope="row">{{ $nominee->id }}</td>
                                    <td>{{$nominee->first_name.' '.$nominee->last_name}}</td>
                                    <td>{{$nominee->email}}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.nominees.destroy', $nominee->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </td>
                                    @if($loop->index == 0)
                                        <td>
                                            <a class="btn btn-success btn-sm" href="">
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
                                    <td colspan="6">
                                        <div>No nominee has been found. Try to add one <a href="">Now</a></div>
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
