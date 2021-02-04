<?php
	class Model{
		
		private $dbh;
		public function __construct($dbh){
			$this->dbh = $dbh;
		}
		
		public function dajTabliceKalendarza(){
			$t = date('t'); // liczba dni w miesiącu
			$j = date('j'); // dzień miesiąca
			$f = date('F'); // nazwa miesiąca
			$m = date('m'); // obecny miesiąc
			$y = date('Y'); // rok YYYY
			$pierwszy = date('w', mktime(0, 0, 0, $m, 1, $y)); // nazwa pierwszego dnia w miesiącu
			$line = 7; // ile w linii
			$tablica = [];
			$licznik = 1;
			for($i = 1; $i <= $line; $i++)
			{
				if ($i < $pierwszy)
				{
					$tablica[] = ["wartosc" => null];
				}else
				{
					$tablica[] = ["wartosc" => $licznik];			
					$licznik++;					
				}
			}
			for( ; $licznik <= $t; $licznik++)
			{
				$tablica[] = ["wartosc" => $licznik];							
			}
			$tablica = array_chunk( $tablica , $line );             //sieka tablice na elementy w zalezności od drugiego parametru
			$ostatni = end($tablica);       						//przesuń wskażnik tablicy na ostatni elemet tablicy 
			for($i = count($ostatni); $i < $line; $i++)
			{
				$ostatni[] = ["wartosc" => null];
			}
			$tablica[key($tablica)] = $ostatni;      //key bierze obecny klucz - na który obecnie wskazuje wskaznik tablicy
			reset($tablica);     //resetujemy pointer  arraya

			foreach ($tablica as $i => $wiersz){
				if ($tablica[$i][$line - 1]["wartosc"] !== null){	
					$tablica[$i][$line - 1]["color"] = "red";
				}
			}
	//		var_dump($tablica);
			return $tablica;
		}
		
		
		
		public function dodaj($liczba){
			$f = $liczba + $this->pobierzZBazy();         //nowy wynik          
			$this->zapiszDoBazy($f);     //zapisze do bazy kazdy wynik
			return $f;     //zwróci wynik do controler
		}
		public function odejmij($liczba){
			$f = $this->pobierzZBazy() - $liczba;         
			$this->zapiszDoBazy($f);
			return $f; 
		}
		public function pomnoz($liczba){
			$f = $liczba * $this->pobierzZBazy();        
			$this->zapiszDoBazy($f);
			return $f;
		}
		public function podziel($liczba){
			$f = $this->pobierzZBazy() / $liczba;        
			$this->zapiszDoBazy($f);
			return $f;
		}
		
		
		public function pobierzZBazy(){
			if(file_exists("wynik.json")){
				$e = file_get_contents("wynik.json");
				$e = json_decode($e, true);
				if(!empty($e["wartosc"])){
					return $e["wartosc"];
				}
			}
			return 0;
		}		
				
		
		private function zapiszDoBazy($liczba){ 
			file_put_contents("wynik.json", json_encode(["wartosc" => $liczba]));
		}
		
		
	
		public function zapiszDoBazy2($formularz){    
			if(file_exists("baza.json")){
				$lista = $this->odczytZBazy2();      //na obiekcie wiec this
				$lista[] = ["imie" => $formularz["imie"], "nazwisko" => $formularz["nazwisko"], "email" => $formularz["email"]]; 
				file_put_contents("baza.json", json_encode($lista));     //DO zapisania do bazy
     																	//zapisuje do pliku zwrocony przez json_encode string
			}else{
				file_put_contents("baza.json", json_encode(
					[["imie" => $formularz["imie"], "nazwisko" => $formularz["nazwisko"], "email" => $formularz["email"]]]
				));			
			}
			return true;
		}		
	
	
	
		public function odczytZBazy2(){
				if(file_exists("baza.json")){ 
					$e = file_get_contents("baza.json");    //weż z bazy
					$e = json_decode($e, true);        //php musi sobie zdekodować bo nie rozumie json
				}
				if(!empty($e)){
					return $e;                     //zwracamy wszytko z bazy
				}else{
					return [ ];      //zwracamy pusta tablica
				}
		}



		public function zapiszDoBazy3($formularz){    
			try{
				$stmt = $this->dbh->prepare("INSERT INTO tabela_druga (Autor, Tytul) VALUES ( :Autor, :Tytul)" ); 
				$stmt->bindParam(':Autor', $formularz["Autor"]);
				$stmt->bindParam(':Tytul', $formularz["Tytul"]);
				$stmt->execute(); 		
				
			} catch (\Throwable $e){ 
				error_log($e->getMessage());
				return false;
			}
			return true;
		}		
	
	
	
		public function odczytZBazy3($parametry){

			try{
				$result = [];
				
				$stmt = $this->dbh->prepare("SELECT * FROM tabela_druga");	
				
				if ($stmt->execute()) {
				  while ($row = $stmt->fetch()) {
					$result[] = $row;
				  }
				}
			} catch (\Throwable $e){ 
				
				return [];
			}
			return $result;
		}
		
		
		
		public function usunZBazy($formularz){
			if(file_exists("baza2.json")){ 
					$e = file_get_contents("baza2.json");    //weź z bazy
					$e = json_decode($e, true);        //php musi sobie zdekodować bo nie rozumie json

					foreach($e as $i => $wiersz)
					{
						if($wiersz["id"] == $formularz["usuwacz"]){     //== lub === porównanie a = przypisanie
							unset($e[$i]);     //ale tutaj nie może być $wiersz bo była potrzebna tylko do porównania
						}
					}
;
					file_put_contents("baza2.json", json_encode($e));        //zapisujemy do bazy rozkodowaną tablicę
			}
		}
		
		
		
		public function usunZBazy2($formularz){

			try{
				$stmt = $this->dbh->prepare("DELETE FROM tabela_druga WHERE ID= :Id" ); 
				$stmt->bindParam(':Id', $formularz["usuwacz"]);
				$stmt->execute(); 
				
			} catch (\Throwable $e){ 
				error_log($e->getMessage());
				return false;
			}
			return true;			
		}

		
		
		
		public function odczytBazaMysql($parametry){
			try{
				$result = [];

				if(isset($parametry["sortuj"]) && $parametry["sortuj"] == "Imie"){
					$stmt = $this->dbh->prepare("SELECT * FROM tabela_pierwsza ORDER BY Imie" ); 
				} elseif(isset($parametry["sortuj"]) && $parametry["sortuj"] == "Miasto"){ 
					$stmt = $this->dbh->prepare("SELECT * FROM tabela_pierwsza ORDER BY Miasto" ); 
				} else{
					$stmt = $this->dbh->prepare("SELECT * FROM tabela_pierwsza");					
				}
				
				if ($stmt->execute()) {
				  while ($row = $stmt->fetch()) {
					$result[] = $row;
				  }
				}
			} catch (\Throwable $e){     //    \Throwable -  obiekt który służy do łapania wszystkiego co nie spełnia bloku try, czyli wszystko co się popsuje , \łapie nawet jak by było name space

				return [];      //zwróci pustą tablicę, a throw wyrzuca i zawsze musi byc obiekt który jest exeptionem
			}
			return $result;
		}
		
		
		
		public function zapiszBazaMysql($formularz){

			try{
				$stmt = $this->dbh->prepare("INSERT INTO tabela_pierwsza (Imie, Nazwisko, Wiek, Kod_Pocztowy, Miasto) VALUES ( :Imie, :Nazwisko, :Wiek, :Kod_Pocztowy, :Miasto)" ); 
				$stmt->bindParam(':Imie', $formularz["Imie"]);
				$stmt->bindParam(':Nazwisko', $formularz["Nazwisko"]);
				$stmt->bindParam(':Wiek', $formularz["Wiek"]);
				$stmt->bindParam(':Kod_Pocztowy', $formularz["Kod_Pocztowy"]);
				$stmt->bindParam(':Miasto', $formularz["Miasto"]);
				$stmt->execute();   //poprostu wykona			
			} catch (\Throwable $e){     //    \Throwable -  obiekt który służy do łapania wszystkiego co nie spełnia bloku try, czyli wszystko co się popsuje , \łapie nawet jak by było name space

				return "NIE udało się zapisać do bazy";
			}
			return true;
		}		
		
		
		public function usunBazaMysql($formularz){
			try{

				$stmt = $this->dbh->prepare("DELETE FROM tabela_pierwsza WHERE ID= :Id" );   //placeholder to z : - tak jakby zamiennik, wezmiemy i pozniej zamienimy przez bindParam ale tylko w momencie wykonania
				$stmt->bindParam(':Id', $formularz["usuwacz"]);
				$stmt->execute();    //i to musimy dodać zeby wogole to zrobił
							//tutaj są ' ' w których jest złapane wieksze wyrażenie a pmiedzy jeszcze " ", a . łączą stringi w php, musimy tak zapisać żeby działało wyrażenie SQL
							//exec - powoduje że wykona to co mu powiesz
			} catch (\Throwable $e){
				return "Nie udało się usunąc";
			}
			return true;			
		}
		









		public function odczytBazaMysql2($get){

			try{
				$result = [];      

				if(isset($get["sortuj"]) && $get["sortuj"] == "Imie"){
					$stmt = $this->dbh->prepare("SELECT * FROM tabela_pierwsza ORDER BY Imie" ); 
				} elseif(isset($get["sortuj"]) && $get["sortuj"] == "Nazwisko"){ 
					$stmt = $this->dbh->prepare("SELECT * FROM tabela_pierwsza ORDER BY Nazwisko" ); 
				} elseif(isset($get["ID"]) && is_numeric($get["ID"])){         //jezeli jest podany ID to wyswietl tylko ta linijke z tym ID
					$stmt = $this->dbh->prepare("SELECT * FROM tabela_pierwsza WHERE ID= :Id" );
					$stmt->bindParam(':Id', $get["ID"]); 
				} else {
					$stmt = $this->dbh->prepare("SELECT * FROM tabela_pierwsza");					
				}
				
				if ($stmt->execute()) {
				  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$result[] = $row;
				  }
				}
			} catch (\Throwable $e){  
				return []; 
			}
			return $result;
		}



		public function zapiszBazaMysql2($post, $id = 0){

			try{
				if($id > 0 ){
					$stmt = $this->dbh->prepare("UPDATE tabela_pierwsza SET
							 Imie = :Imie, Nazwisko = :Nazwisko , Wiek = :Wiek, Kod_Pocztowy = :Kod_Pocztowy, Miasto = :Miasto WHERE ID = :Id" ); 
					$stmt->bindParam(':Id', $id);
				} else {
					$stmt = $this->dbh->prepare("INSERT INTO tabela_pierwsza (Imie, Nazwisko, Wiek, Kod_Pocztowy, Miasto) 
							VALUES ( :Imie, :Nazwisko, :Wiek, :Kod_Pocztowy, :Miasto)" ); 
				}

				$stmt->bindParam(':Imie', $post["Imie"]);
				$stmt->bindParam(':Nazwisko', $post["Nazwisko"]);
				$stmt->bindParam(':Wiek', $post["Wiek"]);
				$stmt->bindParam(':Kod_Pocztowy', $post["Kod_Pocztowy"]);
				$stmt->bindParam(':Miasto', $post["Miasto"]);
				$stmt->execute();   //poprostu wykona
		
			} catch (\Throwable $e){    
				return "NIE udało się zapisać do bazy";
			}
			return true;
		}	



		public function usunBazaMysql2($post){

			try{

				$stmt = $this->dbh->prepare("DELETE FROM tabela_pierwsza WHERE ID= :Id" );  
				$stmt->bindParam(':Id', $post["usuwacz"]);
				$stmt->execute();  

			} catch (\Throwable $e){    
				return "Nie udało się usunąc";
			}
			return true;			
		}






		public function zapiszBazaMysql3($post){

			try{

				$stmt = $this->dbh->prepare("INSERT INTO tabela_uzytkownikow (Email, Haslo) VALUES ( :Email, :Haslo)" ); 
				//echo "Rejestracja udana.";


				$stmt->bindParam(':Email', $post["Email"]);
				$stmt->bindParam(':Haslo', $post["Haslo"]);
				$stmt->execute();   //poprostu wykona
		
			} catch (\Throwable $e){    
				return "NIE udało się zapisać do bazy";
			}
			return true;
		}



		public function odczytPoEmailu($email){

			$result = [];

			try{

				$stmt = $this->dbh->prepare("SELECT * FROM tabela_uzytkownikow WHERE Email= :Email" );
				$stmt->bindParam(':Email', $email); 

				if ($stmt->execute()) {
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$result[] = $row;
					}
				}
			} catch (\Throwable $e){  
				return []; 
			}
			return $result;
		}

	}
	
	