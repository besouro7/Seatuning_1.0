<?php
if($_POST['add_cat']) {

	if(is_uploaded_file($_FILES["photo"]["tmp_name"]))
	{
		$filename = explode(".", $_FILES["photo"]["name"]);
		$filetype = $filename[1];
		$filename = substr(time(), -5);
		$photo = $filename . "." . $filetype;

		image_resize($_FILES["photo"]["tmp_name"], "../images/categories/" . $photo, 159, 42, 100);


		mysql_query("INSERT INTO categories (title, photo) VALUES ('".$_POST['title']."', '$photo')");

	}
}
?>

<form enctype="multipart/form-data" method='POST'>
	<p>Название категории:<br/><input type='text' name='title' /></p>
	<p>Логотип: <input name='photo' type='file' /></p><br/>
	<p><input type='submit' value="Добавить категорию" name='add_cat' /></p>
</form>

<?php
function image_resize($source_path,	$destination_path, $newwidth, $newheight = FALSE, $quality = 100) {

	ini_set("gd.jpeg_ignore_warning", 1); // иначе на некотоых jpeg-файлах не работает

	list($oldwidth, $oldheight, $type) = getimagesize($source_path);

	switch ($type) {
		case IMAGETYPE_JPEG: $typestr = 'jpeg'; break;
		case IMAGETYPE_GIF: $typestr = 'gif' ;break;
		case IMAGETYPE_PNG: $typestr = 'png'; break;
	}
	$function = "imagecreatefrom$typestr";
	$src_resource = $function($source_path);
	if($oldwidth > $oldheight) {
		if (!$newheight) { $newheight = round($newwidth * $oldheight/$oldwidth); }
		elseif (!$newwidth) { $newwidth = round($newheight * $oldwidth/$oldheight); }
	} else {
		$newheight = $newheight;
		$newwidth = round($oldwidth * $newheight/$oldheight);
	}

	$destination_resource = imagecreatetruecolor($newwidth,$newheight);

	imagecopyresampled($destination_resource, $src_resource, 0, 0, 0, 0, $newwidth, $newheight, $oldwidth, $oldheight);

	if ($type = 2) { # jpeg
		imageinterlace($destination_resource, 1); // чересстрочное формирование изображение
		if ($quality) imagejpeg($destination_resource, $destination_path, $quality);
		else imagejpeg($destination_resource, $destination_path);
	}
	else { # gif, png
		$function = "image$typestr";
		$function($destination_resource, $destination_path);
	}

	imagedestroy($destination_resource);
	imagedestroy($src_resource);
}
?>