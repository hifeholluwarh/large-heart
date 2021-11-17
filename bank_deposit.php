<script type="text/javascript">
function reload(form)
{
	var val=form.shelf.options[form.shelf.options.selectedIndex].value; 
	self.location='main.php?page=setup_item&sh=' + val + '#t';
}
</script>
<?php

$action=$_GET['action'];
$id=$_GET['id'];
$show_cat=$_GET['show_cat'];

$Submit=$_POST['Submit'];
$Submit1=$_POST['Submit1'];
$dat=$_POST['dat'];
$acct_name=$_POST['acct_name'];
$deposito=$_POST['deposito'];
$amount=$_POST['amount'];
$teller=$_POST['teller'];

$Submit1=$_POST['Submit1'];
$Load=$_POST['Load'];
$cat=$_POST['cat'];
$acct_nam=$_POST['acct_nam'];

$d=$_POST['d'];
$m=$_POST['m'];
$y=$_POST['y'];

	if($m=="Jan") $m1="01";
	elseif($m=="Feb") $m1="02";
	elseif($m=="Mar") $m1="03";
	elseif($m=="Apr") $m1="04";
	elseif($m=="May") $m1="05";
	elseif($m=="Jun") $m1="06";
	elseif($m=="Jul") $m1="07";
	elseif($m=="Aug") $m1="08";
	elseif($m=="Sep") $m1="09";
	elseif($m=="Oct") $m1="10";
	elseif($m=="Nov") $m1="11";
	elseif($m=="Dec") $m1="12";
	
$dat="$y-$m1-$d";

if($action=="delete")
{
	$msg= "Do you want to delete the selected <b>Bank Deposit</b>?
	<input type=Submit name=Submit id=Submit value='Confirm Delete'>
	<input type=Submit name=Submit id=Submit value='Cancel'> ";
}

if ($Submit == "Confirm Delete")
{
		$result=mysql_query("delete from account_record where id='$id'");
		$msg= "The selected Bank Deposit has been deleted";
		$hide="yes";
}	
elseif ($Submit == "Cancel") $msg= "The delete operation cancelled";

if($Submit=="Add Deposit")
{
	if(!$acct_name)  $msg="You need to select the Account Name!";
	elseif(!$depositor)  $msg="Pls specify who deposited the money!";
	elseif($amount) $msg="Specify the amount that was deposited";
	elseif(!is_numeric($amount)) $msg="Invalid Entry for Amount Deposited (Pls! no comma).";
	{
		$result=mysql_query("select * from account_record where dat='$dat' and teller='$teller'");
		$num_result=mysql_affected_rows();
		if($num_result >= 1) 
		{
		  	$msg="Deposit with the same Teller No. &quot;$teller&quot; already exist!"; 
		}
		else
		{
			$result=mysql_query("insert into account_record values('','$dat','$acct_name','$depositor','$amount','$teller')");
		  	$msg="Depsot Information added successfully!"; 
		}
	}
}

if ($Submit1 == "--")
{
	if(!$acct_name) $msg= "Select the Account to delete!";
	else
	{
		$result=mysql_query("delete from account where acct_name='$acct_name'");
		$msg= "The selected Account &quot;$acct_name&quot; has been deleted";
	}
}
if($Submit=="Add Account")
{
	if(!$acct_nam or !$acct_no)
	{
	 	$msg="You need to enter the Account Name and Number!";
		$Submit1="+";
    }
	else
	{
		$result=mysql_query("select * from account where acct_name='$acct_nam' or acct_no='$acct_no'");
		 $num_result=mysql_affected_rows();
		 if($num_result > 0)
		 {
		  	$msg="Sorry, the specify Account Name and Number already exist!"; 
			$Submit1="+";
		 }
		 else
		 {
		  	$result=mysql_query("insert into account values ('','$acct_nam','$acct_no','')");
		  	$msg="Account details has been added!"; 
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
.style12 {	font-size: 18px;
	font-weight: bold;
}
.style10 {font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="100%" height="181" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
   <td height="13" valign="middle" class="textonly3"><p align="center" class="title style6"><strong>Account/Cash Deposit</strong></p>
          <hr /></td>
  </tr>
  <tr>
    <td height="157" align="center" valign="top"><form id="form1" name="form1" method="post" action="">
        <font color="#FF0000" face="Verdana, Arial, Helvetica, sans-serif">
        <?php echo $msg;?>
        </font>
        <?php if($Submit1=="+"){ ?>
        <table width="500" height="134" border="0" align="center" cellpadding="0" cellspacing="5" bgcolor="#CCFF66" class="textonly3">
          <tr>
            <td width="92" height="38" valign="middle"><div align="right"><strong>Account Name : </strong></div></td>
            <td width="293" valign="middle"><label>
              <input name="acct_nam" type="text" class="inputs" id="acct_nam" value="<?php echo $acct_nam;?>"/>
            </label></td>
          </tr>
          <tr>
            <td height="38" valign="middle"><div align="right"><strong>Account No. : : </strong></div></td>
            <td valign="middle"><label>
              <input name="acct_no" type="text" class="inputs" id="acct_no" value="<?php echo $acct_no;?>"/>
            </label></td>
          </tr>
          <tr>
            <td height="38" valign="middle">&nbsp;</td>
            <td valign="middle"><input name="Submit" type="submit" class="inputs-focus" id="Submit" value="Add Account" /></td>
          </tr>
        </table>
        <?php } ?>
        <br />
        <table width="597" border="0" align="center" cellpadding="0" cellspacing="0" class="textonly3">
          <tr>
            <td height="28" valign="middle"><div align="right"><strong> Date of Deposit* </strong></div></td>
            <td valign="middle"><div align="left">
              <select name="d" id="d" class="inputs"  title="Day" >
                <?php 
					if(!$d) $d=$dt; if(!$d) $d=date('j');
					for($i=1;$i<=31;$i++)
					{ 
						if(strlen($i)==1) $i="0$i";
						if($i==$d) echo "<option value='$i' selected='selected'>$i</option>";
						else echo "<option value='$i'>$i</option>";
				 	}
			 ?>
              </select>
              <select name="m" id="m" class="inputs">
                <?php 
				  	$mnth = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
					if(!$m) $m=$mt;
					if(!$m) $m=date('M');
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
					for($i=1990;$i<=2050;$i++)
					{ 
						if($i==$y) echo "<option value='$i' selected='selected'>$i</option>";
						else echo "<option value='$i'>$i</option>";
				 	}
			 ?>
              </select>
            </div></td>
          </tr>
          <tr>
            <td height="30" valign="middle"><div align="right"><strong>Bank Name: </strong></div></td>
            <td valign="middle"><div align="left">
              <select name="acct_name" class="inputs" id="acct_name" >
                <?php 
						echo "<option value='' selected='selected'>Select One</option>";
				  		$q4=mysql_query("select * from account order by acct_name");
						$r4=mysql_affected_rows();
						for($i=1;$i<=$r4;$i++)
						{
							$row4=mysql_fetch_array($q4);
							$acct2=$row4['acct_name'];
							$acctn=$row4['acct_no'];
							if($acct2==$acct_name)  echo "<option value='$acct2' selected='selected'>$acct2 [$acctn]</option>";
							else echo "<option value='$acct2'>$acct2 [$acctn]</option>";
						}
                  ?>
              </select>
              <input name="Submit1" type="submit" id="Submit1" value="+" title="Add New Book Category" />
              <input name="Submit1" type="submit" id="Submit1" value="--" title="Remove Selected Book Category"  />
            </div></td>
          </tr>
	  
          <tr>
            <td height="38" valign="middle"><div align="right"><strong>Depositors Name : </strong></div></td>
            <td align="left" valign="middle"><div align="left">
              <input name="depositor" type="text" class="inputs" id="depositor" value="<?php echo $depositor;?>" size="40" />
            </div></td>
          </tr>
          <tr>
            <td height="38" valign="middle"><div align="right"><strong>Amount Deposited   : </strong></div></td>
            <td align="left" valign="middle">
              <div align="left">
                <input name="amount" type="text" class="inputs" id="amount" value="<?php echo $amount;?>" size="15"/>            
              <span class="style12"> Naira</span></div></td>
          </tr>
          <tr>
            <td height="38" valign="middle"><div align="right"><strong>Teller Number  : </strong></div></td>
            <td align="left" valign="middle"><div align="left">
              <input name="teller" type="text" class="inputs" id="teller" value="<?php echo $teller;?>"/>
            </div></td>
          </tr>
          <tr>
            <td width="149" height="38" valign="middle">&nbsp;</td>
            <td width="448" align="left" valign="middle">
              <div align="left">
                <input name="Submit" type="submit" class="inputs-focus" value="Add Deposit" />
            </div></td>		
          </tr>

        </table>
        </form>
      <hr />
      <span class="style10 style6">List of Cash Deposit this Month </span>
      <table width="95%" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
        <tr bgcolor="green" class="textonly3">
          <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>S/N</strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Deposit Date</strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Bank Name</strong></div></td>
	      <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Depositor's Name</strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Amount Deposited (#)</strong></div></td>
	      <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Teller Number</strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong></strong></div></td>
        </tr>
<?php
	$mn=date('Y-m');
	$result2= mysql_query("select * from account_record where substring(dat,1,7)='$mn' order by id");
    $nums=mysql_affected_rows();
	for($i=1; $i<=$nums; $i++) 
   	{
		$rows= mysql_fetch_array($result2);
		echo "<tr><td>$i</td>";
		$id=$rows["id"];
		echo "<td>".$rows["dat"]."</td>";
		echo "<td>".$rows["acct_name"]."</td>";
		echo "<td>".$rows["depositor"]."</td>";
		echo "<td align='right'>".number_format($rows["amount"],2)."</td>";
		echo "<td>".$rows["teller"]."</td>";
		echo "<td align=center><a href='main.php?page=bank_deposit&action=delete&id=$id'>
		<img src='images/del-icon.png' alt='Delete Deposit' width='22' height='22' border='0' /></a></td></tr>";
			}
?>
    </table>
    <br /></td>
  </tr>
</table>
<br />
</body>
</html>
