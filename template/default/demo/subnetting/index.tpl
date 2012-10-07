<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php include($location . '/inc/demo.tpl'); ?>
</head>
<body>

<h1>Subnetting</h1>

<p>A module to calculate from an IPv4 address the subnetmask, network and broadcast address. It also calculates the first and last usable IP address.</p>

<form method="post" class="form-inline">
	<p>
	<label>IP:</label>
	<input type="number" name="a" min="0" max="255" value="<?php echo !empty($a) ? $a : 192; ?>" style="width:64px" />.
	<input type="number" name="b" min="0" max="255" value="<?php echo !empty($b) ? $b : 168; ?>" style="width:64px" />.
	<input type="number" name="c" min="0" max="255" value="<?php echo !empty($c) ? $c : 2; ?>" style="width:64px" />.
	<input type="number" name="d" min="0" max="255" value="<?php echo !empty($d) ? $d : 100; ?>" style="width:64px" /> /
	<select name="s" style="width:64px">
		<?php for($i = 1; $i < 32; $i++): ?>
			<?php if((empty($s) && $i == 24) || $i == $s): ?>
			<option selected="selected" value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php else: ?>
			<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endif; ?>
		<?php endfor; ?>
	</select>
	<input class="btn btn-primary" type="submit" />
	</p>
</form>

<hr />

<?php if(isset($ip)): ?>
<pre>
IP:         <?php echo $ip . "\n"; ?>
Subnetmask: <?php echo $subnetmask . "\n"; ?>
Network:    <?php echo $network . "\n"; ?>
Broadcast:  <?php echo $broadcast . "\n"; ?>

From:       <?php echo $start . "\n"; ?>
To:         <?php echo $end . "\n"; ?>
</pre>
<?php endif; ?>

</body>
</html>
