<?php

namespace App\Controllers;

use Hleb\Scheme\App\Controllers\MainController;
use Hleb\Constructor\Handlers\Request;
use App\Models\{NotificationsModel, UserModel};
use Lori\{Config, Base};

class NotificationsController extends MainController
{
    // Страница уведомлений участника
    public function index()
    {
        $login  = Request::get('login');
        $uid    = Base::getUid();
        $user   = UserModel::getUser($uid['user_login'], 'slug');

        // Если страница закладок не участника
        if ($login != $uid['user_login']) {
            redirect('/u/' . $user['user_login'] . '/notifications');
        }

        // Данные участника и список уведомлений
        $list = NotificationsModel::listNotification($uid['user_id']);

        $result = array();
        foreach ($list as $ind => $row) {
            $row['add_time']        = lang_date($row['notification_add_time']);
            $result[$ind]           = $row;
        }

        $meta = [
            'meta_title'    => lang('Notifications') . ' | ' . Config::get(Config::PARAM_NAME),
            'sheet'         => 'notifications',
        ];

        $data = [
            'sheet'         => 'notifications',
            'notifications' => $result,
        ];

        return view('/notification/index', ['meta' => $meta, 'uid' => $uid, 'data' => $data]);
    }

    // Изменяем флаг подписки прочитан или нет (переход по ссылке)
    public function read()
    {
        $uid        = Base::getUid();
        $notif_id   = Request::getInt('id');
        $info       = NotificationsModel::getNotification($notif_id);

        if ($uid['user_id'] != $info['notification_recipient_id']) {
            return false;
        }

        // Если личные сообщения 
        if ($info['notification_action_type'] == 1) {
            $info['notification_url'] = 'messages/read/' . $info['notification_connection_type'];
        }

        NotificationsModel::updateMessagesUnread($uid['user_id'], $notif_id);

        redirect('/' .  $info['notification_url']);
    }

    // Удаляем уведомления
    public function remove()
    {
        $uid    = Base::getUid();
        NotificationsModel::setRemove($uid['user_id']);
        redirect('/u/' . $uid['user_login'] . '/notifications');
    }
}
