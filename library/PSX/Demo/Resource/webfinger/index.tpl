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
		<label for="email">Email:</label>
		<input type="email" name="email" id="email" value="" style="width:312px;" />
	</p>
	<p>
		<input class="btn btn-primary" type="submit" />
	</p>
	</form>

	<?php if(isset($document) && $document instanceof \PSX\Hostmeta\DocumentAbstract): ?>
		<hr />
		<h2>Discovered data</h2>

		<dl>
			<dt>Subject</dt>
			<dd><?php echo $document->getSubject(); ?></dd>
			<dt>Expires</dt>
			<dd><?php echo $document->getExpires(); ?></dd>
			<dt>Aliases</dt>
			<dd><?php $aliases = $document->getAliases(); echo is_array($aliases) ? implode(', ', $document->getAliases()) : ''; ?></dd>
		</dl>

		<table class="table">
		<colgroup>
			<col width="160" />
			<col width="160" />
			<col width="*" />
		</colgroup>
		<thead>
		<tr>
			<th>Rel</th>
			<th>Type</th>
			<th>Href</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($document->getLinks() as $link): ?>
		<tr>
			<td><?php echo $link->getRel(); ?></td>
			<td><?php echo $link->getType(); ?></td>
			<td><?php echo $link->getHref(); ?></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
		</table>
	<?php endif; ?>

<?php else: ?>

	<div class="alert alert-error"><?php echo implode('<br />', $error); ?></div>

<?php endif; ?>


</body>
</html>
