<div id="panel_gorny" class="mx-auto" style="width: 300px;">

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
	<div><?php if($zmienne["wynik_zapisu2"] !== true){ echo $zmienne["wynik_zapisu2"]; } ?></div>
</div>
