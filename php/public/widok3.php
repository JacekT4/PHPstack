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
	
		<form class="form-inline" method="post" id="abc">
		<!--  Tak było w wersji z bazą json
			<input type="text" name="autor" class="form-control mb-2 mr-sm-2" id="autor" placeholder="Autor">
			<input type="text" name="tytul" class="form-control mb-2 mr-sm-2" id="tytul" placeholder="Tytuł">			
		-->	
			<input type="text" name="Autor" class="form-control mb-2 mr-sm-2" id="autor" placeholder="Autor">
			<input type="text" name="Tytul" class="form-control mb-2 mr-sm-2" id="tytul" placeholder="Tytuł">
			<button type="submit" class="btn btn-primary mb-2" id="dodaj">Przygotuj do zapisu</button>
		</form>
		
	</div>
	
	<div id="content" class="mx-auto" style="width: 300px;">
		Lista
		<ol id="lista" class="list-group">
			<?php foreach($lista2 as $i): ?>
				<li><?php  echo "Id: " . htmlspecialchars($i["Id"]) . " Autor: " . htmlspecialchars($i["Autor"]) . " Tytuł: " . htmlspecialchars($i["Tytul"]); ?> 
					<form method="post" class="usuwacze">
<!--						<input type="text" name="usuwacz" value="<?php //echo $i["Id"] ?>">      To było do wersji z bazą json -->
						<input type="hidden" name="usuwacz" value="<?php echo $i["Id"] ?>">      
						<button type="submit" class="btn btn-primary mb-2" id="usun">Usuń</button>
					</form>
				</li>    <!-- Kropka łączy stringi w php -->
			<?php endforeach; ?>
		</ol>
		
		<br><br>

		Lista gotowych do zapisu na serwerze.
		<ol id="lista3" class="list-group">

		</ol>
	</div>
	
	

	<script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> <!-- WIĘKSZA wersja z AJAXEM -->
<!--	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	
	<script>
/*		var test1 = document.getElementById("abc");
		var button1 = test1.getElementsByTagName("button");
		button1[0].addEventListener("click", function(){alert("czesc")});
		console.log(test1);
		console.log(button1);
	*/	

//		var button2 = test2.find("button");
/*		var button2 = $("#abc button");     //selektor , łapie w abc wszystkie buttony
		button2.click(function(){
			alert("czesc");
		});
*/
		var call_ajax = function call_ajax(wartosci){
			
			$.ajax({
				url: "http://www.tester1.com/ksiazki", //gdzie się łączymy
				method: "post", //typ połączenia, domyślnie get
//				dataType    : "json", //typ danych jakich oczekujemy w odpowiedzi

//				contentType : "application/json", //gdy wysyłamy dane czasami chcemy ustawić ich typ
				data: wartosci,
				
				success : function(response) { 
/*					console.log("Udało się");
					console.log(response.status);    //za pomoca tego response wyswietalny jest cała odpowiedz serwerwa w inspektorze   */
					if(response.status == "ok") {
						location.reload();
					} else {
						alert("Nie udalo sie");	
					}
				}, //gdy wszystko ok
				error : function() {
					console.log("Nie udało się");
				}, //gdy błąd połączenia
			});
		}
		
		var js_lista = function js_lista(e){
			e.preventDefault();

			var lista = $("#lista3");

			if(wszystkieWartosci.length == 0){
				lista.append('<button class="btn btn-primary mb-2" id="wyslij">Wyslij na serwer</button>');
				$("#wyslij").click(function(){
					call_ajax({wszystkie: wszystkieWartosci});   //call_ajax potrzebuje dosta dane w postaci obiektu a nie w zwklej tablicy, dlatego dajemy tablice tablic tablic
				});   
			}

			var costam = $(this).find("input");   //this w js odnosi sie do tego co zainicjowalo funkcje
			var wartosci = {};
			var doWyswietlenia = "";
			costam.each(function(){       //za pomoca tehj funkcji wyciagamy SUCHE wartosci z tych inputow
				wartosci[this.name] = $(this).val();   //do tablicy wartosci przypisze wartosc
				doWyswietlenia = doWyswietlenia + " " + this.name + ":" + " " + $(this).val();
			});
			
			wszystkieWartosci.push(wartosci);

			console.log(wartosci, wszystkieWartosci);

			lista.append('<li>' + doWyswietlenia + '</li>');


		}

		var wszystkieWartosci = [];

		var test2 = $("#abc");
		
		test2.submit(js_lista);

		
//chodzi nam o zasabmitowanie za pomoca samego JS
//		test2.submit(call_ajax);

		var usuwacze = $(".usuwacze");

		usuwacze.submit(function(e){
			e.preventDefault();    //dzieki temu się nie submituje
			//var costam = test2.find("input");
			var costam = $(this).find("input");
			var wartosci = {};
			costam.each(function(){
				wartosci[this.name] = $(this).val();   //do tablicy wartosci przypisze wartosc
			});
		
			call_ajax(wartosci);
		});

//		console.log(test2);
//		console.log(button2);
		
		
		
		
	</script>
</body>
</html>
