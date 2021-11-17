<script type="text/javascript">
function reload(form)
{
	var dt=form.d.options[form.d.options.selectedIndex].value;
	var mt=form.m.options[form.m.options.selectedIndex].value;
	var yr=form.y.options[form.y.options.selectedIndex].value;
	var ordby=form.ord_by.options[form.ord_by.options.selectedIndex].value;
	var itemid=form.item_id.options[form.item_id.options.selectedIndex].value; 
	self.location='main.php?page=job_order&dt=' + dt + '&mt=' + mt + '&yr=' + yr + '&itemid=' + itemid + '&ordby=' + ordby + '#t';
}


function FormatNumberBy3(num, decpoint, sep) {
  // check for missing parameters and use defaults if so
  if (arguments.length == 2) {
    sep = ",";
  }
  if (arguments.length == 1) {
    sep = ",";
    decpoint = ".";
  }
  // need a string for operations
  num = num.toString();
  // separate the whole number and the fraction if possible
  a = num.split(decpoint);
  x = a[0]; // decimal
  y = a[1]; // fraction
  z = "";


  if (typeof(x) != "undefined") {
    // reverse the digits. regexp works from left to right.
    for (i=x.length-1;i>=0;i--)
      z += x.charAt(i);
    // add seperators. but undo the trailing one, if there
    z = z.replace(/(\d{3})/g, "$1" + sep);
    if (z.slice(-sep.length) == sep)
      z = z.slice(0, -sep.length);
    x = "";
    // reverse again to get back the number
    for (i=z.length-1;i>=0;i--)
      x += z.charAt(i);
    // add the fraction back in, if it was there
    if (typeof(y) != "undefined" && y.length > 0)
      x += decpoint + y;
  }
  return x;
}

function check_stat()
{
	
	client_id=document.form1.client_id.value
	//discount=document.form1.discount.value
	if(client_id == 'Non Regular')
	{
		document.form1.client_non.disabled=false
	}
	else document.form1.client_non.disabled=true
}

function calc()
{
	sale_price=document.form1.sale_price.value
	width=document.form1.width.value
	height=document.form1.height.value
	qty=document.form1.qty.value
	in_stock=document.form1.in_stock.value
	
	area=Number(width)*Number(height)*Number(qty)
	
	if(qty <= 0)
	{
		alert("The quantity of goods cannot be less than 1")
		document.form1.qty.value=1
	}
	if(area >= in_stock)
	{
		alert("The Material in Stock is less than the Material to use")
		//document.form1.qty.value=1
	}
	else if(isNaN(qty) || isNaN(width) || isNaN(height))
	{
		alert("This field must be Number only (no comma)")
		document.form1.qty.value=1
	}
	else
	{
		//alert("Total Area = #"+FormatNumberBy3(area))
		amount=(Number(sale_price)*Number(area))
		//alert("Total Amount = #"+FormatNumberBy3(amount))
		document.form1.total_amount.value=amount
		document.form1.total_area.value=area
	}
}

</script>
<?php
$action=$_GET['action'];
$id=$_GET['id'];
$Submit=$_POST['Submit'];
$Load=$_POST['Load'];
$Load2=$_POST['Load2'];

$ord_by=$_POST['ord_by'];
$approve_by=$_POST['approve_by'];
$item_id=$_POST['item_id'];
$in_stock=$_POST['in_stock'];
$price=$_POST['price'];
$sale_price=$_POST['sale_price'];
$des=$_POST['des'];
$width=$_POST['width'];
$height=$_POST['height'];
$qty=$_POST['qty'];
$ord_no=$_POST['ord_no'];
$discount=$_POST['discount'];
$d=$_POST['d'];
$m=$_POST['m'];
$y=$_POST['y'];


if(!$width) $width=1;
if(!$height) $height=1;
if(!$qty) $qty=1;

$area=$width*$height*$qty;

if($action=="delete")
{
	$msg= "Do you want to delete the selected <b>Job Order Details</b>?
	<input type=Submit name=Submit id=Submit value='Confirm Delete'>
	<input type=Submit name=Submit id=Submit value='Cancel'> ";
}

if($itemid and !$Submit=="Finish Order")
{
	$item_id=$itemid;
	
		$q5=mysql_query("select * from items where item_id='$item_id'");
		//$r4=mysql_affected_rows();
		$row5=mysql_fetch_array($q5);
		$unit=$row5['unit'];
		$des=$row5['des'];
		$in_stock=$row5['in_stock'];
		$price=$row5['price'];
		$sale_price=$row5['sale_price'];
		
		$msg= "Item Loaded!... You can now enter Quatity and Unit Price";
	
}
if ($Submit == "Confirm Delete")
{
		$result=mysql_query("delete from job_order where id='$id'");
		$msg= "The selected Job Order Details has been deleted";

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
			
	$dat="$y-$m1-$d";

if($Submit=="Submit Order")
{
	if(!$ord_no or !$ord_by or !$sale_price or !$width or !$height)
	{
	 	$msg="All the field marked &quot;*&quot; are required!";
    }
	elseif($area > $in_stock)
	{
	 	$msg="The Material in stock is less than the quantity required!";
    }
	elseif(!is_numeric($sale_price) or !is_numeric($width) or !is_numeric($height)) $msg="Error! Job Sizes and Selling Price must be a number";
	elseif(!checkdate($m1, $d, $y))	$msg="The Date selected is invalid!";
	else
	{
		 $result=mysql_query("select * from job_order where ord_no='$ord_no'");
		 $num_result=mysql_affected_rows();
		 if($num_result > 0)
		 {
		  	$msg="Sorry, Job with Order Number &quot;$ord_no&quot; Already Exist! <a href='main.php?page=job_order'>Add New Sales</a>"; 
		 }
		 else
		 {
		 	$total_amount=$area*$sale_price-$discount;
			$now_stock=$in_stock-$area;
			
		  	$result=mysql_query("insert into job_order values('','$dat','$item_id','$des','$price','$sale_price','$width','$height','$qty',
			'$discount','$ord_by','$approve_by','$ord_no','no')");
			$msg="Job Ordered detail was successful! <a href='main.php?page=job_order'>Add New Job Order</a>";
				$item_id=""; $itemid=""; $count="New"; $ordby=""; $ord_by="";
		 }
	}
}
//echo $count;
$q1=mysql_query("select * from job_order order by id desc");
$r2=mysql_affected_rows();
$rs=mysql_fetch_array($q1);
$ord_no=$rs['ord_no'];
$ord_no++;
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
.style10 {	font-size: 14px;
	font-weight: bold;
}
.style11 {color: #FF0000}
-->
</style>
</head>

<body>
<table width="100%" height="181" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
   <td height="13" valign="middle" class="textonly3"><p align="center" class="title style6"><strong>Job Order Entry</strong></p>
          <hr /></td>
  </tr>
  <tr>
    <td height="157" align="center" valign="top"><form id="form1" name="form1" method="post" action="">
        <font color="#FF0000" face="Verdana, Arial, Helvetica, sans-serif" size="-1">
        <?php echo $msg;?>
        </font><br />
        <table width="496" border="0" align="center" cellpadding="0" cellspacing="2" class="textonly3">
          <tr>
            <td height="36" valign="middle"><div align="right"><strong>Order Number </strong></div></td>
            <td valign="middle"><div align="left"> <strong><font face="Verdana, Arial, Helvetica, sans-serif" size="3"> &nbsp;&nbsp;
              <?php echo $ord_no;?>
              <input name="ord_no" type="hidden" value="<?php echo $ord_no;?>" size="8"  />
            </font></strong> </div></td>
          </tr>
          <tr>
            <td width="199" height="28" valign="middle"><div align="right"><strong>Sales Date  * </strong></div></td>
            <td width="291" valign="middle"><div align="left">
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
            <td height="36" valign="middle"><div align="right"><strong>Order by * </strong></div></td>
            <td valign="middle"><div align="left">
              <?php
            	if($ord_by=="") $ord_by=$_GET['ordby'];
				$res3=mysql_query("select * from debt where ord_by='$ord_by'");
				$num3=mysql_affected_rows();
				if($num3>=1)
				{
					for($i=1;$i<=$num3;$i++)
					{
						$rw=mysql_fetch_array($res3);
						$total_dept+=$rw['balance'];
					}
				}
			?>
              <select name="ord_by" class="inputs" id="ord_by" >
                <?php
						
						if($ord_by=="") echo "<option value='' selected='selected'>Select One</option>";
				  		$q4=mysql_query("select * from clients order by id");
						$r4=mysql_affected_rows();
						for($i=1;$i<=$r4;$i++)
						{
							$row4=mysql_fetch_array($q4);
							$ord_by2=$row4['company'];
							if($ord_by2==$ord_by)  echo "<option value='$ord_by2' selected='selected'>$ord_by2</option>";
							else echo "<option value='$ord_by2'>$ord_by2</option>";
						}
                  ?>
              </select>
              <a href="main.php?page=setup_clients">Add New Client</a></div></td>
          </tr>
          <?php if($total_dept){ ?>
          <tr>
            <td height="18" valign="middle"><div align="right"><strong>Total Dept </strong></div></td>
            <td valign="middle">&nbsp;&nbsp;&nbsp;<span style="font-size:18px; padding:5px; background:#F00">
              <?php echo number_format($total_dept,2);?>
            </span> <a href="main.php?page=r_dept_record&amp;company=<?php echo $ord_by;?>&amp;rept=aa" target="_blank"> View Debt List</a></td>
          </tr>
          <?php } ?>
          <tr>
            <td height="39" valign="middle"><div align="right"><strong>Material Used </strong></div></td>
            <td valign="middle"><div align="left">
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
            <td height="18" valign="middle"><div align="right"><strong>Area in Stock </strong></div></td>
            <td valign="middle"><strong>
              <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="3"> &nbsp;&nbsp;&nbsp;
                <?php echo number_format($in_stock);?>
              </font></div>
              <div align="left">
                <input name="des" type="hidden" id="des" value="<?php echo $des;?>" />
                <input name="in_stock" type="hidden" id="in_stock" value="<?php echo $in_stock;?>" />
                <input name="price" type="hidden" id="price" value="<?php echo $price;?>" />
              </div>
            </strong></td>
          </tr>
          <tr>
            <td height="33" valign="middle"><div align="right"><strong>Unit Price  * </strong></div></td>
            <td valign="middle"><div align="left">
            <input name="sale_price" type="hidden" id="sale_price" value="<?php echo $sale_price;?>" />
              <strong><font face="Verdana, Arial, Helvetica, sans-serif" size="3"> &nbsp;&nbsp;&nbsp; <?php echo $sale_price;?> Naira</font></strong></div></td>
          </tr>
          <tr>
            <td height="36" valign="middle"><div align="right"><strong>Job Width * </strong></div></td>
            <td valign="middle"><div align="left"><strong>
              <input name="width" type="text" class="inputs" id="width" value="<?php echo $width;?>" size="10"  onblur="calc()" />
              <font face="Verdana, Arial, Helvetica, sans-serif" size="3"> Ft.</font></strong></div></td>
          </tr>
          <tr>
            <td height="36" valign="middle"><div align="right"><strong>Job Height * </strong></div></td>
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
            <td height="36" valign="middle"><div align="right"><strong>Discount (If Any) </strong></div></td>
            <td valign="middle"><div align="left">
              <input name="discount" type="text" class="inputs" id="discount"value="<?php echo $discount;?>" size="15" onBlur="calc()" />
              <strong><font face="Verdana, Arial, Helvetica, sans-serif" size="3"> (Naira)</font></strong></div></td>
          </tr>
          <tr>
            <td height="36" valign="middle"><div align="right"><strong>Area of Job* </strong></div></td>
            <td valign="middle"><div align="left"> <strong><font face="Verdana, Arial, Helvetica, sans-serif" size="3"> <font face="Verdana, Arial, Helvetica, sans-serif" size="3"> </font></font>
              <input name="total_area" type="text" class="inputs" id="total_area" onBlur="calc()" value="<?php echo $total_area;?>" size="15"/>
              <font face="Verdana, Arial, Helvetica, sans-serif" size="3"><font face="Verdana, Arial, Helvetica, sans-serif" size="3"> Sqr. Ft.</font></font></strong></div></td>
          </tr>
          <tr>
            <td height="36" valign="middle"><div align="right"><strong>Total Amount * </strong></div></td>
            <td valign="middle"><div align="left"><strong>
              <input name="total_amount" type="text" class="inputs" id="total_amount" onBlur="calc()" value="<?php echo $total_amount;?>" size="15"/>
              <font face="Verdana, Arial, Helvetica, sans-serif" size="3"> (Naira)</font></strong><strong><font face="Verdana, Arial, Helvetica, sans-serif" size="3">
              <?php  echo $approve_by=$loguser; ?>
              <input name="approve_by" type="hidden" id="approve_by" value="<?php echo $approve_by?>" />
              </font></strong></div></td>
          </tr>
          <tr>
            <td height="38" valign="middle">&nbsp;</td>
            <td valign="middle"><div align="left">
              <input name="Submit" type="submit" class="inputs-focus" value="Submit Order" />
            </div></td>
          </tr>
          <?php } ?>
        </table>
    </form>
      <hr />      
      <span class="style10 style6">List of Item Ordered this month of 
      <?php echo date('F, Y');?>
</span><br />
      <table width="95%" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
        <tr bgcolor="green" class="textonly3">
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>S/N</strong></div></td>
		  <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Date Supplied  </strong></div></td>
		  <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Ordered By </strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Goods Description</strong></div></td>
		  <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Job Size </strong></div></td>
		  <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong> Price </strong></div></td>
		  <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong> Total  </strong></div></td>
		  <td align="center" bgcolor="#000000" colspan="2"><div align="center" class="style9"><strong></strong></div></td>
        </tr>
        
<?php
	echo $dat=date('Y-m-d');
	
	if($type=="Operator") $result2= mysql_query("select * from job_order where dat='$dat' and approve_by='$loguser' order by id desc");
	else $result2= mysql_query("select * from job_order where dat='$dat' order by id desc");
	
   echo  $num_results=mysql_affected_rows();
	if($num_results>=1)
	{
		for($i=1; $i<=$num_results; $i++) 
		{
			$rows= mysql_fetch_array($result2);
			echo "<tr class=textonly3><td>$i</td>";
			$id=$rows["id"];
			$processed=$rows["processed"];
			$area=$rows["width"]*$rows["height"];
			echo "<td>".$rows["dat"]."</td>";
			echo "<td>".$rows["ord_by"]."</td>";
			echo "<td>".$rows["des"]." [".$rows["item_id"]."]</td>";
			echo "<td>".$rows["qty"]."(".$rows["width"]." X ".$rows["height"].")</td>";
			echo "<td>".number_format($rows["sale_price"])."</td>";
			echo "<td>".number_format($area*$rows["sale_price"]*$rows["qty"]-$rows["discount"],2)."</td>";
			if($processed!="yes")
			{
				if($type!="Operator")
				{ 
					echo "<td align=center><a href='main.php?page=good_ordered&id=$id'>
					<img src='images/order-icon.png' alt='Enter Job Order' width='22' height='22' border='0' /></td>"; 
				}
				echo "<td align=center><a href='main.php?page=job_order&action=delete&id=$id'>
				<img src='images/del-icon.png' alt='Delete Job Order' width='22' height='22' border='0' /></td>";
			}
			echo "</tr>";
			
			$area=$rows["width"]*$rows["height"]*$rows["qty"];
			$total_amount=$area*$rows["sale_price"]-$rows["discount"];
			$total_sales+=$total_amount;
		}
	}
	else echo "<tr align='center'><td colspan='9'>There is no record for Today</td></tr>";
?>
	<tr bgcolor="green" class="textonly3">
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center"><b>Total</b></td>
          <td align="center"><b>
            <?php echo number_format($total_sales);?>
          </b></td>
          <td align="center" colspan="2">&nbsp;</td>
        </tr>
    </table>  
    
    <?php if($type=="Super"){ ?>    
      <table width="43" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="43" height="25" bgcolor="#FFFFFF"><a href="main.php?page=r_good_ordered"><img src="images/Preview-icon.png" alt="Preview in Printable Format" width="42" height="42" border="0" /></a><a href="print_setup_item.php?download=excel" target="_blank"></a></td>
        </tr>
      </table>
      <?php } ?>
      </td>
  </tr>
</table>
<br />
</body>
</html>
