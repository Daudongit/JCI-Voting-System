@extends('layouts.app')

@section('content')
    <div class="container">
        @component('components.search-form',
            ['route'=>route('admin.results.index'),'col'=>'col-md-12']
        )@endcomponent
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading level">
                        <strong>Election Votes</strong>
                        <div class="level"></div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Voter</th>
                                    <th>Office</th>
                                    <th>Canditate</th>
                                    <th>Session/Election</th>
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
