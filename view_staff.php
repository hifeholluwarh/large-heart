<?php
	session_start();
	require_once("funcs.php");
	conn(); 
	
	$id=$_GET['id'];
	

	
	$res=mysql_query("select * from staff where id='$id'");
	$num_result=mysql_affected_rows();
	$rw=mysql_fetch_array($res);
	$name=$rw['name'];
	$address=$rw['address'];
	$phone=$rw['phone'];
	$email=$rw['email'];
	$post=$rw['post'];
	$salary=$rw['salary'];

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
                <?=strtoupper($name)?></span></span></td>
              </tr>
            <tr>
              <td colspan="2" valign="top"><hr align="right" />
                <span class="style22"><strong>General Details
                  </strong></span>
                <hr align="right" /></td>
            </tr>
            <tr>
              <td width="48%" valign="top"><div align="right"><span class="style21"><strong>Address:</strong></span></div></td>
              <td width="52%" valign="top"><div align="left"><span class="style21">
                <?php echo $address;?>
                </span> </div></td>
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
              <td valign="top"><div align="right"><span class="style21"><strong>Position :</strong></span></div></td>
              <td valign="top"><div align="left"><span class="style21">
                <?php echo $post;?>
              </span></div></td>
            </tr>
            <tr>
              <td valign="top"><div align="right"><span class="style21"><strong>Basic Salary :</strong></span></div></td>
              <td valign="top"><div align="left"><span class="style21">
                <?php echo number_format($salary,2);?> Naira
                </span></div></td>
            </tr>
            <tr>
              <td valign="top">&nbsp;</td>
              <td valign="top"><a href='main.php?page=edit_staff&id=<?=$id?>'>
		<img src='images/edit-icon.png' alt='Edit Supplier' width='35' height='35' border='2' /></a>
        
        <a href='main.php?page=setup_staff&action=delete&id=<?php echo $id;?>'>
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
                <span class="style22"><strong>Salary Payment  History </strong></span>
                <hr align="right" /></td>
            </tr>
            <tr>
              <td height="25" valign="top"><table width="95%" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
                <tr bgcolor="green" class="textonly3">
                  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>S/N</strong></div></td>
                  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Month </strong></div></td>
                  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Basic Pay</strong></div></td>
                  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Extra </strong></div></td>
                  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Net Pay </strong></div></td>
                  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong></strong></div></td>
                </tr>
                <?php
	$result2= mysql_query("select * from staff_salary where name='$name' order by id desc");
    $num_results=mysql_affected_rows();
	for($i=1; $i<=$num_results; $i++) 
   	{
		$rows= mysql_fetch_array($result2);
		echo "<tr><td>$i</td>";
		$name=$rows["name"];
		$month=$rows["m"].", ".$rows["y"];
		$id=$rows["id"];
		echo "<td>$month</td>";
		echo "<td>".number_format($rows["salary"],2)."</td>";
		echo "<td>".number_format($rows["extra"],2)."</td>";
		echo "<td>".number_format($rows["netpay"],2)	."</td>";
		echo "<td align=center><a href='main.php?page=staff_salary&action=delete&id=$id&mnth=$month'>
		<img src='images/del-icon.png' alt='Delete' width='22' height='22' border='0' />
		</td></tr>";
		
			}
?>
              </table>
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
