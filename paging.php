<?php
include_once 'db.php';
$conn = new DbConnect();

$sql = "SELECT COUNT(*) FROM groups";
$result = mysqli_query($sql, $conn);
$r = mysqli_fetch_row($result);
$numrows = $r[0];
 
// number of rows to show per page
$rowsperpage = 10;
 
// find out total pages
$totalpages = ceil($numrows / $rowsperpage);
 
// get the current page or set a default
if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
	$currentpage = (int) $_GET['currentpage'];
} else {
	$currentpage = 1;  // default page number
}
 
// if current page is greater than total pages
if ($currentpage > $totalpages) {
	// set current page to last page
	$currentpage = $totalpages;
}
// if current page is less than first page
if ($currentpage < 1) {
	// set current page to first page
	$currentpage = 1;
}
 
// the offset of the list, based on current page
$offset = ($currentpage - 1) * $rowsperpage;
 
// get the info from the MySQL database
$sql = "SELECT title, description, created_date FROM groups ORDER BY ID DESC LIMIT $offset, $rowsperpage";
$result = mysqli_query($conn, $sql);
 
while ($row = mysqli_fetch_assoc($result)){
	$output[]=$row;
}
return json_encode($output);
 
?>