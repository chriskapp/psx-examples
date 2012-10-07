<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>

<h1><?php echo $result->title; ?></h1>

<p><small>Feed parsed from: <a href="<?php echo $feedUrl; ?>"><?php echo $feedUrl; ?></a></small></p>

<hr />

<ul>
	<?php foreach($result as $item): ?>
	<li><?php echo $item->title; ?></li>
	<?php endforeach; ?>
</ul>

</body>
</html>
