<div class="mx-auto" style="width: 300px;">
   <h3 class="p-0">Rejestracja</h3>


    <form method="post">
        <input name="Email" type="email" class="form-control mb-2 mr-sm-2">
        <input name="Haslo" type="password" class="form-control mb-2 mr-sm-2">
        <input value="Zarejestruj" type="submit" class="form-control mb-2 mr-sm-2">
        <button type="button" class="btn btn-secondary mb-2 mr-sm-2 w-100">Anuluj</button>

    </form>
</div>

<div id="content" class="mx-auto" style="width: 300px;">
	<div><?php if($zmienne["wynik_zapisu2"] !== true){ echo $zmienne["wynik_zapisu2"]; } ?></div>
</div>