<?php

$action=$_GET['action'];
$id=$_GET['id'];
$Submit=$_POST['Submit'];
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$type=$_POST['type'];
$user=$_POST['user'];
$pass=$_POST['pass'];
$cpass=$_POST['cpass'];

if($action=="delete")
{
	$msg= "Do you want to delete the selected <b>User</b>?
	<input type=Submit name=Submit id=Submit value='Confirm Delete'>
	<input type=Submit name=Submit id=Submit value='Cancel'> ";
}

if ($Submit == "Confirm Delete")
{
		$result=mysql_query("delete from admin where id='$id'");
		$msg= "The selected Admin has been deleted";
}	
if ($Submit == "Cancel") $msg= "The delete operation cancelled";

if($Submit=="Add Admin")
{
	if(!$fname || !$lname || !$user || !$pass)
	{
	 	$msg="You have not enter the required details! All fields are reqiuired";
    }
	elseif($pass <> $cpass)
	{
	 	$msg="The Passwords are not the same!";
    }
	else
	{
		$result=mysql_query("select * from admin where user='$user'");
		 $num_result=mysql_affected_rows();
		 if($num_result > 0)
		 {
		  	$msg="Sorry, User Already Exist!"; 
		 }
		 else
		 {
		  	$result=mysql_query("insert into admin values ('','$fname','$lname','$user','$pass','$type')");
		  	$msg="Admin Account Created!"; 
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
   <td height="13" valign="middle" class="textonly3"><p align="center" class="title style6"><strong>Admin Setup</strong></p>
          <hr /></td>
  </tr>
  <tr>
    <td height="157" align="center" valign="top"><form id="form1" name="form1" method="post" action="">
        <font color="#FF0000" face="Verdana, Arial, Helvetica, sans-serif" size="-1">
        <?php echo $msg;?>
        </font><br />
        <table width="400" height="226" border="0" align="center" cellpadding="0" cellspacing="5" class="textonly3">
          <tr>
            <td height="26" valign="middle"><div align="right"><strong>First Name :</strong></div></td>
            <td valign="middle"><label>
            
              <div align="left">
                <input name="fname" type="text" class="inputs" id="fname" value="<?php echo $fname;?>"/>
              </div>
            </label></td>
          </tr>
          <tr>
            <td height="26" valign="middle"><div align="right"><strong>Last Name :</strong></div></td>
            <td valign="middle"><label>
            
              <div align="left">
                <input name="lname" type="text" class="inputs" id="lname" value="<?php echo $lname;?>"/>
              </div>
            </label></td>
          </tr>
          
          
          <tr>
            <td width="153" height="26" valign="middle"><div align="right"><strong>Username:</strong></div></td>
            <td width="232" valign="middle"><label>
            
              <div align="left">
                <input name="user" type="text" class="inputs" id="user" value="<?php echo $user;?>"/>
              </div>
            </label></td>
          </tr>
          <tr bordercolor="#9999FF">
            <td height="29" valign="middle"><div align="right"><strong>Password:</strong></div></td>
            <td valign="middle"><label></label>              
              <div align="left">
                <input name="pass" type="password" class="inputs" id="pass" value="<?php echo $pass;?>"/>            
              </div></td>
          </tr>
          <tr bordercolor="#9999FF">
            <td height="29" valign="middle"><div align="right"><strong>Confirm:</strong></div></td>
            <td valign="middle"><label></label>              
              <div align="left">
                <input name="cpass" type="password" class="inputs" id="cpass" value="<?php echo $cpass;?>"/>            
              </div></td>
          </tr>
          <tr>
            <td height="26" valign="middle"><div align="right"><strong>Type:</strong></div></td>
            <td valign="middle"><label>
            
              <div align="left">
                  <select name="type" class="inputs" id="type">
                    <option value="Operator">Operator</option>
                    <option value="Ordinary">Ordinary</option>
                    <option value="Supervisor">Supervisor</option>
                    <option value="Super">Super</option>
                  </select>
              </div>
            </label></td>
          </tr>
          
          <tr>
            <td height="24" valign="middle"><span class="style2"></span></td>
            <td valign="middle"><label>
              
              <div align="left">
                <input name="Submit" type="submit" class="inputs-focus" value="Add Admin" />
              </div>
            </label></td>
          </tr>
        </table>
        <hr />
    </form>
      <table width="700" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
        <tr bgcolor="green" class="textonly3">
          <td width="35" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>S/N</strong></div></td>
		  <td width="101" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>First Name</strong></div></td>
          <td width="93" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Last Name</strong></div></td>
          <td width="116" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Username</strong></div></td>
		  <td width="140" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Password</strong></div></td>
		  <td width="74" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>User Type</strong></div></td>
          <td width="55" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Action</strong></div></td>
        </tr>
<?php
	$result2= mysql_query("select * from admin");
    $num_results=mysql_affected_rows();
	for($i=1; $i<=$num_results; $i++) 
   	{
		$rows= mysql_fetch_array($result2);
		echo "<tr class=textonly3><td>$i</td>";
		echo "<td>".$rows["fname"]."</td>";
		echo "<td>".$rows["lname"]."</td>";
		echo "<td>".$rows["user"]."</td>";
		echo "<td>".$rows["pass"]."</td>";
		$id=$rows["id"];
		echo "<td>".$rows["type"]."</td>";
		echo "<td align=center><a href='main.php?page=admin_setup&action=delete&id=$id' class='textonly1'>
		<img src='images/del-icon.png' alt='Delete' width='22' height='22' border='0' /></td></tr>";
	}
?>
    </table>      
      <p>&nbsp;</p></td></tr>
</table>
<br />
</body>
</html>