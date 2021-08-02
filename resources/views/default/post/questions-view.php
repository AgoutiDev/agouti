<?php if (!empty($answers)) { ?>
    <div class="answers white-box">
        <h2 class="lowercase size-21">
            <?= $post['post_answers_count'] ?> <?= $post['num_answers'] ?>
        </h2>

        <?php foreach ($answers as  $answer) { ?>
            <div class="block-answer">
                <?php if ($answer['answer_is_deleted'] == 0) { ?>

                    <?php if ($uid['id'] == $answer['answer_user_id']) { ?> <?php $otvet = 1; ?> <?php } ?>

                    <div class="line"></div>
                    <ol class="answer-telo">
                        <li class="answers_subtree" id="answer_<?= $answer['answer_id']; ?>">
                            <div class="answ-telo qa-answ">
                                <div class="qa-footer">
                                    <div class="qa-ava">
                                        <?= user_avatar_img($answer['avatar'], 'max', $answer['login'], 'avatar'); ?>
                                    </div>
                                    <div class="qa-ava-info">
                                        <div class="qa-data-info">
                                            <?= $answer['answer_date']; ?>
                                            <?php if (empty($answer['edit'])) { ?>
                                                (<?= lang('ed'); ?>.)
                                            <?php } ?>
                                            <?php if ($uid['trust_level'] == 5) { ?>
                                                <?= $answer['answer_ip']; ?>
                                            <?php } ?>
                                        </div>
                                        <a class="qa-login" href="/u/<?= $answer['login']; ?>"><?= $answer['login']; ?></a>
                                    </div>
                                </div>

                                <?= $answer['answer_content'] ?>
                            </div>
                            <div class="answer-footer size-13">
                                <?php if ($uid['trust_level'] >= Lori\Config::get(Lori\Config::PARAM_TL_ADD_COMM_QA)) { ?>
                                    <?php if ($post['post_closed'] == 0) { ?>
                                        <?php if ($post['post_is_deleted'] == 0 || $uid['trust_level'] == 5) { ?>
                                            <span id="cm_add_link<?= $answer['answer_id']; ?>" class="cm_add_link indent">
                                                <a data-post_id="<?= $post['post_id']; ?>" data-answer_id="<?= $answer['answer_id']; ?>" class="add-comment gray"><?= lang('Reply'); ?></a>
                                            </span>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>

                                <?php if ($uid['id'] == $answer['answer_user_id'] || $uid['trust_level'] == 5) { ?>
                                    <span id="answer_edit" class="answer_add_link indent">
                                        <a class="editansw gray" href="/answer/edit/<?= $answer['answer_id']; ?>">
                                            <?= lang('Edit'); ?>
                                        </a>
                                    </span>
                                <?php } ?>

                                <?php if ($uid['id']) { ?>
                                    <span class="add-favorite gray indent" data-id="<?= $answer['answer_id']; ?>" data-type="answer">
                                        <?php if ($answer['favorite_user_id']) { ?>
                                            <?= lang('remove-favorites'); ?>
                                        <?php } else { ?>
                                            <?= lang('add-favorites'); ?>
                                        <?php } ?>
                                    </span>
                                <?php } ?>

                                <?php if ($uid['trust_level'] == 5) { ?>
                                    <span class="indent"></span>
                                    <span id="answer_dell" class="answer_add_link indent">
                                        <a data-type="answer" data-id="<?= $answer['answer_id']; ?>" class="type-action gray">
                                            <?= lang('Remove'); ?>
                                        </a>
                                    </span>
                                <?php } ?>

                                <?= votes($uid['id'], $answer, 'answer'); ?>

                            </div>
                            <div id="answer_addentry<?= $answer['answer_id']; ?>" class="reply"></div>
                        </li>
                    </ol>

                <?php } else { ?>
                    <ol class="dell answer-telo">
                        <li class="answers_subtree" id="answer_<?= $answer['answer_id']; ?>">
                            <span class="answ-deletes">~ <?= lang('Answer deleted'); ?></span>
                        </li>
                    </ol>
                <?php } ?>
            </div>

            <?php foreach ($answer['comm'] as  $comment) { ?>
                <?php if ($comment['comment_is_deleted'] == 0) { ?>

                    <ol class="comm-telo qa-comm">
                        <li class="comment_subtree" id="comment_<?= $comment['comment_id']; ?>">
                            <div class="line-qa"></div>
                            <div class="comm-telo">
                                <div class="size-13 comm-body">
                                    <?= $comment['comment_content'] ?>
                                    <span class="gray">
                                        — <a class="gray" href="/u/<?= $comment['login']; ?>"><?= $comment['login']; ?></a>
                                        <span class="lowercase gray">
                                            &nbsp; <?= lang_date($comment['comment_date']); ?>
                                        </span>
                                        <?php if ($uid['trust_level'] == 5) { ?>
                                            &nbsp; <?= $comment['comment_ip']; ?>
                                        <?php } ?>
                                    </span>

                                    <?php if ($uid['trust_level'] >= Lori\Config::get(Lori\Config::PARAM_TL_ADD_COMM_QA)) { ?>
                                        <?php if ($post['post_closed'] == 0) { ?>
                                            <?php if ($post['post_is_deleted'] == 0 || $uid['trust_level'] == 5) { ?>
                                                <span id="cm_add_link<?= $comment['comment_id']; ?>" class="cm_add_link">
                                                    <a data-post_id="<?= $post['post_id']; ?>" data-answer_id="<?= $answer['answer_id']; ?>" data-comment_id="<?= $comment['comment_id']; ?>" class="add-comment-re gray">
                                                        <?= lang('Reply'); ?>
                                                    </a>
                                                </span>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>

                                    <?php if ($uid['id'] == $comment['comment_user_id'] || $uid['trust_level'] == 5) { ?>
                                        <span id="comment_edit" class="cm_add_link">
                                            <a data-post_id="<?= $post['post_id']; ?>" data-comment_id="<?= $comment['comment_id']; ?>" class="editcomm gray">
                                                <?= lang('Edit'); ?>
                                            </a>
                                        </span>
                                    <?php } ?>

                                    <?php if ($uid['trust_level'] == 5) { ?>
                                        <span id="comment_dell" class="cm_add_link">
                                            <a data-type="comment" data-id="<?= $comment['comment_id']; ?>" class="type-action gray">
                                                <?= lang('Remove'); ?>
                                            </a>
                                        </span>
                                    <?php } ?>

                                </div>
                            </div>
                            <div id="comment_addentry<?= $comment['comment_id']; ?>" class="reply"></div>

                        </li>
                    </ol>

                <?php } else { ?>

                <?php } ?>
            <?php } ?>

        <?php } ?>
    </div>
<?php } else { ?>
    <?php if ($post['post_closed'] != 1) { ?>
        <div class="no-content gray">
            <i class="light-icon-info-square green middle"></i>
            <span class="middle"><?= lang('No answers'); ?>... </span>
        </div>
    <?php } ?>
<?php } ?>

<?php if (!empty($otvet)) { ?>

    <div class="no-content gray">
        <i class="light-icon-info-square green middle"></i>
        <span class="middle"><?= lang('you-question-no'); ?>...</span>
    </div>

<?php } else { ?>
    <?php if ($uid['id']) { ?>
        <?php if ($post['post_closed'] == 0) { ?>
            <form id="add_answ" action="/answer/create" accept-charset="UTF-8" method="post">
                <?= csrf_field() ?>
                <div id="test-markdown-view-post">
                    <textarea minlength="6" class="wmd-input h-150 w-95" rows="5" name="answer" id="wmd-input"></textarea>
                </div>
                <div class="clear">
                    <input type="hidden" name="post_id" id="post_id" value="<?= $post['post_id']; ?>">
                    <input type="hidden" name="answer_id" id="answer_id" value="0">
                    <input type="submit" name="answit" value="<?= lang('Reply'); ?>" class="button">
                </div>
            </form>

        <?php } ?>
    <?php } else { ?>
        <div class="no-content gray">
            <?= lang('no-auth-login'); ?>...
        </div>
    <?php } ?>
<?php }  ?>