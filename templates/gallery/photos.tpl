
<div id='photos'>

<?php
	foreach($app -> module -> photos as $photo) {
		echo "<div>	<a href='?module=Gallery&photo=". $photo['id'] ."'>
		<p>". $photo['title'] . "</p></a>
		<a rel='lightbox[boats]' href='/images/gallery/". $photo['photo_big'] . "' rel='gb_image[]'><img alt='". $photo['title'] . "' src=/images/gallery/". $photo['photo_small'] . " /></a></div>";

	}
?>

</div>
