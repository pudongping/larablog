require('./bootstrap');

// 引入 node_modules 中 「highlight」 highlight.js 语法高亮工具
// require('highlight.js/lib/highlight.js');
// 添加全局变量
window.hljs = require('highlight.js/lib/index');
// for 代码高亮（在这里初始化，可使得全局有代码处都可以高亮）
hljs.initHighlightingOnLoad();
