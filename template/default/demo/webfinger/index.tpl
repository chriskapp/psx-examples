<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>


<h1>Webfinger</h1>

<p>This example demonstrates how to discover an user XRD file through an
webfinger request using the PSX library. I.e. gmail supports webfinger.</p>

<?php if(!isset($error)): ?>

	<form method="post" action="<?php echo $self; ?>">

	<p>
		<label for="email">Email:</label><br />
		<input type="email" name="email" id="email" value="" style="width:312px;" />
	</p>

	<p>
		<input class="btn btn-primary" type="submit" />
	</p>

	</form>


	<?php if(isset($response)): ?>

		<hr />

		<h2>User XRD</h2>

		<?php if($response !== false): ?>

			<pre><?php echo $response; ?></pre>

		<?php else: ?>

			<p>No user XRD discovered</p>

		<?php endif; ?>

	<?php endif; ?>

<?php else: ?>

	<div class="alert alert-error"><?php echo implode('<br />', $error); ?></div>

<?php endif; ?>


</body>
</html>
