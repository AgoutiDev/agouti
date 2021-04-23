<?php

namespace App\Controllers;
use Hleb\Constructor\Handlers\Request;
use App\Models\UserModel;
use App\Models\SpaceModel;
use App\Models\AdminModel;
use Parsedown;
use Base;

class AdminController extends \MainController
{
	public function index()
	{
        // Доступ только персоналу
        $uid = Base::getUid();
        if ($uid['trust_level'] != 5) {
            redirect('/');
        }
      
        $user_all = AdminModel::UsersAll();
        
        $result = Array();
        foreach($user_all as $ind => $row){
             
            if(!$row['avatar'] ) {
                $row['avatar'] = 'noavatar.png';
            } 
            
            $row['logs_date'] = (empty($row['logs_date'])) ? null : Base::ru_date($row['logs_date']);
            
            $row['avatar']        = $row['avatar'];  
            $row['replayIp']      = AdminModel::replayIp($row['reg_ip']);
            $row['isBan']         = AdminModel::isBan($row['id']);
            $row['created_at']    = Base::ru_date($row['created_at']); 
            $row['logs_date']     = $row['logs_date'];
            $row['updated_at']    = Base::ru_date($row['updated_at']);
            $result[$ind]         = $row;
         
        } 
        
        $data = [
            'title'        => 'Последние сессии | Админка',
            'description'  => 'Админка на AreaDev',
            'users'        => $result,
        ];

        return view(PR_VIEW_DIR . '/admin/index', ['data' => $data, 'uid' => $uid, 'alluser' => $result]);
	}
    
    public function banUser() 
    {
        // Доступ только персоналу
        $uid = Base::getUid();
        if ($uid['trust_level'] != 5) {
            redirect('/');
        }

        $user_id = \Request::getPostInt('id');
        AdminModel::setBanUser($user_id);
        
        return true;
    }
    
    // Удаленые комментарии
    public function Comments ()
    {
        // Доступ только персоналу
        $uid = Base::getUid();
        if ($uid['trust_level'] != 5) {
            redirect('/');
        }
        
        $Parsedown = new Parsedown(); 
        $Parsedown->setSafeMode(true); // безопасность
         
        $comm = AdminModel::getCommentsDell();

        $result = Array();
        foreach($comm  as $ind => $row){
            if(!$row['avatar']) {
                $row['avatar'] = 'noavatar.png';
            } 
            $row['avatar']  = $row['avatar'];
            $row['content'] = $Parsedown->text($row['comment_content']);
            $row['date']    = Base::ru_date($row['comment_date']);
            $result[$ind]   = $row;
        }
        
        $uid  = Base::getUid();
        $data = [
            'h1'          => 'Удаленные комментарии',
            'title'       => 'Удаленные комментарии' . ' | ' . $GLOBALS['conf']['sitename'],
            'description' => 'Все удаленные комментарии на сайте в порядке очередности. ' . $GLOBALS['conf']['sitename'],
        ]; 
 
        return view(PR_VIEW_DIR . '/admin/comm_del', ['data' => $data, 'uid' => $uid, 'comments' => $result]);
    }
     
    // Удаление комментария
    public function recoverComment()
    {
        // Доступ только персоналу
        $uid = Base::getUid();
        if ($uid['trust_level'] != 5) {
            redirect('/');
        }
        
        $comm_id = \Request::getPostInt('id');
        AdminModel::CommentsRecover($comm_id);
        
        return true;
    }
    
    // Показываем дерево приглашенных
    public function Invitations ()
    {
        // Доступ только персоналу
        $uid        = Base::getUid();
        if ($uid['trust_level'] != 5) {
            redirect('/');
        }  
 
        $invite     = AdminModel::getInvitations();
 
        $result = Array();
        foreach($invite  as $ind => $row){
            if(!$row['avatar']) {
                $row['avatar'] = 'noavatar.png';
            } 
            $row['uid']         = UserModel::getUserId($row['uid']);  
            $row['active_time'] = Base::ru_date($row['active_time']);
            $row['avatar']      = $row['avatar'];
            $result[$ind]       = $row;
        }

        $data = [
            'h1'          => 'Инвайты',
            'title'       => 'Инвайты' . ' | ' . $GLOBALS['conf']['sitename'],
            'description' => 'Дерево инвайтов. ' . $GLOBALS['conf']['sitename'],
        ]; 
 
        return view(PR_VIEW_DIR . '/admin/invitations', ['data' => $data, 'uid' => $uid, 'invitations' => $result]);
    }
    
    // Для дерева инвайтов
    private function invatesTree($active_uid, $level, $invitations, $tree=array()){
        $level++;
        foreach($invitations as $invitation){
            if ($invitation['uid'] == $uid){
                $invitation['level'] = $level-1;
                $tree[] = $invitation;
                $tree = $this->invatesTree($invitation['active_uid'], $level, $invitations, $tree);
            }
        }
		return $tree;
    }
    
    // Пространства
    public function Space ()
    {
        // Доступ только персоналу
        $uid        = Base::getUid();
        if ($uid['trust_level'] != 5) {
            redirect('/');
        }  
        
        $space      = AdminModel::getAdminSpaceAll($uid['id']);
         
        $result = Array();
        foreach($space  as $ind => $row){
            
            if(!$row['space_img'] ) {
                $row['space_img'] = 'space_no.png';
            } 

           if(!$row['avatar'] ) {
                $row['avatar'] = 'noavatar.png';
           } 

            $space['space_img'] = $row['space_img'];
            $result[$ind]       = $row;
        }

        $data = [
            'h1'          => 'Пространства',
            'title'       => 'Пространства' . ' | ' . $GLOBALS['conf']['sitename'],
            'description' => 'Пространства. ' . $GLOBALS['conf']['sitename'],
        ]; 
 
        return view(PR_VIEW_DIR . '/admin/space', ['data' => $data, 'uid' => $uid, 'space' => $result]);
    }
    
    // Добавить пространство администратору
    public function addAdminSpacePage() 
    {
        // Доступ только персоналу
        $uid  = Base::getUid();
        if ($uid['trust_level'] != 5) {
            redirect('/');
        }  
        
        $data = [
            'h1'          => 'Добавить пространство',
            'title'       => 'Добавить пространство' . ' | ' . $GLOBALS['conf']['sitename'],
            'description' => 'Добавить пространство. ' . $GLOBALS['conf']['sitename'],
        ]; 
        
        return view(PR_VIEW_DIR . '/admin/add-space', ['data' => $data, 'uid' => $uid]);
    }
    
    // Удаление / восстановление пространства
    public function delSpace() {
        
        // Доступ только персоналу
        $uid = Base::getUid();
        if ($uid['trust_level'] != 5) {
            redirect('/');
        }   
        
        $space_id = \Request::getPostInt('id');
        SpaceModel::SpaceDelete($space_id);
       
        return true;
    }
    
    // Добавить пространства
    public function spaceAddAdmin() 
    {
        // Доступ только персоналу
        $uid = Base::getUid();
        if ($uid['trust_level'] != 5) {
            redirect('/');
        } 
        
        $space_slug     = \Request::getPost('space_slug');
        $space_name     = \Request::getPost('space_name');  
        $permit         = \Request::getPostInt('permit');
        $meta_desc      = \Request::getPost('space_description');
        $space_text     = \Request::getPost('space_text');  
        $space_color    = \Request::getPostInt('space_color');
        
        if (!preg_match('/^[a-zA-Z0-9]+$/u', $space_slug))
        {
            Base::addMsg('В URL можно использовать только латиницу, цифры', 'error');
            redirect('/admin/space/add');
        }
        if (Base::getStrlen($space_slug) < 4 || Base::getStrlen($space_slug) > 15)
        {
          Base::addMsg('URL должно быть от 3 до ~ 15 символов', 'error');
          redirect('/admin/space/add');
        }
        if (preg_match('/\s/', $space_slug) || strpos($space_slug,' '))
        {
            Base::addMsg('В URL не допускаются пробелы', 'error');
            redirect('/admin/space/add');
        }
        if (SpaceModel::getSpaceInfo($space_slug)) {
            Base::addMsg('Такой URL пространства уже есть', 'error');
            redirect('/admin/space/add');
        }
 
        // Проверяем длину названия
        if (Base::getStrlen($space_name) < 6 || Base::getStrlen($space_name) > 25)
        {
            Base::addMsg('Длина названия должна быть от 6 до 25 знаков', 'error');
            redirect('/admin/space/add');
        }
        
        // Проверяем длину meta
        if (Base::getStrlen($meta_desc) < 6 || Base::getStrlen($meta_desc) > 325)
        {
            Base::addMsg('Длина meta должна быть от 6 до 325 знаков', 'error');
            redirect('/admin/space/add');
        } 
        
        // Проверяем длину meta
        if (Base::getStrlen($space_text) < 6 || Base::getStrlen($space_text) > 325)
        {
            Base::addMsg('Длина описания для Sidebar должна быть от 6 до 325 знаков', 'error');
            redirect('/admin/space/add');
        }
        
        if($permit == '') 
        {
            Base::addMsg('Выберите, кто будет публиковать в пространстве', 'error');
            redirect('/admin/space/add');   
        }
        
        $data = [
            'space_name'         => $space_name,
            'space_slug'         => $space_slug,
            'space_description'  => $meta_desc,
            'space_color'        => $space_color,
            'space_img'          => '',
            'space_text'         => $space_text,
            'space_date'         => date("Y-m-d H:i:s"),
            'space_user_id'      => $uid['id'],
            'space_type'         => 2, 
            'space_permit_users' => $permit,
        ];
 
        // Добавляем пространство
        SpaceModel::AddSpace($data);

        redirect('/admin/space');
        
    }
    
}
