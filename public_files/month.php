<?php  
include '../lib/common.php';

// accept incoming URL parameter
// 接受传入的URL参数
$timestamp = (isset($_GET['t'])) ? $_GET['t'] : time();

// determine useful aspects of the requested month
// 确定被请求的月份的有用方面
list($month, $day, $year) = explode('/', date('m/d/Y', $timestamp));
$first_day_of_month = date('w', mktime(0, 0, 0, $month, 1, $year));	
// 星期中的第几天
$total_days = date('t', $timestamp);	// 给定月份的天数


// output table header
ob_start();
echo '<table id="calendar">';
echo '<tr id="calendar_header"><th colspan="7">';
echo '<a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'?t='.strtotime('-1 month', $timestamp).'">&lt;</a>&nbsp;';
echo date('F', $timestamp) . ' ' . $year;
echo ' &nbsp; <a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'?t='.strtotime('+1 month', $timestamp).'"> &gt; </a>';
echo '</th></tr>';
echo '<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>';

// echo date cells
$current = 1;
while ($current < $total_days) {

	echo "<tr class='calendar_dates'>";
	for ($i=0; $i < 7 ; $i++) { 

		if (($current == 1 && $i < $first_day_of_month)||($current > $total_days)) {
			echo '<td class="empty">&nbsp;</td>';
			continue;
		}

		if($current == $day){
			echo '<td class="curD">'.$current.'</td>';
		} else {
			echo '<td>'.$current.'</td>';
		}

		$current++;
	}

	echo "</tr>";
}
echo "</table>";
$GLOBALS['TEMPLATE']['content'] = ob_get_clean();

// assign styles for calendar
$GLOBALS['TEMPLATE']['extra_head'] = '<link rel="stylesheet" type="text/css" href="../css/month.css" />';
// display page
include '../templates/template-page.php';
?>