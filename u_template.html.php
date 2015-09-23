<html>
<head>
<title><?php echo $calname; ?></title>
<link rel="stylesheet" type="text/css" href="ucal_common.css"  media="all">
<link rel="stylesheet" type="text/css" href="ucalp.css" media="print">
<!-- 
<link rel="alternate" type="application/rss+xml" title="RSS" href="index.rdf">
<link type="text/css" href="js/css/pepper-grinder/jquery-ui-1.8.7.custom.css" rel="Stylesheet" />
-->
<link type="text/css" href="js/css/smoothness/jquery-ui-1.8.7.custom.css" rel="Stylesheet" />
<link rel="stylesheet" type="text/css" href="js/flexigrid/css/flexigrid/flexigrid.css">
<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.7.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.corner.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<script type="text/javascript">
$(function() {
	$('.ondayevent').corner("6px");
	$( ".button").button();
}
);
</script>
<style>
.button{font-size:80%;}
</style>
</head>
<body>
<div id="pageimage">
	<h1><a href="./index.php" class="headerh1"><?php echo $calname; ?></a></h1>
<?php print $this->content(); ?>
	<div class="footer2">
		<span class='footerlogo'><a href='http://www.unicale.com'><img src='image/title_s.gif' alt='UNICALE' border='0'></a></span>
		<a href="http://www.unicale.com">UNICALE</a> ver.2.03 - copyright UNICALE Project Team. -<br>
		<span id="toolbar" class="ui-widget-header ui-corner-all">
			<div style="float: right;"><a href="u_admin.php" class="button"><span class="ui-icon ui-icon-wrench" style="float:left; margin: auto;"></span>設定</a>&nbsp;&nbsp;</div>
		</span>
	</div>
</div>
</body>
</html>
 