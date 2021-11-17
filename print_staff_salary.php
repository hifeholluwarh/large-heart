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
	
	$m=$_GET['m'];	$y=$_GET['y'];
	
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
<?php
	if(!$m) $hd="Salary Payment of Staff in the Year $y";
	else $hd="Salary Payment of Staff in the Month of $m, $y";
?>
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
              <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>S/N</strong></div></td>
              <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Name/Company</strong></div></td>
              <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Phone No. </strong></div></td>
              <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>E-mail Address </strong></div></td>
              <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Basic Salary </strong></div></td>
              <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Extra Pay </strong></div></td>
              <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Net Pay </strong></div></td>
              <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Paid By </strong></div></td>
              
            </tr>
           
            <?php
	if(!$m) $result2= mysql_query("select * from staff_salary where y='$y'");
	else $result2= mysql_query("select * from staff_salary where y='$y' and m='$m'");
    $num_results=mysql_affected_rows();
	for($i=1; $i<=$num_results; $i++) 
   	{
		$rows= mysql_fetch_array($result2);
		echo "<tr><td>$i</td>";
		$name=$rows["name"];
		$id=$rows["id"];
		echo "<td>".$rows["name"]."</td>";
		echo "<td>".$rows["phone"]."</td>";
		echo "<td>".$rows["email"]."</td>";
		echo "<td align='right'>".number_format($rows["salary"],2)."</td>";
		echo "<td align='right'>".number_format($rows["extra"],2)."</td>";
		echo "<td align='right'>".number_format($rows["netpay"],2)."</td>";
		echo "<td>".$rows["paid_by"]."</td></tr>";
		
		$total_basic+=$rows["salary"];
		$total_extra+=$rows["extra"];
		$total_net+=$rows["netpay"];
	}
?>
 			<tr bgcolor="green" class="textonly3">
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><b>Total Salary Payment</b></td>
              <td align="right"><b>
                <?php echo number_format($total_basic,2);?>
              </b></td>
              <td align="right"><b>
                <?php echo number_format($total_extra,2);?>
              </b></td>
              <td align="right"><b>
                <?php echo number_format($total_net,2);?>
              </b></td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
      </tr>
    </table>      
    </td>
  </tr>
</table>
</body>
</html>
