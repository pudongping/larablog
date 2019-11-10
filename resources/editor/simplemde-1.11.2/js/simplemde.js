// 引入 node_modules 中 「simplemde」 markdown 编辑器必要 js
require('simplemde/dist/simplemde.min.js');
// 引入 node_modules 中 「highlight」 highlight.js 语法高亮工具
// 代码高亮需要在全局使用，因此直接在 app.js 中已经引用了
// require('highlight.js/lib/highlight.js');

// 图片拖动上传
require('inline-attachment/src/inline-attachment.js');
require('inline-attachment/src/codemirror-4.inline-attachment');

window.markdown_editor = function () {
    window.SimpleMDE = require('simplemde'); // 引入 simplemde
    // Most options demonstrate the non-default behavior
    var unique_id = $('#title').val() ? $('#title').val() : 'markdown';
    var markdown = new SimpleMDE({
        autofocus: true, // 自动对焦编辑器
        autosave: { // 临时保存文本内容 （已经在页面中使用了 old() 辅助函数，因此可以不开启临时保存内容）
            enabled: false, // 如果设置为真，则自动保存文本。默认值为 false。
            uniqueId: unique_id, // 必须设置唯一的字符串标识符，以便 SimpleMDE 可以自动保存。它与网站上其他 SimpleMDE 实例的区别就在于此。
            delay: 1000 // 保存之间的延迟，以毫秒为单位。默认为 10000(10秒)。
        },
        element: document.getElementById("markdownTextarea"), // 要使用的文本区域的DOM元素。默认设置为页面上的第一个文本区域。
        // 自定义某些插入文本的按钮的行为方式。获取一个包含两个元素的数组。第一个元素将是插入光标之前或突出显示之前的文本，第二个元素将插入光标之后。
        insertTexts: {
            horizontalRule: ["", "\n\n-----\n\n"],
            image: ["![](https://", ")"],
            link: ["[", "](https://)"],
            table: ["", "\n\n| Column 1 | Column 2 | Column 3 |\n| -------- | -------- | -------- |\n| Text     | Text      | Text     |\n\n"],
        },
        placeholder: "请使用 Markdown 格式书写 ;-)，代码片段粘贴时请注意使用高亮语法。", // 自定义占位符
        spellChecker: true,  // 开启拼写检查程序
        renderingConfig: { // 在预览期间调整解析标记的设置
            codeSyntaxHighlighting: true // 开启代码高亮
        },
        tabSize: 4, // 自定义缩进间距
        hideIcons: ["heading"], // 隐藏图标
        showIcons: ["code", "horizontal-rule", "table", "strikethrough", "heading-1", "heading-2", "heading-3"],
        toolbar: [

            {
                name: "bold",
                action: SimpleMDE.toggleBold,
                className: "fa fa-bold",
                title: "加粗"
            },

            {
                name: "bold",
                action: SimpleMDE.toggleItalic,
                className: "fa fa-italic",
                title: "斜体"
            },

            {
                name: "strikethrough",
                action: SimpleMDE.toggleStrikethrough,
                className: "fa fa-strikethrough",
                title: "删除线"
            },

            '|',

            {
                name: "heading",
                action: SimpleMDE.toggleHeadingSmaller,
                className: "fa fa-header",
                title: "一级标题"
            },

            {
                name: "heading-1",
                action: SimpleMDE.toggleHeading1,
                className: "fa fa-header fa-header-x fa-header-1",
                title: "一级标题"
            },

            {
                name: "heading-2",
                action: SimpleMDE.toggleHeading2,
                className: "fa fa-header fa-header-x fa-header-2",
                title: "二级标题"
            },

            {
                name: "heading-3",
                action: SimpleMDE.toggleHeading1,
                className: "fa fa-header fa-header-x fa-header-3",
                title: "三级标题"
            },

            '|',

            {
                name: "code",
                action: SimpleMDE.toggleCodeBlock,
                className: "fa fa-code",
                title: "代码"
            },

            {
                name: "quote",
                action: SimpleMDE.toggleBlockquote,
                className: "fa fa-quote-left",
                title: "引用"
            },

            {
                name: "unordered-list",
                action: SimpleMDE.toggleUnorderedList,
                className: "fa fa-list-ul",
                title: "无序列表"
            },

            {
                name: "ordered-list",
                action: SimpleMDE.toggleOrderedList,
                className: "fa fa-list-ol",
                title: "有序列表"
            },

            {
                name: "horizontal-rule",
                action: SimpleMDE.drawHorizontalRule,
                className: "fa fa-minus",
                title: "插入水平线"
            },

            '|',

            {
                name: "link",
                action: SimpleMDE.drawLink,
                className: "fa fa-link",
                title: "创建链接"
            },

            {
                name: "image",
                action: SimpleMDE.drawImage,
                className: "fa fa-picture-o",
                title: "插入图片"
            },

            {
                name: "table",
                action: SimpleMDE.drawTable,
                className: "fa fa-table",
                title: "插入表格"
            },

            '|',

            {
                name: "preview",
                action: SimpleMDE.togglePreview,
                className: "fa fa-eye no-disable",
                title: "预览"
            },

            {
                name: "side-by-side",
                action: SimpleMDE.toggleSideBySide,
                className: "fa fa-columns no-disable no-mobile",
                title: "编辑并预览"
            },

            {
                name: "fullscreen",
                action: SimpleMDE.toggleFullScreen,
                className: "fa fa-arrows-alt no-disable no-mobile",
                title: "全屏"
            },

            {
                name: "guide",
                action: function customFunction(editor) {
                    window.open("#")
                },
                className: "fa fa-question-circle",
                title: "帮助"
            }
        ]
    });

    // 监听文本框值改变
    markdown.codemirror.on("change", function () {
        var html = markdown.value();
        $('input[name="markdownbody"]').val(html);
    });

    // markdown 编辑器，拖拽上传图片
    // 参考：node_modules/inline-attachment/demo/codemirror-4.html
    // 配置项参考：node_modules/inline-attachment/src/inline-attachment.js => inlineAttachment.defaults={}
    var inlineAttachmentConfig = {
        uploadUrl: '/markdown_upload_image',
        extraHeaders: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        progressText: '![文件正在上传中...]()',
        urlText: "![Alex]({filename})",
        errorText: "文件上传失败！",
    };
    inlineAttachment.editors.codemirror4.attach(markdown.codemirror, inlineAttachmentConfig);


    // 侧边栏内容
    $("h2,h3,h4,h5,h6").each(function(i,item){
        var tag = $(item).get(0).localName;
        $(item).attr("id","wow"+i);
        $("#category").append('<a class="new'+tag+'" href="#wow'+i+'">'+$(this).text()+'</a></br>');
        $(".newh2").css("margin-left",0);
        $(".newh3").css("margin-left",20);
        $(".newh4").css("margin-left",40);
        $(".newh5").css("margin-left",60);
        $(".newh6").css("margin-left",80);
    });
// <div id="category"></div>
}



