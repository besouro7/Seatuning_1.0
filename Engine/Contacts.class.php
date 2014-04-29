<?php

class Contacts extends Module
{
public $module = "Contacts";

function __construct(){
	parent::__construct();

	if(App::POST('sendmessage')) {
		$this -> sendMessage(
			App::POST('username'), App::POST('telephone'), App::POST('text'), App::POST('email')
		);
	}

	if(App::GET('thank')) {
		echo "<script>alert('Спасибо, сообщение отправлено')</script>";
	}

	$this -> templates = array(
		'feedback' => array(
			'is_hidden' => 0,
			'template' => 'contacts/feedback.tpl',
		),
	);
}

protected function sendMessage($username, $telephone, $text, $email) {
	$datetime = date("Y-m-d H:i:s");
	$errors = array();
	if(empty($username)) {
		$errors[] = 'имя';
	}
	if(empty($telephone)) {
		$errors[] = 'телефон';
	}
	if(empty($text)) {
		$errors[] = 'текст';
	}
	if(empty($email)) {
		$errors[] = 'e-mail';
	}
	if(count($errors) > 0) {
		parent::showErrors($errors, 'Заполните ');
	} else {
		$result = mysql_query("
			INSERT INTO contacts (datetime, telephone, text, username, email)
			VALUES ('$datetime', '$telephone', '$text', '$username', '$email');
		");
		$text_mail = "Имя: $username \nE-mail: $email \nТелефон: $telephone \n\nТекст сообщения:\n$text";
		mail("zhuk7232@mail.ru", "SeaTuning", $text_mail);
		if ($result) {
			header("location: index.php?module=Contacts&thank=1");
		}
	}
}

}