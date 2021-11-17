<script type="text/javascript">
function reload(form)
{
	var dt=form.d.options[form.d.options.selectedIndex].value;
	var mt=form.m.options[form.m.options.selectedIndex].value;
	var yr=form.y.options[form.y.options.selectedIndex].value;
	var itemid=form.item_id.options[form.item_id.options.selectedIndex].value; 
	self.location='main.php?page=good_returned&itemid='+itemid+'&dt='+dt + '&mt=' + mt + '&yr=' + yr + '#t';
	//self.location='main.php?page=good_received&itemid=' + itemid;
}

</script>
<?php
$action=$_GET['action'];
$itemid=$_GET['itemid'];
$id=$_GET['id'];
$Submit=$_POST['Submit'];

$ord_no=$_POST['cat'];
$dat=$_POST['dat'];
$item_id=$_POST['item_id'];
$des=$_POST['des'];
$width=$_POST['width'];
$height=$_POST['height'];
$qty=$_POST['qty'];
$sale_price=$_POST['sale_price'];
$discount=$_POST['discount'];
$total_amount=$_POST['total_amount'];
$receive_by=$_POST['receive_by'];
$return_by=$_POST['return_by'];
$record_by=$_POST['record_by'];
$reason=$_POST['reason'];
$ord_no=$_POST['ord_no'];


if($action=="delete")
{
	$msg= "Do you want to delete the selected <b>Good Returned Details</b>?
	<input type=Submit name=Submit id=Submit value='Confirm Delete'>
	<input type=Submit name=Submit id=Submit value='Cancel'> ";
}

if ($Submit == "Confirm Delete")
if ($Submit == "Confirm Delete")
{
		$result=mysql_query("delete from good_returned where id='$id'");
		$msg= "The selected Good Returned Details has been deleted";
}	
if ($Submit == "Cancel") $msg= "The operation was cancelled";

if($Submit=="Continue Return")
{
		$result=mysql_query("select * from good_returned where ord_no='$ord_no'");
			$num_result=mysql_affected_rows();
			if($num_result > 0)
			{
				$msg="Sorry, goods with Order No &quot;$ord_no&quot; has already been returned by &quot;$return_by&quot;!"; 
			}
			else
			{
				//$total_amount=$qty*$price-$discount;
				//$now_stock=$in_stock+$qty;
				//$dat="$y-$m1-$d";
				$result=mysql_query("insert into good_returned values('','$dat','$item_id','$width','$height','$qty',
				'$sale_price','$discount','$total_amount','$return_by','$receive_by','$record_by','$reason','$ord_no')");
				$msg="Good Receive Detail has been recorded!"; 
				$show_detail="";
			}
}

if($Submit=="Return Job")
{
	if(!$receive_by or !$ord_no or !$record_by) $msg="All fields are required!";
	else
	{
		$q5=mysql_query("select * from good_ordered where ord_no='$ord_no'");
		$n5=mysql_affected_rows();
		if($n5<=0) $msg="Job with Order Number not found!";
		else
		{
			$result=mysql_query("select * from good_returned where ord_no='$ord_no'");
			$num_result=mysql_affected_rows();
			if($num_result > 0)
			{
				$msg="Sorry, goods with Order No &quot;$ord_no&quot; has already been returned by &quot;$return_by&quot;!"; 
			}
			else
			{
				$row5=mysql_fetch_array($q5);
				$dat=$row5['dat'];
				$item_id=$row5['item_id'];
				$des=$row5['des'];
				$price=$row5['price'];
				$sale_price=$row5['sale_price'];
				$width=$row5['width'];
				$height=$row5['height'];
				$qty=$row5['qty'];
				$discount=$row5['discount'];
				$return_by=$row5['ord_by'];
				$approve_by=$row5['approve_by'];
				
				$total_amount=$width*$height*$qty*$sale_price-$discount;
				
				$show_detail="show";
			}
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
.style10 {font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="100%" height="181" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
   <td height="13" valign="middle" class="textonly3"><p align="center" class="title style6"><strong>Job/Printing Returned</strong></p>
          <hr /></td>
  </tr>
  <tr>
    <td height="157" align="center" valign="top"><form id="form1" name="form1" method="post" action="">
        <font color="#FF0000" face="Verdana, Arial, Helvetica, sans-serif" size="-1">
        <?php if(!$show_detail){ ?>
		<?php echo $msg;?>
        </font><br />
        <table width="496" border="0" align="center" cellpadding="0" cellspacing="2" class="textonly3">
          <tr>
            <td width="201" height="36" valign="middle"><div align="right"><strong>Order Number </strong></div></td>
            <td width="289" align="left" valign="middle"><div align="left">
              <input name="ord_no" type="text" class="inputs" id="ord_no" value="<?php echo $ord_no;?>" size="15"/>
            </div></td>
          </tr>
         
          <tr>
            <td height="28" valign="middle"><div align="right"><strong>Received by  * </strong></div></td>
            <td valign="middle">              
              
              <div align="left">
                <input name="receive_by" type="text" class="inputs" id="receive_by" value="<?php echo $receive_by;?>" size="30"/>            
              </div></td>
          </tr>
          <tr>
            <td height="28" valign="middle"><div align="right"><strong>Recorded by  * </strong></div></td>
            <td valign="middle"><div align="left">
              <input name="record_by" type="text" class="inputs" id="record_by" value="<?php echo $record_by;?>" size="30"/>
            </div></td>
          </tr>
          <tr>
            <td height="28" valign="middle"><div align="right"><strong>Reason for return </strong></div></td>
            <td valign="middle"><div align="left">
                <textarea name="reason" cols="30" class="inputs" id="reason"><?php echo $reason;?></textarea>
            </div></td>
          </tr>
          
          
          <tr>
            <td height="38" valign="middle">&nbsp;</td>
            <td valign="middle"><div align="left">
              <input name="Submit" type="submit" class="inputs-focus" value="Return Job" />
            </div></td>
          </tr>
		  
        </table>
        <?php ?>
        <p><b>Below is the Order Details</b></p>
        <table width="600" border="1" cellpadding="5" cellspacing="0">
          <tr class="textonly3">
            <td width="279" height="36" valign="middle"><div align="right"><strong>Order Number </strong></div></td>
            <td width="311" align="left" valign="middle"><div align="left"><?php echo $ord_no;?>
                <input name="ord_no" type="hidden" id="ord_no" value="<?php echo $ord_no;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Ordered Date  * </strong></div></td>
            <td valign="middle"><div align="left"><?php echo $dat;?>
                <input name="dat" type="hidden" id="dat" value="<?php echo $dat;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Material Used * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo $item_id;?>
              <input name="item_id" type="hidden" id="item_id" value="<?php echo $item_id;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Description  * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo $des;?>
              <input name="des" type="hidden" id="des" value="<?php echo $des;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Unit Price  * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo number_format($sale_price,2);?>
              Naira
<input name="sale_price" type="hidden" id="sale_price" value="<?php echo $sale_price;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Job Width  * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo $width;?> Feet(s)
<input name="width" type="hidden" id="width" value="<?php echo $width;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Job Height  * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo $height;?> Feet(s)
              <input name="height" type="hidden" id="height" value="<?php echo $height;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Quantity  * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo $qty;?>
              <input name="qty" type="hidden" id="qty" value="<?php echo $qty;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Discount Amount * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo number_format($discount,2);?> Naira
<input name="discount" type="hidden" id="discount" value="<?php echo $discount;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Total Amount  * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo number_format($total_amount,2);?>
              Naira
<input name="total_amount" type="hidden" id="total_amount" value="<?php echo $total_amount;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Returned by * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo $return_by;?>
              <input name="return_by" type="hidden" id="return_by" value="<?php echo $return_by;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Received by  * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php echo $receive_by;?>
              <input name="receive_by" type="hidden" id="receive_by" value="<?php echo $receive_by;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Recorded by  * </strong></div></td>
            <td valign="middle"><div align="left"><?php echo $record_by;?>
              <input name="record_by" type="hidden" id="record_by" value="<?php echo $record_by;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" valign="middle"><div align="right"><strong>Reason for return </strong></div></td>
            <td valign="middle"><div align="left"><?php echo $reason;?>
              <input name="reason" type="hidden" id="reason" value="<?php echo $reason;?>" />
            </div></td>
          </tr>
          <tr class="textonly3">
            <td height="28" align="right" valign="middle"><input name="Submit" type="submit" class="inputs-focus" value="Cancel" id="Submit" /></td>
            <td valign="middle"><div align="left">
              <input name="Submit" type="submit" class="inputs-focus" value="Continue Return" id="Submit" />
            </div></td>
          </tr>
        </table>
        <?php } ?>
        <p>&nbsp;</p>
    </form>
      <hr />
      <span class="style10 style6">List of Goods Returned this month of 
      <?php echo date('F, Y');?>
</span><br />
      <table width="95%" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
        <tr bgcolor="green" class="textonly3">
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>S/N</strong></div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Date </strong></div></td>
          <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Job/Material</strong></div></td>
          <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Size </strong></div></td>
          <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Price </strong></div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Qty </strong></div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Amount </strong></div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Return by </strong></div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Received by </strong></div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Reason </strong></div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong></strong></div></td>
        </tr>
<?php
	$mn=date('Y-m');
	$result2= mysql_query("select * from good_returned where substring(dat,1,7)='$mn' order by id desc");
    $num_results=mysql_affected_rows();
	if($num_results>=1)
	{
		for($i=1; $i<=$num_results; $i++) 
		{
			$rows= mysql_fetch_array($result2);
			echo "<tr class=textonly3><td>$i</td>";
			$id=$rows["id"];
			echo "<td>".$rows["dat"]."</td>";
			echo "<td>".$rows["des"]." [".$rows["item_id"]."]</td>";
			echo "<td>".$rows["width"]." X ".$rows["height"]."</td>";
			echo "<td>".$rows["price"]."</td>";
			echo "<td>".$rows["qty"]."</td>";
			echo "<td>".number_format($rows["total_amount"],2)."</td>";
			echo "<td>".$rows["return_by"]."</td>";
			echo "<td>".$rows["receive_by"]."</td>";
			echo "<td>".$rows["reason"]."</td>";
			echo "<td align=center><a href='view_good_returned.php?id=$id' target='_blank'>
			<img src='images/Preview-icon.png' alt='Preview' width='22' height='22' border='0' /></td></tr>";
		}
	}
	else echo "<tr align='center'><td colspan='9'>There is no record for Today</td></tr>";
?>
      </table>
      <?php if($type=="Super"){ ?>
      <table width="43" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="43" height="25" bgcolor="#FFFFFF"><a href="main.php?page=r_good_returned"><img src="images/Preview-icon.png" alt="Preview in Printable Format" width="42" height="42" border="0" /></a><a href="print_setup_item.php?download=excel" target="_blank"></a></td>
        </tr>
      </table>
      <?php } ?>
      <p>&nbsp;</p></td></tr>
</table>
<br />
</body>
</html>