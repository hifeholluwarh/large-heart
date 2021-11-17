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
	$msg= "Do you want to delete the selected <b>Log</b>?
	<input type=Submit name=Submit id=Submit value='Confirm Delete'>
	<input type=Submit name=Submit id=Submit value='Cancel'> ";
}
if($action=="deleteall")
{
	$msg= "Are you sure you want to delete all the <b>Access Log</b>?
	<input type=Submit name=Submit id=Submit value='Confirm Delete All'>
	<input type=Submit name=Submit id=Submit value='Cancel'> ";
}
if ($Submit == "Confirm Delete")
{
		$result=mysql_query("delete from access_log where id='$id'");
		$msg= "The selected Log has been deleted";
}	
if ($Submit == "Confirm Delete All")
{
		$result=mysql_query("TRUNCATE TABLE access_log");
		$msg= "Admin Access Log has been cleared successfully";
}
if ($Submit == "Cancel") $msg= "The delete operation cancelled";

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
   <td height="13" valign="middle" class="textonly3"><p align="center" class="title style6"><strong>Admin Users Log </strong></p>
          <hr /></td>
  </tr>
  <tr>
    <td height="157" align="center" valign="top"><form id="form1" name="form1" method="post" action="">
      <font color="#FF0000" face="Verdana, Arial, Helvetica, sans-serif" size="-1">
      <?php echo $msg;?>
      </font><br />
    </form>
    <table width="700" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
      <tr bgcolor="green" class="textonly3">
        <td width="35" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>S/N</strong></div></td>
		    <td width="101" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>First Name</strong></div></td>
            <td width="93" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Last Name</strong></div></td>
            <td width="116" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Username</strong></div></td>
		    <td width="116" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Log Time </strong></div></td>
		    <td width="98" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Log Date </strong></div></td>
            <td width="55" align="center" bgcolor="#000000"><div align="center" class="style9">
		  <a href='main.php?page=admin_log&action=deleteall&id=$id' class='textonly1'><strong>Delete All </strong></a></div></td>
        </tr>
  <?php
	$result2= mysql_query("select * from access_log order by id desc");
    $num_results=mysql_affected_rows();
	if($num_results>=1)
	{
		for($i=1; $i<=$num_results; $i++) 
		{
			$rows= mysql_fetch_array($result2);
			$user=$rows["user"];
			
				$result3= mysql_query("select * from admin where user='$user'");
				$row3= mysql_fetch_array($result3);
				
			echo "<tr class=textonly3 align='center'><td>$i</td>";
			echo "<td>".$row3["fname"]."</td>";
			echo "<td>".$row3["lname"]."</td>";
			echo "<td>".$rows["user"]."</td>";
			echo "<td>".$rows["time_log"]."</td>";
			echo "<td>".$rows["date_log"]."</td>";
			$id=$rows["id"];
			echo "<td align=center><a href='main.php?page=admin_log&action=delete&id=$id' class='textonly1'>
			<img src='images/del-icon.png' alt='Delete' width='22' height='22' border='0' /></td></tr>";
		}
	}
	else echo "<tr align='center'><td colspan='9'>There is no Log record of User</td></tr>";
?>
      </table>      
    <p>&nbsp;</p></td></tr>
</table>
<br />
</body>
</html>
