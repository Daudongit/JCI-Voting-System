@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @forelse ($slots as $slot)
                    <div class="panel panel-default">
                        <div class="panel-heading level" style="">
                                <span>{{$slot->position->name}}</span>
                            <div class="level">
                                <a class="btn btn-info btn-sm" href="">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <form action="{{ route('admin.slots.destroy', $slot->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                </form>
                                @if ($loop->first)
                                    <a class="btn btn-success btn-sm ml04" href="">
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
                        <div class="panel-heading">No election slot has been found.</div>
                    </div>
                @endforelse
                <div class="text-center">{{$slots->render()}}</div>
            </div>
        </div>
    </div>
@endsection
