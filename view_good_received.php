<?php
	session_start();
	require_once("funcs.php");
	conn(); 
	
	$id=$_GET['id'];
	
	$d=$_GET['d'];
	$m=$_GET['m'];
	$y=$_GET['y'];
	
	$result2= mysql_query("select * from good_received where id='$id'");
	echo $rows= mysql_fetch_array($result2);
	$dat=$rows["dat"];
	$company=$rows["company"];
	$ord_no=$rows["ord_no"];
	
	$result3= mysql_query("select * from supplier where company='$company'");
	$row3= mysql_fetch_array($result3);
	$contact=$row3["contact"];
	$address=$row3["address"];
	$phone=$row3["phone"];
	$email=$row3["email"];

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
.style7 {	font-size: 18px;
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
        <td align="center"><table width="99%" border="0" cellspacing="0" cellpadding="20">
          <tr>
            <td width="23%">&nbsp;</td>
            <td width="52%"><div align="center"><span class="style7">MATERIALS RECEIVED  </span></div></td>
            <td width="25%"><table width="82%" border="1" align="left" cellpadding="5" cellspacing="0" bordercolor="#000000">
              <tr>
                <td><div align="left"><strong>LHDP/<?php echo $ord_no;?></strong></div></td>
              </tr>
            </table></td>
          </tr>
          
        </table>
          <table width="95%" height="43" border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td width="34%" valign="top"><table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#000000">
                <tr>
                  <td><div align="left"><strong>Supplier  Details: </strong><br />
                    <?php echo $contact;?>
                    <br />
                    <?php echo $company;?>
                    <br />
                    <?php echo $address;?>
                  </div></td>
                </tr>
              </table>                </td>
              <td width="41%" valign="top"><table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#000000">
                <tr>
                  <td><div align="left"><strong>Receiving Address: </strong><br />
                    <b>Large Heart Digital Print Ltd.</b><br />
31, Oluyole Street, Beside Sunasco Plaza,<br />
Near Omotayo Hsopital, Off Ososami Road, <br />
Oke-Ado, Ibadan-Oyo State<br />
Nigeria</div></td>
                </tr>
              </table></td>
              <td width="25%" valign="top"><table width="70%" border="1" align="right" cellpadding="5" cellspacing="0" bordercolor="#000000">
                <tr>
                  <td width="23%"><strong>Date</strong></td>
                  <td width="77%"><?php echo $dat;?></td>
                </tr>
              </table></td>
            </tr>
          </table>
<table width="95%" border="1" cellpadding="3" cellspacing="0" bordercolor="#000000">
  <tr>
			  <td width="4%" align="center"><strong>S/N</strong></td>
              <td width="26%" align="center"><strong>Description</strong></td>
              <td width="12%" align="center"><strong>Size</strong></td>
              <td width="14%" align="center"><strong>Unit Price </strong></td>
              <td width="17%" align="center"><strong>Total Amount </strong></td>
			  </tr>
			  <tr class=textonly3>
<?php 
	$result4= mysql_query("select * from good_received where company='$company' and dat='$dat'");
	$num=mysql_affected_rows();
	if($num<10) $k=10-$num;
	if($num>=1) 
	{
		for($i=1;$i<=$num;$i++)
		{
			$row= mysql_fetch_array($result4);
			$dat=$row["dat"];
			$item_id=$row["item_id"];
			$des=$row["des"];
			$in_stock=$row["in_stock"];
			$width=$row["width"];
			$height=$row["height"];
			$price=$row["price"];
			$discount=$row["discount"];
			$total_amount=$row["total_amount"];
			$ord_no=$row["ord_no"];
			$status=$row["status"];
			$agg_total=$agg_total + $total_amount;
?>
              <td height="34" align="center"><?=$i?></td>
              <td align="center"><?php echo $des;?> (<?php echo $item_id;?>) </td>
              <td align="center"><?php echo $height?> X <?php echo $width;?></td>
              <td align="center">#<?php echo number_format($price);?></td>
              <td align="center"><strong>#
                    <?php echo number_format($total_amount);?>
              </strong></td>
		      </tr>
<?php 		}
		for($j=1;$j<=$k;$j++)
		{
?>
              <tr><td>&nbsp;</td>
			  <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><img src="images/none.jpg" width="100%" /></td>
<?php 
		}
 } 

else echo "<tr><td>There are no record found for $company</td></tr>"; 
	?>
			<tr class=textonly3>
			    <td height="44" colspan="3" align="center">&nbsp;</td>
			    <td height="44" align="center"><span class="style15">Total </span></td>
			    <td align="center"><span class="style15">#
			      <?php echo number_format($agg_total);?>
                </span></td>
			  </tr>
        </table>
          <table width="95%" height="56" border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td width="69%" valign="top"><p>&nbsp;</p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="27%"><p align="center"><span class="style18"><strong>______________________</strong><br />      
                          <strong>LARGE HEART</strong></span></p>
                      </td>
                    <td width="47%">&nbsp;</td>
                    <td width="26%"><div align="center"><span class="style18"><strong>______________________</strong><br />
                      <strong>SUPPLIER</strong></span></div></td>
                  </tr>
                </table></td>
              </tr>
          </table>
          </td>
      </tr>
    </table>      
      <hr /></td>
  </tr>
</table>
</body>
</html>
