<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>

<h1>OpenID test</h1>

<?php if(isset($error)): ?>
<div class="alert alert-error"><?php echo implode('<br />', $error); ?></div>
<?php endif; ?>

<?php if(isset($authed) && $authed == true): ?>

	<p>You have successful authenticated. The psx OpenID client has get the
	following values from your provider. You can logout
	<a href="<?php echo $url; ?>demo/openid_consumer/logout">here</a>.</p>

	<dl>
		<dt>ID</dt>
		<dd><?php echo $id; ?></dd>
		<dt>Name</dt>
		<dd><?php echo $name; ?></dd>
		<dt>Email</dt>
		<dd><?php echo $email; ?></dd>
	</dl>


<?php else: ?>

	<p>This test demonstrates the psx OpenID client library. You are currently
	not logged in please enter an OpenID to authenticate. We try to get your
	name and email address via attribute exchange if it is supported by your
	provider.</p>

	<form method="post" action="<?php echo $self; ?>">

	<p>
		<label for="openid_identifier">OpenID:</label><br />
		<input type="text" class="openid" name="openid_identifier" id="openid_identifier" />
	</p>

	<p>
		<input class="btn btn-primary" type="submit" />
	</p>

	</form>

<?php endif; ?>

</body>
</html>
