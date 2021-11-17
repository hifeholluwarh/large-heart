<?php
$download=$_GET['download'];
$show=$_GET['show'];
$shelf=$_GET['shelf'];

if($download)
{
	$filename ="$download.xls";
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename='.$filename);
}	
	session_start();
	require_once("funcs.php");
	conn(); 
	
	$d=$_GET['d']; $m1=$_GET['m1'];	$y=$_GET['y'];	$hd=$_GET['hd'];  $rept=$_GET['rept'];  $st=$_GET['st']; 
	$start=$_GET['start'];  $end=$_GET['end']; $cat=$_GET['cat'];  $item_id=$_GET['item_id'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="images/favicon.png" type="image/x-icon" />
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Large Heart - Daily Operation Record</title>

<? if(!$download) { ?> <link href="style.css" rel="stylesheet" type="text/css" /> <? } ?>
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
.style9 {color: #FFFFFF}
-->
</style>

</head>

<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
 <tr>
    <td valign="top"> <? include ("header2.php"); ?></td>
  </tr> 
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="5">
      <tr>
        <td align="center"><p class="style7">List of Stocked Materials </p>
          <table width="100%" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
            <tr bgcolor="green" class="textonly3">
         <td width="27" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>S/N</strong></div></td>
         <td width="70" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Item ID</strong></div></td>
         <td width="123" align="center" bgcolor="#00000"><div align="center" class="style9"><strong>Description</strong></div></td>
         <td width="74" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>In Stock (Sqr. Ft.)</strong></div></td>
		 <td width="66" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Cost Price</strong></div></td>
		 <td width="70" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Total Amt </strong></div></td>
         </tr>
<?php
	$result2= mysql_query("select * from items order by id");
    $num_results=mysql_affected_rows();
	if($num_results>=1)
	{
		for($i=1; $i<=$num_results; $i++) 
		{
			$rows= mysql_fetch_array($result2);
			echo "<tr class=textonly3><td>$i</td>";
			$id=$rows["id"];
			$in_stock=$rows["in_stock"];
			$price=$rows["price"];
			echo "<td>".$rows["item_id"]."</td>";
			echo "<td>".$rows["des"]."</td>";
			echo "<td>".number_format($rows["in_stock"])."</td>";
			echo "<td  align='right'>".number_format($rows["price"],2)."</td>";
			$amount=$price*$in_stock;
			echo "<td  align='right'>".number_format($amount,2)."</td>";
			$total_stock=$total_stock+$in_stock;
			$total_price=$total_price+$price;
			$total_amount=$total_amount+$amount;
		}
	}
	else echo "<tr class=textonly3 align='center'><td colspan='9'>Their are no Materials to display</td></tr>";
	
?>
            <tr class="textonly3">
              <td colspan="9"><hr /></td>
              </tr>
            <tr class="textonly3">
              <td colspan="2">&nbsp;</td>
              <td bgcolor="#CCCCCC"><div align="center"><strong>Total</strong></div></td>
              <td bgcolor="#CCCCCC"><div align="center"><strong>
                <?php echo number_format($total_stock);?> <? if($cat) echo $rows['unit']; else echo "Items"; ?>
              </strong></div></td>
              <td bgcolor="#CCCCCC"><div align="right"><strong>
                #<?php echo number_format($total_price,2);?>
              </strong></div></td>
			  <td bgcolor="#CCCCCC"><div align="right"><strong>
                #<?php echo number_format($total_amount,2);?>
              </strong></div></td>
            </tr>
          </table></td>
      </tr>
    </table>      
    </td>
  </tr>
</table>
</body>
</html>
