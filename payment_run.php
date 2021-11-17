<script type="text/javascript">
function reload(form)
{
	var cm=form.company.options[form.company.options.selectedIndex].value;
	self.location='main.php?page=payment_run&cm=' + cm + '#t';
}
</script>
<?

$action=$_GET['action'];
$id=$_GET['id'];
$Submit=$_POST['Submit'];

$company=$_POST['company'];
$invoice_no=$_POST['invoice_no'];
$amt_paid=$_POST['amt_paid'];
$amt_balance=$_POST['amt_balance'];
$amt_supplied=$_POST['amt_supplied'];
$amt_balance=$_POST['amt_balance'];
$paid_by=$_POST['paid_by'];
$paid_to=$_POST['paid_to'];
$des=$_POST['des'];
$d=$_POST['d'];
$m=$_POST['m'];
$y=$_POST['y'];

if($company=="") $company=$cm;

if($action=="delete")
{
	$msg= "Do you want to delete the selected <b>Supplier Details</b>?
	<input type=Submit name=Submit id=Submit value='Confirm Delete'>
	<input type=Submit name=Submit id=Submit value='Cancel'> ";
}

if ($Submit == "Confirm Delete")
{
		$result=mysql_query("delete from supplier where id='$id'");
		$msg= "The selected Supplier Details has been deleted";
}	
if ($Submit == "Cancel") $msg= "The delete operation cancelled";

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
		
if($Submit=="Make Payment")
{
	if(!$company or !$invoice_no or !$amt_paid)
	{
	 	$msg="The Field marked &quot;*&quot; are required!";
    }
	elseif($amt_paid > $amt_balance)
	{
	 	$msg="The Amount Paid cannot be more than the Balance to pay!";
    }
	elseif(!is_numeric($amt_paid)) $msg="Error! Amount Paid must be a number";
	else
	{
		$result=mysql_query("select * from payment_run where company='$company' and invoice_no='$invoice_no' and amt_paid='$amt_paid'");
		 $num_result=mysql_affected_rows();
		 if($num_result > 0)
		 {
		  	$msg="Sorry, detail already exist!"; 
		 }
		 else
		 {
		 	$dat=date('Y-m-d');
		 	$i_dat="$y-$m1-$d";
		 	$amt_balance=$amt_balance-$amt_paid;
			$result2=mysql_query("update supplier set last_paid='$amt_paid', amt_balance='$amt_balance', ldat='$dat',
			invoice_no='$invoice_no' where company='$company'");
			$result=mysql_query("insert into payment_run values
			('','$dat','$company','$amt_balance','$invoice_no','$i_dat','$amt_paid','$paid_by','$paid_to','$des')");
			$msg="Payment Detail has been added!"; 
		 }
	}
}
if($id)
{
	$res=mysql_query("select * from supplier where id='$id'");
	$num_result=mysql_affected_rows();
	$rw=mysql_fetch_array($res);
	$company=$rw['company'];
}

if($company)
{
	$res=mysql_query("select * from supplier where company='$company'");
	$num_result=mysql_affected_rows();
	$rw=mysql_fetch_array($res);
	$dat=$rw['dat'];
	//$company=$rw['company'];
	//$phone=$rw['phone'];
	//$address=$rw['address'];
	$paid_to=$rw['contact'];
	//$product=$rw['product'];
	$amt_balance=$rw['amt_balance'];
	$last_paid=$rw['last_paid'];
}

if(!$company) $msg= "Select the Vendor/Company name to pay";
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
.style12 {font-size: 18px; font-weight: bold; }
.style14 {font-size: 16px; font-weight: bold; }
.style10 {font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="100%" height="181" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
   <td height="13" valign="middle" class="textonly3"><p align="center" class="title style6"><strong>Make Payment </strong></p>
          <hr /></td>
  </tr>
  <tr>
    <td height="157" align="center" valign="top"><form id="form1" name="form1" method="post" action="">
        <font color="#FF0000" face="Verdana, Arial, Helvetica, sans-serif" size="-1">
        <?=$msg?>
        </font><br />
        <table width="519" border="0" align="center" cellpadding="3" cellspacing="0" class="textonly3">
          <tr>
            <td width="212" height="36" valign="middle"><div align="right"><strong>Vendor's Name *   </strong></div></td>
            <td width="307" valign="middle">
            <div align="left">
              <select name="company" class="inputs" id="company" onChange="reload(this.form)" >
                <? 
			  		if($company=="") echo "<option value='' selected='selected'>Select One</option>";
					$q4=mysql_query("select * from supplier order by company");
					$r4=mysql_affected_rows();
					for($i=1;$i<=$r4;$i++)
					{
						$row4=mysql_fetch_array($q4);
						$company2=$row4['company'];
						if($company2==$company)  echo "<option value='$company' selected='selected'>$company</option>";
						else echo "<option value='$company2'>$company2</option>";
					}
               ?>
              </select>
            </div>            </td>
          </tr>
<? if($company){ ?>          
          <tr>
            <td height="21" valign="middle"><div align="right"><strong>Total Balance to be Paid:</strong></div></td>
            <td valign="middle"><span class="style12">
              <div align="left">
                &nbsp;&nbsp;&nbsp;# <?=number_format($amt_balance,2)?>
                <input type="hidden" name="amt_balance" value="<?=$amt_balance?>" />
              </div>
            </span></td>
          </tr>
          <tr>
            <td valign="middle"><div align="right"><span class="style21"><strong>Amount Paid * :</strong></span></div></td>
            <td valign="middle"><div align="left">
                <input name="amt_paid" type="text" class="inputs" id="amt_paid" value="<?=$amt_paid?>" size="20"/>
                <span class="style14">Naira            </span></div></td>
          </tr>
          <tr>
            <td height="28" valign="middle"><div align="right"><strong>Invoice Date   * </strong></div></td>
            <td valign="middle">
              <div align="left">
                <select name="d" id="d" class="inputs"  title="Day" >
                  <? 
					if(!$d) $d=date('j');
					for($i=1;$i<=31;$i++)
					{ 
						if(strlen($i)==1) $i="0$i";
						if($i==$d) echo "<option value='$i' selected='selected'>$i</option>";
						else echo "<option value='$i'>$i</option>";
				 	}
			 ?>
                </select>
                <select name="m" id="m" class="inputs">
                  <? 
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
                  <? 
					if(!$y) $y=$yr;
					if(!$y) $y=date('Y');
					for($i=1990;$i<=2050;$i++)
					{ 
						if($i==$y) echo "<option value='$i' selected='selected'>$i</option>";
						else echo "<option value='$i'>$i</option>";
				 	}
			 ?>
                </select>
              </div></td></tr>
          <tr>
            <td height="29" valign="middle"><div align="right"><strong>Invoice Number  * </strong></div></td>
            <td valign="middle"><div align="left">
                <input name="invoice_no" type="text" class="inputs" id="invoice_no" value="<?=$invoice_no?>" size="10"/>
            </div></td>
          </tr>
          <tr>
            <td valign="middle"><div align="right"><span class="style21"><strong>Notifier/Contact  :</strong></span></div></td>
            <td valign="middle"><div align="left">
              <input name="paid_to" type="text" class="inputs" id="paid_to" value="<?=$paid_to?>" size="20"/>
            </div></td>
          </tr>
          <tr>
            <td valign="middle"><div align="right"><span class="style21"><strong>Paid By  :</strong></span></div></td>
            <td valign="middle"><div align="left">
              <input name="paid_by" type="text" class="inputs" id="paid_by" value="<?=$paid_by?>" size="20"/>
            </div></td>
          </tr>
          <tr>
            <td valign="middle"><div align="right"><span class="style21"><strong>Description  :</strong></span></div></td>
            <td valign="middle"><div align="left">
              <textarea name="des" class="inputs" id="des"><?=$des?>
            </textarea>
            </div></td>
          </tr>
          <tr>
            <td height="31" valign="middle">&nbsp;</td>
            <td valign="middle"><div align="left">
              <input name="Submit" type="submit" class="inputs-focus" value="Make Payment" />
            </div></td>
          </tr>
<? } ?>  
        </table>
        </form>
      <hr />
      <span class="style10 style6">List of Payment Run in this Month of <?=date('F, Y')?>
      </span>
      <table width="783" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
        <tr bgcolor="green" class="textonly3">
          <td width="22" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>S/N</strong></div></td>
		  <td width="26" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Date</strong></div></td>
		  <td width="208" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Company Name </strong></div></td>
		  <td width="85" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Invoice No  </strong></div></td>
		  <td width="116" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Invoice Date  </strong></div></td>
		  <td width="113" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Amount Paid </strong></div></td>
		  <td width="94" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Paid To </strong></div></td>
		  <td width="21" align="center" bgcolor="#000000"><div align="center" class="style9"><strong></strong></div></td>
        </tr>
<?
	$mn=date('Y-m');
	$result2= mysql_query("select * from payment_run where substring(dat,1,7)='$mn' order by id desc");
	//$result2= mysql_query("select * from payment_run");
    $num_results=mysql_affected_rows();
	for($i=1; $i<=$num_results; $i++)
   	{
		$rows= mysql_fetch_array($result2);
		echo "<tr class=textonly3><td>$i</td>";
		$id=$rows["id"];
		echo "<td>".$rows["dat"]."</td>";
		echo "<td>".$rows["company"]."</td>";
		//echo "<td>".$rows["address"]."</td>";
		echo "<td>".$rows["invoice_no"]."</td>";
		echo "<td>".$rows["i_dat"]."</td>";
		echo "<td align='right'>".number_format($rows["amt_paid"],2)."</td>";
		echo "<td align='right'>".$rows["paid_to"]."</td>";
		echo "<td align=center><a href='view_payment.php?id=$id' target='_blank'>
		<img src='images/Preview-icon.png' alt='Preview' width='22' height='22' border='0' /></td></tr>";
		
	}
?>
    </table>      
      <table width="43" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="43" height="25" bgcolor="#FFFFFF"><a href="main.php?page=r_payment_run"><img src="images/Preview-icon.png" alt="Preview in Printable Format" width="42" height="42" border="0" /></a><a href="print_setup_item.php?download=excel" target="_blank"></a></td>
        </tr>
      </table>
      </td>
  </tr>
</table>
<br />
</body>
</html>
