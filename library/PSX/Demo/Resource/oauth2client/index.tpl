<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>

<h1>Obtaining Authorization</h1>

<?php if(!isset($error)): ?>

	<p>This is an example howto use the Oauth2 client library in psx.</p>

	<script type="text/javascript">
	if (window != window.top) {
		document.write('<div class="alert alert-warning">Facebook does not allow to redirect the user in an iframe. Open the <a href="http://example.phpsx.org/oauth2client">oauth2 client</a> demo in an new tab to test the authorization.</div>');
	}
	</script>

	<form method="post" action="<?php echo $url; ?>oauth2client">

	<table class="table">
	<colgroup>
		<col width="160" />
		<col width="*" />
	</colgroup>
	<tr>
		<td><label for="auth_url">Authorization Url:</label></td>
		<td><input class="text" type="url" id="auth_url" name="auth_url" value="https://graph.facebook.com/oauth/authorize" /></td>
	</tr>
	<tr>
		<td><label for="token_url">Token Url:</label></td>
		<td><input class="text" type="url" id="token_url" name="token_url" value="https://graph.facebook.com/oauth/access_token" /></td>
	</tr>
	<tr>
		<td><label for="consumer_key">Client id:</label></td>
		<td><input class="text" type="text" id="consumer_key" name="consumer_key" value="<?php echo htmlspecialchars($oc_client_id); ?>" /></td>
	</tr>
	<tr>
		<td><label for="consumer_secret">Client secret:</label></td>
		<td><input class="text" type="text" id="consumer_secret" name="consumer_secret" value="<?php echo htmlspecialchars($oc_client_secret); ?>" /></td>
	</tr>
	<tr>
		<td><label for="scope">Scope:</label></td>
		<td><input class="text" type="text" id="scope" name="scope" value="read_stream,user_photos,user_videos,publish_stream" /></td>
	</tr>
	<tr>
		<td><label for="redirect">Redirect:</label></td>
		<td><input class="text" type="url" id="redirect" name="redirect" value="<?php echo $url; ?>oauth2client/callback" /></td>
	</tr>
	<tr>
		<td colspan="2">
		<p>
			<input class="btn btn-primary" type="submit" />
			<input class="btn" type="reset" />
		</p>
		</td>
	</tr>
	</table>

<?php else: ?>

	<div class="alert alert-error"><?php echo implode('<br />', $error); ?></div>

<?php endif; ?>

</body>
</html>
