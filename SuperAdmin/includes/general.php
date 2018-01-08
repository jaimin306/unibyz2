
<?php
	function encrypt($sData){
		$id=(double)$sData*52532511.24;
		return base64_encode($id);
	}
	function decrypt($sData){
		$url_id=base64_decode($sData);
		$id=(double)$url_id/52532511.24;
		return $id;
	}
	function GetSettingGeneral($pname){
		global $mysqli;
		$sel1 = "SELECT parameter_value FROM tbl_setting WHERE parameter_name = '$pname'";
		$que1 = mysqli_query($mysqli,$sel1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
		$row1 = mysqli_fetch_assoc($que1);
		$value = $row1["parameter_value"];
		return $value;
	}
	


	/*
	function GetSetting($pname){
      global $mysqli;
      $sel1 = "SELECT parameter_value FROM tbl_setting WHERE parameter_name = '$pname' AND parameter_type = 'General'";
      $que1 = mysqli_query($mysqli,$sel1) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
        $row1 = mysqli_fetch_assoc($que1);
        $value = $row1["parameter_value"];
      return $value;
    }
    function GetSettingEmail($pname){
      global $mysqli;
      $sel2 = "SELECT parameter_value FROM tbl_setting WHERE parameter_name = '$pname' AND parameter_type = 'Email'";
      $que2 = mysqli_query($mysqli,$sel2) or fatal_error( 'MySQL Error: ' . mysqli_errno($mysqli));
        $row2 = mysqli_fetch_assoc($que2);
        $value2 = $row2["parameter_value"];
      return $value2;
    }
    function EplapseTime($start, $end = null, $limit = null, $filter = true, $suffix = 'Ago', $format = 'Y-m-d', $separator = ' ', $minimum = 1)
	{
	    $dates = (object) array(
	        'start' => new DateTime($start ? : 'now'),
	        'end' => new DateTime($end ? : 'now'),
	        'intervals' => array('y' => 'year', 'm' => 'Month', 'd' => 'Day', 'h' => 'Hour', 'i' => 'minute', 's' => 'Second'),
	        'periods' => array()
	    );
	    $elapsed = (object) array(
	        'interval' => $dates->start->diff($dates->end),
	        'unknown' => 'unknown'
	    );
	    if ($elapsed->interval->invert === 1) {
	        return trim('0 seconds ' . $suffix);
	    }
	    if (false === empty($limit)) {
	        $dates->limit = new DateTime($limit);
	        if (date_create()->add($elapsed->interval) > $dates->limit) {
	            return $dates->start->format($format) ? : $elapsed->unknown;
	        }
	    }
	    if (true === is_array($filter)) {
	        $dates->intervals = array_intersect($dates->intervals, $filter);
	        $filter = false;
	    }
	    foreach ($dates->intervals as $period => $name) {
	        $value = $elapsed->interval->$period;
	        if ($value >= $minimum) {
	            $dates->periods[] = vsprintf('%1$s %2$s%3$s', array($value, $name, ($value !== 1 ? 's' : '')));
	            if (true === $filter) {
	                break;
	            }
	        }
	    }
	    if (false === empty($dates->periods)) {
	        return trim(vsprintf('%1$s %2$s', array(implode($separator, $dates->periods), $suffix)));
	    }

	    return $dates->start->format($format) ? : $elapsed->unknown;
	}
	function DownloadImageFromUrl($imagepath)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch,CURLOPT_URL, $imagepath);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result=curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	*/
?>