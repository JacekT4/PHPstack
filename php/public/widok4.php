<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf8">
	<title>Forlmularze</title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	
	<!--<link rel="stylesheet" href="style.css">-->
	
</head>
<body>

	<div id="panel_gorny" class="mx-auto" style="width: 300px;">
	
	<a href="/baza?sortuj=Imie">Sortuj po Imieniu.</a>
	<a href="/baza?sortuj=Miasto">Sortuj po Mieście.</a>

		<form class="form-inline" method="post">
			<input type="text" name="Imie" class="form-control mb-2 mr-sm-2" id="imie" placeholder="Imie">
			<input type="text" name="Nazwisko" class="form-control mb-2 mr-sm-2" id="nazwisko" placeholder="Nazwisko">
			<input type="text" name="Wiek" class="form-control mb-2 mr-sm-2" id="wiek" placeholder="Wiek">
			<input type="text" name="Kod_Pocztowy" class="form-control mb-2 mr-sm-2" id="kod_pocztowy" placeholder="Kod pocztowy">
			<input type="text" name="Miasto" class="form-control mb-2 mr-sm-2" id="miasto" placeholder="Miasto">
			<button type="submit" class="btn btn-primary mb-2" id="dodaj">Submit</button>
		</form>
		
	</div>
	
	<div id="content" class="mx-auto" style="width: 300px;">
	<div><?php if($wynik_zapisu !== true){ echo $wynik_zapisu; } ?></div>
	<div><?php if($wynik_usuwania !== true){ echo $wynik_usuwania; }?></div>
		Lista
		<ol id="lista" class="list-group">
			<?php foreach($wyniki as $i): ?>
				<li><?php  echo "Id: " . htmlspecialchars($i["ID"]) . " Imie: " . htmlspecialchars($i["Imie"]) . " Nazwisko: " . htmlspecialchars($i["Nazwisko"]) . " Wiek: " . htmlspecialchars($i[" Wiek"]) . " Kod Pocztowy: " . htmlspecialchars($i["Kod_Pocztowy"]) . " Miasto: " . htmlspecialchars($i["Miasto"]); ?> 
					<form method="post">
						<input type="hidden" name="usuwacz" value="<?php echo $i["ID"] ?>">      
						<button type="submit" class="btn btn-primary mb-2" id="usun">Usuń</button>
					</form>
				</li>    <!-- Kropka łączy stringi w php -->
			<?php endforeach; ?>
		</ol>
	</div>
	
	

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>
