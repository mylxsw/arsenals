<?php \Admin\block_header('编辑图片库');?>
<form action="<?php echo \Admin\url('photos/editPost');?>" method="post" id="o-form-edit-photo">
    <fieldset>
        <label for="photos-title">标题</label>
        <div class="input-control text size4">
            <input type="text" name="title" id="photos-title" placeholder="标题"  value="<?php echo $photo['title'];?>"/>
            <button class="btn-clear" tabindex="-1" type="button"></button>
        </div>
        <label for="photos-tags">标签</label>
        <div class="input-control text size4">
            <input type="text" name="tags" id="photos-tags" placeholder="标签" value="<?php echo trim($photo['tag'], ',');?>"/>
        </div>
        <div id="selectLabels">
            <?php foreach ($tags as $k => $v): ?>
                <a href="<?php echo $v;?>" class="o-add-label direct" data-target="#photos-tags">
                    <?php echo $v; ?>
                </a>
            <?php endforeach;?>
        </div>
        <label for="photos-intro">概要 </label>
        <div class="input-control textarea size8">
            <textarea name="intro" id="photos-intro" placeholder="概要" ><?php echo $photo['intro'];?></textarea>
        </div>
        <label for="">选择文件</label>
        <div class="input-control text size4">
            <input type="file" name="files" id="file-upload" multiple />
        </div>
        <div class="upload-image-area">
            <?php foreach($photo['images'] as $k=>$v):?>
                <div class="image">
                    <div class="set-index"><img src="<?php echo \Admin\filename_prefix($v['url'], 'thumb_small/');?>"><div class="image-tip">点击设为封面</div></div>
                    <span class="icon-cancel"></span>
                    <div class="intro">
                        <input type="hidden" name="image[]" value="<?php echo $v['url'];?>" />
                        <textarea name="image_intro[]" placeholder="图片介绍"><?php echo $v['intro'];?></textarea>
                    </div>
                </div>
            <?php endforeach;?>
            <div class="clearfix"></div>
        </div>
        <input type="hidden" name="id" value="<?php echo $photo['id'];?>" />
        <button type="button" class="primary" onclick="f.submit('#o-form-edit-photo')">提交</button>
    </fieldset>
</form>
<link type="text/css" rel="stylesheet" href="Public/uploadify/uploadify.css">
<script src="Public/uploadify/jquery.uploadify.min.js"></script>
<script type="text/plain" id="image-upload-template">
    <div class="image">
        <div class="set-index"><img src="<%=thumb_url%>"><div class="image-tip">点击设为封面</div></div>
        <span class="icon-cancel"></span>
        <div class="intro">
            <input type="hidden" name="image[]" value="<%=url%>" />
            <textarea name="image_intro[]" placeholder="图片介绍"><%=filename%></textarea>
        </div>
    </div>
</script>
<script>
    $(function(){
        o_fn.photo.init('#image-upload-template', '#file-upload', '<?php echo \Admin\url('photos/upload');?>');
    });

</script>