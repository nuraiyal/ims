<html>
<?php
	require_once('auth.php');
?>
<head>
	<title>POS</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<style type="text/css">
	body {
		padding-top: 60px;
		padding-bottom: 40px;
	}
	.sidebar-nav {
		padding: 9px 0;
	}
	</style>
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="tcal.css" />
	<script type="text/javascript" src="tcal.js"></script>
	<script language="javascript">
	function Clickheretoprint()
	{ 
		var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
		disp_setting+="scrollbars=yes,width=700, height=400, left=100, top=25"; 
		var content_vlue = document.getElementById("content").innerHTML; 
		var docprint=window.open("","",disp_setting); 
		docprint.document.open(); 
		docprint.document.write('<html><head><title>Print<\/title><\/head><body onLoad="self.print()" style="width: 700px; font-size:11px; font-family:arial; font-weight:normal;">');          
		docprint.document.write(content_vlue); 
		docprint.document.close(); 
		docprint.focus(); 
	}
	</script>
	<script language="javascript" type="text/javascript">
	<!-- Begin
	var timerID = null;
	var timerRunning = false;
	function stopclock (){
		if(timerRunning)
			clearTimeout(timerID);
			timerRunning = false;
	}
	function showtime () {
		var now = new Date();
		var hours = now.getHours();
		var minutes = now.getMinutes();
		var seconds = now.getSeconds();
		var timeValue = "" + ((hours >12) ? hours -12 :hours);
		if (timeValue == "0") timeValue = 12;
		timeValue += ((minutes < 10) ? ":0" : ":") + minutes;
		timeValue += ((seconds < 10) ? ":0" : ":") + seconds;
		timeValue += (hours >= 12) ? " P.M." : " A.M.";
		document.clock.face.value = timeValue;
		timerID = setTimeout("showtime()",1000);
		timerRunning = true;
	}
	function startclock() {
		stopclock();
		showtime();
	}
	window.onload=startclock;
	// End -->
	</SCRIPT>
</head>
<?php
	function createRandomPassword() {
		$chars = "003232303232023232023456789";
		srand((double)microtime()*1000000);
		$i = 0;
		$pass = '' ;
		while ($i <= 7) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$pass = $pass . $tmp;
			$i++;
		}
		return $pass;
	}
	$finalcode='MM-'.createRandomPassword();
?>
<body>
	<?php include('navfixed.php');?>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span2">
				<div class="well sidebar-nav"><div class="tab-pane" id="tab1">
<div class="row-fluid">
<div class="span12">
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
<thead>
<tr>
<th>#</th>
<th> Invoice </th>
<th> Date </th>
<th> Customer </th>
<th> Total </th>
<th> Payment Type </th>
<th> Action </th>
</tr>
</thead>
<tbody>
<?php 
include('connect.php');
$result = $db->prepare("SELECT * FROM sales ORDER BY transaction_id ASC");
$result->execute();
for($i=0; $row = $result->fetch(); $i++){
?>
<tr class="record">
<td><?php echo $row['transaction_id']; ?></td>
<td><?php echo $row['invoice_number']; ?></td>
<td><?php echo $row['date']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo formatMoney($row['total']); ?></td>
<td><?php echo $row['type']; ?></td>
<td><a href="view_sales.php?id=<?php echo $row['transaction_id']; ?>"> View </a>
| <a href="sales_invoice.php?id=<?php echo $row['transaction_id']; ?>"> Print Invoice </a></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>
</div>
</div>
<div class="tab-pane" id="tab2">
<div class="row-fluid">
<div class="span12">
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example1">
<thead>
<tr>
<th>#</th>
<th> Product Code </th>
<th> Product Name </th>
<th> Quantity </th>
<th> Price </th>
<th> Total </th>
<th> Supplier </th>
<th> Date </th>
<th> Action </th>
</tr>
</thead>
<tbody>
<?php 
include('connect.php');
$result = $db->prepare("SELECT * FROM products ORDER BY product_id ASC");
$result->execute();
for($i=0; $row = $result->fetch(); $i++){
?>
<tr class="record">
<td><?php echo $row['product_id']; ?></td>
<td><?php echo $row['product_code']; ?></td>
<td><?php echo $row['product_name']; ?></td>
<td><?php echo $row['quantity']; ?></td>
<td><?php echo formatMoney($row['price']); ?></td>
<td><?php echo formatMoney($row['total']); ?></td>
<td><?php echo $row['supplier']; ?></td>
<td><?php echo $row['date']; ?></td>
<td><a href="edit_product.php?id=<?php echo $row['product_id']; ?>"> Edit </a>
| <a href="delete_product.php?id=<?php echo $row['product_id']; ?>"> Delete </a></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>
</div>
</div>
<div class="tab-pane" id="tab3">
<div class="row-fluid">
<div class="span12">
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">
<thead>
<tr>
<th>#</th>
<th> Firstname </th>
<th> Lastname </th>
<th> Address </th>
<th> Contact </th>
<th> Action </th>
</tr>
</thead>
<tbody>
<?php 
include('connect.php');
$result = $db->prepare("SELECT * FROM customers ORDER BY customer_id ASC");


<div class="modal fade" id="editproduct<?php echo $row['productID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Edit Product</h4>
        </div>
        <div class="modal-body">
		<?php
		$id=$row['productID'];
		$line = mysqli_query($con,"SELECT * FROM products WHERE productID='$id'");
		$row1 = mysqli_fetch_array($line);
		?>
          <form class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="control-group">
            <label class="control-label" for="inputEmail">Product Name:</label>
            <div class="controls">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="text" name="product_name" value="<?php echo $row1['product_name']; ?>" required>
            </div>
          </div>	  <div class="control-group">
          <label class="control-label" for="inputEmail">Product Description:</label>
          <div class="controls">
          <textarea name="product_desc"><?php echo $row1['product_desc']; ?></textarea>
          </div>
        </div>
        
        <div class="control-group">
          <label class="control-label" for="inputEmail">Product Category:</label>
          <div class="controls">
          <select name="category">
              <option value="<?php echo $row1['categoryID']; ?>"><?php echo $row1['category_name']; ?></option>
              <?php
              $result = mysqli_query($con,"SELECT * FROM category WHERE categoryID!='".$row1['categoryID']."'");
              while($row=mysqli_fetch_array($result)){
              ?>
              <option value="<?php echo $row['categoryID']; ?>"><?php echo $row['category_name']; ?></option>
              <?php
              }
              ?>
          </select>
          </div>
        </div>
        
        <div class="control-group">
          <label class="control-label" for="inputEmail">Buying Price:</label>
          <div class="controls">
          <input type="text" name="buying" value="<?php echo $row1['buying_price']; ?>" required>
          </div>
        </div>
        
        <div class="control-group">
          <label class="control-label" for="inputEmail">Selling Price:</label>
          <div class="controls">
          <input type="text" name="selling" value="<?php echo $row1['selling_price']; ?>" required>
          </div>
        </div>
        
        <div class="control-group">
          <label class="control-label" for="inputEmail">Quantity:</label>
          <div class="controls">
          <input type="text" name="qty" value="<?php echo $row1['qty']; ?>" required>
          </div>
        </div>
        
        <div class="control-group">
          <label class="control-label" for="inputEmail">Supplier:</label>
          <div class="controls">
          <select name="supplier">
              <option value="<?php echo $row1['supplierID']; ?>"><?php echo $row1['company_name']; ?></option>
            //   <?php
            //   $result = mysqli_query($con
  