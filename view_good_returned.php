<?php
	session_start();
	require_once("funcs.php");
	conn(); 
	
	$id=$_GET['id'];
	
	$dat=$_GET['dat'];
	$return_by=$_GET['return_by'];
	
	$result2= mysql_query("select * from good_returned where id='$id'");
	$row5= mysql_fetch_array($result2);
	$dat=$row5["dat"];
	$des=$row5["des"];
	$return_by=$row5["return_by"];
	$ord_no=$row5["ord_no"];
	$dat=$row5['dat'];
	$item_id=$row5['item_id'];
	$des=$row5['des'];
	$price=$row5['price'];
	$price=$row5['price'];
	$width=$row5['width'];
	$height=$row5['height'];
	$qty=$row5['qty'];
	$discount=$row5['discount'];
	$approve_by=$row5['approve_by'];
	$receive_by=$row5['receive_by'];
	$record_by=$row5['record_by'];
	$reason=$row5['reason'];
	
	$total_amount=$width*$height*$qty*$price-$discount;
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Large Heart Digital Prints - Daily Operation Record</title>

<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style7 {	font-size: 16px;
	font-weight: bold;
}
body {
	margin-left: 0px;
	margin-top: 00px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style10 {font-size: 10px}
.style15 {font-size: 14px; font-weight: bold; }
.style18 {font-size: 16px}
-->
</style>
</head>

<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td height="143" valign="top"><? include ("header2.php"); ?></td>
  </tr>
  <tr>
    <td height="297" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="5">
      <tr>
        <td align="center"><table width="95%" border="1" cellpadding="5" cellspacing="0">
          <tr class="textonly3">
            <td width="279" height="36" valign="middle"><div align="right"><strong>Order Number </strong></div></td>
            <td width="311" align="left" valign="middle"><div align="left">
              <?php echo $ord_no;?>
              <input name="ord_no" type="hidden" id="ord_no" value="<?php echo $ord_no;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Ordered Date  * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo $dat?>
              <input name="dat" type="hidden" id="dat" value="<?php echo $dat?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Material Used * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo $item_id;?>
              <input name="item_id" type="hidden" id="item_id" value="<?php echo $item_id;?>" />
              </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Unit Price  * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo number_format($sale_price,2);?>
              Naira
              <input name="sale_price" type="hidden" id="sale_price" value="<?php echo $sale_price;?>" />
              </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Job Width  * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo $width;?>
              Feet(s)
              <input name="width" type="hidden" id="width" value="<?php echo $width;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Job Height  * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo $height;?>
              Feet(s)
              <input name="height" type="hidden" id="height" value="<?php echo $height;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Quantity  * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo $qty;?>
              <input name="qty" type="hidden" id="qty" value="<?php echo $qty;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Discount Amount * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo number_format($discount,2);?>
              Naira
              <input name="discount" type="hidden" id="discount" value="<?php echo $discount;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Total Amount  * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo number_format($total_amount,2);?>
              Naira
              <input name="total_amount" type="hidden" id="total_amount" value="<?php echo $total_amount;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Returned by * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo $return_by;?>
              <input name="return_by" type="hidden" id="return_by" value="<?php echo $return_by;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Received by  * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo $receive_by;?>
              <input name="receive_by" type="hidden" id="receive_by" value="<?php echo $receive_by;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Recorded by  * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo $record_by;?>
              <input name="record_by" type="hidden" id="record_by" value="<?php echo $record_by;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Reason for return </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo $reason;?>
              <input name="reason" type="hidden" id="reason" value="<?php echo $reason;?>" />
              </div></td>
          </tr>
          </table></td>
      </tr>
    </table>      
    </td>
  </tr>
</table>
</body>
</html>
