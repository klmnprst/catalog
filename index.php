<?php
#Выводим все ошибки
ini_set('display_errors', TRUE);
error_reporting(E_ALL);
#Установка ключа доступа к файлам 
define('MY_KEY', true);
#Установка кодировки
header("Content-Type: text/html; charset=utf-8");  
#Стартуем сессию
session_start();
#for user controller
$errors = array(); 
	
#Подключаем библиотеки
include './libs/db.php'; 
include './libs/function.php';
include './libs/user.php';
if (logged_in() === true) {
    if (user_active($_SESSION['username']) === false) {
        session_destroy();
        header('Location: /');
        die();
    }
}

################################################################################################
// Конфигурация маршрутов URL проекта.
$routes = array
(
    // Главная страница сайта (http://localhost/)
    array(
        // паттерн в формате Perl-совместимого реулярного выражения
        'pattern' => '~^/$~',
        // Имя класса обработчика
        'class' => 'default',
        // Имя метода класса обработчика
        'method' => 'index'
    ),

    // Страница регистрации пользователя (http://localhost/registration.xhtml)
    array(
        'pattern' => '~^/registration\.xhtml$~',
        'class' => 'User',
        'method' => 'registration',
    ),

    array(
        'pattern' => '~^/product/(.*)$~',
        'class' => 'product',
        'method' => 'index',
        'aliases' => array('product_url'),
    ),

    // Досье пользователя (http://localhost/userinfo/12345.xhtml)
    array(
        'pattern' => '~^/userinfo/([0-9]+)\.xhtml$~',
        'class' => 'User',
        'method' => 'infoInfo',
        // В aliases перечисляются имена переменных, которые должны быть в дальнейшем созданы
        // и заполнены значениями, взятыми на основании разбора URL адреса.
        // В данном случае в переменную user_id должен будет записаться числовой
        // идентификатор пользователя - 12345
        'aliases' => array('user_id'),
    ),

    // Категории 
    array(
        'pattern' => '~^/cat/(.*)$~',
        'class' => 'cat',
        'method' => 'index',
        'aliases' => array('cat_url'),
    ),

    // Форум (http://localhost/forum/web-development/php/12345.xhtml)
    array(
        'pattern' => '~^/forum(/[a-z0-9_/\-]+/)([0-9]+)\.xhtml$~',
        'class' => 'Forum',
        'method' => 'viewTopick',
        // Будут созданы переменные:
        // forum_url = '/web-development/php/'
        // topic_id = 12345
        'aliases' => array('forum_url', 'topic_id'),
    ),
    // Регистрация пользователей, login
    array(
        'pattern' => '~^/user/login$~',
        'class' => 'user',
        'method' => 'login',
    ),

    // Регистрация пользователей, register
    array(
        'pattern' => '~^/user/register$~',
        'class' => 'user',
        'method' => 'register',
    ),
    array(
        'pattern' => '~^/user/protected$~',
        'class' => 'user',
        'method' => 'protected',
    ),
       

    array(
        'pattern' => '~^/user/logout$~',
        'class' => 'user',
        'method' => 'logout',
    ),

     array(
        'pattern' => '~^/admin$~',
        'class' => 'admin',
        'method' => 'index',
    ),
    array(
        'pattern' => '|(?:/admin/attribute)(?:.*)|',
        'class' => 'admin',
        'method' => 'attribute',
    )

    // и т.д.
);

################################################################################################

// Назначаем модуль и действие по умолчанию.
$module = 'default';
$action = 'index';
// Массив параметров из URI запроса.
$params = array();
$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//echo $url_path;
foreach ($routes as $map)
{
    
    if (preg_match($map['pattern'], $url_path, $matches))
    {

        // Выталкиваем первый элемент - он содержит всю строку URI запроса
        // и в массиве $params он не нужен.
        array_shift($matches);


        // Формируем массив $params с теми названиями ключей переменных,
        // которые мы указали в $routes
        foreach ($matches as $index => $value)
        {
            $params[$map['aliases'][$index]] = $value;
        }

        $module = $map['class'];
        $action = $map['method'];

        break;
    } 
            
    
}
$url_path = trim($url_path,"/");
$arr_url = explode('/',$url_path);
//print_arr($arr_url);
$url  = $arr_url['0']; //Если совпадения не найдены, то этот url пойдет в контроллер по умолчанию
if (empty($url)) $url = "/";




/*
echo '<div data-alert class="alert-box success radius">';
echo "\$module: $module\n";
echo "\$action: $action\n";
echo "\$params:\n";
print_r($params);
echo '</div>';
*/










################# LITE ROUTING ################
/*
$url = parse_url($_SERVER['REQUEST_URI']);
$url['path'] = trim($url['path'],"/"); //убираем слеши
$arr_url = explode('/',$url['path']); //находим controller и action
$controller  = $arr_url['0']; //controller
if ($controller=='') $controller='default'; //controller по умолчанию
$action = (isset($arr_url[1]) ? $arr_url[1] : ''); //action
$params = (isset($arr_url[2]) ? $arr_url[2] : ''); //params
$query = (isset($url['query']) ? $url['query'] : ''); //params
*/
################# LITE ROUTING ################


############ Генерируем верхнее меню ############
ob_start();   
#Массив рубрик
$result = mysqli_query($db, "SELECT * FROM main WHERE top_menu='1'");
$super_tree = array();
while ($row = mysqli_fetch_assoc($result)) {
    $super_tree[$row['parent_id']][$row['id']] = $row;
}
echo build_tree_class($super_tree,0);
$top_menu = ob_get_contents();   
ob_end_clean();   
############ Генерируем верхнее меню ############


############ Генерируем боковое меню каталога #########
ob_start();   
#Массив рубрик
$result = mysqli_query($db, "SELECT * FROM main WHERE catalog='1'");
$cat_tree = array();
while ($row = mysqli_fetch_assoc($result)) {
    $cat_tree[$row['parent_id']][$row['id']] = $row;
}
echo build_cat_tree($cat_tree,0,"side-nav");
$cat_menu = ob_get_contents();   
ob_end_clean();  
############ Генерируем боковое меню каталога #########


################# CONTENT OLD #################
/*
ob_start();
#Подключаем контроллер
$controller_path = './controllers/' .$controller. '/index.php';
if (file_exists($controller_path)) {
	include $controller_path;
} else {
	include './controllers/default/index.php';
} 
	//header('Location: /404.html');
	//exit;
$content = ob_get_contents();   
ob_end_clean();   
*/
################# CONTENT OLD #################

################## CONTENT #################

ob_start();
#Подключаем контроллер
$controller_path = './controllers/' .$module. '/' .$action. '.php';
if (file_exists($controller_path)) {
    include $controller_path;
} else {
    include './controllers/default/index.php';
} 
    //header('Location: /404.html');
    //exit;
$content = ob_get_contents();   
ob_end_clean();   
################# CONTENT #################



 

	
#Подключаем главный шаблон   
include './template/index.php';
?>