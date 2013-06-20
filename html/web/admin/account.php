<?php		

		session_start();

		if(!isset($_SESSION['MM_Username'])){		

			header('Location: login.php');			

		}

?>

<?php



  require('includes/application_top.php');



  if (!tep_session_is_registered('customer_id')) {

    $navigation->set_snapshot();

    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));

  }



  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ACCOUNT);



  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html <?php echo HTML_PARAMS; ?> xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title><?php echo TITLE; ?></title>

<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">

<link rel="stylesheet" type="text/css" href="stylesheet.css">

<link rel="stylesheet" type="text/css" href="stylesheet2.css">

<script language="javascript"><!--

function rowOverEffect(object) {

  if (object.className == 'moduleRow') object.className = 'moduleRowOver';

}



function rowOutEffect(object) {

  if (object.className == 'moduleRowOver') object.className = 'moduleRow';

}

//--></script>

</head>

<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">

<!-- header //-->

<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<!-- header_eof //-->



<!-- body //-->



	  <tr>

		<td class="tdborde" valign="top" width="<?php echo BOX_WIDTH_1; ?>" height="100%"><?php require(DIR_WS_INCLUDES . 'column_left.php'); ?></td>

	   <td class="tdborde" valign="top" width="<?php echo BOX_WIDTH_2; ?>" >

       

			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="height:100%"  class="content" >

			  <tr>

				<td width="100%" height="100%" valign="top">

					<table width="100%" style="height:100%" cellspacing="0" cellpadding="0" border="0">

					  <tr>

						<td width="100%" height="100%" valign="top" style="background:url(images/r-t-dr.png) repeat-x; padding: 16px 11px 15px 19px">

							<table width="100%" style="height:22px" cellspacing="0" cellpadding="0" border="0">

							  <tr>

								<td class="h_r_text" height="100%" valign="top" width="100%">

									<strong><?=HEADING_TITLE?></strong><br>

								</td>

								<td width="100%" height="100%" valign="top" style="background: url(images/t1-dr.gif) repeat-x top"></td>

							  </tr>

							</table>

							<br style="line-height:18px;">

							<table width="100%" cellspacing="0" cellpadding="0" border="0">

							  <tr>

								<td width="100%" height="100%" valign="top">

									<br style="line-height:5px;">





		<table cellpadding="0" cellspacing="0" border="0" width="100%">

<?php

  if ($messageStack->size('account') > 0) {

?>

      <tr>

        <td><?php echo $messageStack->output('account'); ?></td>

      </tr>

      <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>

      </tr>

<?php

  }



  if (tep_count_customer_orders() > 0) {

?>





<tr>

        <td><table border="0" cellspacing="0" cellpadding="2">

          <tr>

            <td class="main"><b><?php echo OVERVIEW_TITLE; ?></b></td>

            <td class="main"><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL') . '"><u>' . OVERVIEW_SHOW_ALL_ORDERS . '</u></a>'; ?></td>

          </tr>

        </table></td>

      </tr>



      <tr>

        <td><table border="0" width="100%" cellspacing="1" cellpadding="0" class="infoBox">

          <tr class="infoBoxContents">

            <td><table border="0"  cellspacing="0" cellpadding="2">

              <tr>

                <td class="main" align="center" valign="top" width="130"><?php echo '<b>' . OVERVIEW_PREVIOUS_ORDERS . '</b><br>' . tep_image(DIR_WS_IMAGES . 'arrow_south_east.gif'); ?></td>

                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php

    $orders_query = tep_db_query("select o.orders_id, o.date_purchased, o.delivery_name, o.delivery_country, o.billing_name, o.billing_country, ot.text as order_total, s.orders_status_name from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot, " . TABLE_ORDERS_STATUS . " s where o.customers_id = '" . (int)$customer_id . "' and o.orders_id = ot.orders_id and ot.class = 'ot_total' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' order by orders_id desc limit 3");

    while ($orders = tep_db_fetch_array($orders_query)) {

      if (tep_not_null($orders['delivery_name'])) {

        $order_name = $orders['delivery_name'];

        $order_country = $orders['delivery_country'];

      } else {

        $order_name = $orders['billing_name'];

        $order_country = $orders['billing_country'];

      }

?>

                  <tr class="moduleRow" onMouseOver="rowOverEffect(this)" onMouseOut="rowOutEffect(this)" onClick="document.location.href='<?php echo tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders['orders_id'], 'SSL'); ?>'">

                    <td class="main" width="80"><?php echo tep_date_short($orders['date_purchased']); ?></td>

                    <td class="main"><?php echo '#' . $orders['orders_id']; ?></td>

                    <td class="main"><?php echo tep_output_string_protected($order_name) . ', ' . $order_country; ?></td>

                    <td class="main"><?php echo $orders['orders_status_name']; ?></td>

                    <td class="main" align="right"><?php echo $orders['order_total']; ?></td>

                    <td class="main" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orders['orders_id'], 'SSL') . '">' . tep_image_button('button_view.gif', SMALL_IMAGE_BUTTON_VIEW) . '</a>'; ?></td>

                  </tr>

<?php

    }

?>

                </table></td>

                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>

              </tr>

            </table></td>

          </tr>

        </table></td>

      </tr>

      <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>

      </tr>

<?php

  }

?>

      <tr>

        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

          <tr>

            <td class="main"><b><?php echo MY_ACCOUNT_TITLE; ?></b></td>

          </tr>

        </table></td>

      </tr>

      <tr>

        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">

          <tr class="infoBoxContents">

            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

              <tr>

                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>

                <td width="60"><?php echo tep_image(DIR_WS_IMAGES . 'account_personal.gif'); ?></td>

                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>

                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

                  <tr>

                    <td class="main"><?php echo tep_image(DIR_WS_IMAGES . 'arrow_green.gif') . ' <a href="' . tep_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL') . '">' . MY_ACCOUNT_INFORMATION . '</a>'; ?></td>

                  </tr>

                  <tr>

                    <td class="main"><?php echo tep_image(DIR_WS_IMAGES . 'arrow_green.gif') . ' <a href="' . tep_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">' . MY_ACCOUNT_ADDRESS_BOOK . '</a>'; ?></td>

                  </tr>

                  <tr>

                    <td class="main"><?php echo tep_image(DIR_WS_IMAGES . 'arrow_green.gif') . ' <a href="' . tep_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL') . '">' . MY_ACCOUNT_PASSWORD . '</a>'; ?></td>

                  </tr>

                </table></td>

                <td width="10" align="right"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>

              </tr>

            </table></td>

          </tr>

        </table></td>

      </tr>

      <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>

      </tr>

      <tr>

        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

          <tr>

            <td class="main"><b><?php echo MY_ORDERS_TITLE; ?></b></td>

          </tr>

        </table></td>

      </tr>

      <tr>

        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">

          <tr class="infoBoxContents">

            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

              <tr>

                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>

                <td width="60"><?php echo tep_image(DIR_WS_IMAGES . 'account_orders.gif'); ?></td>

                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>

                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

                  <tr>

                    <td class="main"><?php echo tep_image(DIR_WS_IMAGES . 'arrow_green.gif') . ' <a href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL') . '">' . MY_ORDERS_VIEW . '</a>'; ?></td>

                  </tr>

                </table></td>

                <td width="10" align="right"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>

              </tr>

            </table></td>

          </tr>

        </table></td>

      </tr>

      <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>

      </tr>

      <tr>

        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

          <tr>

            <td class="main"><b><?php echo EMAIL_NOTIFICATIONS_TITLE; ?></b></td>

          </tr>

        </table></td>

      </tr>

      <tr>

        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">

          <tr class="infoBoxContents">

            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

              <tr>

                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>

                <td width="60"><?php echo tep_image(DIR_WS_IMAGES . 'account_notifications.gif'); ?></td>

                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>

                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

                  <tr>

                    <td class="main"><?php echo tep_image(DIR_WS_IMAGES . 'arrow_green.gif') . ' <a href="' . tep_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'SSL') . '">' . EMAIL_NOTIFICATIONS_NEWSLETTERS . '</a>'; ?></td>

                  </tr>

                  <tr>

                    <td class="main"><?php echo tep_image(DIR_WS_IMAGES . 'arrow_green.gif') . ' <a href="' . tep_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'SSL') . '">' . EMAIL_NOTIFICATIONS_PRODUCTS . '</a>'; ?></td>

                  </tr>

                </table></td>

                <td width="10" align="right"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>

              </tr>

            </table></td>

          </tr>

        </table></td>

      </tr>

      

      

      

      

      

            <tr>

        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>

      </tr>

      <tr>

        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

          <tr>

            <td class="main"><b><?php echo "Gift Certificate"; ?></b></td>

          </tr>

        </table></td>

      </tr>

      <tr>

        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">

          <tr class="infoBoxContents">

            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

              <tr>

                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>

                <td width="60"><?php echo tep_image(DIR_WS_IMAGES . 'account_orders.gif'); ?></td>

                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>

                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

                

      <?php

	  	  

	  $coupon_search1_query=tep_db_query("select customers_email_address,customers_id from customers where customers_id ='".(int)$customer_id."'");

      $coupon_search1=tep_db_fetch_array($coupon_search1_query);

	  

	  $coupon_search_query=tep_db_query("select * from coupon_email_track where emailed_to ='".$coupon_search1['customers_email_address']."'");

	  

	  while ($coupon_search=tep_db_fetch_array($coupon_search_query)) {

	  		

				$coupon_search2_query=tep_db_query("select * from coupons where coupon_id ='".$coupon_search['coupon_id']."' order by coupon_id desc");

				$coupon_search2=tep_db_fetch_array($coupon_search2_query);

	  ?>

      

                  <tr>

                    <td class="main"><?php echo tep_image(DIR_WS_IMAGES . 'arrow_green.gif'); ?><a href="gv_redeem.php?gv_no=<?php echo $coupon_search2['coupon_code']; ?>"><?php echo viewcertificate;?> - <?php echo $coupon_search2['coupon_code']; ?></a></td>

                  </tr>

        

        <?php }?>       

                  

                </table></td>

                <td width="10" align="right"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>

              </tr>

            </table></td>

          </tr>

        </table></td>

      </tr>

      

      

      

      

    </table>



<!-- body_eof //-->



								</td>

								<td width="20" height="100%" valign="top"><?php echo tep_draw_separator('spacer.gif', '20', '1'); ?></td>

							  </tr>

							</table>							

						</td>

					  </tr>

					  <tr>

						<td width="100%" height="16" valign="top"></td>

					  </tr>

					</table>

				</td>

			  </tr>

		  </table>









</td>

			  </tr>

</table>

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>

<!-- footer_eof //-->

</body>

</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>