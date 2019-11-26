
<div class="modal fade" id="{{ $modalId ?? ''}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {{-- modal 框标题内容 --}}
                <h5 class="modal-title" id="myModalLabel">{{ $modalTitle ?? '' }}</h5>
                {{-- 取消符号 × --}}
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- modal 框中间显示内容 --}}
            <div class="modal-body">
                {{ $modalBody ?? '' }}
            </div>
            {{-- modal 框底部内容 --}}
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">取消</button>
                {{ $slot ?? '' }}
                {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
            </div>
        </div>
    </div>
</div>

