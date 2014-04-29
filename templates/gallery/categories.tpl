<div id='categories'>

<?php
	foreach($app -> module -> categories as $category) {
		echo "<div>	<a href='?module=Gallery&cat=". $category['id'] ."'>
		<p>". $category['title'] . "</p><img alt='". $category['title'] . "' src=/images/categories/". $category['photo'] . " /></a></div>";
		
	}
?>

</div>