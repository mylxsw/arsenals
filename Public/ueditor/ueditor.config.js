/**
 *  ueditor完整配置项
 *  可以在这里配置整个编辑器的特性
 */
(function () {

    var URL = window.UEDITOR_HOME_URL;
    var phpsessionid = $.cookie('PHPSESSID');
    window.UEDITOR_CONFIG = {
        //为编辑器实例添加一个路径，这个不能被注释
        UEDITOR_HOME_URL : URL

		//图片上传配置区
        ,imageUrl:basePath+"Common/libs/ueditor/imageUp.php?PHPSESSID=" + phpsessionid             //图片上传提交地址
        ,imagePath:basePath + 'Common/libs/ueditor/'                  //图片修正地址，引用了fixedImagePath,如有特殊需求，可自行配置
       //,imageFieldName:"upfile"                   //图片数据的key,若此处修改，需要在后台对应文件修改对应参数
        //,compressSide:0                            //等比压缩的基准，确定maxImageSideLength参数的参照对象。0为按照最长边，1为按照宽度，2为按照高度
        ,maxImageSideLength:4900                    //上传图片最大允许的边长，超过会自动等比缩放,不缩放就设置一个比较大的值，更多设置在image中
        ,savePath: [ '../../../Resources/uploads/' ]

        //涂鸦图片配置区
        ,scrawlUrl:basePath+"Common/libs/ueditor/scrawlUp.php?PHPSESSID=" + phpsessionid           //涂鸦上传地址
        ,scrawlPath:basePath + "Common/libs/ueditor/"                           //图片修正地址，同imagePath
        //附件上传配置区
        ,fileUrl:basePath+"Common/libs/ueditor/fileUp.php?PHPSESSID=" + phpsessionid               //附件上传提交地址
        ,filePath:basePath + "Common/libs/ueditor/"                   //附件修正地址，同imagePath
        //,fileFieldName:"upfile"                    //附件提交的表单名，若此处修改，需要在后台对应文件修改对应参数

         //远程抓取配置区
        //,catchRemoteImageEnable:true               //是否开启远程图片抓取,默认开启
        ,catcherUrl:basePath +"Common/libs/ueditor/getRemoteImage.php?PHPSESSID=" + phpsessionid   //处理远程图片抓取的地址
        ,catcherPath:basePath + "Common/libs/ueditor/"                   //图片修正地址，同imagePath
        //,catchFieldName:"upfile"                   //提交到后台远程图片uri合集，若此处修改，需要在后台对应文件修改对应参数
        //,separater:'ue_separate_ue'               //提交至后台的远程图片地址字符串分隔符
        //,localDomain:[]                            //本地顶级域名，当开启远程图片抓取时，除此之外的所有其它域名下的图片都将被抓取到本地,默认不抓取127.0.0.1和localhost

        //图片在线管理配置区
        ,imageManagerUrl:basePath + "Common/libs/ueditor/imageManager.php?PHPSESSID=" + phpsessionid       //图片在线管理的处理地址
        ,imageManagerPath:basePath + "Common/libs/ueditor/"                                      //图片修正地址，同imagePath
        //屏幕截图配置区
        ,snapscreenHost: basePath                                  //屏幕截图的server端文件所在的网站地址或者ip，请不要加http://
        ,snapscreenServerUrl: basePath +"Common/libs/ueditor/imageUp.php?PHPSESSID=" + phpsessionid //屏幕截图的server端保存程序，UEditor的范例代码为“URL +"server/upload/php/snapImgUp.php"”
        ,snapscreenPath: basePath + "Common/libs/ueditor/"  
        //,snapscreenServerPort: 80                                    //屏幕截图的server端端口
        //,snapscreenImgAlign: 'center'                                //截图的图片默认的排版方式

        //word转存配置区
        ,wordImageUrl:basePath + "Common/libs/ueditor/imageUp.php?PHPSESSID=" + phpsessionid             //word转存提交地址
        ,wordImagePath:''                       //
        //,wordImageFieldName:"upfile"                     //word转存表单名若此处修改，需要在后台对应文件修改对应参数

        //获取视频数据的地址
        ,getMovieUrl:basePath+"Common/libs/ueditor/getMovie.php?PHPSESSID=" + phpsessionid                   //视频数据获取地址
        ,videoUrl:basePath+"Common/libs/ueditor/fileUp.php?PHPSESSID=" + phpsessionid               //附件上传提交地址
        ,videoPath:basePath + "Common/libs/ueditor/"                   //附件修正地址，同imagePath
        //工具栏上的所有的功能按钮和下拉框，可以在new编辑器的实例时选择自己需要的从新定义
        , toolbars:[
            ['fullscreen', 'source', '|',
                'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor',  'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
                'paragraph', 'fontfamily', 'fontsize','indent','|',
                'link', 'unlink', 'anchor', '|', 
                'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe','webapp', 'pagebreak', 'template', 'background', '|',
                'horizontal', 'spechars', '|',
                //'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', '|',
                'print', 'preview', 'searchreplace']
        ]
        ,webAppKey:"fI42qGCMe3w2wX65bulfyOfi"
        ,initialContent:''    //初始化编辑器的内容,也可以通过textarea/script给值，看官网例子

        ,initialFrameWidth:760  //初始化编辑器宽度,默认1000
        ,initialFrameHeight:320  //初始化编辑器高度,默认320

        ,zIndex : 900     //编辑器层级的基数,默认是900

        ,autoSyncData:true //自动同步编辑器要提交的数据

        //wordCount
        ,wordCount:true          //是否开启字数统计
        ,maximumWords:10000       //允许的最大字符数
        //字数统计提示，{#count}代表当前字数，{#leave}代表还可以输入多少字符数,留空支持多语言自动切换，否则按此配置显示
        ,wordCountMsg:''   //当前已输入 {#count} 个字符，您还可以输入{#leave} 个字符
        //超出字数限制提示  留空支持多语言自动切换，否则按此配置显示
        ,wordOverFlowMsg:''    //<span style="color:red;">你输入的字符个数已经超出最大允许值，服务器可能会拒绝保存！</span>

        //highlightcode
        // 代码高亮时需要加载的第三方插件的路径
        // ,highlightJsUrl:basePath + "public/vendor/syntaxhighlighter/js/shCore.js"
         //,highlightCssUrl:basePath + "public/vendor/syntaxhighlighter/css/shCoreEclipse.css"

        ,topOffset:50
        ,allHtmlEnabled:false
    };
})();
