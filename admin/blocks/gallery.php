<?php
if(isset($_POST['add_photo'])) {

	$title = $_POST['title'];
	$description = $_POST['description'];
	$cat_id = $_POST['cat'];
	if(is_uploaded_file($_FILES["photo"]["tmp_name"]))
	{
		$filename = explode(".", $_FILES["photo"]["name"]);
		$filetype = $filename[1];
		$filename = substr(time(), -5);
		$photo_big = $filename . "_big." . $filetype;
		$photo_small = $filename . "_small.". $filetype;
		image_resize($_FILES["photo"]["tmp_name"], "../images/gallery/" . $photo_big, 800, 600, 100);
		image_resize($_FILES["photo"]["tmp_name"], "../images/gallery/" . $photo_small, 150, 112, 100);

		$result = mysql_query("INSERT INTO gallery (title, description, cat_id, photo_big, photo_small)
					VALUES ('$title', '$description', '$cat_id', '$photo_big', '$photo_small')");
		
	}
}
?>

<form enctype="multipart/form-data" method="POST" name="photos">
	<p>Название фотографии:<br/><input name='title' type='text' /></p>
	<p>Описание:<br/><textarea rows="7" cols="70" name='description'> </textarea></p>
	<p><select name='cat'>
		<?php
			$result = mysql_query("SELECT * FROM categories");
			$cats = mysql_fetch_array($result);
			do {
				echo "<option value='".$cats['id']."'>" . $cats['title'] . "</option>";
			} while($cats = mysql_fetch_array($result));
		?>

	</select></p>
	<p>Фотография<input name='photo' type='file' /></p><br/>
	<p><input style='width: 200px; height: 50px;' name='add_photo' type='submit' value='Добавить фото'/></p>
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