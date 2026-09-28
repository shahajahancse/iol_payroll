<!-- load header -->
<?php require_once(APPPATH."views/layout/header.php"); ?>
<?php require_once(APPPATH."views/layout/top_bar.php"); ?>

<!-- BEGIN CONTAINER -->
<div class="page-container row-fluid">
	<!-- BEGIN SIDEBAR MENU -->
	<?php require_once(APPPATH."views/layout/left_menu.php"); ?>
	<!-- BEGIN SIDEBAR MENU -->

	<!-- load content -->
	<?php require_once(APPPATH."views/layout/content.php"); ?>
	<!-- load content -->
</div>
<!-- END CONTAINER -->


<!-- load footer -->
<?php require_once(APPPATH."views/layout/footer.php"); ?>