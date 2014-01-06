<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>

<h1>Html filter</h1>

<p>The PSX html filter class provides an lightweight html filter to sanitze html 
from untrusted sources. It uses the html lexer class to build the dom tree and 
an whitelist to filter the elements and attributes. You can easily create your 
own whitelist based on your needs. If you find any security issues do not 
hesitate to contact us. The following elements are allowed:</p>

<ul class="breadcrumb">
<?php foreach($collection as $el): ?>
	<li><?php echo $el->getName(); ?> <?php if(count($el->getAttributes()) > 0): ?>(<?php echo implode(', ', array_keys($el->getAttributes())); ?>)<?php endif; ?> <span class="divider">/</span></li>
<?php endforeach; ?>
</ul>

<?php if(!isset($error)): ?>

	<form method="post" action="<?php echo $self; ?>">
	<p>
		<label for="input">Input:</label>
		<textarea name="input" id="input" style="width:600px;height:100px"><?php echo isset($input) ? htmlspecialchars($input) : null; ?></textarea>
	</p>
	<p>
		<input class="btn btn-primary" type="submit" />
	</p>
	</form>

	<?php if(isset($input)): ?>
		<hr />
		<fieldset>
			<legend>Html</legend>
			<?php echo $input; ?>
		</fieldset>
		<fieldset>
			<legend>Markup</legend>
			<pre><?php echo htmlspecialchars($input); ?></pre>
		</fieldset>
	<?php endif; ?>

<?php else: ?>

	<div class="alert alert-error"><?php echo implode('<br />', $error); ?></div>

<?php endif; ?>

</body>
</html>
