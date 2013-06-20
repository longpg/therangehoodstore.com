<?php
/*
  $Id: login.php,v 1.80 2003/06/05 23:28:24 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/


// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled (or the session has not started)
 // if ($session_started == false) {
  //  tep_redirect(tep_href_link(FILENAME_COOKIE_USAGE));
 // }

  //require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_LOGIN);

  $error = false;
  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'process')) {
    $email_address = tep_db_prepare_input($HTTP_POST_VARS['email_address']);
    $password = tep_db_prepare_input($HTTP_POST_VARS['password']);

// Check if email exists
// BOF Separate Pricing per Customer
/*    $check_customer_query = tep_db_query("select customers_id, customers_firstname, customers_password, customers_email_address, customers_default_address_id from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "'"); */
    $check_customer_query = tep_db_query("select customers_id, customers_firstname, customers_group_id, customers_password, customers_email_address, customers_default_address_id from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "'");
// EOF Separate Pricing Per Customer
    if (!tep_db_num_rows($check_customer_query)) {
      $error = true;
    } else {
      $check_customer = tep_db_fetch_array($check_customer_query);
// Check that password is good
      if (!tep_validate_password($password, $check_customer['customers_password'])) {
        $error = true;
      } else {
        if (SESSION_RECREATE == 'True') {
          tep_session_recreate();
        }
// BOF Separate Pricing Per Customer: choice for logging in under any customer_group_id
// note that tax rates depend on your registered address!
if ($_GET['skip'] != 'true' && $_POST['email_address'] == SPPC_TOGGLE_LOGIN_PASSWORD ) {
   $existing_customers_query = tep_db_query("select customers_group_id, customers_group_name from " . TABLE_CUSTOMERS_GROUPS . " order by customers_group_id ");
echo '<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">';
print ("\n<html ");
echo HTML_PARAMS;
print (">\n<head>\n<title>Choose a Customer Group</title>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=");
echo CHARSET;
print ("\"\n<base href=\"");
echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG;
print ("\">\n<link rel=\"stylesheet\" type=\"text/css\" href=\"stylesheet.css\">\n");
echo '<body bgcolor="#ffffff" style="margin:0">';
print ("\n<table border=\"0\" width=\"100%\" height=\"100%\">\n<tr>\n<td style=\"vertical-align: middle\" align=\"middle\">\n");
echo tep_draw_form('login', tep_href_link(FILENAME_LOGIN, 'action=process&skip=true', 'SSL'));
print ("\n<table border=\"0\" bgcolor=\"#f1f9fe\" cellspacing=\"10\" style=\"border: 1px solid #7b9ebd;\">\n<tr>\n<td class=\"c_text20\">\n");
  $index = 0;
  while ($existing_customers =  tep_db_fetch_array($existing_customers_query)) {
 $existing_customers_array[] = array("id" => $existing_customers['customers_group_id'], "text" => "&#160;".$existing_customers['customers_group_name']."&#160;");
    ++$index;
  }
print ("<h1>Choose a Customer Group</h1>\n</td>\n</tr>\n<tr>\n<td align=\"center\">\n");
echo tep_draw_pull_down_menu('new_customers_group_id', $existing_customers_array, $check_customer['customers_group_id']);
print ("\n<tr>\n<td class=\"c_text20\">&#160;<br />\n&#160;");
print ("<input type=\"hidden\" name=\"email_address\" value=\"".$_POST['email_address']."\">");
print ("<input type=\"hidden\" name=\"password\" value=\"".$_POST['password']."\">\n</td>\n</tr>\n<tr>\n<td align=\"right\">\n");
echo tep_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE);
print ("</td>\n</tr>\n</table>\n</form>\n</td>\n</tr>\n</table>\n</body>\n</html>\n");
exit;
}
// EOF Separate Pricing Per Customer: choice for logging in under any customer_group_id
        $check_country_query = tep_db_query("select entry_country_id, entry_zone_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$check_customer['customers_id'] . "' and address_book_id = '" . (int)$check_customer['customers_default_address_id'] . "'");
        $check_country = tep_db_fetch_array($check_country_query);

        $customer_id = $check_customer['customers_id'];
        $customer_default_address_id = $check_customer['customers_default_address_id'];
        $customer_first_name = $check_customer['customers_firstname'];
		// BOF Separate Pricing per Customer
	if ($_GET['skip'] == 'true' && $_POST['email_address'] == SPPC_TOGGLE_LOGIN_PASSWORD && isset($_POST['new_customers_group_id']))  {
	$sppc_customer_group_id = $_POST['new_customers_group_id'] ;
	$check_customer_group_tax = tep_db_query("select customers_group_show_tax, customers_group_tax_exempt from " . TABLE_CUSTOMERS_GROUPS . " where customers_group_id = '" .(int)$_POST['new_customers_group_id'] . "'");
	} else {
	$sppc_customer_group_id = $check_customer['customers_group_id'];
	$check_customer_group_tax = tep_db_query("select customers_group_show_tax, customers_group_tax_exempt from " . TABLE_CUSTOMERS_GROUPS . " where customers_group_id = '" .(int)$check_customer['customers_group_id'] . "'");
	}
	$customer_group_tax = tep_db_fetch_array($check_customer_group_tax);
	$sppc_customer_group_show_tax = (int)$customer_group_tax['customers_group_show_tax'];
	$sppc_customer_group_tax_exempt = (int)$customer_group_tax['customers_group_tax_exempt'];
		
	/* TAX RATES EXEMPTABLE BOC */
	$cg_tax_rates_exempt_query = tep_db_query("select tax_rates_id from " . TABLE_CUSTOMERS_GROUPS_TAX_RATES_EXEMPT . " where customers_group_id = '" .$sppc_customer_group_id. "'");
    while($tax_rate = tep_db_fetch_array($cg_tax_rates_exempt_query)) {
		$sppc_customer_group_tax_rates_exempt[$tax_rate['tax_rates_id']] = true;
    }    
	/* TAX RATES EXEMPTABLE EOC */
	
	// EOF Separate Pricing per Customer
        $customer_country_id = $check_country['entry_country_id'];
        $customer_zone_id = $check_country['entry_zone_id'];
        tep_session_register('customer_id');
        tep_session_register('customer_default_address_id');
        tep_session_register('customer_first_name');
		// BOF Separate Pricing per Customer
	tep_session_register('sppc_customer_group_id');
	tep_session_register('sppc_customer_group_show_tax');
	tep_session_register('sppc_customer_group_tax_exempt');
		/* TAX RATES EXEMPTABLE BOC */	
	tep_session_register('sppc_customer_group_tax_rates_exempt');
	/* TAX RATES EXEMPTABLE EOC */	
	// EOF Separate Pricing per Customer
        tep_session_register('customer_country_id');
        tep_session_register('customer_zone_id');

        tep_db_query("update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_of_last_logon = now(), customers_info_number_of_logons = customers_info_number_of_logons+1 where customers_info_id = '" . (int)$customer_id . "'");

// restore cart contents
        $cart->restore_contents();

        if (sizeof($navigation->snapshot) > 0) {
          $origin_href = tep_href_link($navigation->snapshot['page'], tep_array_to_string($navigation->snapshot['get'], array(tep_session_name())), $navigation->snapshot['mode']);
          $navigation->clear_snapshot();
          tep_redirect($origin_href);
        } else {
          tep_redirect(tep_href_link(FILENAME_DEFAULT));
        }
      }
    }
  }

  if ($error == true) {
    $messageStack->add('login', TEXT_LOGIN_ERROR);
  }

  //$breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_LOGIN, '', 'SSL'));
?>
<!-- funcion para ocultar y mostrar div de un ingrediente para productos unicos -->
<script type="text/javascript">
function mostrardiv() {
div = document.getElementById('loginbox');
div.style.display = '';
div = document.getElementById('clickbox');
div.style.display = 'none';
div = document.getElementById('clickbox2');
div.style.display = '';
}

function ocultardiv() {
div = document.getElementById('loginbox');
div.style.display='none';
div = document.getElementById('clickbox');
div.style.display = '';
div = document.getElementById('clickbox2');
div.style.display='none';
}
</script>
<!-- funcion para ocultar y mostrar div de un ingrediente para productos unicos -->

<div style="margin-top:5px; padding-left:44px;" id="clickbox">
<a href="javascript:mostrardiv();"><img src="<?php echo tep_output_string(DIR_WS_LANGUAGES . $language . '/images/buttons/yasoycliente.jpg');?>"/></a>
</div>

<div style="margin-top:5px; padding-left:44px; display:none" id="clickbox2">
<a href="javascript:ocultardiv();"><img src="<?php echo tep_output_string(DIR_WS_LANGUAGES . $language . '/images/buttons/yasoycliente.jpg');?>"/></a>
</div>

<div style="width:198px; background-image:url(images/fondologin.png); background-repeat:no-repeat; height:192px; background-position:top center; display:none" id="loginbox">

	<?php echo tep_draw_form('login', tep_href_link(FILENAME_LOGIN, 'action=process', 'SSL')); ?>
    
    <div style="padding-left:28px; padding-top: 15px">
    <input type="text" name="email_address"  placeholder="<?php echo ENTRY_EMAIL_ADDRESS; ?>" style="padding:5px; border:0; background-color:#F0F0F0;" size="20"/>
    </div>
    
    <div style="padding-left:28px; margin-top:10px;">
    <input type="password" name="password" maxlength="40" placeholder="<?php echo ENTRY_PASSWORD; ?>"  style="padding:5px; border:0; background-color:#F0F0F0; " size="20"/>
    </div>
    
    <div style="padding-left:28px; margin-top:10px;">
    <?php echo tep_image_submit('button_login.gif', IMAGE_BUTTON_LOGIN); ?>
    </div>
    
    <div style=" margin-top:7px; width:100%; text-align:center">
    <?php echo '<a href="' . tep_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '">'.TEXT_PASSWORD_FORGOTTEN.'</a>'; ?></td>
    </div>
    </form>

</div>