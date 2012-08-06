<?php function historycollection_admin_menu() 
    { 
	global $wpdb;	
    $select11=mysql_query("SELECT * FROM ".$wpdb->prefix."historysettings") or die(mysql_error());
	$row11=mysql_fetch_array($select11);
	$user_level=$row11['role']; 
	global $quotescollection_admin_userlevel;
	add_menu_page('History Collection', 'History', $user_level, 'history-collection', 'historycollection_quotes_management');
	$page_about1 = add_submenu_page( 'history-collection',__( ' Listings', 'history-collection' ), __( 'Listings', 'history-collection' ), $user_level , 'history-collection','historycollection_quotes_management' );
	$page_about2 = add_submenu_page( 'history-collection',__( ' Settings', 'history-collection' ), __( 'Settings', 'history-collection' ), $user_level , 'history-settings','history_html_page' );
     }
add_action('admin_menu', 'historycollection_admin_menu');

function historycollection_addquote($title, $description, $day, $month, $year, $tags = "", $public = 'yes')
  {
	if(!$description) return __('Nothing added to the database.', 'quotes-collection');
	global $wpdb;
	$table_name = $wpdb->prefix . "historycollection";
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) 
		return __('Database table not found', 'quotes-collection');
	else 
	{
		$description = wp_kses_data( stripslashes($description) );
		$tags = strip_tags( stripslashes($tags) );
		$title = "'".$wpdb->escape($title)."'";
		$year = "'".$wpdb->escape($year)."'";
		$day = "'".$wpdb->escape($day)."'";
		$month = "'".$wpdb->escape($month)."'";
		$description = "'".$wpdb->escape($description)."'";
		$tags = explode(',', $tags);
		foreach ($tags as $key => $tag)
		$tags[$key] = trim($tag);
		$tags = implode(',', $tags);
		$tags = $tags?"'".$wpdb->escape($tags)."'":"NULL";
		if(!$public) $public = "'no'";
		else $public = "'yes'";
		$insert = "INSERT INTO " . $table_name .
			"(title, description, day, month, year, tags, public, time_added)" .
			"VALUES ({$title}, {$description}, {$day}, {$month},{$year}, {$tags}, {$public}, NOW())";
		$results = $wpdb->query( $insert );
		if(FALSE === $results)
			return __('There was an error in the MySQL query', 'quotes-collection');
		else
			return __('history added', 'quotes-collection');
   }
}

function historycollection_editquote($ID, $title, $description, $day, $month, $year, $tags = "", $public = 'yes')
{
	if(!$description) return __('history not updated.', 'quotes-collection');
	if(!$ID) return srgq_addquote($title, $description, $day, $month, $year, $public);
	global $wpdb;
	$table_name = $wpdb->prefix . "historycollection";
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) 
		return __('Database table not found', 'quotes-collection');
	else
	{
		$description = wp_kses_data( stripslashes($description) );
		$tags = strip_tags( stripslashes($tags) );
        $title = "'".$wpdb->escape($title)."'";
	  	$description = "'".$wpdb->escape($description)."'";
		$day = "'".$wpdb->escape($day)."'";
		$month = "'".$wpdb->escape($month)."'";
		$year = "'".$wpdb->escape($year)."'";
		$tags = explode(',', $tags);
		foreach ($tags as $key => $tag)
		$tags[$key] = trim($tag);
		$tags = implode(',', $tags);
		$tags = $tags?"'".$wpdb->escape($tags)."'":"NULL";
		if(!$public) $public = "'no'";
		else $public = "'yes'";
		$update = "UPDATE " . $table_name . "
			SET title = {$title}, description = {$description},
				day = {$day},
				month = {$month}, year = {$year}, 
				tags = {$tags},
				public = {$public}, 
				time_updated = NOW()
			WHERE ID = $ID";
		$results = $wpdb->query( $update );
		if(FALSE === $results)
			return __('There was an error in the MySQL query', 'quotes-collection');		
		else
			return __('Changes saved', 'quotes-collection');
   }
}

function historycollection_deletequote($ID)
{
	if($ID) {
		global $wpdb;
		$sql = "DELETE from " . $wpdb->prefix ."historycollection" .
			" WHERE ID = " . $ID;
		if(FALSE === $wpdb->query($sql))
			return __('There was an error in the MySQL query', 'quotes-collection');		
		else
			return __('history deleted', 'quotes-collection');
	}
	else return __('The history cannot be deleted', 'quotes-collection');
}

function historycollection_getquotedata($ID)
{
	global $wpdb;
	$sql = "SELECT ID, title, description, day, month, year, tags, public
		FROM " . $wpdb->prefix . "historycollection 
		WHERE ID = {$ID}";
	$quote_data = $wpdb->get_row($sql, ARRAY_A);	
	return $quote_data;
}

function historycollection_editform($ID = 0)
{
	$public_selected = " checked=\"checked\"";
	$submit_value = __('Add History', 'quotes-collection');
	$form_name = "addquote";
	$action_url = get_bloginfo('wpurl')."/wp-admin/admin.php?page=history-collection#addnew";
	$description = $day = $month = $year = $tags = $hidden_input = $back = "";
	if($ID) {
		$form_name = "editquote";
		$quote_data = historycollection_getquotedata($ID);
		foreach($quote_data as $key => $value)
			$quote_data[$key] = $quote_data[$key];
		extract($quote_data);
		$title = htmlspecialchars($title);
		$description = htmlspecialchars($description);
		$day = htmlspecialchars($day);
		$month = htmlspecialchars($month);
		$year = htmlspecialchars($year);
		$tags = implode(', ', explode(',', $tags));
		$hidden_input = "<input type=\"hidden\" name=\"ID\" value=\"{$ID}\" />";
		if($public == 'no') $public_selected = "";
		$submit_value = __('Save changes', 'quotes-collection');
		$back = "<input type=\"submit\" name=\"submit\" value=\"".__('Back', 'quotes-collection')."\" />&nbsp;";
		$action_url = get_bloginfo('wpurl')."/wp-admin/admin.php?page=history-collection";
	}
    $title_label = __('Title', 'quotes-collection');
	$year_label = __('Year (year --> 2012 2013 ....)', 'quotes-collection');
	$description_label = __('Desciption', 'quotes-collection');
	$day_label = __('Day (date --> 01 02 ....)', 'quotes-collection');
	$month_label = __('Month (month --> 01 02 ....)', 'quotes-collection');
	$tags_label = __('Tags', 'quotes-collection');
	$public_label = __('Public?', 'quotes-collection');
	$optional_text = __('optional', 'quotes-collection');
	$comma_separated_text = __('comma separated', 'quotes-collection');
	$display =<<< EDITFORM
 <form name="{$form_name}" method="post" action="{$action_url}">
	{$hidden_input}
	<table class="form-table" cellpadding="5" cellspacing="2" width="100%">
		<tbody>
		<tr class="form-field">
			<th style="text-align:left;" scope="row" valign="top"><label for="quotescollection_title">{$title_label}</label></th>
			<td><input type="text" id="quotescollection_title" name="title" size="40" value="{$title}" /></td>
		</tr>
		<tr class="form-field form-required">
			<th style="text-align:left;" scope="row" valign="top"><label for="quotescollection_quote">{$description_label}</label></th>
			<td><textarea id="quotescollection_quote" name="description" rows="5" cols="50" style="width: 97%;">{$description}</textarea></td>
		</tr>
		<tr class="form-field">
			<th style="text-align:left;" scope="row" valign="top"><label for="quotescollection_day">{$day_label}</label></th>
			<td><input type="text" id="quotescollection_day" name="day" size="40" value="{$day}" /></td>
		</tr>
		<tr class="form-field">
			<th style="text-align:left;" scope="row" valign="top"><label for="quotescollection_month">{$month_label}</label></th>
			<td><input type="text" id="quotescollection_month" name="month" size="40" value="{$month}" /></td>
		</tr>
		<tr class="form-field">
			<th style="text-align:left;" scope="row" valign="top"><label for="quotescollection_year">{$year_label}</label></th>
			<td><input type="text" id="quotescollection_year" name="year" size="40" value="{$year}" /></td>
		</tr>
		<tr class="form-field">
			<th style="text-align:left;" scope="row" valign="top"><label for="quotescollection_tags">{$tags_label}</label></th>
			<td><input type="text" id="quotescollection_tags" name="tags" size="40" value="{$tags}" /><br /></td>
		</tr>
		<tr>
			<th style="text-align:left;" scope="row" valign="top"><label for="quotescollection_public">{$public_label}</label></th>
			<td><input type="checkbox" id="quotescollection_public" name="public"{$public_selected} />
		</tr></tbody>
	</table>
	<p class="submit">{$back}<input name="submit" value="{$submit_value}" type="submit" class="button button-primary" /></p>
</form>
EDITFORM;
	return $display;
}

function historycollection_changevisibility($IDs, $public = 'yes')
{
	if(!$IDs)
	return __('Nothing done!', 'quotes-collection');
	global $wpdb;
	$sql = "UPDATE ".$wpdb->prefix."historycollection 
		SET public = '".$public."',
			time_updated = NOW()
		WHERE ID IN (".implode(', ', $IDs).")";
	$wpdb->query($sql);
	if($public == 'yes')
		return __("Selected quotes made public", 'quotes-collection');
	else
		return __("Selected quotes made private", 'quotes-collection');
}

function historycollection_bulkdelete($IDs)
{
	if(!$IDs)
	return __('Nothing done!', 'quotes-collection');
	global $wpdb;
	$sql = "DELETE FROM ".$wpdb->prefix."historycollection 
		WHERE ID IN (".implode(', ', $IDs).")";
	$wpdb->query($sql);
	return __('History(s) deleted', 'quotes-collection');
}

function historycollection_quotes_management()
{	
	global $quotescollection_db_version;
	$options = get_option('historycollection');
	$display = $msg = $quotes_list = $alternate = "";
	if($options['db_version'] != $quotescollection_db_version )
		historycollection_install();
	if(isset($_REQUEST['submit'])) {
		if($_REQUEST['submit'] == __('Add History', 'quotes-collection')) {
			extract($_REQUEST);
			$msg = historycollection_addquote($title, $description, $day, $month, $year, $tags, $public);
		}
		else if($_REQUEST['submit'] == __('Save changes', 'quotes-collection')) {
			extract($_REQUEST);
			$msg = historycollection_editquote($ID, $title, $description, $day, $month, $year, $tags, $public);
		}
	}
	else if(isset($_REQUEST['action'])) {
		if($_REQUEST['action'] == 'editquote') {
			$display .= "<div class=\"wrap\">\n<h2>History Collection &raquo; ".__('Edit history', 'quotes-collection')."</h2>";
			$display .=  historycollection_editform($_REQUEST['id']);
			$display .= "</div>";
			echo $display;
			return;
		}
		else if($_REQUEST['action'] == 'delquote') {
			$msg = historycollection_deletequote($_REQUEST['id']);
		}
	}
	else if(isset($_REQUEST['bulkactionsubmit']))  {
		if($_REQUEST['bulkaction'] == 'delete') 
			$msg = historycollection_bulkdelete($_REQUEST['bulkcheck']);
		if($_REQUEST['bulkaction'] == 'make_public') {
			$msg = historycollection_changevisibility($_REQUEST['bulkcheck'], 'yes');
		}
		if($_REQUEST['bulkaction'] == 'keep_private') {
			$msg = historycollection_changevisibility($_REQUEST['bulkcheck'], 'no');
		}
	}
	$display .= "<div class=\"wrap\">";
	if($msg)
		$display .= "<div id=\"message\" class=\"updated fade\"><p>{$msg}</p></div>";
	$display .= "<h2>History Collection <a href=\"#addnew\" class=\"add-new-h2\">".__('Add new history', 'quotes-collection')."</a></h2>";
	$num_quotes = historycollection_count();
	if(!$num_quotes) {
		$display .= "<p>".__('No history in the database', 'quotes-collection')."</p>";
		$display .= "</div>";
		$display .= "<div id=\"addnew\" class=\"wrap\">\n<h2>".__('Add new history', 'quotes-collection')."</h2>";
		$display .= historycollection_editform();
		$display .= "</div>";
		echo $display;
		return;
	}
	global $wpdb;
	$sql = "SELECT title, ID, description, day, month, year, tags, public
		FROM " . $wpdb->prefix . "historycollection";
	$option_selected = array (
		'ID' => '',
		'title' => '',
		'description' => '',
		'day' => '',
		'month' => '',
		'year' => '',
		'time_added' => '',
		'time_updated' => '',
		'public' => '',
		'ASC' => '',
		'DESC' => '',
	);
	if(isset($_REQUEST['orderby'])) {
		$sql .= " ORDER BY " . $_REQUEST['orderby'] . " " . $_REQUEST['order'];
		$option_selected[$_REQUEST['orderby']] = " selected=\"selected\"";
		$option_selected[$_REQUEST['order']] = " selected=\"selected\"";
	}
	else {
		$sql .= " ORDER BY ID ASC";
		$option_selected['ID'] = " selected=\"selected\"";
		$option_selected['ASC'] = " selected=\"selected\"";
	}
	
	if(isset($_REQUEST['paged']) && $_REQUEST['paged'] && is_numeric($_REQUEST['paged']))
		$paged = $_REQUEST['paged'];
	else
		$paged = 1;
	$limit_per_page = 20;
	$total_pages = ceil($num_quotes / $limit_per_page);
	if($paged > $total_pages) $paged = $total_pages;
	$admin_url = get_bloginfo('wpurl'). "/wp-admin/admin.php?page=history-collection";
	if(isset($_REQUEST['orderby']))
		$admin_url .= "&orderby=".$_REQUEST['orderby']."&order=".$_REQUEST['order'];
	$page_nav = historycollection_pagenav($total_pages, $paged, 2, 'paged', $admin_url);
	$start = ($paged - 1) * $limit_per_page;
	$sql .= " LIMIT {$start}, {$limit_per_page}"; 
	$descriptions = $wpdb->get_results($sql);
	foreach($descriptions as $quote_data) {
		if($alternate) $alternate = "";
		else $alternate = " class=\"alternate\"";
		$quotes_list .= "<tr{$alternate}>";
		$quotes_list .= "<th scope=\"row\" class=\"check-column\"><input type=\"checkbox\" name=\"bulkcheck[]\" value=\"".$quote_data->ID."\" /></th>";
		$quotes_list .= "<td>" . $quote_data->ID . "</td>";
		$quotes_list .= "<td>" . $quote_data->title . "</td>";
		$quotes_list .= "<td>";
		$quotes_list .= $quote_data->description;
    	$quotes_list .= "<div class=\"row-actions\"><span class=\"edit\"><a href=\"{$admin_url}&action=editquote&amp;id=".$quote_data->ID."\" class=\"edit\">".__('Edit', 'quotes-collection')."</a></span> | <span class=\"trash\"><a href=\"{$admin_url}&action=delquote&amp;id=".$quote_data->ID."\" onclick=\"return confirm( '".__('Are you sure you want to delete this history?', 'quotes-collection')."');\" class=\"delete\">".__('Delete', 'quotes-collection')."</a></span></div>";
		$quotes_list .= "</td>";
		$quotes_list .= "<td>" . make_clickable($quote_data->day) ."</td>";
		$quotes_list .= "<td>" .make_clickable($quote_data->month) ."</td>";
		$quotes_list .= "<td>" .make_clickable($quote_data->year) ."</td>";
		$quotes_list .= "<td>" . implode(', ', explode(',', $quote_data->tags)) . "</td>";
		if($quote_data->public == 'no') $public = __('No', 'quotes-collection');
		else $public = __('Yes', 'quotes-collection');
		$quotes_list .= "<td>" . $public  ."</td>";
		$quotes_list .= "</tr>";
	}
	if($quotes_list) {
		$quotes_count = historycollection_count();
		$display .= "<form id=\"quotescollection\" method=\"post\" action=\"".get_bloginfo('wpurl')."/wp-admin/admin.php?page=history-collection\">";
		$display .= "<div class=\"tablenav\">";
		$display .= "<div class=\"alignleft actions\">";
		$display .= "<select name=\"bulkaction\">";
		$display .= 	"<option value=\"0\">".__('Bulk Actions')."</option>";
		$display .= 	"<option value=\"delete\">".__('Delete', 'quotes-collection')."</option>";
		$display .= 	"<option value=\"make_public\">".__('Make public', 'quotes-collection')."</option>";
		$display .= 	"<option value=\"keep_private\">".__('Keep private', 'quotes-collection')."</option>";
		$display .= "</select>";	
		$display .= "<input type=\"submit\" name=\"bulkactionsubmit\" value=\"".__('Apply', 'quotes-collection')."\" class=\"button-secondary\" />";
		$display .= "&nbsp;&nbsp;&nbsp;";
		$display .= __('Sort by: ', 'quotes-collection');
		$display .= "<select name=\"orderby\">";
		$display .= "<option value=\"ID\"{$option_selected['ID']}>".__('', 'quotes-collection')." ID</option>";
		$display .= "<option value=\"title\"{$option_selected['title']}>".__('Title', 'quotes-collection')."</option>";
		$display .= "<option value=\"description\"{$option_selected['description']}>".__('history', 'quotes-collection')."</option>";
		$display .= "<option value=\"day\"{$option_selected['day']}>".__('Day', 'quotes-collection')."</option>";
		$display .= "<option value=\"month\"{$option_selected['month']}>".__('Month', 'quotes-collection')."</option>";
		$display .= "<option value=\"year\"{$option_selected['year']}>".__('Year', 'quotes-collection')."</option>";
		$display .= "<option value=\"time_added\"{$option_selected['time_added']}>".__('Date added', 'quotes-collection')."</option>";
		$display .= "<option value=\"time_updated\"{$option_selected['time_updated']}>".__('Date updated', 'quotes-collection')."</option>";
		$display .= "<option value=\"public\"{$option_selected['public']}>".__('Visibility', 'quotes-collection')."</option>";
		$display .= "</select>";
		$display .= "<select name=\"order\"><option{$option_selected['ASC']}>ASC</option><option{$option_selected['DESC']}>DESC</option></select>";
		$display .= "<input type=\"submit\" name=\"orderbysubmit\" value=\"".__('Go', 'quotes-collection')."\" class=\"button-secondary\" />";
		$display .= "</div>";
		$display .= '<div class="tablenav-pages"><span class="displaying-num">'.sprintf(_n('%d history(s)', '%d history(s)', $quotes_count, 'quotes-collection'), $quotes_count).'</span><span class="pagination-links">'. $page_nav. "</span></div>";
		$display .= "<div class=\"clear\"></div>";	
		$display .= "</div>";
		$display .= "<table class=\"widefat\">";
		$display .= "<thead><tr>
			<th class=\"check-column\"><input type=\"checkbox\" onclick=\"quotescollection_checkAll(document.getElementById('quotescollection'));\" /></th>
			<th>ID</th><th>".__('Title', 'quotes-collection')."</th><th>".__('Description', 'quotes-collection')."</th>
			<th>".__('DAY', 'quotes-collection')." </th>
			<th>".__('MONTH', 'quotes-collection')."</th>
						<th>".__('YEAR', 'quotes-collection')."</th>
			<th>".__('Tags', 'quotes-collection')."</th>
			<th>".__('Public?', 'quotes-collection')."</th>
		</tr></thead>";
		$display .= "<tbody id=\"the-list\">{$quotes_list}</tbody>";
		$display .= "</table>";
		$display .= "<div class=\"tablenav\">";
		$display .= '<div class="tablenav-pages"><span class="displaying-num">'.sprintf(_n('%d history(s)', '%d history(s)', $quotes_count, 'quotes-collection'), $quotes_count).'</span><span class="pagination-links">'. $page_nav. "</span></div>";
		$display .= "<div class=\"clear\"></div>";	
		$display .= "</div>";
		$display .= "</form>";
		$display .= "<br style=\"clear:both;\" />";
	}
	else
		$display .= "<p>".__('No history(s) in the database', 'quotes-collection')."</p>";
	$display .= "</div>";
	$display .= "<div id=\"addnew\" class=\"wrap\">\n<h2>".__('Add new history', 'quotes-collection')."</h2>";
	$display .= historycollection_editform();
	$display .= "</div>";
	echo $display;
}
function historycollection_admin_footer()
{
	?>
<script type="text/javascript">
function quotescollection_checkAll(form) {
	for (i = 0, n = form.elements.length; i < n; i++) {
		if(form.elements[i].type == "checkbox" && !(form.elements[i].hasAttribute('onclick'))) {
				if(form.elements[i].checked == true)
					form.elements[i].checked = false;
				else
					form.elements[i].checked = true;
		}
	}
}
</script>
<?php
}
add_action('admin_footer', 'historycollection_admin_footer');?>