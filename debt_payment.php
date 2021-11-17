<?php
$action=$_GET['action'];
$id=$_GET['id'];

$Submit=$_POST['Submit'];

$item_id=$_POST['item_id'];
$amount=$_POST['amount'];
$paid=$_POST['paid'];
$client=$_POST['client'];
$d_dat=$_POST['d_dat'];
$ord_no=$_POST['ord_no'];

if($action=="delete")
{
	$msg= "Do you want to delete the selected <b>Item/Product</b>?
	<input type=Submit name=Submit id=Submit value='Confirm Delete'>
	<input type=Submit name=Submit id=Submit value='Cancel'> ";
}

if ($Submit == "Confirm Delete")
{
		$result=mysql_query("delete from items where id='$id'");
		$msg= "The selected Item/Product has been deleted";
		$hide="yes";
}	
elseif ($Submit == "Cancel") $msg= "The delete operation cancelled";

if($Submit=="Make Payment")
{
	$balance=$amount-$paid;
	$dat=date("Y-m-d");
			
	$result=mysql_query("select * from debt_payment where dat='$dat' and item_id='$item_id' and total_amount='$amount' 
	and dat='$dat' and balance='$balance' and amount_paid='$paid'");
	echo $num=mysql_affected_rows();
	if($num>=1) $msg="Debt Payment Record already exist";
	else
	{
		$result=mysql_query("insert into debt_payment values('','$dat','$item_id','$amount','$paid','$balance','$client','$loguser','$ord_no')");
		if($result)
		{	
			$balance=$amount-$paid;
			
			$r=mysql_query("delete from debt where ord_no='$ord_no'");
			if($balance>0)
			{
				$result6=mysql_query("insert into debt values('','$dat','$item_id','$amount','$paid','$balance','$client','$ord_no')");
			}
					
			$msg="Debt Payment Detail was successful!";
			$id="";
		}
	}
}

if($id)
{
	$result=mysql_query("select * from debt where id='$id'");
	$num_result=mysql_affected_rows();
	$row=mysql_fetch_array($result);
	$dat=$row["dat"];
	$item_id=$row["item_id"];
	$amount=$row["balance"];
	$client=$row["ord_by"];
	$ord_no=$row["ord_no"];
	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style9 {color: #FFFFFF}
-->
</style>
<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style6 {font-size: 16px}
.style10 {font-weight: bold}
.style11 {font-weight: bold}
.style12 {
	font-size: 18px;
	font-weight: bold;
}
.style13 {font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="100%" height="181" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
   <td height="13" valign="middle" class="textonly3"><p align="center" class="title style6"><strong>Debt Payment</strong></p>
          <hr /></td>
  </tr>
  <tr>
    <td height="157" align="center" valign="top"><form id="form1" name="form1" method="post" action="">
        <font color="#FF0000" face="Verdana, Arial, Helvetica, sans-serif" size="-1">
        <?php echo $msg;?>
        </font><br />
        <table width="478" border="0" align="center" cellpadding="0" cellspacing="0" class="textonly3">
          <tr>
            <td height="38" valign="middle"><div align="right"><strong>Debt Date : </strong></div></td>
            <td align="left" valign="middle"><div align="left">&nbsp;&nbsp;&nbsp;<span class="style12">
              <?php echo $dat;?></span><strong>
              <input name="d_dat" type="hidden" id="d_dat" value="<?php echo $d_dat;?>" />
            </strong></div></td>
          </tr>
          <tr>
            <td height="38" valign="middle"><div align="right"><strong>Client Name   : </strong></div></td>
            <td align="left" valign="middle"><div align="left"><span class="style12">&nbsp;&nbsp;
              <?php echo $client;?>
            </span><strong>
            <input name="client" type="hidden" id="client" value="<?php echo $client;?>" />
            </strong><strong>
            <input name="ord_no" type="hidden" id="ord_no" value="<?php echo $ord_no;?>" />
            </strong></div></td>
          </tr>
          <tr>
            <td height="38" valign="middle"><div align="right"><strong>Printing/Job : </strong></div></td>
            <td align="left" valign="middle"><div align="left">
              <input name="item_id" type="text" class="inputs" id="item_id" value="<?php echo $item_id;?>" size="40" />
            </div></td>
          </tr>
          <tr>
            <td height="38" valign="middle"><div align="right"><strong>Expected Amount   : </strong></div></td>
            <td align="left" valign="middle"><div align="left">
              <input name="amount" type="text" class="inputs" id="amount" value="<?php echo $amount;?>" size="15"/>
              <span class="style12">Naira/Ft.</span></div></td>
          </tr>
          <tr>
            <td height="38" valign="middle"><div align="right"><strong>Amount Paid   : </strong></div></td>
            <td align="left" valign="middle"><div align="left">
              <input name="paid" type="text" class="inputs" id="paid" value="<?php echo $paid;?>" size="15"/>
              <span class="style12">Naira/Ft.</span></div></td>
          </tr>
          <tr>
            <td width="168" height="38" valign="middle">&nbsp;</td>
            <td width="310" align="left" valign="middle"><div align="left">
              <input name="Submit" type="submit" class="inputs-focus" value="Make Payment" />
            </div></td>
          </tr>
        </table>
    </form>
      <hr />
		  <span class="style10 style6">List of Dept Payments	  </span>
          <table width="95%" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
       <tr bgcolor="green" class="textonly3">
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>S/N</strong></div></td>
		  <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Date</strong></div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Customer</strong></div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Material</strong></div></td>
		  <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Inv. No.</strong></div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Total Amount(#)</strong></div></td>
		  <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Amount Paid(#)</strong></div></td>
		  <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong> Balance(#) </strong></div></td>
        </tr>
<?php
	$id_color=$id;
	$dat=date("Y-m-d");
	$result2= mysql_query("select * from debt_payment where dat='$dat' order by id");
    $num_results=mysql_affected_rows();
	for($i=1; $i<=$num_results; $i++) 
   	{
		$rows= mysql_fetch_array($result2);
		echo "<tr class=textonly3 align='center'><td>$i</td>";
			echo "<td>".$rows["dat"]."</td>";
			$ord_by=$rows["paid_by"];
	
			echo "<td>$ord_by</td>";
			echo "<td>".$rows["item_id"]."</td>";
			echo "<td>".$rows["ord_no"]."</td>";
			//echo "<td>".$rows["des"]."</td>";
			echo "<td>".number_format($rows["total_amount"])."</td>";
			echo "<td>".number_format($rows["amount_paid"])."</td>";
			echo "<td>".number_format($rows["balance"])."</td></tr>";
			
			$total_dept=$total_dept+$rows["balance"];
	}
?>
    </table></td>
  </tr>
</table>
<br />
</body>
</html>
