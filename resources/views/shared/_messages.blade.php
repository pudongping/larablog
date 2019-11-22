@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(session()->has($msg))
        
        <div class="alert alert-{{$msg}} alert-dismissible flash-message" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check-circle fa-lg fa-fw"></i>
            <strong style="text-transform: capitalize">{{$msg}}!</strong> {{ session()->get($msg) }}
        </div>

    @endif
@endforeach
