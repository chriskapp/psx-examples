<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>

<table class="table">
<thead>
<tr>
	<?php foreach($object as $row): ?>
	<?php echo '<th title="' . $row->Type . '">' . strtoupper($row->Field) . '</th>'; ?>
	<?php endforeach; ?>
</tr>
</thead>
<tbody>
<?php foreach($assoc as $row): ?>
<tr>
	<?php foreach($row as $v): ?>
	<td><?php echo $v; ?></td>
	<?php endforeach; ?>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<p>The record with the id 2 has the region <b><?php echo $region; ?></b></p>

<p>Complete we have <b><?php echo $count; ?></b> records</p>

<p>The following regions are listed: <b><?php echo implode(', ', $regions); ?></b></p>

</body>
</html>
