@if(session()->has('success') || session()->has('warning'))
    <div class="alert alert-{{session('warning')?'warning':'success'}} alert-dismissible text-center" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
        {{session('warning')?:session('success')}}
    </div>
@endif


@if($errors->any())
    <div class="alert alert-danger text-center" alert-dismissible role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        ! @foreach($errors->all() as $error)
            {{$error}} 
          @endforeach
      </div>
@endif