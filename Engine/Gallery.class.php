<?php

class Gallery extends Module
{
public $module = "Gallery";
public $categories;
public $photos;
public $photo;

function __construct(){
	parent::__construct();

	$template_cat = '';
	$photos_hidden = 1;
	$photo_hidden = 1;

	if(App::GET('cat')) {
		$this -> photos = $this -> getPhotos(App::GET('cat'));
		$template_cat = '_without_photos';
		if($this -> photos) {
			$photos_hidden = 0;
		}
	}

	if(App::GET('photo')) {
		$this -> photo = mysql_fetch_assoc(mysql_query("SELECT * FROM gallery WHERE id='" . App::GET('photo') . "'"));
		$template_cat = '_without_photos';
		$photo_hidden = 0;
	}

	$this -> categories = $this -> getCategories();

	$this -> templates = array(
		'categories' => array(
			'template' => 'gallery/categories'. $template_cat .'.tpl',
			'is_hidden' => 0
		),
		'photos' => array(
			'template' => 'gallery/photos.tpl',
			'is_hidden' => $photos_hidden
		),
		'photo' => array(
			'template' => 'gallery/photo.tpl',
			'is_hidden' => $photo_hidden
		)
	);


}

/*
 * Метод получает список категорий для Галлереи
 */
function getCategories() {
	$result = mysql_query("
			SELECT * FROM categories
		");
	while($category = mysql_fetch_assoc($result)) {
		$categories[] = $category;
	}
	return $categories;
}

function getPhotos($cat) {
	$result = mysql_query("
			SELECT * FROM gallery WHERE cat_id='$cat'
		");
	while($photo = mysql_fetch_assoc($result)) {
		$photos[] = $photo;
	}
	return $photos;
}

}
