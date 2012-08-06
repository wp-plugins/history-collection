<? if(isset($_POST["link"]))
       {
           $link='yes';
       }
	   else
	   {
	            $link='no';
		}?>
<? if($_POST["submits"])
	 {
	     global $wpdb;
		 $query = "update " . $wpdb->prefix .
			"historysettings set dateformat='".$_POST['dateformat']."',ordering='".$_POST['ordering']."',role='".$_POST['role']."',link='".$link."'";
		mysql_query($query)or die(mysql_error());
	}?>
<?php
function history_html_page() {
		?><? global $wpdb; $select=mysql_query("SELECT * FROM ". $wpdb->prefix ."historysettings") or die(mysql_error());
			
				$row=mysql_fetch_array($select); ?><? echo "<div class=\"wrap\">\n<h2>History Collection &raquo; ".__('Settings', 'quotes-collection')."</h2>";?><form method="post" action="#">
<table class="form-table">
<tr>
<th scope="row" valign="top"><label for="date_format"><?php _e('Date Format') ?></label></th>
<td>
<input type="radio" name="dateformat" id="dateformat" value="<?=('F j, Y')?>"<? if($row['dateformat']==('F j, Y')){?>checked="checked"<? }?>><? echo date('F j, Y')?><br/>
<input type="radio" name="dateformat" id="dateformat" value="<?=('Y/m/d')?>"<? if($row['dateformat']==('Y/m/d')){?>checked="checked"<? }?>><? echo date('Y/m/d')?><br/>
<input type="radio" name="dateformat" id="dateformat" value="<?=('m/d/Y')?>"<? if($row['dateformat']==('m/d/Y')){?>checked="checked"<? }?>><? echo date('m/d/Y')?><br/>
<input type="radio" name="dateformat" id="dateformat" value="<?=('d/m/Y')?>"<? if($row['dateformat']==('d/m/Y')){?>checked="checked"<? }?>><? echo date('d/m/Y')?><br/>
</td>
</tr><tr valign="top">
<th scope="row"><label for="default_role"><?php _e('Minimum User Role to Edit Listings') ?></label></th>
<td>
<select name="role" style="width:150px; padding-right:3px;">
<option value="0"<? if($row['role']=='0'){?>selected="selected"<? }?>> subscriber</option>
<option value="10"<? if($row['role']=='10'){?>selected="selected"<? }?>> administrator</option>
<option value="7"<? if($row['role']=='7'){?>selected="selected"<? }?>> editor</option>
<option value="2"<? if($row['role']=='2'){?>selected="selected"<? }?>> author</option>
<option value="1"<? if($row['role']=='1'){?>selected="selected"<? }?>> contributor</option>
</select>
</td>
</tr>
<tr valign="top">
<th scope="row"><label for="ordering"><?php _e('Ordering of Multiple Listings') ?></label></th>
<td>
<select name="ordering" style="width:150px; padding-right:3px;">
<option value="oldest to newest"<? if($row['ordering']=='oldest to newest') {?>selected="selected"<? }?>>oldest to newest</option>
<option value="newest to oldest"<? if($row['ordering']=='newest to oldest') {?>selected="selected"<? }?>>newest to oldest</option>
</select>
</td></tr>
<tr valign="top">
<td><input type="checkbox" name="link"<? if($row['link']=='yes'){?>checked="checked"<? }?>/> Link to Plugin Author?</td>
</tr>
</table>
<!--<input type="submit" name="submits" value="savechanges" />-->
<p class="submit"><input name="submits" id="submits" class="button-primary" value="Save Changes" type="submit"></p>
</form>
<p>
Donate!</p>
<p>
Has this plugin saved your day? Are you using it for a commercial project? Cool! But please consider a donation for my work:
</p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="9LUSZTG8ZS9EA">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
<?php }?>