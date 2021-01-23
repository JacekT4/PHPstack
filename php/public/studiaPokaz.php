

<div id="panel_gorny" class="mx-auto">
	
	<a href="/studia/pokaz?sortuj=Imie">Sortuj po Imieniu.</a>
	<a href="/studia/pokaz?sortuj=Nazwisko">Sortuj po Nazwisko.</a>

</div>
	
<div id="content" class="mx-auto">
	<div><?php if($zmienne["wynik_zapisu2"] !== true){ echo $zmienne["wynik_zapisu2"]; } ?></div>
	<div><?php if($zmienne["wynik_usuwania2"] !== true){ echo $zmienne["wynik_usuwania2"]; }?></div>
		<h3>Lista</h3>
		<ol id="lista" class="list-group">
			<?php foreach($zmienne["wyniki2"] as $i): ?>
                <li class="list-group-item" style="display: list-item;"><?php  echo "Id: " . htmlspecialchars($i["ID"]) . " Imie: " . htmlspecialchars($i["Imie"]) .
                 " Nazwisko: " . htmlspecialchars($i["Nazwisko"]) . " Wiek: " . htmlspecialchars($i["Wiek"]) . " Kod Pocztowy: " .
                  htmlspecialchars($i["Kod_Pocztowy"]) . " Miasto: " . htmlspecialchars($i["Miasto"]); ?>
                    <?php if($zmienne["zalogowany"]):?>
                        <a href="/studia/edytuj<?php echo "?ID=" . (int) $i["ID"]; ?>"><button type="button" class="btn btn-primary mb-2">Edytuj</button></a>
                    <?php endif;?>
				</li>    <!-- Kropka łączy stringi w php -->
			<?php endforeach; ?>
		</ol>
</div>
