@if (count($users))

    <ul class="list-group mt-4 border-0">
        @foreach ($users as $user)
            <li class="list-group-item pl-2 pr-2 border-right-0 border-left-0 @if($loop->first) border-top-0 @endif">

                <img class="img-circle mr-3" src="{{ $user->avatar }}" alt="{{ $user->name }}" width=40>
                <a href="{{ route('users.show', $user->id) }}">
                    {{ $user->name }}
                </a>

            </li>
        @endforeach
    </ul>

@else
    <div class="empty-block" style="margin-top: 20px">暂无数据 ~_~ </div>
@endif

{{-- 分页 --}}
<div class="mt-4 pt-1">
    {!! $users->render() !!}
</div>
