<?php
/**
 * Displays the offline message and the page title.
 *
 * @package Core
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 * @author Hunter Perrin <hperrin@gmail.com>
 * @copyright SciActive.com
 * @link http://sciactive.com/
 */
/* @var $_ core */
defined('P_RUN') or die('Direct access prohibited');
header('HTTP/1.1 503 Service Unavailable');
header('Content-Type: text/html');
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php e($this->config->page_title); ?></title>
	<link href='http://fonts.googleapis.com/css?family=EB+Garamond' rel='stylesheet' type='text/css'>
	<?php if ($this->config->offline_twitter_feed) { ?>
	<script src='https://widgets.twimg.com/j/2/widget.js' type='text/javascript'></script>
	<?php } ?>
	<style type="text/css" media="all">
		html {
			font-size: 100%;
			-webkit-text-size-adjust: 100%;
			-ms-text-size-adjust: 100%;
		}
		body {
			margin: 0;
			font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
			font-size: 18px;
			line-height: 22px;
			color: #333;
			background: #ccc;
			background: -moz-linear-gradient(top,  #ccc 1%, #aaa 100%) repeat fixed 0 0 transparent;
			background: -webkit-gradient(linear, left top, left bottom, color-stop(1%,#ccc), color-stop(100%,#aaa)) repeat fixed 0 0 transparent;
			background: -webkit-linear-gradient(top,  #ccc 1%,#aaa 100%) repeat fixed 0 0 transparent;
			background: -o-linear-gradient(top,  #ccc 1%,#aaa 100%) repeat fixed 0 0 transparent;
			background: -ms-linear-gradient(top,  #ccc 1%,#aaa 100%) repeat fixed 0 0 transparent;
			background: linear-gradient(to bottom,  #ccc 1%,#aaa 100%) repeat fixed 0 0 transparent;
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cccccc', endColorstr='#aaaaaa',GradientType=0 );
			text-rendering: optimizelegibility;
		}
		.wrapper {
			font-family: sans-serif;
			font-size: 13px;
			margin: 100px 125px;
			color: #333;
			background-color: #ecf7d6;
			-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.8) inset, 0 -2px 0 rgba(10, 12, 15, 0.1) inset, 0 0 10px rgba(255, 255, 255, 0.5) inset, 0 0 0 1px rgba(10, 12, 15, 0.1), 0 2px 4px rgba(10, 12, 15, 0.15), inset -60px -90px 300px 10px #B4DC63;
			box-shadow: 0 1px 0 rgba(255, 255, 255, 0.8) inset, 0 -2px 0 rgba(10, 12, 15, 0.1) inset, 0 0 10px rgba(255, 255, 255, 0.5) inset, 0 0 0 1px rgba(10, 12, 15, 0.1), 0 2px 4px rgba(10, 12, 15, 0.15), inset -60px -90px 300px 10px #B4DC63;
			border-radius: 8px;
			padding: 40px;
		}
		.wrapper .header h1 {
			font-family: 'EB Garamond', serif;
			font-weight: normal;
			font-size: 40px;
			line-height: 1;
			margin: 0 0 5px;
			color: #507800;
			text-decoration: none;
			text-shadow: 0 0 4px #B4DC63;
			filter: dropshadow(color=#B4DC63, offx=0, offy=0);
		}
		.wrapper .header hr {
			margin: 6px -10px;
		}
		.wrapper p {
			margin: .4em 0 0;
			padding: 0;
		}
		.wrapper label {
			margin: 1em 0 0;
			display: block;
			text-align: right;
			margin-right: 60%;
		}
		.wrapper input[type=text] {
			padding: .2em;
			color: #67003A;
			background: #fff;
			border: 1px #67003A solid;
			border-radius: 3px;
			-webkit-transition: border linear 0.2s, box-shadow linear 0.2s;
			-moz-transition: border linear 0.2s, box-shadow linear 0.2s;
			-o-transition: border linear 0.2s, box-shadow linear 0.2s;
			transition: border linear 0.2s, box-shadow linear 0.2s;
		}
		.wrapper input[type=text]:focus {
			border-color: rgba(159, 40, 133, 0.8);
			outline: 0;
			outline: thin dotted \9;
			/* IE6-9 */

			-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(159, 40, 133, 0.6);
			-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(159, 40, 133, 0.6);
			box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(159, 40, 133, 0.6);
		}
		.wrapper .buttons {
			text-align: right;
		}
		.wrapper input[type=submit], .wrapper input[type=reset], .wrapper input[type=button], .wrapper button {
			color: #FFF;
			padding: 6px 10px;
			border: 1px #662E59 solid;
			border-radius: 3px;
			background: #cc5fb2; /* Old browsers */
			background: -moz-linear-gradient(top,  #cc5fb2 0%, #9f488c 6%, #662e59 100%); /* FF3.6+ */
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#cc5fb2), color-stop(6%,#9f488c), color-stop(100%,#662e59)); /* Chrome,Safari4+ */
			background: -webkit-linear-gradient(top,  #cc5fb2 0%,#9f488c 6%,#662e59 100%); /* Chrome10+,Safari5.1+ */
			background: -o-linear-gradient(top,  #cc5fb2 0%,#9f488c 6%,#662e59 100%); /* Opera 11.10+ */
			background: -ms-linear-gradient(top,  #cc5fb2 0%,#9f488c 6%,#662e59 100%); /* IE10+ */
			background: linear-gradient(to bottom,  #cc5fb2 0%,#9f488c 6%,#662e59 100%); /* W3C */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cc5fb2', endColorstr='#662e59',GradientType=0 ); /* IE6-9 */
		}
		.wrapper input[type=submit]:hover, .wrapper input[type=reset]:hover, .wrapper input[type=button]:hover, .wrapper button:hover {
			background: #cc5fb2; /* Old browsers */
			background: -moz-linear-gradient(top,  #cc5fb2 0%, #8c407a 6%, #662e59 100%); /* FF3.6+ */
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#cc5fb2), color-stop(6%,#8c407a), color-stop(100%,#662e59)); /* Chrome,Safari4+ */
			background: -webkit-linear-gradient(top,  #cc5fb2 0%,#8c407a 6%,#662e59 100%); /* Chrome10+,Safari5.1+ */
			background: -o-linear-gradient(top,  #cc5fb2 0%,#8c407a 6%,#662e59 100%); /* Opera 11.10+ */
			background: -ms-linear-gradient(top,  #cc5fb2 0%,#8c407a 6%,#662e59 100%); /* IE10+ */
			background: linear-gradient(to bottom,  #cc5fb2 0%,#8c407a 6%,#662e59 100%); /* W3C */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cc5fb2', endColorstr='#662e59',GradientType=0 ); /* IE6-9 */
		}
	</style>
</head>
<body>
<div class="wrapper">
	<div class="header">
		<h1><?php e($this->config->system_name); ?></h1>
		<hr />
	</div>
	<?php if ($this->config->offline_twitter_feed) { ?>
	<div id="twitter" style="float: right;">
		<style type="text/css" scoped="scoped">
		#twitter .twtr-ft img {
			-webkit-box-shadow: 0px 0px 2px rgba(80, 80, 80, .4), inset 0px 0px 30px rgba(80, 80, 80, .4);
			-moz-box-shadow: 0px 0px 2px rgba(80, 80, 80, .4), inset 0px 0px 30px rgba(80, 80, 80, .4);
			box-shadow: 0px 0px 2px rgba(80, 80, 80, .4), inset 0px 0px 30px rgba(80, 80, 80, .4);
			-webkit-border-radius: 5px;
			-moz-border-radius: 5px;
			border-radius: 5px;
			padding: 3px;
		}
		</style>
		<script type="text/javascript">
			new TWTR.Widget({
				version: 2,
				type: 'profile',
				rpp: 8,
				interval: 30000,
				width: 300,
				height: 250,
				theme: {
					shell: {background: '#eee', color: 'inherit'},
					tweets: {background: '#fff', color: 'inherit', links: ''}
				},
				features: {scrollbar: true, loop: false, live: false, behavior: 'all'}
			}).render().setUser(<?php echo json_encode($this->config->offline_twitter_feed); ?>).start();
		</script>
	</div>
	<p><?php echo $this->config->offline_message; ?></p>
	<div style="clear: both; height: 0; line-height: 0;">&nbsp;</div>
	<?php } else { ?>
	<p><?php echo $this->config->offline_message; ?></p>
	<?php } ?>
</div>
</body>
</html>
<?php exit;