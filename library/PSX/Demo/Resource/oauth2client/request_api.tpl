<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>

<h1>API Request</h1>

<p>This is the API request playground here you can make any kind of request
to an specific URL. If you leave the body blank the psx OAuth 2 client makes
an GET request otherwise an POST request. Because of security reasons the
body size can not be larger then 1024 signs if you want make larger requests
please contact me. Click here to <a href="<?php echo $url; ?>oauth2client/requestapi/logout">logout</a></p>

<form method="post" action="<?php echo $url; ?>oauth2client/requestapi">

<table class="table">
<colgroup>
	<col width="160" />
	<col width="*" />
</colgroup>
<tr>
	<td><label for="url">URL:</label></td>
	<td><input class="text" type="url" id="url" name="url" value="https://graph.facebook.com/me/feed" /></td>
</tr>
<tr>
	<td><label for="body">Body:</label></td>
	<td><textarea name="body" id="body"></textarea></td>
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

</form>

<?php if(isset($request) && isset($response)): ?>

	<hr />

	<h2>Request</h2>
	<pre><?php echo $request; ?></pre>

	<hr />

	<h2>Response</h2>
	<pre><?php echo $response; ?></pre>

<?php endif; ?>

</body>
</html>
