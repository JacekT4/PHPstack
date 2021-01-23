
<div id="content" class="mx-auto">
	<div><?php if($zmienne["wynik_usuwania2"] !== true){ echo $zmienne["wynik_usuwania2"]; }?></div>
		Lista
		<ol id="lista" class="list-group">
			<?php foreach($zmienne["wyniki2"] as $i): ?>
                <li class="list-group-item" style="display: list-item;"><?php  echo "Id: " . htmlspecialchars($i["ID"]) . " Imie: " . htmlspecialchars($i["Imie"]) .
                 " Nazwisko: " . htmlspecialchars($i["Nazwisko"]) . " Wiek: " . htmlspecialchars($i["Wiek"]) . " Kod Pocztowy: " .
                  htmlspecialchars($i["Kod_Pocztowy"]) . " Miasto: " . htmlspecialchars($i["Miasto"]); ?> 
					<form method="post" class="d-inline-block">
						<input type="hidden" name="usuwacz" value="<?php echo $i["ID"] ?>">      
						<button type="submit" class="btn btn-primary mb-2" id="usun">Usuń</button>
					</form>
				</li>    <!-- Kropka łączy stringi w php -->
			<?php endforeach; ?>
		</ol>
</div>
