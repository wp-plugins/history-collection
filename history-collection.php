<?php
/*
Plugin Name: History Collection
Description: History Collection plugin with history sidebar widget helps you collect and display your history on your WordPress blog.
Version: 1.0.2
Author:ionadas local LLC
Author URI: http://www.ionadas.com
License: GPL2
*/
/*  Copyright 2007-2011 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
$quotescollection_admin_userlevel = 'edit_posts'; 
$quotescollection_db_version = '1.4'; 
require_once('history-collection-widget.php');
require_once('history-collection-admin.php');
require_once('history-collection-shortcodes.php');
require_once('history-settings.php');

function historycollection_count($condition = "")
{
	global $wpdb;
	$sql = "SELECT COUNT(*) FROM " . $wpdb->prefix . "historycollection ".$condition;
	$count = $wpdb->get_var($sql);
	return $count;
}

function historycollection_pagenav($total, $current = 1, $format = 0, $paged = 'paged', $url = "")
{
	if($total == 1 && $current == 1) return "";
	if(!$url) {
		$url = 'http';
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$url .= "s";}
		$url .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
		} else {
			$url .= $_SERVER["SERVER_NAME"];
		}
		if ( get_option('permalink_structure') != '' ) {
			if($_SERVER['REQUEST_URI']) {
				$request_uri = explode('?', $_SERVER['REQUEST_URI']);
				$url .= $request_uri[0];
			}
			else $url .= "/";
		}
		else {
			$url .= $_SERVER["PHP_SELF"];
		}
		if($query_string = $_SERVER['QUERY_STRING']) {
			$parms = explode('&', $query_string);
			$y = '';
			foreach($parms as $parm) {
				$x = explode('=', $parm);
				if($x[0] == $paged) {
					$query_string = str_replace($y.$parm, '', $query_string);
				}
				else $y = '&';
			}
			if($query_string) {
				$url .= '?'.$query_string;
				$a = '&';
			}
			else $a = '?';	
		}
		else $a = '?';
	}
	else {
		$a = '?';
		if(strpos($url, '?')) $a = '&';	
	}
	if(!$format || $format > 2 || $format < 0 || !is_numeric($format)) {	
		if($total <= 8) $format = 1;
		else $format = 2;
	}
	if($current > $total) $current = $total;
		$pagenav = "";
	if($format == 2) {
		$first_disabled = $prev_disabled = $next_disabled = $last_disabled = '';
		if($current == 1)
			$first_disabled = $prev_disabled = ' disabled';
		if($current == $total)
			$next_disabled = $last_disabled = ' disabled';
		$pagenav .= "<a class=\"first-page{$first_disabled}\" title=\"".__('Go to the first page', 'quotes-collection')."\" href=\"{$url}\">&laquo;</a>&nbsp;&nbsp;";
		$pagenav .= "<a class=\"prev-page{$prev_disabled}\" title=\"".__('Go to the previous page', 'quotes-collection')."\" href=\"{$url}{$a}{$paged}=".($current - 1)."\">&#139;</a>&nbsp;&nbsp;";
		$pagenav .= '<span class="paging-input">'.$current.' of <span class="total-pages">'.$total.'</span></span>';
		$pagenav .= "&nbsp;&nbsp;<a class=\"next-page{$next_disabled}\" title=\"".__('Go to the next page', 'quotes-collection')."\" href=\"{$url}{$a}{$paged}=".($current + 1)."\">&#155;</a>";
		$pagenav .= "&nbsp;&nbsp;<a class=\"last-page{$last_disabled}\" title=\"".__('Go to the last page', 'quotes-collection')."\" href=\"{$url}{$a}{$paged}={$total}\">&raquo;</a>";
	}
	else {
		$pagenav = __("Goto page:", 'quotes-collection');
		for( $i = 1; $i <= $total; $i++ ) {
			if($i == $current)
				$pagenav .= "&nbsp;<strong>{$i}</strong>";
			else if($i == 1)
				$pagenav .= "&nbsp;<a href=\"{$url}\">{$i}</a>";
			else 
				$pagenav .= "&nbsp;<a href=\"{$url}{$a}{$paged}={$i}\">{$i}</a>";
		}
	}
	return $pagenav;
}

function historycollection_txtfmt($quotedata = array())
{
	if(!$quotedata)
		return;
	foreach($quotedata as $key => $value){
		$value = make_clickable($value); 
		$value = wptexturize(str_replace(array("\r\n", "\r", "\n"), '', nl2br(trim($value))));
		$quotedata[$key] = $value;
	}
	return $quotedata;	
}

function historycollection_quote($args = '') 
{ $day2=date("d");
  $day1=date("j");
  $month1=date("n");
  $month2=date("M"); 
  $month3=date("F");
  $month4=date("m");
	global $quotescollection_instances, $quotescollection_next_quote;
			$key_value = explode('&', $args);
	$options = array();
	foreach($key_value as $value) {
		$x = explode('=', $value);
		$options[$x[0]] = $x[1]; // $options['key'] = 'value';
	} global $wpdb;
     $select=mysql_query("SELECT * FROM ". $wpdb->prefix ."historysettings") or die(mysql_error());
	 $row=mysql_fetch_array($select); 
	 if($row['ordering']=='oldest to newest') {$order="ASC"; } else {$order="DESC";}
			$select2=mysql_query("SELECT * FROM ". $wpdb->prefix ."historycollection WHERE (`day`='$day1' OR `day`='$day2' ) AND (`month`='$month1' OR `month`='$month2' OR `month`='$month3' OR `month`='$month4' ) ORDER BY year ".$order.",month ".$order.",day ".$order." LIMIT 0,{$options['show_limit']}") or die(mysql_error());
				 $n=mysql_num_rows($select2);
 if($n==0)
		 {
		   echo "Nothing happened today. Or, at least, nothing has been entered for this day.";
		 }
		else
		 {			while($row2=mysql_fetch_array($select2)){ if($row['dateformat']==('d/m/Y')){$x=$row2['day'].'/'.$row2['month'].'/'.$row2['year'];} else if($row['dateformat']==('Y/m/d')) { $x=$row2['year'].'/'.$row2['month'].'/'.$row2['day'];} else if($row['dateformat']==('m/d/Y')) {$x=$row2['month'].'/'.$row2['day'].'/'.$row2['year'];} else if($row['dateformat']==('F j, Y')){$x=date( 'F', mktime(0, 0, 0,$row2['month']) ).' '.$row2['day'].', '.$row2['year'];}
	$display="";
	$display .='<h3>'.$x.'</h3>';
	if($options['show_title'] && $row2['title']){
		$display .= '<span class="quotescollection_title"><strong>'. $row2['title'] .'</strong></span>';}
	$display .= "<p><q>".$row2['description'] ."</q>";
	
	if($options['show_taag']) {
	if($row2['tags']){
			$display .= '<br/>tags:<span class="quotescollection_source">'. $row2['tags'] .'</span></p>';
			}else{$display .= '<br/>tags:none</p>';
                 }
	}
			echo $display;}}
}

function historycollection_install()
{
	global $wpdb;
	$table_name = $wpdb->prefix . "historycollection";
	if(!defined('DB_CHARSET') || !($db_charset = DB_CHARSET))
		$db_charset = 'utf8';
	$db_charset = "CHARACTER SET ".$db_charset;
	if(defined('DB_COLLATE') && $db_collate = DB_COLLATE) 
		$db_collate = "COLLATE ".$db_collate;
	if(!$wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name)  {
		$sql = "CREATE TABLE " . $table_name . " (
			ID mediumint(9) NOT NULL AUTO_INCREMENT,
			title VARCHAR(255),
			description TEXT NOT NULL,
			day VARCHAR(255),
			month VARCHAR(255),
			year VARCHAR(255),
			tags VARCHAR(255),
			public enum('yes', 'no') DEFAULT 'yes' NOT NULL,
			time_added datetime NOT NULL,
			time_updated datetime,
			PRIMARY KEY  (ID)
		) {$db_charset} {$db_collate};";
		$results = $wpdb->query( $sql );
	}
	global $wpdb;
	$table_name = $wpdb->prefix . "historysettings";
	if(!defined('DB_CHARSET') || !($db_charset = DB_CHARSET))
		$db_charset = 'utf8';
	$db_charset = "CHARACTER SET ".$db_charset;
	if(defined('DB_COLLATE') && $db_collate = DB_COLLATE) 
		$db_collate = "COLLATE ".$db_collate;
		if(!$wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name){$sql = "CREATE TABLE " . $table_name . " (
			ID mediumint(9) NOT NULL,
			dateformat VARCHAR(255),
			ordering VARCHAR(255),
			role VARCHAR(255),
			link enum('yes', 'no') DEFAULT 'yes' NOT NULL,
			PRIMARY KEY  (ID)
		) {$db_charset} {$db_collate};";
		$x=('F j, Y');
		$results = $wpdb->query( $sql );
	$insert = "INSERT INTO "  . $wpdb->prefix .
			"historysettings(ID, dateformat, ordering, role, link)" .
			"VALUES ('1', '$x', 'oldest to newest', '10', 'no')";
		$result = $wpdb->query( $insert );}
	}
	
function historycollection_css_head() 
{
	?><link rel="stylesheet" type="text/css" href="<?php echo plugins_url(); ?>/history-collection/history-collection.css" />
<?php
}
add_action('wp_head', 'historycollection_css_head' );
register_activation_hook( __FILE__, 'historycollection_install' );
?>