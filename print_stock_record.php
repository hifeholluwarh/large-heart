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
.style9 {color: #FFFFFF}
.style10 {
	color: #000000;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td valign="top"><? include ("header2.php"); ?></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="5">
      <tr>
        <td align="center"><p class="style7"><?php echo $hd;?></p>
          <table width="793" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
        <tr bgcolor="green" class="textonly3">
          <td width="24" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>S/N</strong></div></td>
		  <td width="70" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Date</strong></div></td>
          <td width="59" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Item ID</strong></div></td>
		  <td width="123" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Description</strong></div></td>
		  <td width="77" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Job Area</strong></div></td>
		  <td width="74" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Price</strong></div></td>
		  <td width="72" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Total Amt.</strong></div></td>
        </tr>
<?php
	 			if($item_id) 
					{
						if($rept=="aa") $add_this="where item_id='$item_id'";
						else $add_this="and item_id='$item_id'";
						$dcat="Stock with Item ID [$item_id]";
					}
				else $dcat="Goods in Stock";
				
	$datd="$y-$m1-$d"; $datm="$y-$m1"; $daty="$y";
	$tb_name="stock_record";
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
			$ord_no=$rows["ord_no"];
			$now_stock=$rows["now_stock"];
			$user=$rows["user"];
		   	echo "<tr class=textonly3 align='center' title='Order No: $ord_no\nNow in Stock: $now_stock\nLogin As: $user'><td>$i</td>";
			echo "<td>".$rows["dat"]."</td>";
			$optname=$rows["optname"];
			echo "<td>".$rows["item_id"]."</td>";
			echo "<td>".$rows["des"]."</td>";
			$id=$rows["id"];
			$price=$rows["price"];
			$in_stock=$rows["in_stock"];
			$qty=$rows["area"];
			$amount=$qty*$price;
			
			if ($in_stock<=$now_stock) 
			{
				
				echo "<td>".number_format($qty)." Sqr. Ft.</td>"; 
				$qty_in=$qty_in+$qty; $price_in=$price; $amount_in=$amount_in+$amount; 
				$total_amount=$total_amount-$amount;
			}
			else 
			{
				
				echo "<td>(".number_format($qty).") Sqr. Ft.</td>"; 
				$qty_out=$qty_out+$qty; $price_out=$price; $amount_out=$amount_out+$amount; 
				$total_amount=$total_amount+$amount;
			}

			echo "<td align='right'>".number_format($rows["price"],2)."</td>";
			echo "<td align='right'>".number_format($amount,2)."</td>";	
			
			$total_qty=$total_qty+$qty;
			$total_price=$total_price+$price;
			//$total_amount=$total_amount+$amount;
			//$total_amount=$total_amount+$amount;
		}
	}
	else echo "<tr><td colspan='11'><center>No Record Found</td></tr>";
?>
            <tr class="textonly3">
              <td colspan="9"><hr /></td>
              </tr>
            <tr class="textonly3">
              <td colspan="3">&nbsp;</td>
              <td bgcolor="#CCCCCC"><div align="center"><strong>Total</strong></div></td>
              <td bgcolor="#CCCCCC" title='<?php echo "Items In: $in \nItems Out: $out"; ?>'>&nbsp;</td>
              <td bgcolor="#CCCCCC">&nbsp;</td>
			  <td bgcolor="#CCCCCC"><div align="right"><strong>
                #<?php echo number_format($total_amount,2);?>
              </strong></div></td>
            </tr>
          </table>
          <br />
          <table width="496" border="1" cellpadding="5" cellspacing="0" bordercolor="#000000">
            <tr>
              <td width="117" bgcolor="#000000"><div align="center"><span class="style9"><strong>Summary</strong></span></div></td>
              <td width="152" bgcolor="#CCCCCC"><div align="center"><strong>Quantity</strong></div></td>
              <td width="135" bgcolor="#CCCCCC"><div align="center"><strong>Total Amount </strong></div></td>
            </tr>
            <tr>
              <td bgcolor="#CCCCCC"><span class="style10">Items in </span></td>
              <td><div align="center"><span class="style7">
                <?php echo number_format($qty_in);?>
              </span></div></td>
              <td><div align="right"><span class="style7">
                <?php echo number_format($amount_in,2);?>
              </span></div></td>
            </tr>
            <tr>
              <td bgcolor="#CCCCCC"><span class="style10">Items Out </span></td>
              <td><div align="center"><span class="style7">
                <?php echo number_format($qty_out);?>
                </span></div></td>
              <td><div align="right"><span class="style7">
                <?php echo number_format($amount_out,2);?>
                </span></div></td>
            </tr>
            </table>
          <p>&nbsp;</p></td>
      </tr>
    </table>      
    </td>
  </tr>
</table>
</body>
</html>
