@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Election</div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
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
                                    <td>{{$election->title}}</td>
                                    <td>{{$election->results_count}}</td>
                                    <td>
                                        @if($election->isLocked())
                                            <span class="label label-danger">Closed</span>
                                        @elseif($election->isComingSoon())
                                            <span class="label label-info">Soon</span>
                                        @elseif($election->isRunning())
                                            <span class="label label-success">Started</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.elections.destroy', $election->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-sm">
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
                                    <td colspan="7">
                                        <div>No election has been found. Try to add one <a href="">Now</a></div>
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
