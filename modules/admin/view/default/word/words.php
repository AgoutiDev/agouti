<?= includeTemplate(
  '/view/default/menu',
  [
    'data'  => $data,
    'meta'  => $meta,
    'menus' => []
  ]
); ?>

<a class="sky mb15" href="<?= url($data['type'] . '.add'); ?>"> <?= __('admin.add'); ?> </a>
<?php if (!empty($data['words'])) : ?>
  <?php foreach ($data['words'] as $key => $word) : ?>
    <p>
      <?= $word['stop_word']; ?> |
      <a data-id="<?= $word['stop_id']; ?>" data-type="word" class="type-ban lowercase text-sm">
        <?= __('admin.remove'); ?>
      </a>
    </p>
  <?php endforeach; ?>
<?php else : ?>
  <?= insert('/_block/no-content', ['type' => 'small', 'text' => __('admin.no'), 'icon' => 'bi-info-lg']); ?>
<?php endif; ?>
</div>
</main>
<?= includeTemplate('/view/default/footer'); ?>