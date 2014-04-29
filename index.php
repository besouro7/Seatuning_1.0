<?php
header("Content-Type: text/html; charset=utf-8");

class App
{
public $title = 'Seatuning | ';
public $description = 'Seatuning - ';
public $keywords = 'Лодки, ';
public $text = '';
public $module;
public $menu;

function __construct() {
	$login = 'root';
	$password = '';
	$host = 'localhost';
	$db = 'fmfest';

	$this -> connectDB($login, $password, $host, $db);
	include_once 'Engine/Module.class.php';
}

private function connectDB($login, $password, $host, $db) {
	mysql_connect($host, $login, $password);
	mysql_select_db($db);
	mysql_query("SET NAMES utf8");
	mysql_query("SET COLLATION_CONNECTION=utf8_bin");
}

/*
 * Метод получает название класса, подключает его и возвращает объект данного класса.
 * Если данного класса не существует - подключается класс Main.class.php
 */
private function getModule($module)
{
	$path = 'Engine/' . $module . '.class.php';

	if(!file_exists($path)){
		$module = 'Main';
		$path = 'Engine/' . $module . '.class.php';
	}

	include_once $path;
	return new $module;
}

/*
 * Метод получает название элемента из глобального массива GET,
 * возвращает её в обработанном виде
 */
static function GET($variable)
{
	$get = trim(htmlspecialchars($_GET[$variable]));
	return (!empty($get)) ? $get : 0;
}
/*
 * Метод получает название элемента из глобального массива POST,
 * возвращает её в обработанном виде
 */
static function POST($variable)
{
	$post = trim(htmlspecialchars($_POST[$variable]));
	return (!empty($post)) ? $post : 0;
}

/*
 * Метод строит страницу в браузере исходя из данных GET-запроса
 */
public function makePage() {
	$module = self::GET('module');

	if(!$module) {
		$module = 'Main';
	}

	$this -> module = $this -> getModule($module);
	$this -> menu = $this -> module -> getMenu();
	$this -> title .= $this -> module -> title;
	$this -> description .= $this -> module -> description;
	$this -> keywords .= $this -> module -> keywords;
	$this -> text .= $module -> text;

}
}

$app = new App;
$app -> makePage();

?>
<!DOCTYPE HTML>
<html>
<head>
<title><?=$app -> title?></title>
<meta name="keywords" content="<?=$app -> keywords?>">
<meta name="description" content="<?=$app -> description?>">
<link href="/css/reset.css" rel="stylesheet" media="all" >
<link href="/css/main.css" rel="stylesheet" media="all" >
<link href="/css/styles.css" rel="stylesheet" media="all" >
<link href="/css/lightbox.css" rel="stylesheet" media="all" >
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="/js/lightbox.js"></script>
</head>
<body>

<header>
<link rel="stylesheet" href="/css/bjqs.css">
<script src="/js/bjqs-1.3.min.js"></script>
<script class="secret-source">
jQuery(document).ready(function($) {
   $('#slider').bjqs({
	   'height' : 250,
	   'width' : 900,
	   'responsive' : true,
	   'showmarkers' : false,
	   'showcontrols' : true,
	   'animspeed' : 4500,
	   'animduration' : 1250,
	   'nexttext' : '',
	   'prevtext' : '',
	   'hoverpause' : false,
   });
});
</script>
<br/>
<div id="slider">
   <ul class="bjqs">
	   <li><img src="images/1.jpg"></li>
	   <li><img src="images/2.jpg"></li>
	   <li><img src="images/3.jpg"></li>
   </ul>
</div>
</header>
<nav id="menu">
<?php
    foreach($app -> menu as $node) {
		echo "<div>" . $node['textlink'] . "</div>";
	}
?>
</nav>
<div id="content">
<p class="with-indent"><?=$app -> module -> text?></p>

<?php
	foreach($app -> module -> templates as $tpl) {
		if($tpl['is_hidden'] == 0) {
			include ('/templates/' . $tpl['template']);
		}
	}
?>
</div>

</body>

</html>