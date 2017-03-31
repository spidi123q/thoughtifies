<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['data/1']='Login/loginUser';
$route['data/2']='Login/createAccount';
$route['data/3']='Login/loginUser2';
$route['data/4']='Login/loginFacebook';
$route['login/(:num)']='Login/restoreSession/$1';
$route['home']='Login/loadHome';
$route['index']='Login/index';
$route['license']='Login/license';
$route['privacy']='Login/privacy';
$route['(:any)/logout']='Login/logout';
$route['(:any)/p/(:num)']='Login/pageSelection/$2';
$route['(:any)/settings/(:num)']='Login/changeSettings/$2';
$route['(:any)/settings/get/0']='Login/getMyDetails';
$route['(:any)/settings/upload']='Login/dpUpload';
$route['(:any)/settings/setdp']='Login/setDp';
$route['(:any)/msg/load/(:num)']='Login/displayMessages/$2';
$route['(:any)/msg/sent']='Login/sentMessage';
$route['(:any)/msg/count/(:num)']='Login/countMsg/$2';
$route['(:any)/msg/get']='Login/getMessages';
$route['(:any)/msg/users/(:num)']='Login/getMsgUsers/$2';
$route['(:any)/msg/users/count']='Login/getMsgUsersCount';
$route['(:any)/msg/f/(:num)']='Login/f/$2';
$route['(:any)/msg/del/user/(:num)']='Login/deleteMsgUser/$2';
$route['(:any)/msg/page/(:num)']='Login/messagePagination/$2';
$route['(:any)/msg/emoji/(:num)']='Login/listEmoji/$2';
$route['(:any)/search/tool/(:num)/(:any)']='Login/searchToolBar/$2/$3';
$route['(:any)/search/tool/(:num)']='Login/searchToolBar/$2';
$route['(:any)/search/adv']='Login/advancedSearch';
$route['(:any)/search/adv/count']='Login/advancedSearchCount';
$route['(:any)/online/id']='Login/updateOnlineUsers';
$route['(:any)/online/2']='Login/listOnlineUsers';
$route['(:any)/dialog/(:num)']='Login/getDialog/$2';
$route['(:any)/dialog/content/(:num)']='Login/getDialogContent/$2';
$route['(:any)/info/1']='Login/getMyInfo';
$route['(:any)/list/countries']='Login/getCountriesList';
$route['(:any)/chatbox']='Login/getChatBox';
$route['(:any)/users/(:num)']='Login/getUserDetails/$2';
$route['(:any)/users/rv/(:num)']='Login/addRecentVisitor/$2';
$route['(:any)/users/request/(:any)']='Login/addFriend/$2';
$route['(:any)/users/rv/get']='Login/getRecentVisitor';
$route['(:any)/users/cancel/(:any)']='Login/removeFriend/$2';
$route['(:any)/users/block/(:num)']='Login/blockUser/$2';
$route['(:any)/users/unfriend/(:num)']='Login/unfriendUser/$2';
$route['(:any)/users/frnd/status/(:any)']='Login/getFriendshipStatus/$2';
$route['(:any)/element/(:num)']='Login/getElement/$2';
$route['(:any)/home/upload']='Login/postImageUpload';
$route['(:any)/home/post']='Login/insertPost';
$route['(:any)/req/frnd/(:num)']='Login/getFriendRequestList/$2';
$route['(:any)/req/frnd/count']='Login/getFriendRequestCount';
$route['(:any)/req/frnd/action/(:num)/(:num)']='Login/friendRequestActions/$2/$3';
$route['(:any)/post/onrating/(:num)/(:num)']='Login/onRating/$2/$3';
$route['(:any)/post/count']='Login/getPostsCount';
$route['(:any)/post/id/(:num)']='Login/getPostById/$2';
$route['(:any)/post/get/(:num)']='Login/getPosts/$2';
$route['(:any)/post/delete/(:num)']='Login/deletePost/$2';
$route['(:any)/post/count/(:num)']='Login/getPostsCount/$2';
$route['(:any)/post/friends/get/(:num)']='Login/getFriendsPosts/$2';
$route['(:any)/post/friends/count']='Login/getFriendsPostsCount';
$route['(:any)/post/get/(:num)/(:num)']='Login/getPosts/$2/$3';
$route['(:any)/post/report']='Login/reportPost';
$route['(:any)/rating/get/(:num)']='Login/getMyRating/$2';
$route['(:any)/block/get']='Login/listBlockedUsers';
$route['(:any)/block/cancel/(:num)']='Login/unBlock/$2';
$route['(:any)/img/dp/(:any)/(:num)']='Login/dpFetch/$2/$3';
$route['(:any)/img/userdp/(:num)/(:num)']='Login/userDpFetch/$2/$3';
$route['(:any)/tbs/hash/(:any)/(:num)']='Login/searchPostByHashtag/$2/$3';
$route['(:any)/tbs/hash/count/(:any)']='Login/searchPostByHashtagCount/$2';
$route['(:any)/tbs/keyword/(:any)/(:num)']='Login/searchPostByKeyword/$2/$3';
$route['(:any)/tbs/keyword/count/(:any)']='Login/searchPostByKeywordCount/$2';
$route['(:any)/noti/get']='Login/getNotification';
$route['(:any)/noti/seen/(:any)']='Login/setNotification/$2';
$route['(:any)/globe/get/(:num)']='Login/listPostRating/$2';
$route['(:any)/globe/count']='Login/listPostRatingCount';
$route['(:any)/friend/list/(:num)']='Login/friendsList/$2';
$route['(:any)/friend/count']='Login/friendsCount';
