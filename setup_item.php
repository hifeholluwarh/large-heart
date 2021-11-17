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

$Submit=$_POST['Submit'];
$Submit1=$_POST['Submit1'];
$price=$_POST['price'];
$price2=$_POST['price2'];
$critical=$_POST['critical'];
$item_id=$_POST['item_id'];
$des=$_POST['des'];
$in_stock=$_POST['in_stock'];

if($Submit=="Add Material")
{
	if(!$item_id)  $msg="You need to specify the Item ID!";
	elseif(!$des)  $msg="You need to specify the Item Description!";
	elseif($in_stock and !is_numeric($in_stock)) $msg="Invalid Entry for Stock Number (Pls! no comma).";
	elseif(!is_numeric($price) or !is_numeric($price)) $msg="The Cost/Selling Price should be a number!";
	elseif($price > $price2) $msg="The Cost Price cannot be more than the Selling price";
	else
	{
		$result=mysql_query("select * from items where item_id='$item_id'");
		$num_result=mysql_affected_rows();
		if($num_result >= 1) 
		{
		  	$msg="Sorry, Material/Product ID &quot;$item_id&quot; already exist! Use another."; 
		}
		else
		{
			$result=mysql_query("insert into items values ('','$item_id','$des','$in_stock','$critical','$price','$price2')");
		  	$msg="Material/Product added successfully!"; 
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
   <td height="13" valign="middle" class="textonly3"><p align="center" class="title style6"><strong>Material/Product Setup          </strong></p>
          <hr /></td>
  </tr>
  <tr>
    <td height="157" align="center" valign="top"><form id="form1" name="form1" method="post" action="">
        <font color="#FF0000" face="Verdana, Arial, Helvetica, sans-serif">
        <?php echo $msg;?>
        </font><br />
        <table width="478" border="0" align="center" cellpadding="0" cellspacing="0" class="textonly3">
	  
          <tr>
            <td height="38" valign="middle"><div align="right"><strong>Material/Product ID : </strong></div></td>
            <td align="left" valign="middle"><div align="left">
                <input name="item_id" type="text" class="inputs" id="item_id" value="<?php echo $item_id;?>"/>
            </div></td>
          </tr>
          <tr>
            <td height="38" valign="middle"><div align="right"><strong>Item Description : </strong></div></td>
            <td align="left" valign="middle"><div align="left">
                <input name="des" type="text" class="inputs" id="des" value="<?php echo $des;?>" size="40" />
            </div></td>
          </tr>
          <tr>
            <td height="38" valign="middle"><div align="right"><strong>Cost Price   : </strong></div></td>
            <td align="left" valign="middle">
              <div align="left">
                <input name="price" type="text" class="inputs" id="price" value="<?php echo $price;?>" size="15"/>            
              <span class="style12"> Naira/Ft.</span></div></td>
          </tr>
          <tr>
            <td height="38" valign="middle"><div align="right"><strong>Selling Price   : </strong></div></td>
            <td align="left" valign="middle"><div align="left">
              <input name="price2" type="text" class="inputs" id="price2" value="<?php echo $price2;?>" size="15"/>
              <span class="style12"> Naira/Ft. </span></div></td>
          </tr>
          <tr>
            <td height="38" valign="middle"><div align="right"><strong>Area In-Stock : </strong></div></td>
            <td align="left" valign="middle"><div align="left">
                <input name="in_stock" type="text" class="inputs" id="in_stock" value="<?php echo $in_stock;?>" size="10"/>
                <span class="style12"> Sqr. Ft.</span></div></td>
          </tr>
          <tr>
            <td height="38" valign="middle"><div align="right"><strong>Critical Level  : </strong></div></td>
            <td align="left" valign="middle"><div align="left">
                <?php if(!$critical) $critical="20"; ?>
                <input name="critical" type="text" class="inputs" id="critical" value="<?php echo $critical;?>" size="10"/>
                <span class="style12">Sqr. Ft.</span></div></td>
          </tr>
          
          <tr>
            <td width="168" height="38" valign="middle">&nbsp;</td>
            <td width="310" align="left" valign="middle">
              <div align="left">
                <input name="Submit" type="submit" class="inputs-focus" value="Add Material" />
              </div></td>		
          </tr>

        </table>
        </form>
      <hr />
      <span class="style10 style6">List of Items Available  <?php if($show_shelf) echo "in <b>$show_shelf</b> Shelf"; ?> 
	  <?php if($show_cat) echo "under <b>$show_cat</b> Category"; ?></span>
      <table width="95%" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
        <tr bgcolor="green" class="textonly3">
          <td width="20" align="center" bgcolor="#000"><div align="center" class="style9"><strong>S/N</strong></div></td>
		  <td width="86" align="center" bgcolor="#000"><div align="center" class="style9"><strong>Item ID</strong></div></td>
	      <td width="111" align="center" bgcolor="#000"><div align="center" class="style9"><strong>Description</strong></div></td>
		  <td width="92" align="center" bgcolor="#000"><div align="center" class="style9"><strong>In Stock (Sqr. Ft.)</strong></div></td>
		  <td width="62" align="center" bgcolor="#000"><div align="center" class="style9"><strong>Cost Price</strong></div></td>
          <td width="62" align="center" bgcolor="#000"><div align="center" class="style9"><strong>Sales Price</strong></div></td>
		  <td width="19" align="center" bgcolor="#000"><div align="center" class="style9"><strong></strong></div></td>
        </tr>
<?php
	$result2= mysql_query("select * from items order by id");
    $nums=mysql_affected_rows();
	for($i=1; $i<=$nums; $i++) 
   	{
		$rows= mysql_fetch_array($result2);
		echo "<tr><td>$i</td>";
		$id=$rows["id"];
		$c_level=$rows["critical"];
		$shelfy=$rows["shelf"];
		$caty=$rows["cat"];
		echo "<td>".$rows["item_id"]."</td>";
		echo "<td>".$rows["des"]."</td>";
		$in_stock=$rows["in_stock"];
		if($in_stock<=$c_level) echo "<td bgcolor='#FF99CC'>".number_format($rows["in_stock"])."</td>";
		else echo "<td>".number_format($rows["in_stock"])."</td>";
		echo "<td align='right'>".number_format($rows["price"],2)."</td>";
		echo "<td align='right'>".number_format($rows["sale_price"],2)."</td>";
		echo "<td align=center><a href='main.php?page=edit_item&id=$id'>
		<img src='images/edit-icon.png' alt='Edit Item' width='22' height='22' border='0' /></a></td></tr>";
			}
?>
    </table>
      <table width="43" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="43" height="25" bgcolor="#FFFFFF"><a href="print_setup_item.php" target="_blank"><img src="images/Preview-icon.png" alt="Preview in Printable Format" width="42" height="42" border="0" /></a><a href="print_setup_item.php?download=excel" target="_blank"></a></td>
        </tr>
      </table>
<br /></td>
  </tr>
</table>
<br />
</body>
</html>
