<?php
	session_start();
	require_once("funcs.php");
	conn(); 
	
	$id=$_GET['id'];
	$show_one=$_GET['show_one'];
	
	$dat=$_GET['dat'];
	$ord_by=$_GET['ord_by'];
	
	$result2= mysql_query("select * from good_ordered where id='$id'");
	$rows= mysql_fetch_array($result2);
	$dat=$rows["dat"];
	$ord_by=$rows["ord_by"];
	$ord_no=$rows["ord_no"];
	
	$result2= mysql_query("select * from good_ordered where dat='$dat' and ord_by='$ord_by'");
	$rows= mysql_fetch_array($result2);
	
	$dat=$rows["dat"];
	$ord_by=$rows["ord_by"];
	$approve_by=$rows["approve_by"];
	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="images/favicon.png" type="image/x-icon" />
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Large Heart - Daily Operation Record</title>

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
body,td,th,p,a {
	font-size: 20px;
}
-->
</style>
</head>

<body>
<table width="200" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td valign="top">
      <table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tr>
          <td width="42%" valign="middle"><p align="left"><img src="images/Ayanfe_logo.jpg" width="198" height="126" /></p></td>
          <td width="58%" valign="middle"><div align="left" style="font-size:18px">
              <strong>No 9, Darlington Street ,Mokola <br />
					Ibadan-Oyo State, 
              Nigeria.<br />
              Tel: 08159482998, 08035123039</strong><br />
          </div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="297" valign="top"><table width="99%" border="0" cellspacing="5" cellpadding="5">
      <tr>
        <td align="center"><table width="95%" height="43" border="0" cellpadding="5" cellspacing="0">
          <tr>
    <td colspan="2" align="center" valign="top" bgcolor="#CCCCCC"><b>PRINTING ORDER RECEIPT</b></td>
    </tr>
  <tr>
    <td width="48%" valign="top"><strong>To:</strong>
      <?php echo $ord_by;?></td>
    <td width="52%" align="right" valign="top"><span class="style7">AM/<?php echo $ord_no;?>
      </span></td>
  </tr>
          </table>
          <table width="95%" height="43" border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td width="68%" height="43" valign="top"><strong> By:</strong>
                      <?php echo $approve_by;?>
             </td>
              <td width="32%" valign="top"><div align="left">|
                <?php echo $dat;?>
              </div></td>
            </tr>
          </table>
          <table width="95%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000">
            <tr>
			  <td width="10%" align="center" bgcolor="#CCCCCC"><strong>S/N</strong></td>
              <td width="16%" align="center" bgcolor="#CCCCCC"><strong>Desc.</strong></td>
              <td width="12%" align="center" bgcolor="#CCCCCC"><strong> Area</strong></td>
              <td width="15%" align="center" bgcolor="#CCCCCC"><strong>Price </strong></td>
              <td width="13%" align="center" bgcolor="#CCCCCC"><strong>Qty </strong></td>
              <td width="13%" align="center" bgcolor="#CCCCCC"><strong>Total</strong></td>
              <td width="21%" align="center" bgcolor="#CCCCCC"><strong>Balance </strong></td>
              </tr>
			  <tr class=textonly3>
<?php 	if(!$show_one)
	{
		$result4= mysql_query("select * from good_ordered where ord_by='$ord_by' and dat='$dat'");
		$num=mysql_affected_rows();
	}
	else
	{
		$result4= mysql_query("select * from good_ordered where id='$id'");
		$num=mysql_affected_rows();
	}
	//if($num<10) $k=10-$num;
	if($num<=0) echo "There are no record found for $order_by"; 
	else
	{
		for($i=1;$i<=$num;$i++)
		{
			$row= mysql_fetch_array($result4);
			$dat=$row["dat"];
			$id=$row["id"];
			$item_id=$row["item_id"];
			$des=$row["des"];;
			$width=$row["width"];
			$height=$row["height"];
			$qty=$row["qty"];
			$sale_price=$row["sale_price"];
			$discount=$row["discount"];
			$total_area=$width*$height;
			$total_amount=$total_area*$sale_price*$qty-$discount;
			$ord_by=$row["ord_by"];
			$approve_by=$row["approve_by"];
			$ord_no=$row["ord_no"];
			$balance=$total_amount - $row["amount_paid"];
			$agg_total+=$row["amount_paid"];
			$agg_balance+=$balance;
?>
              <td height="36" align="center"><?php echo $i;?></td>
			  <td align="center"><a href="view_item_ordered.php?id=<?php echo $id;?>&show_one=yes" style="font-size:14px; color:#000"><?php echo $des;?> (<?php echo $item_id;?>) </a></td>
              <td align="center"><?php  echo $width."x".$height." (".number_format($total_area).")";?> <?php echo $unit;?></td>
              <td align="center">#<?php echo number_format($sale_price);?></td>
              <td align="center"><?php echo number_format($qty);?></td>
              <td align="center"><strong>#<?php echo number_format($row["amount_paid"]);?></strong></td>
              <td align="center"><strong>#<?php echo number_format($balance);?></strong></td>
              </tr>
<?php } 
		for($j=1;$j<=$k;$j++)
		{
?>
              <tr><td>&nbsp;</td>
			  <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><img src="images/none.jpg" width="100%" /></td>
              <td>&nbsp;</td>
<?php 
		}
} ?>
			<tr class=textonly3>
			    <td height="49" colspan="4" align="left"><div align="left" style="font-size:17px">All Printing Certified OK before received are not  returnable. Thanks for your Patronage </div></td>
                <td height="49" align="center"><b>Total</span></b></td>
			    <td align="center"><b>#<?php echo number_format($agg_total);?>
			    </b></td>
                <td align="center"><b>#<?php echo number_format($agg_balance);?>
                </b></td>
		      </tr>
          </table>
          <table width="95%" height="56" border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td width="69%" valign="top"><p>
                  </p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="27%" height="38"><p align="center"><span class="style18"><strong>______________________</strong><br />
                      <strong>CUSTOMER</strong></span></p></td>
                    <td width="47%">&nbsp;</td>
                    <td width="26%"><div align="center"><span class="style18"><strong>______________________</strong><br />
                      <strong>LARGE HEART</strong></span></div></td>
                  </tr>
                </table></td>
              </tr>
          </table>
          </td>
      </tr>
    </table>      
    </td>
  </tr>
</table>
</body>
</html>
 