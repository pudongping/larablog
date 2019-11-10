@extends('portal.layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
@stop

@section('content')

    <div class="container">
        <div class="col-md-10 offset-md-1">
            <div class="card ">

                <div class="card-body">
                    <h2 class="">
                        <i class="far fa-edit"></i>
                        @if($article->id)
                            编辑文章
                        @else
                            新建文章
                        @endif
                    </h2>

                    <hr>

                    @if($article->id)
                        <form action="{{ route('articles.update', $article->id) }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id" value="{{ $article->id }}">
                    @else
                        <form action="{{ route('articles.store') }}" method="POST" accept-charset="UTF-8">
                    @endif

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            @include('shared._error')

                            <div class="form-group">
                                <input class="form-control" type="text" name="title" value="{{ old('title', $article->title ) }}" placeholder="请填写标题" required />
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="category_id" required>
                                    <option value="" hidden disabled {{ $article->id ? '' : 'selected' }}>请选择分类</option>
                                    @foreach ($categories as $value)
                                        <option value="{{ $value->id }}" {{ $article->category_id == $value->id ? 'selected' : '' }}>
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- 采用 markdown 文本 --}}
                            <div class="form-group" id="markdownEditor">
                                <textarea name="markdownbody" class="form-control" id="markdownTextarea" rows="6" placeholder="请填入至少三个字符的内容。">{{ old('body', html_2_markdown($article->body) ) }}</textarea>
                                <input type="hidden" name="is_markdown" value="1">
                            </div>

                            {{-- 采用 html 文本 --}}
                            <div class="form-group" id="htmlEditor" style="display: none;">
                                <textarea name="htmlbody" class="form-control" id="htmlTextarea" rows="6" placeholder="请填入至少三个字符的内容。">{{ old('body', $article->body ) }}</textarea>
                            </div>

                            <div class="well well-sm">
                                <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i> 保存</button>

                                <div class="btn-group" role="group" aria-label="">
                                    <button type="button" class="btn btn-success" onclick="choice_editor(true)"><i class="fab fa-markdown mr-2" aria-hidden="true"></i> markdown</button>
                                    <button type="button" class="btn btn-success" onclick="choice_editor(false)"><i class="fas fa-code mr-2" aria-hidden="true"></i> 富文本</button>
                                </div>

                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>
    <script type="text/javascript" src="{{ mix('js/simplemde.js') }}"></script>

    <script>

        $(document).ready(function() {
            markdown_editor();
            html_editor();
        })

        function choice_editor(editorCategory) {
            var markdownEditor = $('#markdownEditor');
            var htmlEditor = $('#htmlEditor');
            if (editorCategory) {
                console.log('预计触发markdown');
                markdownEditor.css('display', 'block');
                htmlEditor.css("display","none");
                $('input[name="is_markdown"]').val(1);
            } else {
                console.log('预计触发html');
                markdownEditor.css("display","none");
                htmlEditor.css('display', 'block');
                $('input[name="is_markdown"]').val(0);
            }
        }

        function html_editor() {
            var editor = new Simditor({
                textarea: $('#htmlTextarea')
                ,toolbar: [
                    'title',  // 标题
                    'bold',  // 加粗
                    'italic',  // 斜体
                    'underline',  // 下划线文字
                    // 'strikethrough',  // 删除线文字
                    'fontScale',  // 字体大小
                    'color',  // 文字颜色
                    'ol',  // 有序列表
                    'ul',  // 无序列表
                    'blockquote',  // 引用
                    'code', // 代码
                    'table',  // 表格
                    'link',  // 链接
                    'image',  // 图片
                    'hr',  // 下划线
                    'indent',  // 向右缩进
                    'outdent',  // 向左缩进
                    'alignment'  // 水平对齐
                ]
                ,upload:{
                    url: '{{ route('articles.upload_image') }}'
                    ,params: {
                        _token: '{{ csrf_token() }}'
                    }
                    ,fileKey: 'image'
                    ,connectionCount: 3
                    ,leaveConfirm: '文件上传中，关闭此页面将取消上传。'
                }
                ,pasteImage: true  // 支持图片黏贴上传
            });
        }

    </script>
@stop
