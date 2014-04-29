<?php
abstract class Module
{
public $title;
public $module;
public $description;
public $keywords;
public $text;
public $templates = array();

function __construct() {

	$pageinfo = $this -> getPageInfo();
	$this -> title = $pageinfo['title'];
	$this -> text = $pageinfo['text'];
	$this -> keywords = $pageinfo['meta_k'];
	$this -> description = $pageinfo['meta_d'];
}

/*
 * Метод строит навигацию сайта,
 * если находимся на какой-либо странице, то ссылку на неё не формируем
 */
function getMenu () {

	$menu = array(
		'Main' => array(
			'title' => 'Ремонт и тюнинг',
			'description' => 'Что и почем',
			'makelink' => 1,
			'textlink'
			),
		'Gallery' => array(
			'title' => 'Галерея',
			'description' => 'Фото наших работ',
			'makelink' => 1,
			'textlink'
			),
		'Contacts' => array(
			'title' => 'Контакты',
			'description' => 'Как с нами связаться',
			'makelink' => 1,
			'textlink'
			),
	);

	foreach ($menu as $key => $value) {
		if($key == $this -> module) {
			$menu[$key]['makelink'] = 0;
		}
	}

	foreach ($menu as $key => $value) {
		if($menu[$key]['makelink'] == 0) {
			$menu[$key]['textlink'] = $menu[$key]['title'];
		} else {
			$menu[$key]['textlink'] =
					'<a title="' . $menu[$key]['description'] . '" href="/?module=' . $key . '">' .
							$menu[$key]['title'] . '</a>';
		}
	}

	return $menu;
}

function getPageInfo() {
	$result = mysql_query("
			SELECT * FROM page WHERE category='" . $this -> module . "'
			");
	return mysql_fetch_array($result);
}

function showErrors($errors, $text) {
	echo "<script>alert('";
	echo $text;
	for($i = 0; $i < count($errors); $i++) {
		echo $errors[$i];
		if($i == (count($errors)-1)) {
			echo ".";
		} else {
			echo ", ";
		}
	}
	echo "');</script>";
}

}
