<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<style type='text/css'>
body
{
	font-family: Arial;
	font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
	text-decoration: underline;
}
.form-button-box input#form-button-save{
	background: #47A447 !important;
	color:#fff;
}

.form-button-box input#save-and-go-back-button{
	background: #3276B1 !important;
	color:#fff;
}

.form-button-box input#cancel-button{
	background: #D2322D !important;
	color:#fff;
}

@media  screen and (max-width : 500px) {
	.flexigrid div.form-div input[type="text"], .flexigrid div.form-div input[type="password"], .chzn-container a.chzn-single{
		width: 150px;
	}
}
</style>
</head>
<body style="background-color:#E5E9EC;">
	<div style='height:20px;'></div>  
    <div>
		<?php echo $output; ?>
    </div>
</body>
</html>
