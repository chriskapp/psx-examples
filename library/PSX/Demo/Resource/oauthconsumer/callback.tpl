<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>

<?php if($ui_status == 0x0): ?>

	<h1>Resource Owner Authorization</h1>

	<?php if(!isset($error)): ?>

		<p>The user has authorized the "Temporary Credential" and the provider has
		redirected them to the callback url. Now we have all credentials
		to exchange the "Temporary Credential" for an "Token".</p>

		<form method="get" action="<?php echo $url; ?>demo/oauth_consumer/access_token">
		<input class="btn btn-primary" type="submit" value="Next" />
		</form>

		<hr />

		<dl>
			<dt>Token</dt>
			<dd><?php echo $token; ?></pre></dd>
			<dt>Verifier</dt>
			<dd><?php echo $verifier; ?></dd>
		</dl>

	<?php else: ?>

		<div class="alert alert-error"><?php echo implode('<br />', $error); ?></div>

	<?php endif; ?>

<?php endif; ?>


</body>
</html>
