<?php

include('simple_html_dom.php');

$url="http://www.tnpsc.gov.in/latest-notification.html";

// $url="http://www.tnpsc.gov.in/previous-notification.html";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$data = curl_exec ($ch);
curl_close ($ch);
// you can do something with $data like explode(); or a preg match regex to get the exact information you need
// echo $data;

$html = new simple_html_dom();  

$html->load($data);

$notifications = array();


foreach($html->find('.tableborder') as $table) {
	$i = 0;
    foreach($table->find('tr') as $tr){

    	// echo $tr;

    	if($i >= 4){
    		// echo '<pre>'.var_dump($tr->find('td', 2), true).'</pre>';
    		// echo $i.' '.$tr->innertext.'</br>';

    		if(!empty($tr->find('td', 0)) && !empty($tr->find('td', 1)) && !empty($tr->find('td', 2)) && !empty($tr->find('td', 3))
    		&& !empty($tr->find('td', 4)) && !empty($tr->find('td', 5)) ){

			$notification['notification_number']    = $tr->find('td', 1)->plaintext;
    		$notification['post_name']    			= $tr->find('td', 2)->plaintext;

    		$notification['href']  = $tr->find("td", 2)->children(0)->children(0)->href;

    		foreach($tr->find('td', 2) as $element) {
       			// $notification['post_ref_url'] = $element->href;
    		}

    		$notification['from_date'] 				= $tr->find('td', 3)->plaintext;
    		$notification['to_date'] 				= $tr->find('td', 4)->plaintext;
    		$notification['date_of_examination'] 	= $tr->find('td', 5)->plaintext;


    		$notifications[] 			= $notification;

    		}

    		
    	}
    	
        $i++;
    }
}


echo '<pre>'.print_r($notifications , true).'</pre>';


?>