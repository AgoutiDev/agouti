<?php

// https://phphleb.ru/ru/v1/groups/
Route::before('Designator', [UserData::USER_FIRST_LEVEL, '>='])->getGroup();
    Route::getType('post');
        Route::get('/flag/repost')->controller('AuditController@report');
        Route::get('/backend/upload/{type}/{id}')->controller('Post\EditPostController@uploadContentImage')->where(['type' => '[a-z-]+', 'id' => '[0-9]+']);
        Route::get('/status/action')->controller('ActionController@deletingAndRestoring');
        Route::get('/post/grabtitle')->controller('Post\AddPostController@grabMeta');
        Route::get('/comment/editform')->controller('Comment\EditCommentController');
        Route::get('/team/search/user')->module('teams', 'App\Search@select');
        Route::get('/reply/editform')->module('catalog', 'App\Reply@index');
        // @ users | posts | topics | category
        Route::get('/search/{type}')->controller('ActionController@select')->where(['type' => '[a-z]+']);
         
            Route::getProtect();
                Route::get('/invitation/create')->controller('User\InvitationsController@create')->name('invit.create');
                Route::get('/messages/send')->controller('MessagesController@send')->name('messages.send');
                Route::get('/users/setting/edit')->controller('User\SettingController@edit')->name('setting.edit');
                Route::get('/folder/content/add')->controller('FolderController@set')->name('folder.content.create');
                Route::get('/users/setting/avatar/edit')->controller('User\SettingController@avatarEdit')->name('setting.avatar.edit');
                Route::get('/users/setting/security/edit')->controller('User\SettingController@securityEdit')->name('setting.security.edit');
                Route::get('/users/setting/notification/edit')->controller('User\SettingController@notificationEdit')->name('setting.notif.edit');
                
                // Add / Edit: post | comment | answer | facet | web | team
                Route::get('/web/create')->module('catalog', 'App\Add@create')->name('web.create');
                Route::get('/web/reply/create')->module('catalog', 'App\Reply@create')->name('reply.create');
                Route::get('/web/reply/edit')->module('catalog', 'App\Reply@edit')->name('reply.edit');
                Route::get('/web/change')->module('catalog', 'App\Edit@edit')->name('web.change');
                Route::get('/team/create')->module('teams', 'App\Teams@create')->name('team.create');
                Route::get('/team/change')->module('teams', 'App\Teams@change')->name('team.change');
                
                Route::get('/create/{type}')->controller('ActionController@create')->where(['type' => '[a-z]+'])->name('content.create');
                Route::get('/change/{type}')->controller('ActionController@change')->where(['type' => '[a-z]+'])->name('content.change');
            Route::endProtect();
    Route::endType();

    Route::type(['get', 'post'])->get('/folder/content/save')->controller('FolderController@addFolderContent');

    // Pages (forms) for adding and changing: (post | page | answer), (topic | category | blog | sections) and site
    Route::get('/web/add')->module('catalog', 'App\Add')->name('web.add');    
    Route::get('/add/{type}')->controller('ActionController@add')->where(['type' => '[a-z]+'])->name('content.add');
    Route::get('/web/edit/{id}')->module('catalog', 'App\Edit')->where(['id' => '[0-9]+'])->name('web.edit');
    Route::get('/edit/{type}/{id}')->controller('ActionController@edit')->where(['type' => '[a-z]+', 'id' => '[0-9]+'])->name('content.edit');
    // end
 
    Route::get('/add/post/{topic_id}')->controller('Post\AddPostController', ['post'])->where(['topic_id' => '[0-9]+']);

    Route::get('/post/img/{id}/remove')->controller('Post\EditPostController@imgPostRemove')->where(['id' => '[0-9]+']);
    Route::get('/@{login}/delete/cover')->controller('User\SettingController@coverRemove')->where(['login' => '[A-Za-z0-9]+'])->name('delete.cover'); 
    Route::get('/@{login}/messages')->controller('MessagesController@messages')->where(['login' => '[A-Za-z0-9]+'])->name('send.messages');

    Route::get('/web/bookmarks')->module('catalog', 'App\UserArea@bookmarks')->name('web.bookmarks');
    Route::get('/web/my/{page?}')->module('catalog', 'App\UserArea')->name('web.user.sites');

    Route::get('/teams')->module('teams', 'App\Teams')->name('teams');
    Route::get('/team/add')->module('teams', 'App\Teams@add')->name('team.add');
    Route::get('/team/edit/{id}')->module('teams', 'App\Teams@edit')->where(['id' => '[0-9]+'])->name('team.edit');
    Route::get('/team/view/{id}')->module('teams', 'App\Teams@view')->where(['id' => '[0-9]+'])->name('team.view');

    Route::get('/setting/{type?}')->controller('User\SettingController')->where(['section' => '[a-z]+'])->name('setting'); 

    Route::get('/messages')->controller('MessagesController')->name('messages');   
    Route::get('/messages/{id}')->controller('MessagesController@dialog')->where(['id' => '[0-9]+'])->name('dialogues'); 
	Route::get('/notifications')->controller('NotificationController')->name('notifications'); 
    Route::get('/notification/{id}')->controller('NotificationController@read')->where(['id' => '[0-9]+'])->name('notif.read');  
    Route::get('/notifications/delete')->controller('NotificationController@remove')->name('notif.remove');  
    Route::get('/favorites')->controller('User\UserController@favorites')->name('favorites');
    Route::get('/favorites/folders')->controller('User\UserController@folders')->name('favorites.folders');
    Route::get('/favorites/folders/{id}')->controller('User\UserController@foldersFavorite')->where(['id' => '[0-9]+'])->name('favorites.folder.id');
    Route::get('/subscribed')->controller('User\UserController@subscribed')->name('subscribed');
    Route::get('/drafts')->controller('User\UserController@drafts')->name('drafts');
    Route::get('/invitations')->controller('User\InvitationsController@invitationForm')->name('invitations');

    Route::get('/logout')->controller('Auth\LogoutController')->name('logout');

    Route::get('/topics/my/{page?}')->controller('Facets\AllFacetController', ['my', 'topic'])->name('topics.my');
 
    Route::get('/post/scroll/{page?}')->controller('HomeController@scroll'); 
 
    Route::get('/blogs/my')->controller('Facets\AllFacetController', ['my', 'blog'])->name('blogs.my');
 
    Route::get('/all/{page?}')->controller('HomeController', ['all'])->name('main.all');
    
    Route::get('/deleted/{page?}')->controller('HomeController', ['deleted'])->name('main.deleted');
Route::endGroup();

Route::before('Designator', [UserData::USER_ZERO_LEVEL, '='])->getGroup();
    Route::getType('post');
        Route::getProtect();
            Route::get('/recover/send')->controller('Auth\RecoverController')->name('recover.send'); 
            Route::get('/recover/send/pass')->controller('Auth\RecoverController@remindNew'); 
            Route::get('/register/add')->controller('Auth\RegisterController')->name('register.add');
            Route::get('/login')->controller('Auth\LoginController');
        Route::endProtect();
    Route::endType();

    Route::get('/invite')->controller('User\InvitationsController@inviteForm')->name('invite');
	Route::get('/register')->controller('Auth\RegisterController@showRegisterForm')->name('register');
    
    Route::getType('get');
        Route::get('/register/invite/{code}')->controller('Auth\RegisterController@showInviteForm')->where(['code' => '[a-z0-9-]+'])->name('invite.reg');
        Route::get('/recover')->controller('Auth\RecoverController@showPasswordForm')->name('recover');  
        Route::get('/recover/remind/{code}')->controller('Auth\RecoverController@showRemindForm')->where(['code' => '[A-Za-z0-9-]+'])->name('recover.code');
        Route::get('/email/activate/{code}')->controller('Auth\RecoverController@ActivateEmail')->where(['code' => '[A-Za-z0-9-]+'])->name('activate.code');
        Route::get('/login')->controller('Auth\LoginController@showLoginForm')->name('login');
    Route::endType();
Route::endGroup();

Route::getType('post');
    Route::get('/post/shown')->controller('Post\PostController@shownPost');
    Route::get('/user/card')->controller('User\UserController@card');
    Route::get('/msg/go')->controller('Post\AddPostController@msg');
    Route::get('/comments/addform')->controller('Comment\AddCommentController');
    Route::get('/reply/addform')->module('catalog', 'App\Reply@addForma');
Route::endType();
  
Route::get('/search')->module('search', 'App\Search')->name('search'); 
Route::get('/search/go')->module('search', 'App\Search@go')->name('search.go');
 
Route::type(['get', 'post'])->get('/topic/{slug}/followers/{id}')->controller('Facets\TopicFacetController@followers')->where(['slug' => '[a-z0-9-]+', 'id' => '[0-9]+'])->name('topic.followers');  
  
// Other pages without authorization
Route::get('/post/{id}')->controller('Post\PostController', ['post'])->where(['id' => '[0-9]+']);
Route::get('/post/{id}/{slug}')->controller('Post\PostController', ['post'])->where(['id' => '[0-9]+', 'slug' => '[A-Za-z0-9-_]+'])->name('post');

// Страницы info
Route::get('/{facet_slug}/article/{slug}')->controller('Post\PostController', ['info.page'])->where(['facet_slug' => '[A-Za-z0-9-_]+', 'slug' => '[A-Za-z0-9-_]+'])->name('facet.article'); 

Route::get('/users/new/{page?}')->controller('User\UserController', ['new'])->name('users.new');
Route::get('/users/{page?}')->controller('User\UserController', ['all'])->name('users.all');

Route::get('/@{login}')->controller('User\ProfileController')->where(['login' => '[A-Za-z0-9]+'])->name('profile');
Route::get('/@{login}/posts/{page?}')->controller('User\ProfileController@posts')->where(['login' => '[A-Za-z0-9]+'])->name('profile.posts');
Route::get('/@{login}/answers/{page?}')->controller('User\ProfileController@answers')->where(['login' => '[A-Za-z0-9]+'])->name('profile.answers');
Route::get('/@{login}/comments/{page?}')->controller('User\ProfileController@comments')->where(['login' => '[A-Za-z0-9]+'])->name('profile.comments');

Route::get('/comments/{page?}')->controller('Comment\CommentController', ['all'])->name('comments');
Route::get('/answers/{page?}')->controller('Answer\AnswerController', ['all'])->name('answers');

Route::get('/topics/new/{page?}')->controller('Facets\AllFacetController', ['new', 'topic'])->name('topics.new');
Route::get('/topic/{slug}/recommend')->controller('Facets\TopicFacetController', ['recommend', 'topics'])->where(['slug' => '[a-z0-9-]+'])->name('recommend');
Route::get('/topic/{slug}/info')->controller('Facets\TopicFacetController@info')->where(['slug' => '[a-z0-9-]+'])->name('topic.info');
Route::get('/topic/{slug}/writers')->controller('Facets\TopicFacetController@writers')->where(['slug' => '[a-z0-9-]+'])->name('topic.writers');
Route::get('/topics/{page?}')->controller('Facets\AllFacetController', ['all', 'topic'])->name('topics.all');

Route::get('/topic/{slug}/{page?}')->controller('Facets\TopicFacetController', ['facet.feed', 'topics'])->where(['slug' => '[a-zA-Z0-9-]+'])->name('topic');
Route::get('/blogs/new/{page?}')->controller('Facets\AllFacetController', ['new', 'blog'])->name('blogs.new');
Route::get('/blogs/{page?}')->controller('Facets\AllFacetController', ['all', 'blog'])->name('blogs.all');

Route::get('/blog/{slug}/{page?}')->controller('Facets\BlogFacetController', ['facet.feed', 'blog.user'])->where(['slug' => '[a-zA-Z0-9-]+'])->name('blog');

Route::get('/domain/{domain}/{page?}')->controller('Post\PostController@domain', ['web.feed'])->where(['domain' => '[A-Za-z0-9-.]+'])->name('domain');

Route::get('/web')->module('catalog', 'App\Home', ['main'])->name('web');
Route::get('/web/website/{slug}')->module('catalog', 'App\Detailed')->name('website');
Route::get('/web/dir/{grouping}/{slug}')->module('catalog', 'App\Catalog', ['top'])->name('web.dir');
Route::get('/web/dir/{grouping}/{slug}/all')->module('catalog', 'App\Catalog', ['all'])->name('web.dir.all');
Route::get('/web/dir/{grouping}/{slug}/top')->module('catalog', 'App\Catalog', ['top'])->name('web.dir.top');

Route::type(['get', 'post'])->get('/cleek')->module('catalog', 'App\Catalog@cleek');

Route::get('/top/{page?}')->controller('HomeController', ['top'])->name('main.top');

Route::get('/sitemap.xml')->controller('RssController');
Route::get('/turbo-feed/topic/{slug}')->controller('RssController@turboFeed')->where(['slug' => '[A-Za-z0-9-]+']);
Route::get('/rss-feed/topic/{slug}')->controller('RssController@rssFeed')->where(['slug' => '[A-Za-z0-9-]+']);

Route::get('/{page?}')->controller('HomeController', ['feed'])->name('main'); 

require 'admin.php';