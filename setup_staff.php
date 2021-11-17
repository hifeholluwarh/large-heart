<?php

$action=$_GET['action'];
$id=$_GET['id'];
$Submit=$_POST['Submit'];

$name=$_POST['name'];
$address=$_POST['address'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$post=$_POST['post'];
$salary=$_POST['salary'];

if($action=="delete")
{
	$msg= "Do you want to delete the selected <b>Staff Details</b>?
	<input type=Submit name=Submit id=Submit value='Confirm Delete'>
	<input type=Submit name=Submit id=Submit value='Cancel'> ";
}

if ($Submit == "Confirm Delete")
{
		$result=mysql_query("delete from staff where id='$id'");
		$msg= "The selected Staff Details has been deleted";
}	
if ($Submit == "Cancel") $msg= "The delete operation cancelled";

if($Submit=="Add Staff")
{
	if(!$name) $msg="The Name Field is required!";
	elseif(strpos($name,"&")) $msg="An ampersand (&) is not allowed in Name field, use &quot;and&quot; instead.";
	else
	{
		$result=mysql_query("select * from staff where name='$name'");
		$num_result=mysql_affected_rows();
		if($num_result > 0)
		{
		 	$msg="Sorry, Staff with Name &quot;$name&quot; already Exist! Try another."; 
		}
		else
		{
	 		$result=mysql_query("insert into staff values('','$name','$address','$phone','$email','$post','$salary')");
		  	$msg="Staff Detail successfully added!"; 
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
   <td height="13" valign="middle" class="textonly3"><p align="center" class="title style6"><strong>Staff/Worker Setup          </strong></p>
          <hr /></td>
  </tr>
  <tr>
    <td height="157" align="center" valign="top"><form id="form1" name="form1" method="post" action="">
        <font color="#FF0000" face="Verdana, Arial, Helvetica, sans-serif" size="-1">
        <?php echo $msg;?>
        </font><br />
        <table width="441" height="227" border="0" align="center" cellpadding="0" cellspacing="0" class="textonly3">
          <tr>
            <td height="31" valign="middle"><div align="right"><strong>Staff Name *   </strong></div></td>
            <td valign="middle">
              <div align="left">
                <input name="name" type="text" class="inputs" id="name" value="<?php echo $name;?>" size="30"/>
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
            <td valign="middle"><div align="left">
              <input name="email" type="text" class="inputs" id="email" value="<?php echo $email;?>" size="30"/>
            </div></td>
          </tr>
          <tr>
            <td height="31" valign="middle"><div align="right"><strong>Position </strong></div></td>
            <td valign="middle"><div align="left">
              <input name="post" type="text" class="inputs" id="post" value="<?php echo $post;?>" size="30"/>
            </div></td>
          </tr>
          <tr>
            <td height="31" valign="middle"><div align="right"><strong>Monthly Salary </strong></div></td>
            <td valign="middle">
              <div align="left">
                <input name="salary" type="text" class="inputs" id="salary" value="<?php echo $salary;?>" size="20"/>
              <strong><font face="Verdana, Arial, Helvetica, sans-serif" size="3"> (Naira)</font></strong></div>            </td>
          </tr>
          
          <tr>
            <td height="33" valign="middle">&nbsp;</td>
            <td valign="middle"><div align="left">
              <input name="Submit" type="submit" class="inputs-focus" value="Add Staff" />
            </div></td>
          </tr>
        </table>
        <br />
    </form>
      <table width="95%" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
        <tr bgcolor="green" class="textonly3">
          <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>S/N</strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Staff Name</strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Phone No. </strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>E-mail Address </strong></div></td>
          <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Position </strong></div></td>
          <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Salary (#) </strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong></strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong></strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong></strong></div></td>
        </tr>
<?php
	$result2= mysql_query("select * from staff");
    $num_results=mysql_affected_rows();
	for($i=1; $i<=$num_results; $i++) 
   	{
		$rows= mysql_fetch_array($result2);
		echo "<tr><td>$i</td>";
		$name=$rows["name"];
		$id=$rows["id"];
		echo "<td>".$rows["name"]."</td>";
		//echo "<td>".$rows["address"]."</td>";
		echo "<td>".$rows["phone"]."</td>";
		echo "<td>".$rows["email"]."</td>";
		echo "<td>".$rows["post"]."</td>";
		echo "<td align='right'>".number_format($rows["salary"],2)."</td>";
		echo "<td align=center><a href='view_staff.php?id=$id' target='_blank'>
		<img src='images/Preview-icon.png' alt='Preview' width='22' height='22' border='0' /></td>";
		echo "<td align=center><a href='main.php?page=edit_staff&id=$id'>
		<img src='images/edit-icon.png' alt='Edit Supplier' width='22' height='22' border='0' /></td>";
		echo "<td align=center><a href='main.php?page=setup_staff&action=delete&id=$id'>
		<img src='images/del-icon.png' alt='Delete' width='22' height='22' border='0' /></td></tr>";
		
			}
?>
    </table>      
      <br />
      <table width="147" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="43" height="25" bgcolor="#FFFFFF"><a href="print_staff.php" target="_blank"><img src="images/Preview-icon.png" alt="Preview in Printable Format" width="42" height="42" border="0" /></a></td>
          <td width="63" align="center" bgcolor="#FFFFFF">&nbsp;</td>
          <td width="41" bgcolor="#FFFFFF"><a href="print_staff.php?download=<?php echo "$page".date('Ymdhms');?>"><img src="images/Download-Excel-icon.png" alt="Download in Excel Format" width="41" height="39" border="0" /></a></td>
        </tr>
      </table>
    <p>&nbsp;</p></td></tr>
</table>
<br />
</body>
</html>
