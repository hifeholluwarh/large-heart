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
	$start=$_GET['start'];  $end=$_GET['end']; $cat=$_GET['cat'];
	
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
              <td width="20" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>S/N</strong></div></td>
              <td width="53" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Date</strong></div></td>
              <td width="81" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Company </strong></div></td>
              <td width="60" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Item ID</strong></div></td>
              <td width="114" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Description</strong></div></td>
              <td width="58" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Unit Price(#) </strong></div></td>
              <td width="63" align="center" bgcolor="#000"><div align="center" class="style9"><strong>Size</strong></div></td>
              <td width="58" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Amount</strong>(#)</div></td>
              <td width="57" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Order</strong></div></td>
              <td width="57" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Received by</strong></div></td>
            </tr>
            <?php
			
			if($cat and !$item_id) 
					{
						if($rept=="aa") $add_this="where company='$cat'";
						else $add_this="and company='$cat'";
						$dcat="$cat Received";
					}
				elseif($cat and $item_id) 
					{
						if($rept=="aa") $add_this="where company='$cat' and item_id='$item_id'";
						else $add_this="and company='$cat' and item_id='$item_id'";
						$dcat="$cat Received with ID [$item_id]";
					}
				elseif(!$cat and $item_id) 
					{
						if($rept=="aa") $add_this="where item_id='$item_id'";
						else $add_this="and item_id='$item_id'";
						$dcat="$cat Received with ID [$item_id]";
					}
				else $dcat="Materials Received";
				
	$datd="$y-$m1-$d"; $datm="$y-$m1"; $daty="$y";
	$tb_name="good_received";
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
			echo "<td><b>".$rows["company"]."</td>";
			$optname=$rows["optname"];
			echo "<td>".$rows["item_id"]."</td>";
			echo "<td>".$rows["des"]."</td>";
			$id=$rows["id"];
			$in_stock=$rows["in_stock"];
			$now_stock=$rows["now_stock"];
			echo "<td>".number_format($rows["price"])."</td>";
			echo "<td>".$rows["width"]." X ".$rows["height"]."</td>";
			echo "<td>".number_format($rows["total_amount"])."</td>";
			echo "<td>".$rows["ord_no"]."</td>";
			echo "<td>".$rows["receive_by"]."</td>";		
		}
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
