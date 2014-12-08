<?php $page_title = 'Account Info'; 
session_start(); // Access the existing session.
include('includes/header.html'); ?>

<a href="edit_customer.php">Edit Account Info</a> <br/>
<a href="edit_password.php">Edit Password</a> <br/>
<a href="orders.php">Your Orders</a> <br/>
<a href="logout.php">Logout</a> <br/>
<?php include('includes/footer.html'); ?>