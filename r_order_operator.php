<?php 

$id=$_GET['id'];
$Submit=$_POST['Submit'];

$d=$_POST['d'];
$m=$_POST['m'];
$y=$_POST['y'];
$rept=$_POST['rept'];
$cat=$_POST['cat'];
$st=$_POST['st'];
$item_id=$_POST['item_id'];

if(!$cat) $cat=$_GET['company'];
if(!$rept) $rept=$_GET['rept'];

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
.style7 {
	font-size: 16px;
	font-weight: bold;
}
.style10 {color: #009900}
-->
</style>
</head>

<body>
<table width="100%" height="181" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
   <td height="13" valign="middle" class="textonly3"><p align="center" class="title style6"><strong> Ordered Printing Report         </strong></p>
          <hr /></td>
  </tr>
  <tr>
    <td height="157" align="center" valign="top"><form id="form1" name="form1" method="post" action="main.php?page=r_order_operator">
      <table width="100%" height="45" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr bgcolor="#B9B9B9">
          <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">
           <?php
		   		if(!$rept or $rept=="dd") $ddd="checked='checked'";
				elseif($rept=="mm") $mmm="checked='checked'";
				elseif($rept=="yy") $yyy="checked='checked'";
				elseif($rept=="aa") $aaa="checked='checked'";
				elseif($rept=="ww") $www="checked='checked'";
				if($use_cat) $use="checked='checked'";
		   
		   ?>
            <input name="rept" type="radio" value="aa" <?php echo $aaa;?>  title="Search All Records" /> <strong>All
            <input name="rept" type="radio" value="ww" <?php echo $www;?>  title="Search 7days to Selected Date" /> 7days to </strong>
            <input name="rept" type="radio" value="dd" <?php echo $ddd;?> title="Search Day" />
            <select name="d" id="d" class="inputs" title="Day" >
              <?php
					if(!$d) $d=date('d');
					for($i=1;$i<=31;$i++)
					{ 
						if(strlen($i)==1) $i="0$i";
						if($i==$d) echo "<option value='$i' selected='selected'>$i</option>";
						else echo "<option value='$i'>$i</option>";
				 	}
			 ?>
            </select>
            <input name="rept" type="radio" value="mm" <?php echo $mmm;?> title="Search Month" />
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
            <input name="rept" type="radio" value="yy" <?php echo $yyy;?> title="Search Year" />
            <select name="y" id="y" class="inputs" title="Year">
              <?php 
					if(!$y) $y=date('Y');
					for($i=1990;$i<=2050;$i++)
					{ 
						if($i==$y) echo "<option value='$i' selected='selected'>$i</option>";
						else echo "<option value='$i'>$i</option>";
				 	}
			 ?>
            </select>
            <span class="title">
            
            <select name="cat" class="inputs" id="cat" title="Category of Goods" >
              <?php 
					if($cat=="") $cat=$ct;
						echo "<option value='' selected='selected'>All Clients</option>";
				  		$q4=mysql_query("select * from admin order by fname");
						$r4=mysql_affected_rows();
						for($i=1;$i<=$r4;$i++)
						{
							$row4=mysql_fetch_array($q4);
							$f=$row4['fname'];
							$l=$row4['lname'];
							$cat2="$f $l";
							if($cat2==$cat)  echo "<option value='$cat2' selected='selected'>$cat2</option>";
							else echo "<option value='$cat2'>$cat2</option>";
						}
                  ?>
            </select>
           
            <select name="item_id" class="inputs" id="item_id" >
              <?php 
						echo "<option value='' selected='selected'>All Materials</option>";
				  		$q4=mysql_query("select * from items order by item_id");
						$r4=mysql_affected_rows();
						for($i=1;$i<=$r4;$i++)
						{
							$row4=mysql_fetch_array($q4);
							$item_id2=$row4['item_id'];
							if($item_id2==$item_id)  echo "<option value='$item_id' selected='selected'>$item_id</option>";
							else echo "<option value='$item_id2'>$item_id2</option>";
						}
                  ?>
            </select>
          
            <select name="st" id="st" class="inputs" title="Sorting Order">
              <?php 
			  		if(!$st or $st=="asc") { $asc="asc"; $a="selected='selected'"; }
					elseif($st=="desc") { $desc="desc"; $b="selected='selected'"; }
			  ?>
              <option value="asc" <?php echo $a;?> >asc</option>
              <option value="desc" <?php echo $b;?>>desc</option>
            </select>
            <input name="Submit" type="submit" class="inputs" id="Submit" value="Go &gt;&gt;"  title="Validate Selections" />
            </span></td>
          </tr>
      </table>
      <hr />
    </form>
      <p class="style7 style10">
	  <?php 
	  			if($cat and !$item_id) 
					{
						if($rept=="aa") $add_this="where approve_by='$cat'";
						else $add_this="and approve_by='$cat'";
						$dcat="$cat Ordered";
					}
				elseif(!$cat and $item_id) 
					{
						if($rept=="aa") $add_this="where item_id='$item_id'";
						else $add_this="and item_id='$item_id'";
						$dcat="$item_id Ordered";
					}
				elseif($cat and $item_id) 
					{
						if($rept=="aa") $add_this="where item_id='$item_id' and approve_by='$cat'";
						else $add_this="and item_id='$item_id' and approve_by='$cat'";
						$dcat="$cat Ordered with ID [$item_id]";
					}
				else $dcat="Ordered Items";
					
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
			
			if ($rept=="dd" or !$rept) echo $hd="Summary of $dcat on ".date("l - jS \of M Y", mktime(0,0,0,$m1,$d,$y)); 
			elseif ($rept=="mm") echo $hd="Summary of $dcat in the Month of $m, $y"; 
			elseif ($rept=="yy") echo $hd="Summary of $dcat in the Year $y"; 
			elseif ($rept=="aa") echo $hd="Overall Summary of $dcat till date"; 
			elseif ($rept=="ww")
			{
				echo $hd="Summary of $dcat from [".date("D - jS M Y", mktime(0,0,0,$m1,$d-6,$y))."] 
				to [".date("D - jS M Y", mktime(0,0,0,$m1,$d-0,$y))."]";
				
				$start=date("Y-m-d", mktime(0,0,0,$m1,$d-6,$y)); 
				$end=date("Y-m-d", mktime(0,0,0,$m1,$d-0,$y));
			}
			
	  ?></p>
      <table width="95%" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
        <tr bgcolor="green" class="textonly3">
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>S/N</strong></div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Date</strong></div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Customer</strong></div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Material</strong></div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Inv. No.</strong></div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Job Area</strong></div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Size</strong></div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong> Price(#) </strong></div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Total</strong>(#)</div></td>
          <td align="center" bgcolor="#000000"><div align="center" class="style9"><strong>Paid</strong>(#)</div></td>
        </tr>
        <?php
	$datd="$y-$m1-$d"; $datm="$y-$m1"; $daty="$y";
	$tb_name="good_ordered";
	if(!$rept or $rept=='dd') $sql="select * from $tb_name where dat='$datd' $add_this order by dat $st";
	elseif($rept=='mm') $sql= "select * from $tb_name where substring(dat,1,7)='$datm' $add_this order by dat $st";
	elseif($rept=='yy') $sql= "select * from $tb_name where substring(dat,1,4)='$daty' $add_this order by dat $st";
	elseif($rept=='aa') $sql="select * from $tb_name $add_this order by dat $st";
	elseif($rept=='ww') $sql="select * from $tb_name where dat BETWEEN '$start' AND '$end' $add_this order by dat $st";
	
	$result2=mysql_query($sql);
    $num_results=mysql_affected_rows();
	if($num_results>=1)
	{
		for($i=1; $i<=$num_results; $i++) 
		{
			$rows= mysql_fetch_array($result2);
			
			$discount=number_format($rows["discount"],2);
			$processed_by=$rows["approve_by"];
			
			$area=$rows["width"]*$rows["height"]*$rows["qty"];
			$total_sales=$area*$rows["sale_price"]-$rows["discount"];
			$original_total=$area*$rows["sale_price"];
			$dept=number_format(($total_sales-$rows["amount_paid"]),2);
			
			$agg_total_sales+=$total_sales;
			$agg_total_amount+=$rows["amount_paid"];
			$agg_dept+=$dept;
			$agg_discount+=$rows["discount"];
			$optname=$rows["optname"];
			$customer=$rows["ord_by"];
			
			echo "<tr title='- Discount: N$discount \n- Processed by: $processed_by \n- Debt: N$dept \n- Total (No discount): N$original_total'><td>$i</td>";
			echo "<td>".$rows["dat"]."</td>";
			$optname=$rows["optname"];
			$customer=$rows["ord_by"];
			
			$r5=mysql_query("select * from clients where company='$customer'");
   			$row5=mysql_fetch_array($r5);
			//$customer=$["customer"];
			$phone=$row5["phone"];
			$address=$row5["address"];
			$cid=$row5["id"];
			
			$id=$rows["id"];
			$ord_by=$rows["ord_by"];
			$dat=$rows["dat"];
			$discount=$rows["discount"];			
			echo "<td><a href='view_clients.php?id=$cid' title='Tel: $phone | Address: $address' target='_blank'>$customer</td>";
			echo "<td>".$rows["item_id"]."</td>";
			echo "<td><a href='view_item_ordered.php?id=$id' target='_blank'>".$rows["ord_no"]."</a></td>";
			//echo "<td>".$rows["des"]."</td>";
			
			echo "<td>".$rows["width"]." X ".$rows["height"]."</td>";
			echo "<td>".number_format($rows["qty"])."</td>";
			$in_stock=$rows["in_stock"];
			$now_stock=$rows["now_stock"];
			$area=$rows["width"]*$rows["height"];
			echo "<td>".number_format($rows["sale_price"])."</td>";
			$total_amount=$rows["qty"]*$area*$rows["sale_price"]-$discount;
			echo "<td>".number_format($total_amount,2)."</td>";
			echo "<td>".number_format($rows['amount_paid'],2)."</td></tr>";
			
			$total_paid+=$rows['amount_paid'];
			$agg_original_total+=$original_total;
		}
		
		
		echo "<tr bgcolor='#00CC66' title='- Total Discount: N$agg_discount \n- Total Debt: N$agg_dept \n- Total Payment (No Discount): N$agg_original_total'>"; ?>
          <td bgcolor="#00CC66">&nbsp;</td>
          <td bgcolor="#00CC66">&nbsp;</td>
          <td bgcolor="#00CC66">&nbsp;</td>
          <td bgcolor="#00CC66">&nbsp;</td>
          <td bgcolor="#00CC66">&nbsp;</td>
          <td bgcolor="#00CC66">&nbsp;</td>
          <td bgcolor="#00CC66">&nbsp;</td>
          <td bgcolor="#00CC66"><b>Total Sales</b></td>
          <td align="center" bgcolor="#00CC66"><b>
            <?php echo number_format($agg_total_sales,2);?>
          </b></td>
          <td align="center" bgcolor="#00CC66"><b>
            <?php echo number_format($total_paid,2);?>
          </b></td>
        </tr>
        <?php
	}
	else echo "<tr><td colspan='11'><center>No Record Found</td></tr>";
?>
      </table>
      <br />
      <table width="147" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="43" height="25" bgcolor="#FFFFFF"><a href="print_order_operator.php?rept=<?php echo $rept;?>&amp;d=<?php echo $d;?>&amp;m1=<?php echo $m1;?>&amp;y=<?php echo $y;?>&amp;hd=<?php echo $hd;?>&amp;start=<?php echo $start;?>&amp;end=<?php echo $end;?>&amp;cat=<?php echo $cat;?>&amp;item_id=<?php echo $item_id;?>&amp;st=<?php echo $st;?>" target="_blank"><img src="images/Preview-icon.png" alt="Preview in Printable Format" width="42" height="42" border="0" /></a><a href="print_setup_item.php?download=excel" target="_blank"></a></td>
          <td width="63" bgcolor="#FFFFFF">&nbsp;</td>
          <td width="41" bgcolor="#FFFFFF"><a href="print_item_ordered.php?rept=<?php echo $rept;?>&d=<?php echo $d;?>&m1=<?php echo $m1;?>&y=<?php echo $y;?>&hd=<?php echo $hd;?>&start=<?php echo $start;?>&end=<?=php echo $end;?>&cat=<?php echo $cat;?>&item_id=<?php echo $item_id;?>&st=<?php echo $st;?>&download=<?php echo "$page".date('Ymdhms');?>"><img src="images/Download-Excel-icon.png" alt="Download in Excel Format" width="41" height="39" border="0" /></a></td>
        </tr>
      </table></td>
  </tr>
</table>
<br />
</body>
</html>
