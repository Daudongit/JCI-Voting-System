@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading level">
                        <strong>{{$election->title}}</strong>
                        <div class="level">
                            <a class="btn btn-success btn-sm ml04" 
                                href="{{route('admin.elections.index')}}">
                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @forelse ($slots as $slot)
                    <div class="panel panel-default">
                        <div class="panel-heading level" >
                            <span>{{$slot->position->name}}</span>
                            <div class="level">
                                <a class="btn btn-default btn-sm ml04" 
                                    href="{{route('admin.results.export',[$election->id,$slot->id])}}">
                                    <img src="/assets/image/xls.png" width="21"/>
                                </a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nominee</th>
                                        <th>Vote Count</th>
                                    </tr>
                                </thead>
                                @forelse ($slot->nomineesWithResultCount($election->id) as $nominee)
                                    <tr>
                                        <td>{{$nominee->id}}</td>
                                        <td>{{$nominee->first_name.' '.$nominee->last_name}}</td>
                                        <td>{{$nominee->results_count}}</td>
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
                        <div class="panel-heading">No result has been found.</div>
                    </div>
                @endforelse
                <div class="text-center">{{$slots->render()}}</div>
            </div>
        </div>
    </div>
@endsection
