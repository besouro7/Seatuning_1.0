<?php
header("Content-Type: text/html; charset=utf-8");
$login = 'root';
$password = '';
$host = 'localhost';
$db = 'seatuning';

mysql_connect($host, $login, $password);
mysql_select_db($db);

?>
<style>
	table {width: 1000px; margin: 0 auto; min-height: 500px; }
	td, tr {border: 1px solid #cecece; vertical-align: top;}
	a { padding: 10px;}
</style>
<table>
<tr>
	<td width=250>
		<br/>
		<a href="index.php?do=gallery">Галерея</a>
	<br/><br/>

		<a href="index.php?do=pages">Страницы</a>

	<br/><br/>
		<a href="index.php?do=messages">Сообщения обратной связи</a>

	<br/><br/>
		<a href="index.php?do=categories">Категории галереи</a>
	</td>
	<td>
<?php

		include 'blocks/'.$_GET['do'].'.php';


?>
	</td>
</tr>
</table>