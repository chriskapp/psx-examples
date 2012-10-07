<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>PSX Exception</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="content-style-type" content="text/css" />
	<meta name="generator" content="psx" />
</head>
<body>

<h1>An internal error has occurred</h1>

<p><?php echo $message; ?></p>

<?php if(isset($debug)): ?>

	<div><pre class="error"><?php echo $debug; ?></pre></div>

<?php endif; ?>

</body>
</html>
