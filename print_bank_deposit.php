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
            <tr bgcolor="green" >
              <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>S/N</strong></div></td>
              <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Deposit Date</strong></div></td>
              <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Bank Name</strong></div></td>
              <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Depositor's Name</strong></div></td>
              <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Amount Deposited (#)</strong></div></td>
              <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Teller Number</strong></div></td>
              <td align="center" bgcolor="#000"><div align="center" class="style9"><strong></strong></div></td>
            </tr>
            <?php
			
			if($cat) 
					{
						if($rept=="aa") $add_this="where acct_name='$cat'";
						else $add_this="and acct_name='$cat'";
						$dcat="$cat Bank Deposits";
					}
				else $dcat="Bank Deposits";
				
	$datd="$y-$m1-$d"; $datm="$y-$m1"; $daty="$y";
	$tb_name="account_record";
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
			echo "<tr><td>$i</td>";
			$id=$rows["id"];
			$amount=$rows["amount"];
			echo "<td>".$rows["dat"]."</td>";
			echo "<td>".$rows["acct_name"]."</td>";
			echo "<td>".$rows["depositor"]."</td>";
			echo "<td align='center'>".number_format($rows["amount"],2)."</td>";
			echo "<td>".$rows["teller"]."</td>";
			echo "<td align=center><a href='main.php?page=bank_deposit&action=delete&id=$id'>
			<img src='images/del-icon.png' alt='Delete Deposit' width='22' height='22' border='0' /></a></td></tr>";
			
			$total_amount+=$amount;
		}
		?>
            <tr bgcolor="green">
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><b>Total Sales</b></td>
              <td align="center"><b>
                <?php echo number_format($total_amount,2);?>
              </b></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
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
