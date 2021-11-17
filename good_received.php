
<?php
$action=$_GET['action'];
$id=$_GET['id'];
$Submit=$_POST['Submit'];
$Load=$_POST['Load'];
$Load2=$_POST['Load2'];

$company=$_POST['company'];
$item_id=$_POST['item_id'];
$in_stock=$_POST['in_stock'];
$receive_by=$_POST['receive_by'];
$price=$_POST['price'];
$des=$_POST['des'];
$width=$_POST['width'];
$height=$_POST['height'];
$qty=$_POST['qty'];

$ord_no=$_POST['ord_no'];
$d=$_POST['d'];
$m=$_POST['m'];
$y=$_POST['y'];

if(!$width) $width=1;
if(!$height) $height=1;
if(!$qty) $qty=1;

$total_area=$width*$height*$qty;

if($action=="delete")
{
	$msg= "Do you want to delete the selected <b>Supplier Details</b>?
	<input type=Submit name=Submit id=Submit value='Confirm Delete'>
	<input type=Submit name=Submit id=Submit value='Cancel'> ";
}
if($ct)
{
	$msg= "Category Loaded!... You can now select the Product ID";
}

if(!$item_id) $item_id=$itemid;
if($itemid)
{	
		$q5=mysql_query("select * from items where item_id='$item_id'");
		//$r4=mysql_affected_rows();
		$row5=mysql_fetch_array($q5);
		$unit=$row5['unit'];
		$des=$row5['des'];
		$price=$row5['price'];
		$in_stock=$row5['in_stock'];
		
		$msg= "Item Loaded!... You can now enter Quatity and Unit Price";
	
}
if ($Submit == "Confirm Delete")
{
	$res=mysql_query("select * from good_received where id='$id'");
	$num=mysql_affected_rows();
	if($num > 0)
	{
		$row=mysql_fetch_array($res);
		$company=$row['company'];
		$item_id=$row['item_id'];
		$in_stock=$row['in_stock'];
		$price=$row['price'];
		$des=$row['des'];
		$width=$row['width'];
		$height=$row['height'];
		$qty=$row['qty'];
		$dat=$row['dat'];
		$ord_no=$row['ord_no'];
		$total_amount=$row['total_amount'];
		
		$total_area=$width*$height*$qty;
		
		$q8=mysql_query("select * from items where item_id='$item_id'");
		$row8=mysql_fetch_array($q8);
		$in_stock8=$row8['in_stock']-$total_area;
		
		$result2=mysql_query("update items set in_stock='$in_stock8' where item_id='$item_id'");
		if($result2)
		{
			$result=mysql_query("delete from good_received where id='$id'");
			$result=mysql_query("delete from stock_record where in_stock='$in_stock' and area='$total_area' and dat='$dat'
			 and item_id='$item_id'");
			
			$msg= "The selected Supplier Details has been deleted";
			$item_id=""; $itemid="";
		}
	}
}	
if ($Submit == "Cancel") $msg= "The delete operation cancelled";

if($Submit=="Add Goods")
{
	if(!$company or !$price or !$width or !$height)
	{
	 	$msg="All the field marked &quot;*&quot; are required!";
    }
	elseif(!is_numeric($price) or !is_numeric($width) or !is_numeric($height)) $msg="Error! Width, Height and Unit Price must be a number";
	else
	{
		$result=mysql_query("select * from good_received where ord_no='$ord_no'");
		 $num_result=mysql_affected_rows();
		 if($num_result > 0)
		 {
		  	$msg="Sorry, goods with Order Number &quot;$ord_no&quot; Already Exist!"; 
		 }
		 else
		 {
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
		
			
			$total_amount=$total_area*$price;
			$now_stock=$in_stock+$total_area;
			
		 	$dat="$y-$m1-$d";
		  	$result=mysql_query("insert into good_received values('','$dat','$company','$item_id','$des',
							'$in_stock','$price','$width','$height','$qty','$total_amount','$ord_no','$receive_by')");
			$result2=mysql_query("update items set in_stock='$now_stock' where item_id='$item_id'");
			$result3=mysql_query("insert into stock_record values('','$dat','$item_id','$des','$price',
							'$in_stock','$total_area','$now_stock','$ord_no','$username')");
		
		  	$msg="Good Receive Detail has been recorded!";
			$item_id=""; $itemid="";
		 }
	}
}

$q1=mysql_query("select * from good_received order by id desc");
$r2=mysql_affected_rows();
$rs=mysql_fetch_array($q1);
$ord_no=$rs['ord_no'];
if($Submit<>"Continue") $ord_no++;
if(!$ord_no) $ord_no=1;
$ord_no = sprintf("%06d", $ord_no);
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
   <td height="13" valign="middle" class="textonly3"><p align="center" class="title style6"><strong>Receive/Acquire Materials </strong></p>
    <hr /></td>
  </tr>
  <tr>
    <td height="157" align="center" valign="top"><form id="form1" name="form1" method="post" action="">
        <font color="#FF0000" face="Verdana, Arial, Helvetica, sans-serif" size="-1">
        <?php echo $msg;?>
        </font><br />
        <table width="545" border="0" align="center" cellpadding="0" cellspacing="2" class="textonly3">
          <tr>
            <td width="203" height="36" valign="middle"><div align="right"><strong>Order Number * </strong></div></td>
            <td width="336" valign="middle"><div align="left"> <strong><font face="Verdana, Arial, Helvetica, sans-serif" size="3"> &nbsp;
                      <?php echo $ord_no;?>
                      <input name="ord_no" type="hidden" value="<?php echo $ord_no;?>" size="8" />
            </font></strong> </div></td>
          </tr>
          <tr>
            <td height="28" valign="middle"><div align="right"><strong>Date Received  * </strong></div></td>
            <td valign="middle"><div align="left">
              <select name="d" id="d" class="inputs"  title="Day" >
                <?php 
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
            <td height="39" valign="middle"><div align="right"><strong>Item/Product ID  *    </strong></div></td>
            <td valign="middle">
              <div align="left">
                <select name="item_id" class="inputs" id="item_id" onChange="reload(this.form)" >
                  <?php 
			  		if($item_id=="") $item_id=$itemid;
						if($item_id=="") echo "<option value='' selected='selected'>Select One</option>";
				  		$q4=mysql_query("select * from items order by item_id");
						$r4=mysql_affected_rows();
						for($i=1;$i<=$r4;$i++)
						{
							$row4=mysql_fetch_array($q4);
							$item_id2=$row4['item_id'];
							$ds=$row4['des'];
							if($item_id2==$item_id)  echo "<option value='$item_id' selected='selected'>$item_id - [$ds]</option>";
							else echo "<option value='$item_id2'>$item_id2 - [$ds]</option>";
						}
                  ?>
                </select>
            </div></td>
          </tr>
          <?php if($item_id){ ?>
          <tr>
            <td height="18" valign="middle"><div align="right"><strong>Total in Stock </strong></div></td>
            <td valign="middle"><strong>
              <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="3"> &nbsp;&nbsp;&nbsp;
                <?php echo number_format($in_stock);?>
                <?php echo $unit;?>
              </font></div>
              <div align="left">
                <input name="des" type="hidden" id="des" value="<?php echo $des;?>" />
                <input name="in_stock" type="hidden" id="in_stock" value="<?php echo $in_stock;?>" />
                <input name="unit" type="hidden" id="unit" value="<?php echo $unit;?>" />
              </div>
            </strong></td>
          </tr>

          <tr>
            <td height="28" valign="middle"><div align="right"><strong>Supplying Company * </strong></div></td>
            <td valign="middle"><div align="left">

                <select name="company" class="inputs" id="company" onChange="reload3(this.form)" >
                  <?php 
						$q4=mysql_query("select * from supplier order by company");
						$r4=mysql_affected_rows();
				  		if($company=="") echo "<option value='' selected='selected'>Select One</option>";
						for($i=1;$i<=$r4;$i++)
						{
							$row4=mysql_fetch_array($q4);
							$company2=$row4['company'];
							if($company2==$company)  echo "<option value='$company' selected='selected'>$company</option>";
							else echo "<option value='$company2'>$company2</option>";
						}
				?>
                </select>
            </div></td>
          </tr>
<?php if($item_id){ ?>
          <tr>
            <td height="36" valign="middle"><div align="right"><strong>Unit Price  * </strong></div></td>
            <td valign="middle">
              <div align="left">
                <input name="price" type="text" class="inputs" id="price" value="<?php echo $price;?>" size="15"/>
            <strong><font face="Verdana, Arial, Helvetica, sans-serif" size="3"> (Naira)</font></strong></div></td>
          </tr>
          <tr>
            <td height="36" valign="middle"><div align="right"><strong>Material Width * </strong></div></td>
            <td valign="middle"><div align="left"><strong>
              <input name="width" type="text" class="inputs" id="width" value="<?php echo $width;?>" size="10"  onblur="calc()" />
              <font face="Verdana, Arial, Helvetica, sans-serif" size="3"> Ft.</font></strong></div></td>
          </tr>
          <tr>
            <td height="36" valign="middle"><div align="right"><strong>Material Height * </strong></div></td>
            <td valign="middle"><div align="left"> <strong>
              <input name="height" type="text" class="inputs" id="height" onBlur="calc()" value="<?php echo $height;?>" size="10"/>
              <font face="Verdana, Arial, Helvetica, sans-serif" size="3"> <font face="Verdana, Arial, Helvetica, sans-serif" size="3"> Ft.</font></font></strong></div></td>
          </tr>
          <tr>
            <td height="36" valign="middle"><div align="right"><strong>Quantity * </strong></div></td>
            <td valign="middle"><div align="left"> <strong>
              <input name="qty" type="text" class="inputs" id="qty" onBlur="calc()" value="<?php echo $qty;?>" size="10"/>
              <font face="Verdana, Arial, Helvetica, sans-serif" size="3"> <font face="Verdana, Arial, Helvetica, sans-serif" size="3"> Unit</font></font></strong></div></td>
          </tr>
          <tr>
            <td height="36" valign="middle"><div align="right"><strong>Area of Material* </strong></div></td>
            <td valign="middle"><div align="left"> <strong><font face="Verdana, Arial, Helvetica, sans-serif" size="3"> <font face="Verdana, Arial, Helvetica, sans-serif" size="3"> </font></font>
              <input name="total_area" type="text" class="inputs" id="total_area" onBlur="calc()" value="<?php echo $total_area;?>" size="15"/>
              <font face="Verdana, Arial, Helvetica, sans-serif" size="3"><font face="Verdana, Arial, Helvetica, sans-serif" size="3"> Sqr. Ft.</font></font></strong></div></td>
          </tr>
          <tr>
            <td height="36" valign="middle"><div align="right"><strong>Total Amount * </strong></div></td>
            <td valign="middle"><div align="left"><strong>
              <input name="total_amount" type="text" class="inputs" id="total_amount" onBlur="calc()" value="<?php echo $total_amount;?>" size="15"/>
              <font face="Verdana, Arial, Helvetica, sans-serif" size="3"> (Naira)</font></strong></div></td>
          </tr>
          <tr>
            <td height="36" valign="middle"><div align="right"><strong>Received By  * </strong></div></td>
            <td valign="middle"><div align="left"><strong>
              <input name="receive_by" type="text" class="inputs" id="receive_by" onBlur="calc()" value="<?php echo $receive_by;?>" size="15"/>
            </strong></div></td>
          </tr>
          <tr>
            <td height="38" valign="middle">&nbsp;</td>
            <td valign="middle"><div align="left">
              <input name="Submit" type="submit" class="inputs-focus" value="Add Goods" />
            </div></td>
          </tr>
		  
		  <?php } } ?>
        </table>
        </form>
      <hr />
      <span class="style10 style6">List of Goods Received  Today
      <?php echo date('l - dS \of M, Y');?>
      </span><br />
      <table width="95%" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
        <tr bgcolor="green" class="textonly3">
          <td width="28" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>S/N</strong></div></td>
		  <td width="91" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Date  </strong></div></td>
		  <td width="221" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Company Name </strong></div></td>
		  <td width="217" align="center" bgcolor="#000"><div align="center" class="style9"><strong>Goods Description</strong></div></td>
		  <td width="95" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Unit Price </strong></div></td>
          <td width="103" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Size </strong></div></td>
		  <td width="144" align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Total Amount  </strong></div></td>
		  <td width="31" align="center" bgcolor="#000000" colspan="2"><div align="center" class="style9"><strong></strong></div></td></tr>
<?php 
	$mn=date('Y-m');
	$result2= mysql_query("select * from good_received where substring(dat,1,7)='$mn' order by id desc");
    $num_results=mysql_affected_rows();
	if($num_results>=1)
	{
		for($i=1; $i<=$num_results; $i++) 
		{
			$rows= mysql_fetch_array($result2);
			echo "<tr><td>$i</td>";
			$id=$rows["id"];
			echo "<td>".$rows["dat"]."</td>";
			echo "<td>".$rows["company"]."</td>";
			echo "<td>".$rows["des"]." [".$rows["item_id"]."]</td>";
			echo "<td>".number_format($rows["price"],2)."</td>";
			echo "<td>".$rows["qty"]."(".$rows["width"]." X ".$rows["height"].")</td>";
			echo "<td>".number_format($rows["total_amount"],2)."</td>";
			echo "<td align=center><a href='view_good_received.php?id=$id' target='_blank'>
			<img src='images/Preview-icon.png' alt='Preview' width='22' height='22' border='0' /></td>";
			echo "<td align=center><a href='main.php?page=good_received&action=delete&id=$id' title='Delete Goods Received'>
			<img src='images/del-icon.png' alt='Delete' width='22' height='22' border='0' /></td></tr>";
		}
	}
	else echo "<tr align='center'><td colspan='9'>There is no record for Today</td></tr>";
?>
    </table>      
      <?php if($type=="Super"){ ?>
      <table width="43" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="43" height="25" bgcolor="#FFFFFF"><a href="main.php?page=r_good_received"><img src="images/Preview-icon.png" alt="Preview in Printable Format" width="42" height="42" border="0" /></a><a href="print_setup_item.php?download=excel" target="_blank"></a></td>
        </tr>
      </table>
      <?php } ?>
    </td>
  </tr>
</table>
<br />
</body>
</html>