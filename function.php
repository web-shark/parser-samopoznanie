<?php
//$path = $_SERVER['DOCUMENT_ROOT'];
require_once('lib/PHPExcel.php');
require_once('lib/PHPExcel/Writer/Excel5.php');
require_once('lib/PHPExcel/IOFactory.php');
require_once ('lib/phpQuery.php');
require_once ('lib/cURL.php');
require_once ('lib/cURL2.php');
require_once ('lib/cURL3.php');

//подключение библиотек
function parce_in_page($mainurl,$n,$filename){
//берем данные с каждого элемента
	$results_page = get_xml_page($mainurl); 
	$results = phpQuery::newDocument($results_page); 
	$blocks = $results->find('div.page.object_description.sitemap li');
	foreach ($blocks as $block){ 
		$el = pq($block);
		unset($block);
		$name = stristr($el->find('a')->text(),'(',true);//имя
		//$city = substr(stristr(stristr($el->find('li > a')->text(),')',true),'('),1);
		$url = 'https://samopoznanie.ru'.$el->find('a')->attr('href');//ссылка
		//echo $url;
		sleep(2);
		$next_page=get_xml_page($url);
		//echo $next_page;
		$next_result=phpQuery::newDocument($next_page);
		//$name = $next_result->find('h5')->text();
		//$type = $next_result->find('table.object_info.table_info tr:contains() > td:last');
		$city = stristr($next_result->find('table.object_info.table_info tr:contains("Регион")')->text(),'.',true);
		if( is_string($next_result->find('table.contact_adress_block:first a.f14.dash.border_bot')->text()) )
		{
			$skype = 'skype:'.trim($next_result->find('table.contact_adress_block:first a.f14.dash.border_bot')->text());
		}else{
			$skype = "0";
		}
		$object_first = $next_result -> find('table.adress.object_info.contact_adress_block a.dash.border_bot');
		$object_id = $object_first->attr('object_id');
		$object_adress_id = $object_first->attr('data-object_adress_id');
		$object_type = $object_first->attr('object_type');
		$is_update = $object_first->attr('data-is_update');
		$data = ['object_type'=>$object_type,
			'object_id'=>$object_id,
			'object_adress_id'=>$object_adress_id,
			'is_update'=>$is_update];
		sleep(2);
		$num_content = phpQuery::newDocument(get_xml_page2('https://samopoznanie.ru/?action=show_phone',$data,$url));

		//var_dump($num_content);
		$phones_inner = $num_content->find('div.phone-box');
		//var_dump($num_content);
		$phones = [];
		$i=0;
		foreach ($phones_inner as $phone) {
		    	$phones[$i] = pq($phone)->find('a.gray.noline.dash')->text();
		    	$i++;
		}
		//$phones = implode(",", $phones);
		$obj=[$name,$city,trim($skype)];
		$obj = array_merge ($obj,$phones);


		//var_dump($obj2);
	//var_dump($obj3);
	//var_dump($obj4);
	//var_dump($obj5);
		if($n==375){
			$filename = '2-'.$filename;
			$n=0;
		}
		
		if(file_exists($filename)){
			$objPHPExcel = PHPExcel_IOFactory::load($filename);
		}else{
			$objPHPExcel = new PHPExcel();
		}

		$objPHPExcel->getActiveSheet(0)->fromArray($obj, NULL, 'A'.$n);
		$n++;

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save($filename);
		$objPHPExcel->disconnectWorksheets();

		unset($objPHPExcel);
		unset($objWriter);
		gc_collect_cycles();
//		gc_mem_caches();

	} 
	phpQuery::unloadDocuments();
	gc_collect_cycles();

	return $n;
}
