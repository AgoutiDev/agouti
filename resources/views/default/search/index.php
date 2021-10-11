<main class="col-span-9 bg-white br-rd-5 border-box-1 pt5 pr15 pb5 pl15">
  <h1><?= lang('search'); ?></h1>
  <?php if (!empty($data['result'])) { ?>
    <div><?= lang('you were looking for'); ?>: <b><?= $data['query']; ?></b></div>
  <?php } ?>
  <br>
  <?php if (!empty($data['result'])) { ?>
    <?php if (Config::get('general.search') == 0) { ?>
      <?php foreach ($data['result'] as  $post) { ?>
        <div class="search max-w780 mb20">
          <a class="search-title size-21" href="<?= getUrlByName('post', ['id' => $post['post_id'], 'slug' => $post['post_slug']]); ?>">
            <?= $post['post_title']; ?>
          </a>
          <span class="no-md"><?= $post['post_content']; ?>...</span>
        </div>
        <div class="mt15 mb15"></div>
      <?php } ?>
    <?php } else { ?>
      <?php foreach ($data['result'] as  $post) { ?>
        <div class="search max-w780 mb20">
          <div class="search-info gray size-14 lowercase">
            <?= spase_logo_img($post['space_img'], 'small', $post['space_name'], 'w18 mr5'); ?>
            <a class="search-info gray lowercase" href="<?= getUrlByName('space', ['slug' => $post['space_slug']]); ?>"><?= $post['space_name']; ?></a>
            — <?= lang('like'); ?> <?= $post['post_votes']; ?>
          </div>
          <a class="search-title" href="<?= getUrlByName('post', ['id' => $post['post_id'], 'slug' => $post['post_slug']]); ?>">
            <?= $post['_title']; ?>
          </a>
          <div class="no-md"><?= $post['_content']; ?></div>
        </div>
        <div class="mt15 mb15"></div>
      <?php } ?>
    <?php } ?>
  <?php } else { ?>
    <p><?= lang('the search has not given any results'); ?>
    <p>
    <?php } ?>
</main>
<aside class="col-span-3 br-rd-5 no-mob">
  <div class="bg-white br-rd-5 border-box-1 p15 mb15">
    <?= lang('info-search'); ?>
  </div>
  <?php foreach ($data['tags'] as $key => $topic) { ?>
    <div class="search max-w780 mb15 ml10">
      <a class="bg-blue-100 bg-hover-300 white-hover flex justify-center pt5 pr10 pb5 pl10 br-rd-20 blue inline size-14" href="<?= getUrlByName('topic', ['slug' => $topic['topic_slug']]); ?>">
        <?= $topic['topic_title']; ?>
      </a>
      <sup class="gray">x<?= $topic['topic_count']; ?></sup>
    </div>
  <?php } ?>
</aside>