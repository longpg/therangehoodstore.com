<?php
/*
  $Id: gv_redeem.php,v 1.1.1.1.2.1 2003/04/18 16:56:03 wilt Exp $

  The Exchange Project - Community Made Shopping!
  http://www.theexchangeproject.org

  Gift Voucher System v1.0
  Copyright (c) 2001,2002 Ian C Wilson
  http://www.phesis.org

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE', 'Redeem Gift Certificate');
define('HEADING_TITLE', 'Redeem Gift Certificate');
define('TEXT_INFORMATION', 'For more information regarding Gift Certificates, please see our <a href="' . tep_href_link(FILENAME_GV_FAQ,'','NONSSL').'">'.GV_FAQ.'.</a>');
define('TEXT_INVALID_GV', 'The Gift Certificate number may be invalid or has already been redeemed. To contact the shop owner please use the Contact Page');
define('TEXT_VALID_GV', 'Congratulations, you have purchased a Gift Certificate worth %s');
define('TEXT_MSG_GV1', 'Use your gift certificate code at the payment module');
define('TEXT_MSG_GV2', 'To send gift certificate to a friend');
?>