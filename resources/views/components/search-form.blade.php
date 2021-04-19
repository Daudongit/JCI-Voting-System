<div class="row">
    <div class="{{$col}}">
        <div class="panel panel-default">
            <form class="form-horizontal" action="{{$route}}" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" aria-label="..."
                        placeholder="please enter your search text here ..." name="keywords">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-search" aria-hidden="true"></i> Search 
                        </button>
                    </div>
                </div>
            </form> 
        </div>
    </div>
</div>