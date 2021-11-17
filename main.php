<?php
session_start();
require_once("funcs.php");
conn(); 

$username=$_SESSION['username'];
$password=$_SESSION['password'];

$page=$_GET['page'];
$t=$_GET['t'];

    if (!isset($username) || !isset($password))
	{
		  $msg="You are not authorised to see this page";
		  header("location:index.php?page=error");
		  exit;
    }

$ct=$_GET['ct'];
$dt=$_GET['dt'];
$mt=$_GET['mt'];
$yr=$_GET['yr'];
$sh=$_GET['sh'];
$zn=$_GET['zn'];
$ft=$_GET['ft'];
$cm=$_GET['cm'];
$dpt=$_GET['dpt'];
$ord=$_GET['ord'];
$fl=$_GET['fl'];
$sid=$_GET['sid'];
$cid=$_GET['cid'];
$itemid=$_GET['itemid'];

$r= mysql_query("select * from admin where user='$username' and pass='$password'");
$row=mysql_fetch_array($r);
$type=$row['type'];
$log_fname=$row['fname'];
$log_lname=$row['lname'];
$loguser="$log_fname $log_lname";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="images/favicon.png" type="image/x-icon" />
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ayanfemi Media - Daily Operation Record</title>

<link href="style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-top: 0px;
	margin-bottom: 0px;
	margin-left: 0px;
	margin-right: 0px;
}
.style3 {
	color: #FFFFFF;
	font-weight: bold;
}
.style4 {color: #FFFFFF}
-->
</style>


</head>

<body>

<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td height="19" valign="top" bgcolor="#999999">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#660066"><?php include ("header.php"); ?></td>
  </tr>
  <tr>
    <td height="297" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#CC00FF">
          <tr>
            <td width="4%" height="28" align="left">&nbsp;</td>
            <td width="36%" align="left"><div align="left"><strong>Currently Logged in user : </strong> <span class="style4">
              <?php echo $loguser;?>
            </span></div></td>
            <td width="26%" align="center"><marquee scrollamount="3">New Trend in Efficiency & Professionalism</marquee></td>
			
            <td width="34%" align="center"><strong>Today is: </strong><span class="style3"> <?php echo date("l - dS \of F, Y");?>
              <a name="t" id="t"></a></span></td>
          </tr>
        </table>
          <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#000099">
            <tr>
              <td width="5%" align="center">&nbsp;</td>
              <td width="95%" align="left"><?php include 'link.php' ?></td>
            </tr>
          </table>
		  <table width="100%" height="250" border="0" cellpadding="5" cellspacing="5" bgcolor="#0099FF">
            
            <tr>
              <td width="100%" valign="top" bgcolor="#FFFFFF">
                <?php
				if($page=="welcome") 					include('welcome.php');
				
				elseif($page=="admin_setup")			include('admin_setup.php');
				elseif($page=="admin_log") 				include('admin_log.php');	

				elseif($page=="setup_item")				include('setup_item.php');
				elseif($page=="edit_item")				include('edit_item.php');
				elseif($page=="setup_supplier")			include('setup_supplier.php');
				elseif($page=="edit_supplier")			include('edit_supplier.php');
				elseif($page=="setup_clients")			include('setup_clients.php');
				elseif($page=="edit_clients")			include('edit_clients.php');
				
				elseif($page=="setup_staff")			include('setup_staff.php');
				elseif($page=="edit_staff")				include('edit_staff.php');
				elseif($page=="staff_salary")			include('staff_salary.php');
				
				elseif($page=="bank_deposit")			include('bank_deposit.php');
				
				elseif($page=="good_ordered")			include('good_ordered.php');
				elseif($page=="good_issue")				include('good_issue.php');
				elseif($page=="good_returned")			include('good_returned.php');
				elseif($page=="debt_payment")			include('debt_payment.php');
				elseif($page=="job_order")				include('job_order.php');
				
				elseif($page=="purchase_order")			include('purchase_order.php');
				elseif($page=="purchase_request")		include('purchase_request.php');
				elseif($page=="good_received")			include('good_received.php');
				
				elseif($page=="r_stock_record")			include('r_stock_record.php');
				elseif($page=="r_good_ordered")			include('r_good_ordered.php');
				elseif($page=="r_good_received")		include('r_good_received.php');
				elseif($page=="r_good_returned")		include('r_good_returned.php');
				elseif($page=="r_ordered_cost")			include('r_ordered_cost.php');
				elseif($page=="r_cost_summary")			include('r_cost_summary.php');
				elseif($page=="r_sale_profit")			include('r_sale_profit.php');
				elseif($page=="r_dept_record")			include('r_dept_record.php');
				elseif($page=="r_bank_deposit")			include('r_bank_deposit.php');
				elseif($page=="r_dept_payment")			include('r_dept_payment.php');
				elseif($page=="r_order_operator")		include('r_order_operator.php');
				
				else 									include('welcome.php');
				
			?>		</td>
            </tr>
            </table></td>
        </tr>
      
    </table>    </td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="#000000" style="bottom:0px; position:fixed">
  <tr>
    <td width="48%"><div align="left" class="style4"><strong>Copyright &copy; Large Heart Digital Print Ltd. <?php echo date('Y');?>.  All Rights Reserved.</strong></div></td>
    <td width="52%"><div align="right" class="style4"><strong>Designed by Afelumo Ifeoluwa </strong></div></td>
  </tr>
</table>
</body>
</html