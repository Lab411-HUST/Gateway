<?php 
	$doc = new DOMDocument();
		$doc->load("https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%3D91882938%20and%20u%3D%27c%27&diagnostics=true");
		$channel = $doc->getElementsByTagName("channel");
		foreach($channel as $ch)
		{
			$item = $ch->getElementsByTagName("item");
			foreach($item as $itemgotten)
			{
				$temp = $itemgotten->getElementsByTagNameNS("http://xml.weather.yahoo.com/ns/rss/1.0","condition")->item(0)->getAttribute("temp");	
				
			}
			$hum = $ch->getElementsByTagNameNS("http://xml.weather.yahoo.com/ns/rss/1.0","atmosphere")->item(0)->getAttribute("humidity");
			$infor = $temp . " " . $hum;
			echo $infor;
		}
?>