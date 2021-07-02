<?php include TEMPLATE_DIR . '/header.php'; ?>
<div class="wrap">
    <main>
        <div class="white-box">
            <div class="inner-padding">
                <ul class="nav-tabs">
                    <li class="active">
                        <span><?= $data['h1']; ?></span>
                    </li>
                    <li>
                        <a href="/space/<?= $space['space_slug']; ?>/edit/logo">
                            <span><?= lang('Logo'); ?> / <?= lang('Cover art'); ?></span>
                        </a>
                    </li>
                    <li class="right">
                        <a href="/s/<?= $space['space_slug']; ?>">
                            <span><?= lang('In space'); ?></span>
                        </a>
                    </li>
                </ul>
                
                <div class="telo space">
                    <div class="box create">
                        <form action="/space/editspace" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="boxline">
                                <label class="form-label" for="post_title">URL<sup class="red">*</sup></label>
                                <input class="form-input" minlength="3" type="text" value="<?= $space['space_slug']; ?>" name="space_slug" />
                            </div>  
                            <div class="boxline">
                                <label class="form-label" for="post_title"><?= lang('Title'); ?><sup class="red">*</sup></label>
                                <input class="form-input" minlength="4" maxlength="18" type="text" value="<?= $space['space_name']; ?>" name="space_name" />
                                <div class="box_h">Короткое от 4 - 18 <?= lang('characters'); ?></div>
                            </div>
                            <div class="boxline">
                                <label class="form-label" for="post_content"><?= lang('Long'); ?><sup class="red">*</sup></label>
                                <input class="form-input" minlength="20" maxlength="250" type="text" name="space_short_text" value="<?= $space['space_short_text']; ?>">
                                <div class="box_h">Длинное название от 20 - 250 <?= lang('characters'); ?></div>
                            </div>
                            <div class="boxline"> 
                                <label class="form-label" for="post_content">Публикации<sup class="red">*</sup></label>
                                <input type="radio" name="permit" <?php if($space['space_permit_users'] == 0) { ?>checked<?php } ?> value="0"> <?= lang('All'); ?>
                                <input type="radio" name="permit" <?php if($space['space_permit_users'] == 1) { ?>checked<?php } ?> value="1" > <?= lang('Just me'); ?>
                                <div class="box_h">Кто сможет размещать посты</div>
                            </div>  
                            <div class="boxline"> 
                                <label class="form-label" for="post_content"><?= lang('Show'); ?><sup class="red">*</sup></label>
                                <input type="radio" name="feed" <?php if($space['space_feed'] == 0) { ?>checked<?php } ?> value="0"> <?= lang('Yes'); ?>
                                <input type="radio" name="feed" <?php if($space['space_feed'] == 1) { ?>checked<?php } ?> value="1" > <?= lang('No'); ?>
                                <div class="box_h">Если нет, то посты не будут видны в ленте (на главной)</b></div>
                            </div> 
                            <div class="boxline">
                                <label class="form-label" for="post_content">Meta-<sup class="red">*</sup></label>
                                <input class="form-input" minlength="60" type="text" name="space_description" value="<?= $space['space_description']; ?>">
                                <div class="box_h">Description: 60 - 180 <?= lang('characters'); ?></div>
                            </div>
                            <div id="box" class="boxline">
                                <label class="form-label" for="post_content"><?= lang('Color'); ?></label>
                                <input class="form-input" type="color" value="<?= $space['space_color']; ?>" id="colorSpace">
                                <input type="hidden" name="color" value="" id="color">
                            </div> 
                            <div class="boxline">
                                <label class="form-label" for="post_content"><?= lang('Text'); ?> (Sidebar)</label>
                                <textarea class="form-input" id="h-200" name="space_text"><?= $space['space_text']; ?></textarea>
                                <div class="box_h">Markdown</div>
                            </div>
                            <div class="boxline">
                                <input type="hidden" name="space_id" id="space_id" value="<?= $space['space_id']; ?>">
                                <input type="submit" class="button" name="submit" value="<?= lang('Edit'); ?>" />
                            </div>                
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </main>
    <aside>
        <div class="white-box">
            <div class="inner-padding big">
                <?= lang('info_space_edit'); ?>
            </div>
        </div>
    </aside>
</div>    
<?php include TEMPLATE_DIR . '/footer.php'; ?>