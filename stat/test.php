<?php
/*statistic result*/


//$dbcon = mysql_connect($CFG['db']['hostname'], $CFG['db']['username'], $CFG['db']['password']) or die('error');
//mysql_select_db($CFG['db']['name'], $dbcon) or die('error');

/* Скрипт показывает клиентов, которые яблоки любят больше чем апельсины */

/* Переменные для соединения с базой данных */
$CFG['db']['hostname'] = 'localhost';
$CFG['db']['name'] = 'mediabox';
$CFG['db']['username'] = 'mediabox';
$CFG['db']['password'] = 'abror';

/*$hostname = "localhost";
$username = "myusername";
$password = "mypassword";
$dbName = "products";
*/
/* Таблица MySQL, в которой хранятся данные */
//$userstable = "clients";

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

echo  "<table boreder=1>";
echo "<tr>
		  <td width=20px>ID:</td>
		  <td width=500px>Название</td>
		  <td width=50px>Просмотор</td></tr>";
echo "</table>";
// Выводим результаты в html
while($row=mysql_fetch_array($res))
{
$video_id=$row['video_id'];
$video_title=$row['video_title'];	
$sum=$row['sum(video_viewed.total_views)'];

echo "<table border=1>";
echo "<tr>
		  <td width=20px>$video_id</td>
		  <td width=500px>$video_title</td>
		  <td width=50px>$sum</td></tr>";
echo  "</table>";

//echo $video_id;
//echo "($video_id) - $video_title <br><p align=justify>$sum";
}

// Освобождаем память от результата
mysql_free_result($res);


// Закрываем соединение
mysql_close($connect);
?>
