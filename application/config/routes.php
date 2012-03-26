<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "main";
$route['404_override'] = 'error/page_404';

$route['denied'] = 'error/denied';

$route['(about|contact|help|advertise)'] = 'page/index/$1';

$route['article/(:num)/(:any)'] = 'article/index/$1';
$route['article/(:any)'] = 'article/index/$1';

$route['member'] = 'member/main';
//$route['member/'] = 'member/main';
$route['member/blog/page/(:num)'] = 'member/blog/index/$1';
$route['member/blog/series/(:any)'] = 'member/blog/index/$1';

$route['member/project/page/(:num)'] = 'member/project/index/$1';
$route['member/project/tag/(:any)'] = 'member/project/index/$1';

$route['member/review/page/(:num)'] = 'member/review/index/$1';
$route['member/video/page/(:num)'] = 'member/video/index/$1';
$route['member/forum/page/(:num)'] = 'member/forum/index/$1';

$route['user/(:any)/add_friend'] = 'user/add_friend/$1';
$route['user/(:any)/remove_friend'] = 'user/remove_friend/$1';

$route['user/page/(:num)'] = 'user/index/$1';
$route['user/by/(:any)'] = 'user/index/$1';
$route['user/(:any)/friends'] = 'user/friend/$1';
$route['user/(:any)'] = 'user/read/$1';

$route['forum/page/(:num)'] = 'forum/index/$1';
$route['forum/(:num)'] = "forum/browse/$1";
$route['forum/tag/(:any)'] = 'forum/index/$1';
$route['forum/(:num)/unanswered'] = "forum/unanswered/$1";


$route['blog/page/(:num)'] = 'blog/index/$1';
#$route['blog/by/(:any)/page/(:num)'] = 'blog/index/$1';
$route['blog/series/(:num)/page/(:num)'] = "blog/series/$1/page/$2";

$route['blog/tag/(:any)'] = 'blog/index/$1';
$route['blog/by/(:any)'] = 'blog/index/$1';
$route['blog/(:num)/(:any)'] = "blog/read/$1";
$route['blog/series/(:num)'] = "blog/series/$1";
$route['blog/(:any)'] = "blog/browse/$1";

$route['project/page/(:num)'] = 'project/index/$1';
#$route['project/by/(:any)/page/(:num)'] = 'project/index/$1';

$route['project/tag/(:any)'] = 'project/index/$1';
$route['project/by/(:any)'] = 'project/index/$1';
$route['project/(:num)/(:any)'] = "project/read/$1";
$route['project/(:any)'] = "project/browse/$1";

$route['review/page/(:num)'] = 'review/index/$1';

$route['review/brand/(:any)'] = 'review/index/$1';
$route['review/category/(:any)'] = 'review/index/$1';
$route['review/tag/(:any)'] = 'review/index/$1';
$route['review/by/(:any)'] = 'review/index/$1';
$route['review/(:num)/(:any)'] = "review/read/$1";
$route['review/(:any)'] = "review/browse/$1";

$route['video/page/(:num)'] = 'video/index/$1';
$route['video/tag/(:any)'] = 'video/index/$1';
$route['video/by/(:any)'] = 'video/index/$1';
$route['video/(:num)/(:any)'] = "video/read/$1";
$route['video/(:any)'] = "video/browse/$1";

$route['contest/(:num)/vote'] = "contest/vote/$1";
$route['contest/(:num)/submit'] = "contest/submit/$1";
$route['contest/(:num)/entries'] = "contest/entries/$1";
$route['contest/(:num)/result'] = "contest/result/$1";
$route['contest/(:num)/(:any)'] = "contest/read/$1";
$route['contest/(:any)'] = "404";

$route['member/message/(sent|received)'] = "member/message/index";
$route['member/message/(sent|received)/page/(:num)'] = "member/message/index";
$route['member/message/(:num)'] = "member/message/read/$1";
$route['member/message/(:num)/reply'] = "member/message/reply/$1";
$route['member/message/(:num)/(remove_inbox|remove_outbox)'] = "member/message/$2/$1";

$route['backadmin'] = 'internal/login';
$route['backadmin/user/by/(:any)'] = 'internal/user/index/$1';
$route['backadmin/forum/page/(:num)'] = 'internal/forum/index/$1';
$route['backadmin/(:any)'] = 'internal/$1';

$route['backadmin/comment/only/(:any)'] = 'internal/comment/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */