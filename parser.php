<?php
ini_set("display_errors", 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//error_reporting(E_ALL);
ini_set('max_execution_time', '0'); 
set_time_limit(0);
ignore_user_abort (true);
ini_set('memory_limit', '512M');
$worker = $argv[1];
//$worker = 0;
$main_url = "https://www.google.com.ua/";
$filename = "output$worker.csv";
$filename2 = "results$worker.vcf";

$url = 'https://samopoznanie.ru/odessa/';
get_page_cookies($url,$main_url, $cookies, $info, $cookies);
//42
for ($i=$worker+1; $i < 43; $i+=20) { 
	$page_url = 'https://samopoznanie.ru/sitemap/?action=treiners&p='.$i;
	//echo $page_url;
	geturl($page_url,$url,$cookies,null,null,$info,$output_first);
	//echo $output_trainer;
	preg_match("/<div class=\"page object_description sitemap\">(.*?)<\/div>/uis", $output_first,$block_href);
	preg_match_all("/<li><a href=\"(.*?)\">(.*?)&nbsp;(.*?)<\/a><\/li>/uis", $block_href[1],$wrapper);

	for ($n=0; $n < count($wrapper[1]); $n++) { 
		$randomFloat = mt_rand(10, 20) / 100;
		sleep($randomFloat);
		//preg_match("/href=\"(.*?)\">(.*?)<\/a>/uis", $wrapper_href[1][$n],$url_trainer);
		//var_dump($wrapper_href[1]);
		geturl('https://samopoznanie.ru'.$wrapper[1][$n],$page_url,$cookies,null,null,$info,$output_trainer);
		preg_match("/<h1 id=\"h1-treiner\">(.*?)<\/h1>/uis", $output_trainer,$name);
		//data-object_adress_id="1435724"
		//current_object_id = 31701;
		//current_object_type = 1;
		//data-is_update="0"
		preg_match("/data-object_adress_id=\"(.*?)\"/uis", $output_trainer,$object_adress_id);
		preg_match("/data-is_update=\"(.*?)\"/uis", $output_trainer,$is_update);
		preg_match("/current_object_id = (.*?);/uis", $output_trainer,$current_object_id);
		preg_match("/current_object_type = (.*?);/uis", $output_trainer,$current_object_type);
		//echo $current_object_type[1].'<br>'.$current_object_id[1].'<br>'.$is_update[1].'<br>'.$object_adress_id[1];
		//<div class="phone-box"><a class="gray noline dash" href="tel:+79130588555">+7 913 058-85-55</a></div><div class="phone-box"><a class="gray noline dash" href="tel:+79135450555">+7 913 545-05-55</a></div>
		//
		preg_match("/<td>(Регион|Регионы)<\/td>\\n\\t\\t\\t\\t\\t\\t<td width=\"100%\">\\n\\t\\t\\t\\t\\t\\t\\t<hr\/>\\n\\t\\t\\t\\t\\t\\t<\/td>\\n\\t\\t\\t\\t\\t<\/tr>\\n\\t\\t\\t\\t<\/table>\\n\\t\\t\\t<\/td>\\n\\t\\t\\t\\n\\t\\t\\t<td>(.*?)<\/td>/uis", $output_trainer,$city);
		preg_match("/href=\"skype:(.*?)\?chat\"/uis", $output_trainer,$skype);
		$postarray = ['object_type'=>$current_object_type[1],'object_id'=>$object_adress_id[1], 'object_adress_id'=>$object_adress_id[1],'is_update'=>$is_update[1],'object_type'=>$current_object_type[1]];
		geturl('https://samopoznanie.ru/?action=show_phone',$page_url,$cookies,$postarray,null,$info,$output_phone);
		preg_match_all("/href=\"tel:(.*?)\"/uis", $output_phone,$phones);
/*
<td>Регион</td>
						<td width="100%">
							<hr/>
						</td>
					</tr>
				</table>
			</td>
			
			<td>Москва.</td>
<td>Регион</td>
						<td width="100%">
							<hr/>
						</td>
					</tr>
				</table>
			</td>
			
			<td>Новосибирск.</td>
*/
		//echo $city[1];
		//exit();
		//if(count(var))
		for ($ph=0; $ph < count($phones[1]); $ph++) { 
			if(preg_match('/[0-9]+\+/uis', $phones[1][$ph])){
				$phones[1][$ph] = str_replace('+', "", $phones[1][$ph]);
				$phones[1][$ph] = "+".$phones[1][$ph];
			}
		}
		//$phones_string = implode(", ",$phones[1]);
		$name_to_array = html_entity_decode($wrapper[2][$n]);
		$city_to_array = html_entity_decode($city[2]);
		if(empty($city_to_array)){
			var_dump($city);
			echo $output_trainer;
		}
		$skype_to_array = $skype[1];
		if(empty($skype_to_array)){
			$skype_to_array='-';
		}

			$name = trim($name_to_array);
			$obj = [$name,$city_to_array,$skype_to_array];
			$obj = array_merge($obj,$phones[1]);
			//var_dump($obj);
			$key = 0;
			foreach ($obj as $value) {

				$value = iconv("UTF-8","windows-1251",$value);
				$obj[$key] = $value;
				$key++;
			}
			$df = fopen($filename, 'a');
			fputcsv($df, $obj,";",'"');
			fclose($df);
			

		$randomFloat = mt_rand(30, 40) / 100;
		sleep($randomFloat);
	}

}
for ($i=$worker+1; $i < 26; $i+=20) { 
	$page_url = 'https://samopoznanie.ru/sitemap/?action=organizators&p='.$i;
	//echo $page_url;
	geturl($page_url,$url,$cookies,null,null,$info,$output_first);
	//echo $output_trainer;
	preg_match("/<div class=\"page object_description sitemap\">(.*?)<\/div>/uis", $output_first,$block_href);
	preg_match_all("/<li><a href=\"(.*?)\">(.*?)&nbsp;(.*?)<\/a><\/li>/uis", $block_href[1],$wrapper);

	for ($n=0; $n < count($wrapper[1]); $n++) { 
		$randomFloat = mt_rand(10, 20) / 100;
		sleep($randomFloat);
		//preg_match("/href=\"(.*?)\">(.*?)<\/a>/uis", $wrapper_href[1][$n],$url_trainer);
		//var_dump($wrapper_href[1]);
		geturl('https://samopoznanie.ru'.$wrapper[1][$n],$page_url,$cookies,null,null,$info,$output_trainer);
		preg_match("/<h1 id=\"h1-treiner\">(.*?)<\/h1>/uis", $output_trainer,$name);
		//data-object_adress_id="1435724"
		//current_object_id = 31701;
		//current_object_type = 1;
		//data-is_update="0"
		preg_match("/data-object_adress_id=\"(.*?)\"/uis", $output_trainer,$object_adress_id);
		preg_match("/data-is_update=\"(.*?)\"/uis", $output_trainer,$is_update);
		preg_match("/current_object_id = (.*?);/uis", $output_trainer,$current_object_id);
		preg_match("/current_object_type = (.*?);/uis", $output_trainer,$current_object_type);
		//echo $current_object_type[1].'<br>'.$current_object_id[1].'<br>'.$is_update[1].'<br>'.$object_adress_id[1];
		//<div class="phone-box"><a class="gray noline dash" href="tel:+79130588555">+7 913 058-85-55</a></div><div class="phone-box"><a class="gray noline dash" href="tel:+79135450555">+7 913 545-05-55</a></div>
		//
		preg_match("/<td>(Регион|Регионы)<\/td>\\n\\t\\t\\t\\t\\t\\t<td width=\"100%\">\\n\\t\\t\\t\\t\\t\\t\\t<hr\/>\\n\\t\\t\\t\\t\\t\\t<\/td>\\n\\t\\t\\t\\t\\t<\/tr>\\n\\t\\t\\t\\t<\/table>\\n\\t\\t\\t<\/td>\\n\\t\\t\\t\\n\\t\\t\\t<td>(.*?)<\/td>/uis", $output_trainer,$city);
		preg_match("/href=\"skype:(.*?)\?chat\"/uis", $output_trainer,$skype);
		$postarray = ['object_type'=>$current_object_type[1],'object_id'=>$object_adress_id[1], 'object_adress_id'=>$object_adress_id[1],'is_update'=>$is_update[1],'object_type'=>$current_object_type[1]];
		geturl('https://samopoznanie.ru/?action=show_phone',$page_url,$cookies,$postarray,null,$info,$output_phone);
		preg_match_all("/href=\"tel:(.*?)\"/uis", $output_phone,$phones);
/*
<td>Регион</td>
						<td width="100%">
							<hr/>
						</td>
					</tr>
				</table>
			</td>
			
			<td>Новосибирск.</td>
*/
		//echo $city[1];
		//exit();
		//if(count(var))
		for ($ph=0; $ph < count($phones[1]); $ph++) { 
			if(preg_match('/[0-9]+\+/uis', $phones[1][$ph])){
				$phones[1][$ph] = str_replace('+', "", $phones[1][$ph]);
				$phones[1][$ph] = "+".$phones[1][$ph];
			}
		}
		//$phones_string = implode(", ",$phones[1]);
		$name_to_array = html_entity_decode($wrapper[2][$n]);
		$city_to_array = html_entity_decode($city[2]);
		$skype_to_array = $skype[1];
		if(empty($skype_to_array)){
			$skype_to_array='-';
		}

			$name = trim($name_to_array);
			$obj = [$name,$city_to_array,$skype_to_array];
			$obj = array_merge($obj,$phones[1]);
			//var_dump($obj);
			$key = 0;
			foreach ($obj as $value) {

				$value = iconv("UTF-8","windows-1251",$value);
				$obj[$key] = $value;
				$key++;
			}
			$df = fopen($filename, 'a');
			fputcsv($df, $obj,";",'"');
			fclose($df);
			


		
		
		$randomFloat = mt_rand(30, 40) / 100;
		sleep($randomFloat);
	}

}
	echo "end$worker";

function geturl($url, $ref, $cookie, $postdata, $header, &$info, &$output)
{

	//global $worker;
	//$proxy_array = file("proxy.txt");
	//$proxy = explode("@",$proxy_array[$worker]);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1); 
	curl_setopt($ch, CURLOPT_PROXY, "localhost:9050");
	curl_setopt($ch, CURLOPT_PROXYTYPE, 7);
    curl_setopt($ch, CURLOPT_URL,$url);
	//curl_setopt($ch, CURLOPT_PROXY, trim($proxy[0]));
	//curl_setopt($ch, CURLOPT_PROXYUSERPWD, trim($proxy[1]));
    curl_setopt($ch, CURLOPT_COOKIESESSION, true); 
    if ($cookie)
    {
    	$cook_url = "";
    	foreach ($cookie as $cook) {
    		$cook_url.= $cook;
    		$cook_url.=";";
    	}
    	curl_setopt($ch, CURLOPT_COOKIE, $cook_url);
        
    }
    curl_setopt($ch, CURLOPT_HEADER, 0);
    if($header){
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
	curl_setopt($ch,CURLOPT_ENCODING , "gzip");
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
	curl_setopt($ch,CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36');
    if ($ref)
    {
        curl_setopt($ch, CURLOPT_REFERER, $ref);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if ($postdata)
    {
        curl_setopt($ch, CURLOPT_POST, true);
        $postStr = "";
        foreach ($postdata as $key => $value)
        {
            if ($postStr)
                $postStr .= "&";
            $postStr .= $key . "=" . $value;
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postStr);
    }
    $output = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    
    
}
function get_page_cookies($url, $ref, $cookie, &$info, &$output) { 
	//global $worker;
	//$proxy_array = file("proxy.txt");
	//$proxy = explode("@",$proxy_array[$worker]);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1); 
	curl_setopt($ch, CURLOPT_PROXY, "localhost:9050");
	curl_setopt($ch, CURLOPT_PROXYTYPE, 7);
    curl_setopt($ch, CURLOPT_URL,$url);
	//curl_setopt($ch, CURLOPT_PROXY, $proxy[0]);
	//curl_setopt($ch, CURLOPT_PROXYUSERPWD, trim($proxy[1]));
    curl_setopt($ch, CURLOPT_COOKIESESSION, true); 
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch,CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36');
    if ($ref)
    {
        curl_setopt($ch, CURLOPT_REFERER, $ref);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if ($cookie)
    {
        curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ ."/". $cookie);
    }
    $info = curl_getinfo($ch);
    $output = curl_exec($ch);
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi',$output, $output);

    curl_close($ch);
} 
function grab_image($url,$dist){
	//global $worker;
	$proxy_array = file("proxy.txt");
	$proxy = explode("@",$proxy_array[$worker]);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_PROXY, $proxy[0]);
	curl_setopt($ch, CURLOPT_PROXYUSERPWD, trim($proxy[1]));
    $fp = fopen($dist, 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
}