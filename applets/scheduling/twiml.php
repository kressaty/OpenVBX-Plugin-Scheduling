<?php 

$response = new Response();

$fallback = AppletInstance::getDropZoneUrl('fallback');
$choices = AppletInstance::getValue('choices[]');
$start = AppletInstance::getValue('timestart[]');
$finish = AppletInstance::getValue('timefinish[]');
$ci_timezone = AppletInstance::getValue('timezones');

$ci = & get_instance();

$choice_array = array();

if(count($start) == 1)
{

	$new_start = array(0 => $start);
	$start = $new_start;
	
	$new_finish = array(0 => $finish);
	$finish = $new_finish;

}

foreach($choices as $a=>$q)
{	
	$choice_array[$a] = AppletInstance::getDropZoneUrl('choices['.$a.']');
}

function verify_day($key, $today) {
	$sunday = AppletInstance::getValue('sunday[]');
	$monday = AppletInstance::getValue('monday[]');
	$tuesday = AppletInstance::getValue('tuesday[]');
	$wednesday = AppletInstance::getValue('wednesday[]');
	$thursday = AppletInstance::getValue('thursday[]');
	$friday = AppletInstance::getValue('friday[]');
	$saturday = AppletInstance::getValue('saturday[]');
	
	$days = array(
	 0 => (is_array($sunday) && array_key_exists($key, $sunday)) ? $sunday[$key] : $sunday,
	 1 => (is_array($monday) && array_key_exists($key, $monday)) ? $monday[$key] : $monday,
	 2 => (is_array($tuesday) && array_key_exists($key, $tuesday)) ? $tuesday[$key] : $tuesday,
	 3 => (is_array($wednesday) && array_key_exists($key, $wednesday)) ? $wednesday[$key] : $wednesday,
	 4 => (is_array($thursday) && array_key_exists($key, $thursday)) ? $thursday[$key] : $thursday,
	 5 => (is_array($friday) && array_key_exists($key, $friday)) ? $friday[$key] : $friday,
	 6 => (is_array($saturday) && array_key_exists($key, $saturday)) ? $saturday[$key] : $saturday,
	);
	
	return $days[$today];
}

function verify_time($currentTime, $startTime, $endTime){
	
	$now = explode(":", $currentTime);
	$currentHour = intval($now[0]);	
	$currentMinute = intval($now[1]);	

	$start = explode(":", $startTime);
	$startHour = intval($start[0]);	
	$startMinute = intval($start[1]);	

	$end = explode(":", $endTime);
	$endHour = intval($end[0]);	
	$endMinute = intval($end[1]);	

	$pass = true;

	if($startHour <= $endHour)
	{

		if($currentHour < $startHour)
		{
			$pass = false;
		};

		if($currentHour > $endHour)
		{
			$pass = false;
		};

		if($currentHour == $startHour)
		{
			if($currentMinute < $startMinute)
			{
				$pass = false;
			};
		};

		if($currentHour == $endHour)
		{
			if($currentMinute > $endMinute)
			{
				$pass = false;
			};
		};

	} 
	
	else 
	{

		if( ($currentHour < $startHour) && ($currentHour > $endHour) ){
			$pass = false;
		};

		if($currentHour == $startHour){
			if($currentMinute < $startMinute){
				$pass = false;
			};
		};

		if($currentHour == $endHour){
			if($currentMinute > $endMinute){
				$pass = false;
			};
		};

	};

	if($pass == false)
	{
		return 0;
	} 
	else 
	{
		return 1;
	};

};

$oops = true;
$do_fallback = false;

foreach($start as $k=>$b)
{

	if(!isset($ci_timezone))
	{
		$ci_timezone = "UM8";
	}
	
	$ci->config->set_item('time_reference', 'local');
	$ci->load->helper('date');
	
	$offset = (int)timezones($ci_timezone);
	
	$hour = date("G") + $offset;
	
	$server_time = mktime($hour, date("i"), date("s"));
	
	$server_time_formatted = date("G:i", $server_time);
	
	$server_day = date("w", $server_time);
		
	$currentTime = $server_time_formatted;
	
	$finish_time = $finish[$k];
	
	//debug - set a time here to restate $currentTime
	//$currentTime = "17:00";
	
	//echo $currentTime.' - '.$b.' - '.$finish_time;
	
	if(verify_time($currentTime, $b, $finish_time) == 1 AND verify_day($k, $server_day)) 
	{ 
		$response->addRedirect($choice_array[$k]);
		$response->Respond();
		$oops = false;
		$do_fallback = false;
		//echo "passed check ";
		break;
	}
	
	elseif(verify_time($currentTime, $b, $finish_time) == 0 OR !verify_day($k, $server_day)) 
	{
		$do_fallback = true;
		$oops = true;
		//echo "failed check ";
	}
}

if($oops == true AND $do_fallback == true)
{
	$response->addRedirect($fallback);
	$response->Respond();
}

?>