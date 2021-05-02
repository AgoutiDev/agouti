<aside class="sidebar"> 
    <div class="menu-info">
        <a <?php if($uid['uri'] == '/info') { ?>class="active"<?php } ?> href="/info">~ <?= lang('Info'); ?></a>
        <a <?php if($uid['uri'] == '/info/privacy') { ?>class="active"<?php } ?> href="/info/privacy">~ <?= lang('Privacy'); ?></a>
        <a <?php if($uid['uri'] == '/info/markdown') { ?>class="active"<?php } ?> href="/info/markdown">~ <?= lang('Мarkdown'); ?></a> 
        <a <?php if($uid['uri'] == '/info/trust-level') { ?>class="active"<?php } ?> href="/info/trust-level">~ <?= lang('Trust level'); ?> (TL)</a>
        <a <?php if($uid['uri'] == '/info/about') { ?>class="active"<?php } ?> href="/info/about">~ <?= lang('About'); ?></a>
        <div class="v-ots"></div>
        <a <?php if($uid['uri'] == '/info/initial-setup') { ?>class="active"<?php } ?> href="/info/initial-setup">~ <?= lang('Initial Setup'); ?></a>
        <div class="v-ots"></div>
        <a <?php if($uid['uri'] == '/info/stats') { ?>class="active"<?php } ?> href="/info/stats">~ <?= lang('Statistics'); ?></a>
    </div>
</aside>