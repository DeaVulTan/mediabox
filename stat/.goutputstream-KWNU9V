<?php
/* вкл. Smarty */
require('smarty.php');

/* Переменные для соединения с базой данных */
$CFG['db']['hostname'] = 'localhost';
$CFG['db']['name'] = 'mediabox';
$CFG['db']['username'] = 'abror';
$CFG['db']['password'] = 'abror';

/* создать соединение */
$connect = mysql_connect($CFG['db']['hostname'],$CFG['db']['username'],$CFG['db']['password']) OR DIE("Не могу создать соединение ");
/* выбрать базу данных. Если произойдет ошибка - вывести ее */
mysql_select_db($CFG['db']['name']) or die(mysql_error()); 

/* составить запрос, который выберет всех клиентов - яблочников */
$query = "SELECT video.video_title, video_viewed.video_id, video_viewed.view_date, sum(video_viewed.total_views)  FROM video, video_viewed WHERE video.video_id=video_viewed.video_id GROUP BY video_viewed.video_id;";
/* Выполнить запрос. Если произойдет ошибка - вывести ее. */
$res = mysql_query($query) or die(mysql_error());

/* Как много нашлось таких */
$number = mysql_num_rows($res);

// Выводим результаты в html

while($row = mysql_fetch_array($res)){
	
	$video_title = $row['video_title'];
	$video_id = $row['video_id'];
	$sum = $row['sum(video_viewed.total_views)'];
	
}

$smarty = new Smarty();

$smarty->assign('video_title', $video_title);
$smarty->assign('video_id', $video_id);
$smarty->assign('sum', $sum);

$smarty->display('index.tpl');

/*
$video_id = $row['video_id'];
$video_title = $row['video_title'];	
$sum = $row['sum(video_viewed.total_views)'];
*/

// Присваиваем значенич

// Освобождаем память от результата
mysql_free_result($res);


// Закрываем соединение
mysql_close($connect);

?>
