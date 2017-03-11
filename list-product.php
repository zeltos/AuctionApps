<?php
include 'config/connect.php';
include 'config/frontend.php';
// echo $frontend->getBaseUrl();
?>

<!DOCTYPE html>
<html ng-app="auctionApp">
<head>
	<?php include 'view/html/head.php'; ?>
</head>
<body>
	<?php include 'view/html/navigation.php'; ?>
  <div class="main-content">
	   <?php include 'view/product/list.php'; ?>
  </div>
	<?php include 'view/html/footer.php'; ?>
</body>
</html>
