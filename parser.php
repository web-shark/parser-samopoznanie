<?php
//парсер наушников с розетки
ini_set('max_execution_time', '0'); 
set_time_limit(0);
ignore_user_abort (true);
ini_set('memory_limit', '1028M');
//системные настройки, чтобы парсер не останавливался
error_reporting(E_ALL); 
if(!empty($_POST["url"])){
	$main=$_POST["url"];//ссылка на категорию парсинга
	$mainurl = $main.'?action=treiners&p=24';
//	$url = $main.'organizers/';
}else{
	$mainurl='https://samopoznanie.ru/sitemap/?action=treiners&p=6';
//	$url = 'https://samopoznanie.ru/msk/organizers/';
}
	$filename='samopoznanie_tainers.xlsx';//название exel файла, name.xlsx
?>
<a href="/" style="margin-left: 30px;text-decoration: none;text-align: center;	font-size: 20px;color: blue;">парсинг начался,вернуться назад</a>
<p style="margin-left: 30px;">1 минуту посмотрите чтобы страница работала,потом можете закрывать</p>
<p style="margin-left: 30px;font-size: 20px;">Парсер баниться Авито периодически. Eсли окно страницы загрузилось сразу, значит парсер не работает, запустите его через час или напишите мне, <a style="color: blue;text-decoration: none;" href="https://t.me/sergey_bliacharskiy">Сергей</a>.</p>
<?php
$max = 39;//последняя страница парсинга
//$max_a = 38;


$elem_in_page=750;//количество элементов на странице
//header('Location: /');

//начало сбора данных парсера
require_once 'function.php';


$n=0;
$i=24;
$n = parce_in_page($mainurl,$n,$i.$filename);
$i++;

//$n = parce_organisation($url,$n,$filename);
/*if($max_a!=null){
	$max=$max_a;
}*/
		while($i<$max)
		{
		parce_in_page('https://samopoznanie.ru/sitemap/?action=treiners&p='.$i,$n,$i.$filename);
		//$n++;
		$i++;
		}




//if($max>2){


/*
	конец сбора данных, начало записи в exel файл

*/


//echo '<pre>';
//var_dump($obj);//вывод массива с данными
//echo '</pre>';



