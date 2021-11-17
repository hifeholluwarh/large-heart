<?php
$action=$_GET['action'];
$id=$_GET['id'];

$Submit=$_POST['Submit'];
$Submit1=$_POST['Submit1'];
$item_id=$_POST['item_id'];
$des=$_POST['des'];
$in_stock=$_POST['in_stock'];
$price=$_POST['price'];
$price2=$_POST['price2'];
$critical=$_POST['critical'];

if($action=="delete")
{
	$msg= "Do you want to delete the selected <b>Item/Product</b>?
	<input type=Submit name=Submit id=Submit value='Confirm Delete'>
	<input type=Submit name=Submit id=Submit value='Cancel'> ";
}

if ($Submit == "Confirm Delete")
{
		$result=mysql_query("delete from items where id='$id'");
		$msg= "The selected Item/Product has been deleted";
		$hide="yes";
}	
elseif ($Submit == "Cancel") $msg= "The delete operation cancelled";

if($Submit=="Update Item")
{
	
	if(!$item_id)  $msg="You need to specify the Material ID!";
	elseif(!$des)  $msg="You need to specify the Material Description!";
	elseif($in_stock and !is_numeric($in_stock)) $msg="Invalid Entry for Stock Number (Pls! no comma).";
	elseif(!is_numeric($price) or !is_numeric($price)) $msg="The Cost/Selling Price should be a number!";
	elseif($price > $price2) $msg="The Cost Price cannot be more than the Selling price";
	else
	{	
		$result=mysql_query("update items set in_stock='$in_stock', des='$des', item_id='$item_id', 
		price='$price', sale_price='$price2', critical='$critical'  where id='$id'");
		$msg="Item/Product has been Successfully Updated! <a href='main.php?page=setup_item'>Add Item</a>"; 
	}
}

$result=mysql_query("select * from items where id='$id'");
$num_result=mysql_affected_rows();
$row=mysql_fetch_array($result);
$item_id=$row["item_id"];
$des=$row["des"];
$price=$row["price"];
$price2=$row["sale_price"];
$in_stock=$row["in_stock"];
$critical=$row["critical"]
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
.style10 {font-weight: bold}
.style11 {font-weight: bold}
.style12 {
	font-size: 18px;
	font-weight: bold;
}
.style13 {font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="100%" height="181" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
   <td height="13" valign="middle" class="textonly3"><p align="center" class="title style6"><strong>Item/Product Edit</strong></p>
          <hr /></td>
  </tr>
  <tr>
    <td height="157" align="center" valign="top"><form id="form1" name="form1" method="post" action="">
        <font color="#FF0000" face="Verdana, Arial, Helvetica, sans-serif" size="-1">
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
            <td align="left" valign="middle"><div align="left">
              <input name="price" type="text" class="inputs" id="price" value="<?php echo $price;?>" size="15"/>
              <span class="style12">Naira/Ft.</span></div></td>
          </tr>
          <tr>
            <td height="38" valign="middle"><div align="right"><strong>Sales Price   : </strong></div></td>
            <td align="left" valign="middle"><div align="left">
              <input name="price2" type="text" class="inputs" id="price2" value="<?php echo $price2;?>" size="15"/>
              <span class="style12">Naira/Ft.</span></div></td>
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
            <td width="310" align="left" valign="middle"><div align="left">
              <input name="Submit" type="submit" class="inputs-focus" value="Update Item" />
            </div></td>
          </tr>
        </table>
    </form>
      <hr />
		  <span class="style10 style6">List of Items Available 
		  <?php if($show_shelf) echo "in <b>$show_shelf</b> Shelf"; ?>
		  </span>
      <table width="95%" height="26" border="1" align="center" cellpadding="5" cellspacing="0">
        <tr bgcolor="green">
          <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>S/N</strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Item ID</strong></div></td>
	      <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Description</strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>In Stock</strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Cost Price</strong></div></td>
		  <td align="center" bgcolor="#000"><div align="center" class="style9"><strong>Selling Price</strong></div></td>
		  <td align="center" bgcolor="#000" colspan="3"><div align="center" class="style9">
		  <a href="main.php?page=setup_item">
		  <img src='images/new-icon.png' alt='Add New' width='67' height='30' border='0' /></a></div>		   
		  <div align="center" class="style9"><strong></strong></div></td>
	    </tr>
<?php
	$id_color=$id;
	$result2= mysql_query("select * from items order by id");
    $num_results=mysql_affected_rows();
	for($i=1; $i<=$num_results; $i++) 
   	{
		$rows= mysql_fetch_array($result2);
		$id=$rows["id"];
		if($id_color==$id) $colo="#CCCCCC"; else $colo="";
		echo "<tr class=textonly3 bgcolor=$colo><td>$i</td>";
		$c_level=$rows["critical"];		
		echo "<td>".$rows["item_id"]."</td>";
		echo "<td>".$rows["des"]."</td>";
		$in_stock=$rows["in_stock"];
		if($in_stock<=$c_level) echo "<td bgcolor='#FF99CC' title='You need to add to stock'>".number_format($rows["in_stock"])."</td>";
		else echo "<td>".number_format($rows["in_stock"])."</td>";
		echo "<td align='right'>".number_format($rows["price"],2)."</td>";
		echo "<td align='right'>".number_format($rows["sale_price"],2)."</td>";
		echo "<td align=center><a href='main.php?page=edit_item&id=$id' class='textonly1'>
		<img src='images/edit-icon.png' alt='Edit' width='22' height='22' border='0' /></a></td>";
		echo "<td align=center><a href='main.php?page=edit_item&action=delete&id=$id' class='textonly1'>
		<img src='images/del-icon.png' alt='Delete' width='22' height='22' border='0' /></a></td></tr>";
	}
?>
    </table></td>
  </tr>
</table>
<br />
</body>
</html>
