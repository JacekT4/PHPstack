<?php
//	echo "<div>Siemano</div>";
//	var_dump($kalendarz);
?>

<html>
<head>
	<title>
		<?php echo $tytul ?>
	</title>
</head>
<body>
		<h3><?php echo $naglowek ?></h3>
		<table>
			<?php foreach($kalendarz as $i): ?>
				<tr>
				<?php foreach($i as $j): ?>
				<td> <?php echo $j["wartosc"] ?></td>
				<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</table>
</body>
</html>