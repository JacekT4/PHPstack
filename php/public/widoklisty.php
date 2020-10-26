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
	
		<form class="form-inline" method="post">
		  <input type="text" name="imie" class="form-control mb-2 mr-sm-2" id="imie" placeholder="imie">
		  <input type="text" name="nazwisko" class="form-control mb-2 mr-sm-2" id="nazwisko" placeholder="nazwisko">

		  <label class="sr-only" for="inlineFormInputGroupUsername2">Username</label>
		  <div class="input-group mb-2 mr-sm-2">
			<div class="input-group-prepend">
			  <div class="input-group-text">@</div>
			</div>
			<input type="text" name="email" class="form-control" id="email" placeholder="email">
		  </div>
		  <button type="submit" class="btn btn-primary mb-2" id="dodaj">Submit</button>
		</form>
		
	</div>
	
	<div id="content" class="mx-auto" style="width: 300px;">
		Lista
		<ol id="lista" class="list-group">
		</ol>
	</div>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>
