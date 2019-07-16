@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading level">
                        <strong>Votes</strong>
                        <div class="level">
                            <a class="btn btn-default btn-sm ml04" 
                                href="{{route('admin.results.votes.export')}}">
                                <img src="/assets/image/xls.png" width="21"/>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Voter</th>
                                    <th>Post</th>
                                    <th>Nominee</th>
                                    <th>Election</th>
                                </tr>
                            </thead>
                            @forelse ($results as $result)
                                <tr>
                                    <td scope="row">{{ $result->id }}</td>
                                    <td>{{$result->voter}}</td>
                                    <td>{{$result->post}}</td>
                                    <td>{{$result->nominee}}</td>
                                    <td>{{$result->election}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="text-center">No vote  has been found.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </table>
                        <div class="text-center">{{$results->render()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
