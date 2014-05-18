<blockquote class="block-title">写文章 Markdown [<a href="http://wowubuntu.com/markdown/" target="_blank" class="direct">语法参考</a>]</blockquote>
<form action="<?php echo \Admin\url('article/writePost');?>" method="post" success="form_after" id="o-form-write-article" enctype="multipart/form-data">
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="act" value="" />
	<fieldset>
		<label for="blog_title">标题</label>
		<div class="input-control text size4" data-role="input-control">
	      <input type="text" name="blog_title" id="blog_title" placeholder="标题" />
	      <button class="btn-clear" tabindex="-1" type="button"></button>
		</div>
		<label for="category">分类 (Ctrl多选)</label>
		<div class="input-control select size4">
	     	<select name="category_id[]" id="category" multiple>
				<?php foreach($categorys as $k=>$v): ?>
					<option value="<?php echo $v['id'];?>"><?php echo $v['name']; ?></option>
				<?php endforeach;?>
			</select>
		</div>
        <label for="sources">来源</label>
		<div class="input-control text size3">
            <input type="text" name="sources" list="sources_list" />
            <?php echo \Admin\article_source_list("sources_list");?>
		</div>
		<label for="tag">标签</label>
		<div class="input-control text size4">
		   <input type="text" name="tag" id="tag" placeholder="标签"/>
		   <button class="btn-search o-toggle" data-target="#selectLabels"></button>
		</div>
		<div class="o-hide" id="selectLabels">
			<?php foreach ($tags as $k => $v): ?>
				<a href="<?php echo $v['name'];?>" class="o-add-label direct" data-target="#tag">
					<?php echo $v['name']; ?>
				</a>
			<?php endforeach;?>
		</div>
		<label for="blog_intro">内容概要 </label>
		<div class="input-control textarea size8">
		    <textarea name="intro" id="blog_intro" placeholder="内容概要" ></textarea>
		</div>
		<label for="blog_textarea">文章正文 </label>
		<div class="input-control textarea size 10">
		    <textarea name="blog_textarea" style="min-height: 350px;" id="blog_textarea"></textarea>
		    <div id="blog_textarea_preview" class="markdown-preview"></div>
		</div>
		<input type="hidden" name="model" value="markdown" />
        <label for="feature_img">封面图片 <a href="#" data-event="blog.select_image_cover">选择</a></label>
		<div class="input-control file size4" data-role="input-control">
			<input type="file" name="feature_img" id="feature_img" data-role="input-control" />
            <input type="hidden" name="feature_img_selected" />
			<button class="btn-file"></button>
		</div>
        <div id="feature_img_area" style="display:none" class="image-container"></div>
		<div class="o-clear"></div>
      	<button type="button" class="primary" data-event="blog.submit_to_blog" id="submit_to_blog">提交</button>
	</fieldset>
</form>
<script src="<?php \Admin\public_resource_path();?>showdown-master/src/showdown.js"></script>
<script type="text/javascript">
	
    // 表单提价之后的事件
    function form_after(data){
        if(data.status == 1){
        	LOCAL.remove("article_content_markdown");
        }
    }
    $(function(){
		$.Metro.initInputs();
    	// 检查是否有未保存的数据
        window.setTimeout(function(){
            if(LOCAL.isExist("article_content_markdown") && LOCAL.get("article_content_markdown").length > 0 && $("#blog_textarea").val() == ''){
				//处理内容
            	$("#blog_textarea").val(LOCAL.get("article_content_markdown"));
            }
        }, 2000);
        // 每隔30s保存一次数据
        var saveContent = function(){
            if($("#o-form-write-article").length){
                window.setTimeout(saveContent, 30000);
            }
            if($("#blog_textarea").val() == ''){
                return false;
            }
            var content = $("#blog_textarea").val();
            LOCAL.set("article_content_markdown", content);
        };
        window.setTimeout(saveContent, 30000);

    	// Markdown预览
        var conv = new Showdown.converter();
		var content = $("#blog_textarea").val();
        $("#blog_textarea").blur(function(){
			if(content != $(this).val()){
				content = $(this).val();
				$("#blog_textarea_preview").html(conv.makeHtml(content));
			}
        });

        
    });
</script>