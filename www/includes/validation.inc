<?php 
function is_empty($var,$label = '',$verbose = 1)
{
	if(is_array($var))
	{
		if(count($var) <= 0)
		{
			if($verbose)
			{
				display_error(_("The $label field cannot be empty."));
				set_focus($var);	
			}
			return true;
		}
	}
	else if (strlen(trim($var)) <= 0)
	{
		if($verbose)
		{
			display_error(_("The $label field cannot be empty."));
			set_focus($var);	
		}
		return true;
	}
	else
	{}
	return false;
}
function is_number($var,$label,$verbose = 1)
{
	if (!is_numeric($var))
	{
		if($verbose)
		{
			display_error(_("The $label can contain only numbers."));
			set_focus($var);	
		}
		return false;
	}
	return true;
}

function is_time($time,$label,$verbose = 1,$is24Hours=true,$seconds=true) 
{
    $pattern = "/^".($is24Hours ? "([1-2][0-3]|[01]?[1-9])" : "(1[0-2]|0?[1-9])").":([0-5]?[0-9])".($seconds ? ":([0-5]?[0-9])" : "")."$/";
    if (preg_match($pattern, $time)) 
    {
        return true;
    }
	if($verbose)
	{
		display_error(_("The $label can contain only valid times."));
		set_focus($var);	
	}
    return false;
}
function greater_sanity_check($var1,$var2,$label1,$label2,$verbose = 1)
{
	if($var1 > $var2)
	{
		if($verbose)
		{
			display_error(_("The $label1 cannot be greater then $label2."));
			set_focus($var1);	
		}
	    return false;
	}
	return true;
}
function time_sanity_check($var1,$var2,$label1,$label2,$verbose = 1)
{
	// convert times to seconds from epoch
	$timeOn = strtotime($var1);
	$timeOff = strtotime($var2);
	// if database time is in timestamp format,
	// only the hour, minutes and second information is needed
	$timeOn = mktime(date("H", $timeOn), date("i", $timeOn), date("s", $timeOn));
	$timeOff = mktime(date("H", $timeOff), date("i", $timeOff), date("s", $timeOff));
	// if time on is higher than time off, time on is of yesterday
	$start = $timeOn;
	$end = $timeOff;
	if($start <= $end)
	{
	    return true;
	}
	if($verbose)
	{
		display_error(_("The $label2 cannot be less then $label1."));
		set_focus($var);	
	}
    return false;
	
}
function date_sanity_check($var1,$var2,$label1,$label2,$verbose = 1)
{
	try 
	{
  		if(!is_date($var1) || !is_date($var2)) throw new Exception("exception");
		$obj1 = new DateTime($var1);
  		$obj2 = new DateTime($var2);
  		if($obj2 -> getTimestamp() >= $obj1 -> getTimestamp())
  		{
  			return true;	
  		}
  		else 
  		{
  			if($verbose)
			{
				display_error(_("The $label1 cannot be greater then $label2."));
				set_focus($var1);	
			}
			return false;
  		}
	} 
	catch (Exception $e) 
	{
		if($verbose)
		{
			display_error(_("The $label1 and $label2 can contain only valid dates."));
			set_focus($var1);	
		}
		return false;
	}
}
?>