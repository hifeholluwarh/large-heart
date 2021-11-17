<?php

$action=$_GET['action'];
$id=$_GET['id'];
$mnth=$_GET['mnth'];
$mt=substr($mnth,0,3);
$yr=substr($mnth,4,4);

$Submit=$_POST['Submit'];
if(!$id) $id=$_POST['id'];

$name=$_POST['name'];
$address=$_POST['address'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$salary=$_POST['salary'];
$pay=$_POST['pay'];
$extra=$_POST['extra'];
$num_staff=$_POST['num_staff'];
$m=$_POST['m'];
$y=$_POST['y'];
$sys_ip=$_SERVER['REMOTE_ADDR'];

if(!$m) $m=$mt;	if(!$m) $m=date('M');
if(!$y) $y=$yr;	if(!$y) $y=date('Y');

$month="$m $y";
if($month==" ") $month="$mnth";

if($action=="delete")
{
	$msg= "Do you want to delete the selected <b>Staff Salary Details</b>?
	<input type=Submit name=Submit id=Submit value='Confirm Delete'>
	<input type=Submit name=Submit id=Submit value='Cancel'> ";
}

if ($Submit == "Confirm Delete")
{
		$result=mysql_query("delete from staff_salary where id='$id'");
		$msg= "The selected Staff Salary Details has been deleted";
}	
if ($Submit == "Cancel") $msg= "The delete operation cancelled";

if($Submit=="Make Payment")
{
		
		if ($extra and !is_numeric($extra))	$msg="Sorry! The extra salary is not a number (pls no comma)."; 
		else
		{
			$query1=mysql_query("select * from staff_salary where name='$name' and month='$month'");
			$result1=mysql_affected_rows();
			if($result1>=1) $msg="Error! $name Salary had already been paid $month salary!"; 
			else
			{
				$dat=date("d M, Y");
				$net=$salary+$extra;
				$result=mysql_query("insert into staff_salary values('','$name','$address','$phone','$email',
				'$salary','$extra','$net','$m','$y','$loguser','$sys_ip','$dat')");
				$msg="$name $month Salary successfully Paid!"; 
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
   <td height="13" valign="middle" class="textonly3"><p align="center" class="title style6"><strong>Staff Salary Payment</strong></p>
          <hr /></td>
  </tr>
  <tr>
    <td height="157" align="center" valign="top">
      <form id="form1" name="form1" method="post" action="main.php?page=staff_salary">   
      <font color="#FF0000" face="Verdana, Arial, Helvetica, sans-serif" size="-1">
        <?php echo $msg;?>
        </font>
      <input name="id" type="hidden" id="id" value="<?php echo $id;?>" />
  
      <p><b>Select Payment Month: 
        </b>
        <select name="m" id="m" class="inputs">
          <?php 
				  	$mnth = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
					for($i=0;$i<=11;$i++)
					{ 
						if($m==$mnth[$i]) echo "<option value='$m' selected='selected'>$m</option>";
						else echo "<option value='$mnth[$i]'>$mnth[$i]</option>";
				 	}
			  ?>
        </select>
        <select name="y" id="y" class="inputs">
          <?php 
					if(!$y) $y=$yr;
					if(!$y) $y=date('Y');
					for($i=2012;$i<=2050;$i++)
					{ 
						if($i==$y) echo "<option value='$i' selected='selected'>$i</option>";
						else echo "<option value='$i'>$i</option>";
				 	}
			 ?>
        </select>
        <span class="title">
        <input name="Submit" type="submit" class="inputs" id="Submit" value="Go &gt;&gt;"  title="Validate Selections" />
      </span>
        <label for="checkbox"></label>
      </p></form>
      <table width="95%" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
        <tr bgcolor="green" class="textonly3">
          <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>S/N</strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Staff Name</strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Phone No. </strong></div></td>
          <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Salary </strong></div></td>
          <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Extra Wage</strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong></strong></div></td>
          <td align="center" bgcolor="#000"><div align="center" class="style9"><strong></strong></div></td>
          
          <td align="center" bgcolor="#000"><div align="center" class="style9"><strong></strong></div></td>
        </tr>
        
<?php
	$result2= mysql_query("select * from staff");
    $num_results=mysql_affected_rows();
	for($i=1; $i<=$num_results; $i++) 
   	{
      	echo "<form id='form2' name='form2' method='post' action='main.php?page=staff_salary'>";
		$rows= mysql_fetch_array($result2);
		echo "<tr><td>$i</td>";
		$name=$rows["name"];
		$address=$rows["address"];
		$phone=$rows["phone"];
		$email=$rows["email"];
		$salary=$rows["salary"];
		$salary2=number_format($rows["salary"]);
		$id=$rows["id"];
		$payj="yes";
		
		$query1=mysql_query("select * from staff_salary where name='$name' and m='$m' and y='$y'");
		$result1=mysql_affected_rows();
		$row1= mysql_fetch_array($query1);
		$ids=$row1["id"];
		$mnths=$month;
		
		echo "<td>".$rows["name"]."</td>";
		//echo "<td>".$rows["address"]."</td>";
		echo "<td>".$rows["phone"]."</td>";
		echo "<td align='right'>".number_format($rows["salary"],2)."</td>";
		
	
		
			if($result1<=0) 
			{
				echo "<td align='center'><input type='text' size='5' class='inputs' name='extra' value=''></td>";
				echo "<td align=center>
				<input name='Submit' type='submit' class='inputs' id='Submit' value='Make Payment'  title='Validate Selections for Payments' />
				</td>";
			}
			else 
			{
				echo "<td align='center'><input type='text' size='5' class='inputs' name='extra' value='' disabled></td>";
				echo "<td align=center><h3>Salary Paid</h3></td>";
			}
				echo "<input type='hidden' name='name' value='$name'>";
				echo "<input type='hidden' name='address' value='$address'>";
				echo "<input type='hidden' name='phone' value='$phone'>";
				echo "<input type='hidden' name='email' value='$email'>";
				echo "<input type='hidden' name='salary' value='$salary'>";
				echo "<input type='hidden' name='id' value='$id'>";
				
				echo "<input type='hidden' name='num_staff' value='$num_results'>";
				echo "<input type='hidden' name='m' value='$m'><input type='hidden' name='y' value='$y'>";
				echo "</form>";
				echo "<td align=center><a href='view_staff.php?id=$id' target='_blank'>
						<img src='images/Preview-icon.png' alt='Preview' width='22' height='22' border='0' /></td>";
				echo "<td align=center><a href='main.php?page=staff_salary&action=delete&id=$ids&mnth=$mnths'>
						<img src='images/del-icon.png' alt='Delete' width='22' height='22' border='0' /></td></tr>";		
				
	}
	
?>
		
    </table>
      <p>&nbsp;</p>
      <table width="147" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="43" height="25" bgcolor="#FFFFFF"><a href="print_staff_salary.php?m=<?php echo $m;?>&y=<?php echo $y;?>" target="_blank"><img src="images/Preview-icon.png" alt="Preview in Printable Format" width="42" height="42" border="0" /></a></td>
          <td width="63" align="center" bgcolor="#FFFFFF"><a href="print_staff_salary.php?y=<?php echo $y;?>" target="_blank"><h2><?php echo $y;?></h2></a></td>
          <td width="41" bgcolor="#FFFFFF"><a href="print_staff.php?download=<?php echo "$page".date('Ymdhms');?>"><img src="images/Download-Excel-icon.png" alt="Download in Excel Format" width="41" height="39" border="0" /></a></td>
        </tr>
      </table>
    </table>

<br />
</body>
</html>
