<?php \Admin\block_header('图片管理');?>
<div class="page-section">
    <div class="toolbar transparent">
        <div class="toolbar-group">
            <label for="">选择文件</label>
            <div class="input-control text size4">
                <input type="file" name="files" id="file-upload" multiple />
            </div>
            <div class="upload-image-area"><div class="clearfix"></div></div>
        </div>
    </div>
    <?php if(isset($photos['data']) && is_array($photos['data'])) foreach($photos['data'] as $photo): ?>
        <div class="image-item">
            <img src="<?php echo \Admin\filename_prefix($photo['url'], 'thumb_small/');?>" />
            <div class="file-meta">
                <div class="filename"><?php echo $photo['file_name'];?>(<?php echo $photo['width'] , ' x ' , $photo['height'];?>)</div>
                <div class="image-url"><a href="<?php echo $photo['url'];?>" target="_blank" class="direct"><?php echo $photo['url'];?></a></div>
            </div>
            <div class="o-clear"></div>
        </div>
    <?php endforeach;?>
    <?php echo \Admin\pagination('photos/manager' , $photos['total'], $photos['page'], $p); ?>
</div>
<link type="text/css" rel="stylesheet" href="Public/uploadify/uploadify.css">
<script src="Public/uploadify/jquery.uploadify.min.js"></script>
<script type="text/plain" id="image-upload-template">
    <div class="image-small image">
        <div class="set-index"><img src="<%=thumb_url%>"><div class="image-tip"><%=filename%></div></div>
    </div>
</script>
<script>
    $(function(){
        o_fn.photo.init('#image-upload-template', '#file-upload', '<?php echo \Admin\url('photos/upload');?>');
    });

</script>