<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * clean_date
 *
 * Create a custom date format.
 * default is 'd M y'
 *
 * @access	public
 * @param	string
 * @return	string
 */
function clean_date($time, $str_format="m-d-Y")
{	
	if($time=='0000-00-00')	{
		$date = '';
	}else{
		$date = strtotime($time);
		$date = date($str_format , $date);
	}
	return $date;
}
// ------------------------------------------------------------------------

/**
 * pretty_date
 *
 * Create a pretty date format.
 * based on human readable format time
 *
 * @access	public
 * @param	string
 * @return	string
 */
function pretty_date($date,$compareTo = NULL)
{

	$date = new DateTime($date);

	if(is_null($compareTo)) {
		$compareTo = new DateTime();
	}else{
		$compareTo = new DateTime($compareTo);
	}

	$diff = $compareTo->format('U') - $date->format('U');
	$dayDiff = floor($diff / 86400);

	if(is_nan($dayDiff) || $dayDiff < 0) {
		return '';
	}

	if($dayDiff == 0) {
		if($diff < 60) {
			return 'Just now';
		} elseif($diff < 120) {
			return '1 minute ago';
		} elseif($diff < 3600) {
			return floor($diff/60) . ' minutes ago';
		} elseif($diff < 7200) {
			return '1 hour ago';
		} elseif($diff < 86400) {
			return floor($diff/3600) . ' hours ago';
		}
	} elseif($dayDiff == 1) {
		return 'Yesterday';
	} elseif($dayDiff < 7) {
		return $dayDiff . ' days ago';
	} elseif($dayDiff == 7) {
		return '1 week ago';
	} elseif($dayDiff < (7*6)) { // Modifications Start Here
		// 6 weeks at most
		return floor($dayDiff/7) . ' week' . (floor($dayDiff/7) > 1 ? 's' : '') . ' ago';
	} elseif($dayDiff < 365) {
		return floor($dayDiff/(365/12)) . ' month' . ( floor($dayDiff/(365/12)) > 1 ? 's' : '') . ' ago';
	} else {
		$years = round($dayDiff/365);
		return $years . ' year' . ($years != 1 ? 's' : '') . ' ago';
	}
}
// ------------------------------------------------------------------------

/**
 * get_month
 *
 * Create a custom format month in specific language.
 * return the value of month array
 *
 * @access	public
 * @param	int
 * @return	string
 */
function get_month($m)
{
	$month = array (
		1 => 'January',
		2 => 'February',
		3 => 'March',
		4 => 'April',
		5 => 'May',
		6 => 'June',
		7 => 'July',
		8 => 'August',
		9 => 'September',
		10 => 'October',
		11 => 'November',
		12 => 'December'
	);
	return $month[$m];
}

function get_total_days($start, $end) {
	$start = substr($start, 0,10);
	$start_ts = strtotime($start);
	$end_ts = strtotime($end);
	$diff = $end_ts - $start_ts;
	return round($diff / 86400);

}
/* End of file pretty_date_helper.php */
/* Location: ./application/helpers/pretty_date_helper.php */