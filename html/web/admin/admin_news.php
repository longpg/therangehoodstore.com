<?php		session_start();

		if(!isset($_SESSION['MM_Username'])){		

			header('Location: login.php');			

		}

?>

<?php require_once('Connections/wa_coneccion.php'); ?>

<?php require_once('includes/languages/'.$language.'/main.php'); ?>

<?php

// Load the common classes

require_once('includes/common/KT_common.php');



// Load the tNG classes

require_once('includes/tng/tNG.inc.php');



// Load the required classes

require_once('includes/tfi/TFI.php');

require_once('includes/tso/TSO.php');

require_once('includes/nav/NAV.php');



// Make unified connection variable

$conn_wa_coneccion = new KT_connection($wa_coneccion, $database_wa_coneccion);



//Start Restrict Access To Page

//$restrict = new tNG_RestrictAccess($conn_wa_coneccion, "");

//Grand Levels: Any

//$restrict->Execute();

//End Restrict Access To Page



if (!function_exists("GetSQLValueString")) {

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 

{

  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;



  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);



  switch ($theType) {

    case "text":

      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

      break;    

    case "long":

    case "int":

      $theValue = ($theValue != "") ? intval($theValue) : "NULL";

      break;

    case "double":

      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";

      break;

    case "date":

      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";

      break;

    case "defined":

      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;

      break;

  }

  return $theValue;

}

}



// Filter

$tfi_listRecordset8 = new TFI_TableFilter($conn_wa_coneccion, "tfi_listRecordset8");

$tfi_listRecordset8->addColumn("title_news", "STRING_TYPE", "title_news", "%");

$tfi_listRecordset8->addColumn("date_news", "STRING_TYPE", "date_news", "%");

$tfi_listRecordset8->addColumn("content_news", "STRING_TYPE", "content_news", "%");

$tfi_listRecordset8->addColumn("image_news", "STRING_TYPE", "image_news", "%");

$tfi_listRecordset8->Execute();



// Sorter

$tso_listRecordset8 = new TSO_TableSorter("Recordset1", "tso_listRecordset8");

$tso_listRecordset8->addColumn("title_news");

$tso_listRecordset8->addColumn("date_news");

$tso_listRecordset8->addColumn("content_news");

$tso_listRecordset8->addColumn("image_news");

$tso_listRecordset8->setDefault("title_news");

$tso_listRecordset8->Execute();



// Navigation

$nav_listRecordset8 = new NAV_Regular("nav_listRecordset8", "Recordset1", "", $_SERVER['PHP_SELF'], 10);



//NeXTenesio3 Special List Recordset

$maxRows_Recordset1 = $_SESSION['max_rows_nav_listRecordset8'];

$pageNum_Recordset1 = 0;

if (isset($_GET['pageNum_Recordset1'])) {

  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];

}

$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;



// Defining List Recordset variable

$NXTFilter_Recordset1 = "1=1";

if (isset($_SESSION['filter_tfi_listRecordset8'])) {

  $NXTFilter_Recordset1 = $_SESSION['filter_tfi_listRecordset8'];

}

// Defining List Recordset variable

$NXTSort_Recordset1 = "title_news";

if (isset($_SESSION['sorter_tso_listRecordset8'])) {

  $NXTSort_Recordset1 = $_SESSION['sorter_tso_listRecordset8'];

}

mysql_select_db($database_wa_coneccion, $wa_coneccion);



$query_Recordset1 = "SELECT ne.*, ne_d.* FROM news ne, news_description ne_d WHERE  ne.id_news=ne_d.id_news AND ne_d.id_language=1 ORDER BY ne.id_news DESC";

$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);

$Recordset1 = mysql_query($query_limit_Recordset1, $wa_coneccion) or die(mysql_error());

$row_Recordset1 = mysql_fetch_assoc($Recordset1);



if (isset($_GET['totalRows_Recordset1'])) {

  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];

} else {

  $all_Recordset1 = mysql_query($query_Recordset1);

  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);

}

$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

//End NeXTenesio3 Special List Recordset



$nav_listRecordset8->checkBoundries();

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>TA package - Apolomultimedia.com</title>

<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />

<link href="estilosadmin.css" rel="stylesheet" type="text/css" />

<script src="includes/common/js/base.js" type="text/javascript"></script>

<script src="includes/common/js/utility.js" type="text/javascript"></script>

<script src="includes/skins/style.js" type="text/javascript"></script>

<script src="includes/nxt/scripts/list.js" type="text/javascript"></script>

<script src="includes/nxt/scripts/list.js.php" type="text/javascript"></script>

<script type="text/javascript">

$NXT_LIST_SETTINGS = {

  duplicate_buttons: true,

  duplicate_navigation: true,

  row_effects: true,

  show_as_buttons: true,

  record_counter: true

}

</script>



</head>



<body>





<div class="subtitulo">&nbsp;</div><br />

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/logo2.png"/><br />

<br />

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="titulo">BLOG</span>





<div class="main">



<br><br>



<?php



mysql_select_db($database_wa_coneccion, $wa_coneccion);

$query_Recordset8000 = "SELECT * FROM activa_modulo WHERE name_activa_modulo = 'module_news'";

$Recordset8000 = mysql_query($query_Recordset8000, $wa_coneccion) or die(mysql_error());

$row_Recordset8000 = mysql_fetch_assoc($Recordset8000);

$totalRows_Recordset8000 = mysql_num_rows($Recordset8000);



?>







<?php



if ((isset($_POST["MM_insertcheck"])) && ($_POST["MM_insertcheck"] == "formcheck")) {

 

$insertSQL = "UPDATE activa_modulo SET check_activa_modulo = '".$_POST["checkbox"]."' WHERE name_activa_modulo = 'module_news'";



  mysql_select_db($database_wa_coneccion, $wa_coneccion);

  $Result200 = mysql_query($insertSQL, $wa_coneccion) or die(mysql_error());

echo '<script type="text/javascript">'; 

echo 'window.location.href="admin_news.php";'; 

echo '</script>'; 

}

?>





<br>

<div class="KT_tng" id="listRecordset8">



  <div class="KT_tnglist">

    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">

      <div class="KT_options"> <a href="<?php echo $nav_listRecordset8->getShowAllLink(); ?>">

        <?php 

  // Show IF Conditional region1

  if (@$_GET['show_all_nav_listRecordset8'] == 1) {

?>

          <?php echo $_SESSION['default_max_rows_nav_listRecordset8']; ?>

          <?php 

  // else Conditional region1

  } else { ?>

          <?php echo ALL; ?>

          <?php } 

  // endif Conditional region1

?>

            <?php echo RECORDS; ?></a> &nbsp;

        &nbsp;

               

      </div>

      <table cellpadding="2" cellspacing="0" class="KT_tngtable" width="896">

        <thead>

          <tr class="KT_row_order">

            <th>&nbsp;</th>

            <th id="title_news"><?php echo TITLE; ?></th>

            <th id="date_news"><?php echo DATE; ?></th>

            <th id="content_news"><?php echo CONTENT; ?></th>

            <th id="image_news"><?php echo IMAGE; ?></th>

            <th>&nbsp;</th>

          </tr>

          <?php 

  // Show IF Conditional region3

  if (@$_SESSION['has_filter_tfi_listRecordset8'] == 1) {

?>

            <tr class="KT_row_filter">

              <td>&nbsp;</td>

              <td><input type="text" name="tfi_listRecordset8_title_news" id="tfi_listRecordset8_title_news" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listRecordset8_title_news']); ?>" size="20" maxlength="20" /></td>

              <td><input type="text" name="tfi_listRecordset8_date_news" id="tfi_listRecordset8_date_news" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listRecordset8_date_news']); ?>" size="20" maxlength="20" /></td>

              <td><input type="text" name="tfi_listRecordset8_content_news" id="tfi_listRecordset8_content_news" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listRecordset8_content_news']); ?>" size="20" maxlength="20" /></td>

              <td><input type="text" name="tfi_listRecordset8_image_news" id="tfi_listRecordset8_image_news" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listRecordset8_image_news']); ?>" size="20" maxlength="20" /></td>

              <td><input type="submit" name="tfi_listRecordset8" value="<?php echo NXT_getResource("Filter"); ?>" /></td>

            </tr>

            <?php } 

  // endif Conditional region3

?>

        </thead>

        <tbody>

          <?php if ($totalRows_Recordset1 == 0) { // Show if recordset empty ?>

            <tr>

              <td colspan="5"><?php echo TEXTO77; ?></td>

            </tr>

            <?php } // Show if recordset empty ?>

          <?php if ($totalRows_Recordset1 > 0) { // Show if recordset not empty ?>

            <?php do { ?>

              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">

                <td>&nbsp;</td>

                <td><div class="KT_col_title_news"><?php echo KT_FormatForList($row_Recordset1['title_news'], 20); ?></div></td>

                <td><div class="KT_col_date_news"><?php echo KT_FormatForList($row_Recordset1['date_news'], 20); ?></div></td>

                <td><div class="KT_col_content_news"><?php echo KT_FormatForList($row_Recordset1['content_news'], 20); ?></div></td>

                <td><div class="KT_col_image_news"><?php echo KT_FormatForList($row_Recordset1['image_news'], 20); ?></div></td>

                <td align="right"><a class="KT_edit_link" href="admin_news_detail.php?id_news=<?php echo $row_Recordset1['id_news']; ?>&amp;KT_back=1"><?php echo EDIT; ?></a></td>

              </tr>

              <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>

            <?php } // Show if recordset not empty ?>

        </tbody>

      </table>

      <div class="KT_bottomnav">

        <div>

          <?php

            $nav_listRecordset8->Prepare();

            require("includes/nav/NAV_Text_Navigation.inc.php");

          ?>

        </div>

      </div>

      <div class="KT_bottombuttons">

        <div class="KT_operations">  </div>

<span>&nbsp;</span>

        

        <a class="KT_additem_op_link" href="admin_news_detail.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo ADDNEW; ?></a> </div>

    </form>

  </div>

  <br class="clearfixplain" />

</div>



</div>





</body>

</html>

<?php

mysql_free_result($Recordset1);



mysql_free_result($Recordset8000);

?>

