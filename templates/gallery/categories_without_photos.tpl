<div id='categories'>

<?php
	foreach($app -> module -> categories as $category) {
		echo "<div>	<a href='?module=Gallery&cat=". $category['id'] ."'>
		<p>". $category['title'] . "</p></a></div>";

	}
?>

</div>