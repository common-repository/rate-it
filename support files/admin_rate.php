<?php
require('./wp-blog-header.php');
?>

<?php
$ID =	$_REQUEST['id'];
$num = $_REQUEST['rate'];
$return = $_REQUEST['return'];
?>

<form name="update" method="post" action="<?php admin_rate($num,$ID); ?>">
</form>
<?php 
	echo '<META HTTP-EQUIV="Refresh" CONTENT="0;URL=';
	echo $return;
	echo '">';
?>