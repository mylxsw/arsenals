<div style="width: 600px; height: 400px;overflow-y: auto; ">
    <?php foreach($covers as $k=>$v){ ?>
    <a href="#" class="select-cover" data-pop-event="select-cover" data-id="<?php echo $v;?>"><img src="<?php echo $v;?>" style="width: 100px;width: 100px;height: 100px;margin: 5px;border: 1px solid #6F6F6F;" /></a>
    <?php } ?>
</div>