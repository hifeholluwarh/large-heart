<?php
	session_start();
	require_once("funcs.php");
	conn(); 
	
	$id=$_GET['id'];
	
	$d=$_GET['d'];
	$m=$_GET['m'];
	$y=$_GET['y'];
	
	$res=mysql_query("select * from supplier where id='$id'");
	$num_result=mysql_affected_rows();
	$rw=mysql_fetch_array($res);
	$dat=$rw['dat'];
	$company=$rw['company'];
	$phone=$rw['phone'];
	$address=$rw['address'];
	$contact=$rw['contact'];
	$email=$rw['email'];
	$product=$rw['product'];
	$amt_supplied=$rw['amt_supplied'];
	$amt_balance=$rw['amt_balance'];
	$last_paid=$rw['last_paid'];
	$ldat=$rw['ldat'];
	$invoice_no=$rw['invoice_no'];

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
.style21 {font-size: 14px}
.style22 {font-size: 16px}
.style23 {font-size: 24px}
.style9 {color: #FFFFFF}
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
        <td align="center"><table width="100%" border="0" cellpadding="10" cellspacing="0">
            <tr>
              <td colspan="2" align="center" valign="top" bgcolor="#99FF99"><span class="style7"><span class="style23">
                <?php echo strtoupper($company);?></span></span></td>
              </tr>
            <tr>
              <td colspan="2" valign="top"><hr align="right" />
                <span class="style22"><strong>General Details
                </strong></span>
                <hr align="right" /></td>
              </tr>
            <tr>
              <td width="48%" valign="top"><div align="right"><span class="style21"><strong>Registered Date : </strong><br />              
              </span></div></td>
              <td width="52%" valign="top"><div align="left"><span class="style21">
                <?php echo $dat;?>
              </span></div></td>
            </tr>
            <tr>
              <td valign="top"><div align="right"><span class="style21"><strong>Address:</strong></span></div></td>
              <td valign="top"><div align="left"><span class="style21">
                <?php echo $address;?>
              </span> </div></td>
            </tr>
            <tr>
              <td valign="top"><div align="right"><span class="style21"><strong>Contact Person :</strong></span></div></td>
              <td valign="top"><div align="left"><span class="style21">
                <?php echo $contact;?>
              </span></div></td>
            </tr>
            <tr>
              <td valign="top"><div align="right"><span class="style21"><strong>Phone:</strong></span></div></td>
              <td valign="top"><div align="left"><span class="style21">
                <?php echo $phone;?>
              </span></div></td>
            </tr>
            <tr>
              <td valign="top"><div align="right"><span class="style21"><strong>E-mail Address :</strong></span></div></td>
              <td valign="top"><div align="left"><span class="style21">
                <?php echo $email;?>
                </span></div></td>
            </tr>
            <tr>
              <td valign="top">&nbsp;</td>
              <td valign="top"><a href='main.php?page=edit_supplier&id=<?php echo $id;?>'>
		<img src='images/edit-icon.png' alt='Edit Supplier' width='35' height='35' border='2' /></a>
        
        <a href='main.php?page=setup_supplier&action=delete&id=<?php echo $id;?>'>
		<img src='images/del-icon.png' alt='Delete Supplier' width='35' height='35' border='2' /></a>
        </td>
            </tr>
            </table>
          <table width="100%" height="25" border="0" cellpadding="5" cellspacing="0">
            <tr>
              <td width="76%" valign="top"></td>
              </tr>
            <tr>
              <td height="25" valign="top"><hr align="right" />
                <span class="style22"><strong>Supplied History </strong></span>
                <hr align="right" /></td>
            </tr>
            <tr>
              <td height="25" valign="top"><table width="100%" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
                <tr bgcolor="green" class="textonly3">
                  <td width="28" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>S/N</strong></div></td>
                  <td width="91" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Date </strong></div></td>
                  <td width="221" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Company Name </strong></div></td>
                  <td width="217" align="center" bgcolor="#000"><div align="center" class="style9"><strong>Goods Description</strong></div></td>
                  <td width="95" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Unit Price </strong></div></td>
                  <td width="103" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Size </strong></div></td>
                  <td width="144" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Total Amount </strong></div></td>
                  <td width="31" align="center" bgcolor="#000000" colspan="2"><div align="center" class="style9"><strong></strong></div></td>
                </tr>
                <?php
	
	echo $company;
	$result2= mysql_query("select * from good_received where company='$company' order by id desc");
    $num_results=mysql_affected_rows();
	if($num_results>=1)
	{
		for($i=1; $i<=$num_results; $i++) 
		{
			$rows= mysql_fetch_array($result2);
			echo "<tr><td>$i</td>";
			$id=$rows["id"];
			echo "<td>".$rows["dat"]."</td>";
			echo "<td>".$rows["company"]."</td>";
			echo "<td>".$rows["des"]." [".$rows["item_id"]."]</td>";
			echo "<td>".number_format($rows["price"],2)."</td>";
			echo "<td>".$rows["width"]." X ".$rows["height"]."</td>";
			echo "<td>".number_format($rows["total_amount"],2)."</td>";
			echo "<td align=center><a href='view_good_received.php?id=$id' target='_blank'>
			<img src='images/Preview-icon.png' alt='Preview' width='22' height='22' border='0' /></td>";
			echo "<td align=center><a href='main.php?page=good_received&action=delete&id=$id' title='Delete Goods Received'>
			<img src='images/del-icon.png' alt='Delete' width='22' height='22' border='0' /></td></tr>";
		}
	}
	else echo "<tr align='center'><td colspan='9'>There is no record for Today</td></tr>";
?>
            </table>
              <? if($type=="Super"){ ?>
              <table width="43" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                  <td width="43" height="25" bgcolor="#FFFFFF"><a href="main.php?page=r_good_received"><img src="images/Preview-icon.png" alt="Preview in Printable Format" width="42" height="42" border="0" /></a><a href="print_setup_item.php?download=excel" target="_blank"></a></td>
                </tr>
              </table>
              <? } ?>
              </td>
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
