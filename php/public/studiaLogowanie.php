<div class="mx-auto" style="width: 300px;">
   <h3>Logowanie</h3>


    <form method="post">
        <input name="Email" type="email" class="form-control mb-2 mr-sm-2">
        <input name="Haslo" type="password" class="form-control mb-2 mr-sm-2">
        <input value="Zaloguj" type="submit" class="form-control mb-2 mr-sm-2">

    </form>
</div>

<div id="content" class="mx-auto" style="width: 300px;">
	<div><?php if(!empty($zmienne["error"])){ echo $zmienne["error"]; } ?></div>
</div>