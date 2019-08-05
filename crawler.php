<?php
include_once('simple_html_dom.php');

function scraping_sites($url) {
	//Create context to act like a browser to the site. Otherwise some site will not allow to crawl
	$context = stream_context_create(array(
		'http' => array(
			'header' => array('User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201'),
		),
	));
	
    $html = file_get_html($url,false, $context);
	
	$links = array();
	if(!empty($html)){
		if(method_exists($html,"find")){
			$instaURL =  $html->find('a[href*="instagram.com"]');
			if(!empty($instaURL)){
				foreach($instaURL as $a) {
					if(!empty($a)){
						$links['Link'] = $a->href;
					}else{
						//$links[$url]['Link'] = 'Instagram not found';
					}
				}
				
			}else{
				$links['Link'] = 'Instagram not found';
			}
			
			//clean up memory
			$html->clear();
			unset($html);		
		}
	}else{
		$links['Link'] = 'Site not found';
	}
	
    return $links;
}
//List of the sites that will be crawled
$siteList = [
"http://www.bizroids.com/", 
"http://www.ampedlocal.com/", 
"https://desimoneglobalmarketing.com", 
"http://www.pillarbrands.com/", 
"https://nwc.media", 
"http://www.rapjab.com/", 
"http://www.havashelia.com/", 
"http://bergeycreativegroup.com/", 
"http://sukle.com", 
"https://waltonstreetwebdesign.com/", 
"http://schrockinteractive.com/", 
"https://www.redcrowmarketing.com/", 
"https://woodycreative.com/",
];
$resultArr = array();
foreach($siteList as $siteLink){
	
	$ret = scraping_sites($siteLink);
	$resultArr[$siteLink] = $ret;
}
$jsonData = json_encode($resultArr);

return $jsonData;


?>