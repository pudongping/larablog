<div class="card ">
    <div class="card-body">
        <a href="{{ route('articles.create') }}" class="btn btn-success btn-block" aria-label="Left Align">
            <i class="fas fa-pencil-alt mr-2"></i>  新建博文
        </a>
    </div>
</div>

{{-- 当前活跃用户 --}}
@if (count($activeUsers))
    <div class="card mt-4">
        <div class="card-body active-users pt-2">
            <div class="text-center mt-1 mb-0 text-muted">活跃用户</div>
            <hr class="mt-2">
            @foreach ($activeUsers as $activeUser)
                <a class="media mt-2" href="{{ route('users.show', $activeUser->id) }}">
                    <div class="media-left media-middle mr-2 ml-1">
                        <img src="{{ $activeUser->avatar }}" width="24px" height="24px" class="media-object" alt="{{ $activeUser->name }}">
                    </div>
                    <div class="media-body">
                        <small class="media-heading text-secondary">{{ $activeUser->name }}</small>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif

{{-- 文章标签 --}}
@if (count($tags))
    <div class="card mt-4">
        <div class="card-body pt-2">
            <div class="text-center mt-1 mb-0 text-muted">标签</div>
            <hr class="mt-2 mb-3">
            @foreach ($tags as $tag)
                <a class="btn btn-outline-{{ $tag->btn_class }}  btn-sm mr-2 mt-2" role="button" href="#">
                    <span >{{ $tag->name }}</span>
                </a>
            @endforeach
        </div>
    </div>
@endif

{{-- 资源推荐 --}}
@if (count($links))
    <div class="card mt-4">
        <div class="card-body pt-2">
            <div class="text-center mt-1 mb-0 text-muted">资源推荐</div>
            <hr class="mt-2 mb-3">
            @foreach ($links as $link)
                <a class="media mt-1" href="{{ $link->link }}">
                    <div class="media-body">
                        <span class="media-heading text-muted">{{ $link->title }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif

