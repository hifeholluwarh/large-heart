<?php

$action=$_GET['action'];
$id=$_GET['id'];
$Submit=$_POST['Submit'];

$company=$_POST['company'];
$address=$_POST['address'];
$phone=$_POST['phone'];
$email=$_POST['email'];

if($action=="delete")
{
	$msg= "Do you want to delete the selected <b>Clients Details</b>?
	<input type=Submit name=Submit id=Submit value='Confirm Delete'>
	<input type=Submit name=Submit id=Submit value='Cancel'> ";
}

if ($Submit == "Confirm Delete")
{
		$result=mysql_query("delete from clients where id='$id'");
		$msg= "The selected Client Details has been deleted";
}	
if ($Submit == "Cancel") $msg= "The delete operation cancelled";

if($Submit=="Add Client")
{
	if(!$company)
	{
	 	$msg="The Name/Company Field is required!";
    	}
	elseif(strpos($company,"&"))
	{
	 	$msg="An ampersand (&) is not allowed in Name/Company, use &quot;and&quot; instead.";
   	}
	else
	{
		$result=mysql_query("select * from clients where company='$company'");
		 $num_result=mysql_affected_rows();
		 if($num_result > 0)
		 {
		  	$msg="Sorry, Client with Name/Company &quot;$company&quot; already Exist! Try another."; 
		 }
		 else
		 {
	 		$result=mysql_query("insert into clients values('','$company','$address','$phone','$email')");
		  	$msg="Client Detail has been added!"; 
		 }
	}
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
-->
</style>
</head>

<body>
<table width="100%" height="181" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
   <td height="13" valign="middle" class="textonly3"><p align="center" class="title style6"><strong>Clients Setup          </strong></p>
          <hr /></td>
  </tr>
  <tr>
    <td height="157" align="center" valign="top"><form id="form1" name="form1" method="post" action="">
        <font color="#FF0000" face="Verdana, Arial, Helvetica, sans-serif" size="-1">
        <?php echo $msg;?>
        </font><br />
        <table width="441" height="191" border="0" align="center" cellpadding="0" cellspacing="0" class="textonly3">
          <tr>
            <td height="31" valign="middle"><div align="right"><strong>Name/Company *   </strong></div></td>
            <td valign="middle">
              <div align="left">
                <input name="company" type="text" class="inputs" id="company" value="<?php $company;?>" size="30"/>
              </div>            </td>
          </tr>
          <tr>
            <td height="39" valign="middle"><div align="right"><strong> Address * </strong></div></td>
            <td valign="middle">
              <div align="left">
                <textarea name="address" cols="30" class="inputs" id="address"><?php echo $address;?></textarea>
              </div>            </td>
          </tr>
          <tr>
            <td height="31" valign="middle"><div align="right"><strong>Phone Number *    </strong></div></td>
            <td valign="middle">
              <div align="left">
                <input name="phone" type="text" class="inputs" id="phone" value="<?php echo $phone;?>" size="30"/>
              </div>            </td>
          </tr>
          <tr>
            <td height="31" valign="middle"><div align="right"><strong>E-mail Address </strong></div></td>
            <td valign="middle">
              <div align="left">
                <input name="email" type="text" class="inputs" id="email" value="<?php echo $email;?>" size="30"/>
              </div>            </td>
          </tr>
          
          <tr>
            <td height="33" valign="middle">&nbsp;</td>
            <td valign="middle"><div align="left">
              <input name="Submit" type="submit" class="inputs-focus" value="Add Client" />
            </div></td>
          </tr>
        </table>
        <br />
    </form>
   <?php if($type!="Operator"){ ?>
      <table width="95%" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
        <tr bgcolor="green" class="textonly3">
          <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>S/N</strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Name/Company</strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Phone No. </strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>E-mail Address </strong></div></td>
		  <td align="center" bgcolor="#000" colspan="3"><div align="center" class="style9"><strong></strong></div></td>
        </tr>
<?php
	$result2= mysql_query("select * from clients order by company asc");
    $num_results=mysql_affected_rows();
	for($i=1; $i<=$num_results; $i++) 
   	{
		$rows= mysql_fetch_array($result2);
		echo "<tr class=textonly3><td>$i</td>";
		$company=$rows["company"];
		$id=$rows["id"];
		echo "<td>".$rows["company"]."</td>";
		//echo "<td>".$rows["address"]."</td>";
		echo "<td>".$rows["phone"]."</td>";
		echo "<td>".$rows["email"]."</td>";
		echo "<td align=center><a href='view_clients.php?id=$id' target='_blank'>
		<img src='images/Preview-icon.png' alt='Preview' width='22' height='22' border='0' /></td>";
		if($type!="Operator"){ echo "<td align=center><a href='main.php?page=edit_clients&id=$id'>
		<img src='images/edit-icon.png' alt='Edit Supplier' width='22' height='22' border='0' /></td>";
		echo "<td align=center><a href='main.php?page=setup_clients&action=delete&id=$id'>
		<img src='images/del-icon.png' alt='Delete' width='22' height='22' border='0' />
		</td>"; }
		echo "</tr>";
		
			}
?>
    </table>      
      <br />
   <?php } ?>    
      <?php if($type=="Super"){ ?>
      <table width="147" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="43" height="25" bgcolor="#FFFFFF"><a href="print_clients.php" target="_blank"><img src="images/Preview-icon.png" alt="Preview in Printable Format" width="42" height="42" border="0" /></a></td>
          <td width="63" bgcolor="#FFFFFF">&nbsp;</td>
          <td width="41" bgcolor="#FFFFFF"><a href="print_clients.php?download=<?php echo "$page".date('Ymdhms');?>"><img src="images/Download-Excel-icon.png" alt="Download in Excel Format" width="41" height="39" border="0" /></a></td>
        </tr>
      </table>
      <?php } ?>
      
	</td></tr>
</table>

<br />
</body>
</html>