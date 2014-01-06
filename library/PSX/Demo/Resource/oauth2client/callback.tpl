<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>

<h1>Issuing an Access Token</h1>

<?php if(!isset($error)): ?>

	<p>The application has redirected the user to the redirect url. We have
	tried to get an access token with the code wich was submitted in the
	request. We got the following response:</p>

	<form method="get" action="<?php echo $url; ?>oauth2client/requestapi">
	<input class="btn btn-primary" type="submit" value="Next" />
	</form>

	<hr />

	<dl>
		<dt>Access token</dt>
		<dd><?php echo $access_token; ?></dd>
		<dt>Token type</dt>
		<dd><?php echo $token_type; ?></dd>
		<dt>Expires in</dt>
		<dd><?php echo $expires_in; ?></dd>
		<dt>Refresh token</dt>
		<dd><?php echo $refresh_token; ?></dd>
		<dt>Scope</dt>
		<dd><?php echo $scope; ?></dd>
	</dl>

	<hr />

	<h2>Request</h2>
	<pre><?php echo $request; ?></pre>

	<hr />

	<h2>Response</h2>
	<pre><?php echo $response; ?></pre>

<?php else: ?>

	<div class="alert alert-error"><?php echo $error; ?></div>

<?php endif; ?>

</body>
</html>
