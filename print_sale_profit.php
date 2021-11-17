<?php
$download=$_GET['download'];
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
	$start=$_GET['start'];  $end=$_GET['end']; $cat=$_GET['cat']; $item_id=$_GET['item_id'];
	
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
.style10 {font-size: 10px}
.style15 {font-size: 14px; font-weight: bold; }
.style9 {color: #FFFFFF}
-->
</style>
</head>

<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td valign="top"><? include ("header2.php"); ?></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="5">
      <tr>
        <td align="center"><p class="style7"><?php echo $hd;?></p>
          <table width="100%" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
            <tr bgcolor="green" class="textonly3">
              <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>S/N</strong></div></td>
              <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Date</strong></div></td>
              <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Customer</strong></div></td>
              <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Material</strong></div></td>
              <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Total Sales(#)</strong></div></td>
              <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Total Cost(#)</strong></div></td>
              <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Profit(#)</strong></div></td>
            </tr>
            <?php
			
			if($cat and !$item_id) 
					{
						if($rept=="aa") $add_this="where ord_by='$cat'";
						else $add_this="and ord_by='$cat'";
						$dcat="$cat Ordered";
					}
				elseif(!$cat and $item_id) 
					{
						if($rept=="aa") $add_this="where item_id='$item_id'";
						else $add_this="and item_id='$item_id'";
						$dcat="$item_id Ordered";
					}
				elseif($cat and $item_id) 
					{
						if($rept=="aa") $add_this="where ord_by='$cat' and item_id='$item_id'";
						else $add_this="and ord_by='$cat' and item_id='$item_id'";
						$dcat="$cat Ordered with ID [$item_id]";
					}
				else $dcat="Printed Items";
				
	$datd="$y-$m1-$d"; $datm="$y-$m1"; $daty="$y";
	$tb_name="good_ordered";
	if(!$rept or $rept=='dd') $sql="select * from $tb_name where dat='$datd' $add_this order by dat $st";
	elseif($rept=='mm') $sql= "select * from $tb_name where substring(dat,1,7)='$datm' $add_this order by dat $st";
	elseif($rept=='yy') $sql= "select * from $tb_name where substring(dat,1,4)='$daty' $add_this order by dat $st";
	elseif($rept=='aa') $sql="select * from $tb_name $add_this order by dat $st";
	elseif($rept=='ww') $sql="select * from $tb_name where dat BETWEEN '$start' AND '$end' $add_this order by dat $st";
	
	$result2=mysql_query($sql);
    $num_results=mysql_affected_rows();
	if($num_results>=1)
	{
		for($i=1; $i<=$num_results; $i++) 
		{
			$rows= mysql_fetch_array($result2);
			echo "<tr class=textonly3 align='center'><td>$i</td>";
			echo "<td>".$rows["dat"]."</td>";
			$optname=$rows["optname"];
			$customer=$rows["ord_by"];
			
			$r5=mysql_query("select * from clients where company='$customer'");
   			$row5=mysql_fetch_array($r5);
			//$customer=$["customer"];
			$phone=$row5["phone"];
			$address=$row5["address"];
			
			$id=$rows["id"];
			$ord_by=$rows["ord_by"];
			$dat=$rows["dat"];			
			echo "<td><a href='view_item_ordered.php?id=$id' title='Tel: $phone | Address: $address' target='_blank'>$customer</td>";
			echo "<td>".$rows["item_id"]."</td>";
			//echo "<td>".$rows["des"]."</td>";
			
			$in_stock=$rows["in_stock"];
			$now_stock=$rows["now_stock"];
			$area=$rows["width"]*$rows["height"];
			$total_cost=$rows["qty"]*$area*$rows["price"];
			$total_sales=$rows["qty"]*$area*$rows["sale_price"];
			$profit=$total_sales-$total_cost;
			echo "<td>".number_format($total_sales,2)."</td>";
			echo "<td>".number_format($total_cost,2)."</td>";
			echo "<td>".number_format($profit,2)."</td></tr>";
			
			$agg_total_cost=$agg_total_cost+$total_cost;
			$agg_total_sales=$agg_total_sales+$total_sales;
			$agg_profit=$agg_profit+$profit;
			
		}
		?>
            <tr bgcolor="green" class="textonly3">
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><b>Total Sales</b></td>
              <td align="center"><b>
                <?php echo number_format($agg_total_sales,2);?>
              </b></td>
              <td align="center"><b>
                <?php echo number_format($agg_total_cost,2);?>
              </b></td>
              <td align="center"><b>
                <?php echo number_format($agg_profit,2);?>
              </b></td>
            </tr>
            <?php
	}
	else echo "<tr><td colspan='11'><center>No Record Found</td></tr>";
?>
          </table></td>
      </tr>
    </table>      
    </td>
  </tr>
</table>
</body>
</html>
