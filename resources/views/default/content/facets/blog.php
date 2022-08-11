<?php $blog = $data['facet'];
if ($blog['facet_is_deleted'] == 0) : ?>

  <div class="w-100">
    <?= insert('/content/facets/blog-header', ['data' => $data]); ?>

    <div class="flex gap mb-block">
      <main>
        <div class="flex justify-between mb20">
          <ul class="nav scroll">
            <?php $list =  [
              [
                'id'    => 'main.feed',
                'url'   => url('blog', ['slug' => $blog['facet_slug']]),
                'title' => __('app.feed'),
              ], [

                'id'    => 'main.all',
                'url'   => url('blog.posts', ['slug' => $blog['facet_slug']]),
                'title' => __('app.posts'),
              ], [

                'id'    => 'main.all',
                'url'   => url('blog.questions', ['slug' => $blog['facet_slug']]),
                'title' => __('app.questions'),
              ],
            ]; ?>
            <?= insert('/_block/navigation/nav', ['list' => $list]); ?>
          </ul>

        </div>
        <?= insert('/content/post/post-card', ['data' => $data]); ?>
        <?= Html::pagination($data['pNum'], $data['pagesCount'], $data['sheet'], url('blog', ['slug' => $blog['facet_slug']])); ?>
      </main>
      <aside>
        <?php if ($blog['facet_is_deleted'] == 0) : ?>
          <div class="box bg-beige">
            <h4 class="uppercase-box"><?= __('app.created_by'); ?></h4>
            <a class="flex relative pt5 pb5 items-center hidden gray-600" href="<?= url('profile', ['login' => $data['user']['login']]); ?>">
              <?= Img::avatar($data['user']['avatar'], $data['user']['login'], 'img-base', 'small'); ?>
              <span class="ml5"><?= $data['user']['login']; ?></span>
            </a>
            <div class="gray-600 text-sm mt5">
              <svg class="icons">
                <use xlink:href="/assets/svg/icons.svg#calendar"></use>
              </svg>
              <span class="middle lowercase"><?= Html::langDate($blog['facet_date']); ?></span>
            </div>
          </div>

          <?php if ($data['focus_users']) : ?>
            <div class="box bg-lightgray">
              <h4 class="uppercase-box"><?= __('app.reads'); ?>
                <a href="<?= url('blog.read', ['slug' => $blog['facet_slug']]) ?>" title="<?= __('app.more'); ?>" class="gray-600" href="">...</a>
              </h4>
              <ul>
                <?php foreach ($data['focus_users'] as $user) : ?>
                  <li class="mt15">
                    <a href="<?= url('profile', ['login' => $user['login']]); ?>">
                      <?= Img::avatar($user['avatar'], $user['login'], 'img-sm mr5', 'max'); ?>
                      <?= $user['login']; ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <?php if ($data['info']) : ?>
            <div class="sticky top-sm">
              <div class="box bg-lightgray content-body">
                <?= $data['info']; ?>
              </div>
            </div>
          <?php endif; ?>

        <?php endif; ?>
      </aside>
    </div>
  </div>
<?php else : ?>
  <main>
    <div class="box center gray-600">
      <svg class="icons icon-max">
        <use xlink:href="/assets/svg/icons.svg#x-octagon"></use>
      </svg>
      <div class="mt5 gray"><?= __('app.remote'); ?></div>
    </div>
  </main>
<?php endif; ?>