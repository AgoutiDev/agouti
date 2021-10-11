<?php

namespace App\Controllers\Space;

use Hleb\Scheme\App\Controllers\MainController;
use Hleb\Constructor\Handlers\Request;
use App\Models\SpaceModel;
use Config, Base, Validation;

class AddSpaceController extends MainController
{
    // Добавления пространства
    public function index()
    {
        $uid            = Base::getUid();
        $space          = SpaceModel::getUserCreatedSpaces($uid['user_id']);
        $count_space    = count($space);

        $valid = Validation::validTl($uid['user_trust_level'], Config::get('general.tl_add_space'), $count_space, 3);
        if ($valid === false) {
            // redirect('/');
        }

        $space_slug     = Request::getPost('space_slug');
        $space_name     = Request::getPost('space_name');
        $space_permit   = Request::getPostInt('permit');
        $space_feed     = Request::getPostInt('feed');
        $space_tl       = Request::getPostInt('space_tl');

        $redirect       = '/space/add';

        Validation::charset_slug($space_slug, 'URL', $redirect);
        Validation::Limits($space_name, lang('titles'), '4', '18', $redirect);
        Validation::Limits($space_slug, 'slug (URL)', '3', '12', $redirect);

        if (preg_match('/\s/', $space_slug) || strpos($space_slug, ' ')) {
            addMsg(lang('url-gaps'), 'error');
            redirect($redirect);
        }
        if (SpaceModel::getSpace($space_slug, 'slug')) {
            addMsg(lang('url-already-exists'), 'error');
            redirect($redirect);
        }

        $space_permit   = $space_permit == 1 ? 1 : 0;
        $space_feed     = $space_feed == 1 ? 1 : 0;
        $space_tl       = $space_tl == 1 ? 1 : 0;

        $data = [
            'space_name'            => $space_name,
            'space_slug'            => $space_slug,
            'space_description'     => '',
            'space_color'           => '#fa6807',
            'space_img'             => 'space_no.png',
            'space_text'            => '',
            'space_wiki'            => '',
            'space_short_text'      => '',
            'space_date'            => date("Y-m-d H:i:s"),
            'space_category_id'     => 1,
            'space_user_id'         => $uid['user_id'],
            'space_type'            => 0,
            'space_permit_users'    => $space_permit,
            'space_feed'            => $space_feed,
            'space_tl'              => $space_tl,
            'space_is_delete'       => 0,
        ];

        // Добавляем пространство
        SpaceModel::AddSpace($data);

        addMsg(lang('space-add-success'), 'success');
        redirect('/s/' . $space_slug);
    }

    // Форма добавления пространства
    public function add()
    {
        $uid  = Base::getUid();

        // Если пользователь уже создал пространство, то ограничим их количество (кроме TL5)
        $space          = SpaceModel::getUserCreatedSpaces($uid['user_id']);
        $count_space    = count($space);
        $total_allowed  = $uid['user_trust_level'] == 5 ? 20 : Config::get('trust-levels.tl_add_space_limit');
        $valid = Validation::validTl($uid['user_trust_level'], Config::get('trust-levels.tl_add_space'), $count_space, $total_allowed);
        if ($valid === false) {
            redirect('/');
        }

        $num_add_space = $total_allowed - $count_space;

        $meta = meta($m = [], lang('add space'));
        $data = [
            'num_add_space' => $num_add_space,
            'sheet'         => 'spaces',
        ];

        return view('/space/add', ['meta' => $meta, 'uid' => $uid, 'data' => $data]);
    }
}
