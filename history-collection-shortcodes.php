<? function todayhistory($atts)
{ ob_start();

$condition="";
extract(shortcode_atts(array(
		'tags' => ''
	), $atts));
	if ($tags) {
		$tags = html_entity_decode($tags);
		if(!$tags)
			break;
		$taglist = explode(',', $tags);
		$tags_condition = "";
		foreach($taglist as $tag) {
			$tag = trim($tag);
			if($tags_condition) $tags_condition .= " OR ";
			$tags_condition .= "tags = '{$tag}' OR tags LIKE '{$tag},%' OR tags LIKE '%,{$tag},%' OR tags LIKE '%,{$tag}'";
		}
		if($tags_condition) $condition .= " AND (".$tags_condition.")";
			}

	
if(!$_GET['act1'] && !$_GET['act2'] && !$_GET['act3'] && !$_GET['act4'])
  {
global $wpdb; 
	if($_GET['act']=='new') 
	    { 
		        $select=mysql_query("SELECT * FROM ". $wpdb->prefix ."historycollection WHERE ID=".mysql_real_escape_string($_GET['id'])) or die(mysql_error());
				$row=mysql_fetch_array($select);?> <p><strong><? echo stripslashes($row['title']);?></strong></p><p><? echo stripslashes($row['description']);?></p><span style="float:left">
				tags:<? if($row['tags']) {?><? echo stripslashes($row['tags']);}else { echo "none";}?></span><? }
    else{if (!(isset($_GET['pagenum']))) 
		 { 
		 	 $pagenum = 1; 
		 } 
		else
		 {		  
			 $pagenum=$_GET['pagenum'];
		 }
  $day2=date("d");
  $day1=date("j");
  $month1=date("n");
  $month2=date("M"); 
  $month3=date("F");
  $month4=date("m");
  ?><? global $wpdb;
     $select=mysql_query("SELECT * FROM ". $wpdb->prefix ."historysettings") or die(mysql_error());
	 $row=mysql_fetch_array($select); 
	 if($row['ordering']=='oldest to newest') {$order="ASC"; } else {$order="DESC";}
	 $sql = mysql_query("SELECT ID, title, description, day, month, year, tags, public FROM " . $wpdb->prefix . "historycollection WHERE (`day`='$day1' OR `day`='$day2' ) AND (`month`='$month1' OR `month`='$month2' OR `month`='$month3' OR `month`='$month4' )$condition ORDER BY time_added ".$order );
     $n=mysql_num_rows($sql);
     $page_rows = 20; 
		$last = ceil($n/$page_rows);
		if ($pagenum < 1) 
		 { 
			 $pagenum = 1; 
		 } 
 		elseif ($pagenum > $last) 
		 { 
			 $pagenum = $last; 
		 } 
		$max = 'limit ' .($pagenum - 1) * $page_rows .',' .$page_rows;
     if($n==0)
		 {
		   echo "<p>Nothing happened today. Or, at least, nothing has been entered for this day.</p>";
		 }
		else
		 {?><? $sql22 = mysql_query("SELECT ID, title, description, day, month, year, tags, public FROM " . $wpdb->prefix . "historycollection WHERE (`day`='$day1' OR `day`='$day2' ) AND (`month`='$month1' OR `month`='$month2' OR `month`='$month3' OR `month`='$month4' )$condition  ORDER BY year ".$order.",month ".$order.",day ".$order." $max"); 
		while($row1 = mysql_fetch_array($sql22))
		    {?><h3><? if($row['dateformat']==('Y/m/d')){?><?=$row1['year']?>/<?=$row1['month']?>/<?=$row1['day']?><? } else?><? if($row['dateformat']==('m/d/Y')){?><?=$row1['month']?>/<?=$row1['day']?>/<?=$row1['year']?><? }else?><? if($row['dateformat']==('d/m/Y')){?><?=$row1['day']?>/<?=$row1['month']?>/<?=$row1['year']?><? }else?><? if($row['dateformat']==('F j, Y')){?><? echo date( 'F', mktime(0, 0, 0, $row1['month']) ) ?>&nbsp;<?=$row1['day']?>,&nbsp;<?=$row1['year']?><? }?></h3>
							<strong><?=stripslashes($row1['title'])?></strong>
				<p><?=stripslashes($row1['description'])?></p>
				
			 <? }?><? if($n>$page_rows){
			echo " <a class='pagesbt' href='?pagenum=1' title='Go to the first page'>&laquo;</a>&nbsp;&nbsp; ";	
			 echo " ";
			 $previous = $pagenum-1;
			 echo " <a class='pagesbt' href='?pagenum=$previous' title='Go to the previous page'>&#139;</a>&nbsp;&nbsp; ";
			 echo $pagenum." of ".$last;
			 $next = $pagenum+1;
			 echo "&nbsp;&nbsp;<a class='pagesbt' href='?pagenum=$next' title='Go to the next page'>&#155;</a>&nbsp;&nbsp; ";
			 echo " ";
			 echo " <a class='pagesbt' href='?pagenum=$last' title='Go to the last page'>&raquo;</a> ";
                   }
	      }?><? if($row['link']=='yes'){?><p>Today in History WordPress Plugin by <a href="http://www.ionadas.com">ionadas local LLC</a></p><? }?><? }
   }
return ob_get_clean();}
add_shortcode('todayhistory', 'todayhistory'); ?><? function monthlyhistory($atts)
{ob_start();
$condition="";
extract(shortcode_atts(array(
		'tags' => ''
	), $atts));
	if ($tags) {
		$tags = html_entity_decode($tags);
		if(!$tags)
			break;
		$taglist = explode(',', $tags);
		$tags_condition = "";
		foreach($taglist as $tag) {
			$tag = trim($tag);
			if($tags_condition) $tags_condition .= " OR ";
			$tags_condition .= "tags = '{$tag}' OR tags LIKE '{$tag},%' OR tags LIKE '%,{$tag},%' OR tags LIKE '%,{$tag}'";
		}
		if($tags_condition) $condition .= " AND (".$tags_condition.")";
	}

  if(!$_GET['act'] && !$_GET['act2'] && !$_GET['act3'] && !$_GET['act4'])
   { 
      global $wpdb; 
	  if($_GET['act1']=='new1') 
	    {   
		     $select=mysql_query("SELECT * FROM ". $wpdb->prefix ."historycollection WHERE ID=".mysql_real_escape_string($_GET['id'])) or die(mysql_error());
			 $row=mysql_fetch_array($select);?><p><strong><? echo stripslashes($row['title']);?></strong></p><p><? echo stripslashes($row['description']);?></p><span style="float:left">
			 tags:<? if($row['tags']) {?><? echo stripslashes($row['tags']);}else { echo "none";}?></span><? }
      else{
	    if (!(isset($_GET['pagenum']))) 
		    { 
		 	 $pagenum = 1; 
		    } 
		else
		    {		  
			 $pagenum=$_GET['pagenum'];
		    }
     $month1=date("n"); 
	 $month2=date("M"); 
	 $month3=date("F");
	 $month4=date("m");
     ?><? global $wpdb;
     $select=mysql_query("SELECT * FROM ". $wpdb->prefix ."historysettings") or die(mysql_error());
	 $row=mysql_fetch_array($select); if($row['ordering']=='oldest to newest') {$order="ASC"; } else {$order="DESC";}
	 $sql = mysql_query("SELECT ID, title, description, day, month, year, tags, public FROM " . $wpdb->prefix . "historycollection WHERE (`month`='$month1' OR `month`='$month2' OR `month`='$month3' OR `month`='$month4' )$condition ORDER BY time_added ".$order );
     $n=mysql_num_rows($sql);
     $page_rows = 20; 
		$last = ceil($n/$page_rows);
		if ($pagenum < 1) 
		 { 
			 $pagenum = 1; 
		 } 
 		elseif ($pagenum > $last) 
		 { 
			 $pagenum = $last; 
		 } 
		$max = 'limit ' .($pagenum - 1) * $page_rows .',' .$page_rows;
 
 if($n==0)
		 {
		   echo "<p>no history(s) were found </p>";
		 }
		else
		 {?>
		 <? $sql22 = mysql_query("SELECT ID, title, description, day, month, year, tags, public FROM " . $wpdb->prefix . "historycollection WHERE (`month`='$month1' OR `month`='$month2' OR `month`='$month3' OR `month`='$month4' )$condition ORDER BY year ".$order.",month ".$order.",day ".$order." $max" );  
				 while($row1 = mysql_fetch_array($sql22))
				     {?><h3><? if($row['dateformat']==('Y/m/d')){?><?=$row1['year']?>/<?=$row1['month']?>/<?=$row1['day']?><? } else?><? if($row['dateformat']==('m/d/Y')){?><?=$row1['month']?>/<?=$row1['day']?>/<?=$row1['year']?><? }else?><? if($row['dateformat']==('d/m/Y')){?><?=$row1['day']?>/<?=$row1['month']?>/<?=$row1['year']?><? }else?><? if($row['dateformat']==('F j, Y')){?><? echo date( 'F', mktime(0, 0, 0, $row1['month']) ) ?>&nbsp;<?=$row1['day']?>,&nbsp;<?=$row1['year']?><? }?></h3>
				<strong><!--<a href="?act1=new1&id=<?=$row1['ID']?>">--><?=stripslashes($row1['title'])?><!--</a>--></strong>
				<p><?=stripslashes($row1['description'])?></p>
				<? }?>
<? if($n>$page_rows){
			 echo " <a class='pagesbt' href='?pagenum=1' title='Go to the first page'>&laquo;</a>&nbsp;&nbsp; ";	
			 echo " ";
			 $previous = $pagenum-1;
			 echo " <a class='pagesbt' href='?pagenum=$previous' title='Go to the previous page'>&#139;</a>&nbsp;&nbsp; ";
			 echo $pagenum." of ".$last;
			 $next = $pagenum+1;
			 echo "&nbsp;&nbsp;<a class='pagesbt' href='?pagenum=$next' title='Go to the next page'>&#155;</a>&nbsp;&nbsp; ";
			 echo " ";
			 echo " <a class='pagesbt' href='?pagenum=$last' title='Go to the last page'>&raquo;</a> ";
                    }
          }?><? if($row['link']=='yes'){?><p>Monthly History WordPress Plugin by <a href="http://www.ionadas.com">ionadas local LLC</a></p><? }?><? }
  }
return ob_get_clean();}
add_shortcode('monthlyhistory', 'monthlyhistory');?><? function fullhistory($atts)
{ob_start();
$condition="";
extract(shortcode_atts(array(
		'tags' => ''
	), $atts));
	if ($tags) {
		$tags = html_entity_decode($tags);
		if(!$tags)
			break;
		$taglist = explode(',', $tags);
		$tags_condition = "";
		foreach($taglist as $tag) {
			$tag = trim($tag);
			if($tags_condition) $tags_condition .= " OR ";
			$tags_condition .= "tags = '{$tag}' OR tags LIKE '{$tag},%' OR tags LIKE '%,{$tag},%' OR tags LIKE '%,{$tag}'";
		}
if($tags_condition) $condition .= " WHERE ".$tags_condition;	}

  if(!$_GET['act'] && !$_GET['act1'] && !$_GET['act3'] && !$_GET['act4'])
  { 
     global $wpdb; 
	 if($_GET['act2']=='new2')
	  { 
	    $select=mysql_query("SELECT * FROM ". $wpdb->prefix ."historycollection WHERE ID=".mysql_real_escape_string($_GET['id'])) or die(mysql_error());
		$row=mysql_fetch_array($select);?><p><strong><? echo $row['title'];?></strong></p><p><? echo $row['description'];?></p><span style="float:left">
		tags:<? if($row['tags']) {?><? echo stripslashes($row['tags']);}else { echo "none";}?></span><? }
 else{ if (!(isset($_GET['pagenum']))) 
		 { 
		 	 $pagenum = 1; 
		 } 
		else
		 {		  
			 $pagenum=$_GET['pagenum'];
		 }?><? global $wpdb; 
          $select=mysql_query("SELECT * FROM ". $wpdb->prefix ."historysettings") or die(mysql_error());
		  $row=mysql_fetch_array($select); if($row['ordering']=='oldest to newest') {$order="ASC"; } else {$order="DESC";}
		  $sql = mysql_query("SELECT ID, title, description, day, month, year, tags, public FROM " . $wpdb->prefix . "historycollection $condition ORDER BY time_added ".$order );
          $n=mysql_num_rows($sql);
          $page_rows = 20; 
		  $last = ceil($n/$page_rows);
		if ($pagenum < 1) 
		 { 
			 $pagenum = 1; 
		 } 
 		elseif ($pagenum > $last) 
		 { 
			 $pagenum = $last; 
		 } 
		$max = 'limit ' .($pagenum - 1) * $page_rows .',' .$page_rows; 
 if($n==0)
		 {
		   echo "<p>no history(s) were found </p>";
		 }
		else
		 {?><? $sql22 = mysql_query("SELECT ID, title, description, day, month, year, tags, public FROM " . $wpdb->prefix . "historycollection $condition ORDER BY year ".$order.",month ".$order.",day ".$order." $max" );
     while($row1 = mysql_fetch_array($sql22))
	    {?><h3><? if($row['dateformat']==('Y/m/d')){?><?=$row1['year']?>/<?=$row1['month']?>/<?=$row1['day']?><? } else?><? if($row['dateformat']==('m/d/Y')){?><?=$row1['month']?>/<?=$row1['day']?>/<?=$row1['year']?><? }else?><? if($row['dateformat']==('d/m/Y')){?><?=$row1['day']?>/<?=$row1['month']?>/<?=$row1['year']?><? }else?><? if($row['dateformat']==('F j, Y')){?><? echo date( 'F', mktime(0, 0, 0, $row1['month']) ) ?>&nbsp;<?=$row1['day']?>,&nbsp;<?=$row1['year']?><? }?></h3>
				
				<strong><!--<a href="?act2=new2&id=<?=$row1['ID']?>">--><?=stripslashes($row1['title'])?><!--</a>--></strong>
				<p><?=stripslashes($row1['description'])?></p>
<? }?><? if($n>$page_rows){
			echo " <a class='pagesbt' href='?pagenum=1' title='Go to the first page'>&laquo;</a>&nbsp;&nbsp; ";	
			 echo " ";
			 $previous = $pagenum-1;
			 echo " <a class='pagesbt' href='?pagenum=$previous' title='Go to the previous page'>&#139;</a>&nbsp;&nbsp; ";
			 echo $pagenum." of ".$last;
			 $next = $pagenum+1;
			 echo "&nbsp;&nbsp;<a class='pagesbt' href='?pagenum=$next' title='Go to the next page'>&#155;</a>&nbsp;&nbsp; ";
			 echo " ";
			 echo " <a class='pagesbt' href='?pagenum=$last' title='Go to the last page'>&raquo;</a> ";
                }
	    }?><? if($row['link']=='yes'){?><p>History WordPress Plugin by <a href="http://www.ionadas.com">ionadas local LLC</a></p><? }?><? }
  }
return ob_get_clean();}
add_shortcode('fullhistory', 'fullhistory');?><? function weekhistory($atts)
{ob_start();
$condition="";
extract(shortcode_atts(array(
		'tags' => ''
	), $atts));
	if ($tags) {
		$tags = html_entity_decode($tags);
		if(!$tags)
			break;
		$taglist = explode(',', $tags);
		$tags_condition = "";
		foreach($taglist as $tag) {
			$tag = trim($tag);
			if($tags_condition) $tags_condition .= " OR ";
			$tags_condition .= "tags = '{$tag}' OR tags LIKE '{$tag},%' OR tags LIKE '%,{$tag},%' OR tags LIKE '%,{$tag}'";
		}
if($tags_condition) $condition .= " AND (".$tags_condition.")";	}

  if(!$_GET['act'] && !$_GET['act1'] && !$_GET['act2'] && !$_GET['act4'])
   { 
      global $wpdb; 
	  if($_GET['act3']=='new3') 
	  { 
	       $select=mysql_query("SELECT * FROM ". $wpdb->prefix ."historycollection WHERE ID=".mysql_real_escape_string($_GET['id'])) or die(mysql_error());
		   $row=mysql_fetch_array($select);?><p><strong><? echo $row['title'];?></strong></p><p><? echo stripslashes($row['description']);?></p><span style="float:left">
		   tags:<? if($row['tags']) {?><? echo stripslashes($row['tags']);}else { echo "none";}?></span><? }
    else{if (!(isset($_GET['pagenum']))) 
		   { 
		 	 $pagenum = 1; 
		   } 
		else
		   {		  
			 $pagenum=$_GET['pagenum'];
		   }
 $month1=date("n"); 
 $month2=date("M");
 $month3=date("F");
 $month4=date("m");
 $WeekDayNumber = date('w');
 $x1 = date("d",time() - ($WeekDayNumber - 1)*60*60*24);
 $x2=date("d",time() - ($WeekDayNumber - 1)*60*60*24+60*60*24);
 $x3=date("d",time() - ($WeekDayNumber - 1)*60*60*24+2*60*60*24);
 $x4=date("d",time() - ($WeekDayNumber - 1)*60*60*24+3*60*60*24);
 $x5=date("d",time() - ($WeekDayNumber - 1)*60*60*24+4*60*60*24);
 $x6=date("d",time() - ($WeekDayNumber - 1)*60*60*24+5*60*60*24);
 $x7=date("d",time() - ($WeekDayNumber - 1)*60*60*24+6*60*60*24);
    ?><? global $wpdb;
  $select=mysql_query("SELECT * FROM ". $wpdb->prefix ."historysettings") or die(mysql_error());
  $row=mysql_fetch_array($select); if($row['ordering']=='oldest to newest') {$order="ASC"; } else {$order="DESC";}
  $sql = mysql_query("SELECT ID, title, description, day, month, year, tags, public FROM " . $wpdb->prefix . "historycollection WHERE (`day`='$x1' OR `day`='$x2' OR `day`='$x3' OR `day`='$x4' OR `day`='$x5' OR `day`='$x6' OR `day`='$x7') AND (`month`='$month1' OR `month`='$month2' OR `month`='$month3' OR `month`='$month4' ) $condition ORDER BY time_added ".$order );
   $n=mysql_num_rows($sql);
   $page_rows = 20; 
   $last = ceil($n/$page_rows);
		if ($pagenum < 1) 
		 { 
			 $pagenum = 1; 
		 } 
 		elseif ($pagenum > $last) 
		 { 
			 $pagenum = $last; 
		 } 
		$max = 'limit ' .($pagenum - 1) * $page_rows .',' .$page_rows; 
      if($n==0)
		 {print_r($dates);
		   echo "<p>no history(s) were found</p> ";
		 }
		else
		 {?><? $sql22 = mysql_query("SELECT ID, title, description, day, month, year, tags, public FROM " . $wpdb->prefix . "historycollection WHERE (`day`='$x1' OR `day`='$x2' OR `day`='$x3' OR `day`='$x4' OR `day`='$x5' OR `day`='$x6' OR `day`='$x7') AND (`month`='$month1' OR `month`='$month2' OR `month`='$month3' OR `month`='$month4' ) $condition ORDER BY year ".$order.",month ".$order.",day ".$order." $max" );
		 while($row1 = mysql_fetch_array($sql22))
		  {?><h3><? if($row['dateformat']==('Y/m/d')){?><?=$row1['year']?>/<?=$row1['month']?>/<?=$row1['day']?><? } else?><? if($row['dateformat']==('m/d/Y')){?><?=$row1['month']?>/<?=$row1['day']?>/<?=$row1['year']?><? }else?><? if($row['dateformat']==('d/m/Y')){?><?=$row1['day']?>/<?=$row1['month']?>/<?=$row1['year']?><? }else?><? if($row['dateformat']==('F j, Y')){?><? echo date( 'F', mktime(0, 0, 0, $row1['month']) ) ?>&nbsp;<?=$row1['day']?>,&nbsp;<?=$row1['year']?><? }?></h3>
				<strong><!--<a href="?act3=new3&id=<?=$row1['ID']?>">--><!--</a>--></strong>
				<p><?=stripslashes($row1['description'])?></p>
<? }?><? if($n>$page_rows){
			 echo " <a class='pagesbt' href='?pagenum=1' title='Go to the first page'>&laquo;</a>&nbsp;&nbsp; ";	
			 echo " ";
			 $previous = $pagenum-1;
			 echo " <a class='pagesbt' href='?pagenum=$previous' title='Go to the previous page'>&#139;</a>&nbsp;&nbsp; ";
			 echo $pagenum." of ".$last;
			 $next = $pagenum+1;
			 echo "&nbsp;&nbsp;<a class='pagesbt' href='?pagenum=$next' title='Go to the next page'>&#155;</a>&nbsp;&nbsp; ";
			 echo " ";
			 echo " <a class='pagesbt' href='?pagenum=$last' title='Go to the last page'>&raquo;</a> ";
                     }
		 }?><? if($row['link']=='yes'){?><p>Weekly History WordPress Plugin by <a href="http://www.ionadas.com">ionadas local LLC</a></p><? }?><? }
 }
return ob_get_clean();}
add_shortcode('weeklyhistory', 'weekhistory');?>
