<?php

class Main extends Module
{
public $module = "Main";

function __construct(){
	parent::__construct();
	$this -> templates = array(
		'slider' => array(
			'is_hidden' => 0,
			'template' => 'main/slider.tpl',
		),
	);
}

}