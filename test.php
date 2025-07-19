<?php
	
	$url = "https://blitcharter.com/get_query.html";
	$data = ["from"=>"10005","to"=>"10010","ajax_load"=>"1"];
	
	$postdata = http_build_query($data);
	
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_POST,true);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	
	$response = curl_exec($ch);
	if ($response === false) {
	  die("Error in recieving info :" . curl_error($ch));
	}
	curl_close($ch);
	
	
	
	$bot_token = "8121735578:AAGIXmKdv7z13zaanm5YBuk7D8U8yhUS1Rc";
	$chat_id = "782399844";
	
	function sendTelegramMessage($bot_token,$chat_id,$message){
	  $url = "https://api.telegram.org/bot$bot_token/sendMessage";
	  
	  $data = ['chat_id'=>$chat_id , 'text'=> $message];
	  
	  $ch = curl_init();
	  curl_setopt($ch,CURLOPT_URL,$url);
	  curl_setopt($ch,CURLOPT_POST,true);
	  curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
	  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	  $result = curl_exec($ch);
	  if ($result === false) {
	    error_log("Error sending Telegram Message : ") . curl_error($ch) ;
	  }
	  curl_close($ch);
	};
	
	
	
	foreach ($data["result"] as $item){
	  if(isset($item["price"])) {
	    $clean_price = strip_tags($item["price"]);
	    $clean_price = str_replace([',',' '] , "" , $clean_price);
	    $clean_price = str_replace('تومان', "" , $clean_price);
	    $price = (int)$clean_price;
	    
	    $if($price > 0 && $price <5000) {
	      
	      $message = "appropriate price found/ Price: {$price} / Date: {$item['date_flight']}";
	      sendTelegramMessage($bot_token , $chat_id , $message);
	    }
	  }
	}
	
	
	
	
	
	
	
	
	
	
	
?>