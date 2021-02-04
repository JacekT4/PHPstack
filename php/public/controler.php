<?php
class Controler{
	private $model;
	public function __construct($model){
		$this->model = $model;
	}
	
	public function kalendarz(){
		$kalendarz = $this->model->dajTabliceKalendarza();
		$tytul = "Twoj ulubiony kalendarz";
		$naglowek = "Kalendarz";
		include("widok.php");
	}
	
	public function dzialanie($parametry){
		if(isset($parametry["dodaj"]) && is_numeric($parametry["dodaj"])){
			echo "wynik: " . $this->model->dodaj($parametry["dodaj"]);
		} elseif(isset($parametry["odejmij"])){
			echo "wynik: " .  $this->model->odejmij($parametry["odejmij"]);
		} elseif(isset($parametry["pomnoz"])){
			echo "wynik: " .  $this->model->pomnoz($parametry["pomnoz"]);
		} elseif(!empty($parametry["podziel"])){
			echo "wynik: " .  $this->model->podziel($parametry["podziel"]);
		} else{
			echo "Zła komenda podana";
		}
	}
	
	public function obecnywynik(){
		echo "obecny wynik: " . $this->model->pobierzZBazy();
	}


	public function emaile($formularz){
		
		if(!empty($formularz)){

			$efektZapisania = $this->model->zapiszDoBazy2($formularz);

		} 
		$lista = $this->model->odczytZBazy2();
		
		include("widoklisty.php");
	}
	
	
	public function ksiazki($formularz){
	
		if(!empty($formularz)){
			if(!empty($formularz["Autor"]) && !empty($formularz["Tytul"])){
				$r = $this->model->zapiszDoBazy3($formularz);
			}elseif(!empty($formularz["usuwacz"])){
				$r = $this->model->usunZBazy2($formularz);
			}elseif(!empty($formularz["wszystkie"])){
				foreach($formularz["wszystkie"] as $i => $value){
					$r = $this->model->zapiszDoBazy3($value);
				}		
			}

			if($r){
				header("Content-Type: application/json");
				echo json_encode(["status" => "ok"]);
				exit;
			} else{
				header("Content-Type: application/json");
				echo json_encode(["status" => "gowno"]);
				exit;
			}
		}

		$lista2 = $this->model->odczytZBazy3($parametry);
			
		include("widok3.php");
	}
	
	
	
	public function baza($parametry, $formularz){
		$wynik_usuwania = true;

		if(!empty($formularz)){
			if(!empty($formularz["Imie"]) && !empty($formularz["Nazwisko"]) && !empty($formularz["Wiek"]) && !empty($formularz["Kod_Pocztowy"]) 
			&& !empty($formularz["Miasto"])){
				$wynik_zapisu = $this->model->zapiszBazaMysql($formularz);
			}elseif(!empty($formularz["usuwacz"])){ 
				$wynik_usuwania = $this->model->usunBazaMysql($formularz);
			}
		}
		$wyniki = $this->model->odczytBazaMysql($parametry);
		
		include("widok4.php");		
	}






	

	public function stronaDomowa(){
		$this->renderuj("stronaDomowa.php");
	}

	public function studiaDodaj($get, $post){

		$wynik_zapisu2 = "";

		if(!empty($post)){
			$args = array(
				'Imie'   => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/^[0-9A-Za-ząĄęĘłŁńŃśŚćĆźŹżŻóÓ_ -]{2,25}$/']],
				'Nazwisko'    => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/^[0-9A-Za-ząĄęĘłŁńŃśŚćĆźŹżŻóÓ_-]{2,25}$/']],
				'Wiek'     => FILTER_VALIDATE_INT,
				'Kod_Pocztowy' => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/^[0-9A-Za-ząĄęĘłŁńŃśŚćĆźŹżŻóÓ_-]{2,25}$/']],
				'Miasto'   => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/^[0-9A-Za-ząĄęĘłŁńŃśŚćĆźŹżŻóÓ_-]{2,25}$/']]
			);
			
			$post = filter_var_array($post, $args);
		}

		if(!empty($post["Imie"]) && !empty($post["Nazwisko"]) && !empty($post["Wiek"]) && !empty($post["Kod_Pocztowy"]) 
		&& !empty($post["Miasto"])){
			$wynik_zapisu2 = $this->model->zapiszBazaMysql2($post);
			if($wynik_zapisu2 === true){
				header("Location: /studia/pokaz");
				exit;
			}
		} elseif(!empty($post)) {
			$wynik_zapisu2 .= "Niepoprawna wartosc dla ";
			foreach($post as $key => $p){				
				if(empty($p)){
					$wynik_zapisu2 .= $key . " ";
				}
			}
		}

		$this->renderuj("studiaDodaj.php", ["wynik_zapisu2" => $wynik_zapisu2]);
	}

	public function studiaPokaz($get, $post, $zalogowany){

		$wyniki2 = $this->model->odczytBazaMysql2($get);

		$this->renderuj("studiaPokaz.php", ["wyniki2" => $wyniki2, "zalogowany" => $zalogowany]);
	}


	public function studiaEdytuj($get, $post){

		$wyniki2 = $this->model->odczytBazaMysql2($get);
		if(empty($wyniki2[0]["ID"])){  
			header("Location: /studia/pokaz");
			exit;
		}

		$wynik_zapisu2 = "";
		
		if(!empty($post)){
			$args = array(
				'Imie'   => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/^[0-9A-Za-ząĄęĘłŁńŃśŚćĆźŹżŻóÓ_ -]{2,25}$/']], 
				'Nazwisko'    => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/^[0-9A-Za-ząĄęĘłŁńŃśŚćĆźŹżŻóÓ_ -]{2,25}$/']],
				'Wiek'     => FILTER_VALIDATE_INT,
				'Kod_Pocztowy' => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/^[0-9A-Za-ząĄęĘłŁńŃśŚćĆźŹżŻóÓ_ -]{2,25}$/']],
				'Miasto'   => ['filter' => FILTER_VALIDATE_REGEXP, 'options' => ['regexp' => '/^[0-9A-Za-ząĄęĘłŁńŃśŚćĆźŹżŻóÓ_ -]{2,25}$/']] 
			);
			
			$post = filter_var_array($post, $args);
		}

		if(!empty($post["Imie"]) && !empty($post["Nazwisko"]) && !empty($post["Wiek"]) && !empty($post["Kod_Pocztowy"]) 
		&& !empty($post["Miasto"])){
			$wynik_zapisu2 = $this->model->zapiszBazaMysql2($post, $wyniki2[0]["ID"]);
			if($wynik_zapisu2 === true){
				header("Location: /studia/pokaz");
				exit;
			}
		} elseif(!empty($post)) {
			$wynik_zapisu2 .= "Niepoprawna wartosc dla ";
			foreach($post as $key => $p){				
				if(empty($p)){
					$wynik_zapisu2 .= $key . " ";
				}
			}
		}
		
		$this->renderuj("studiaEdytuj.php", ["wyniki2" => $wyniki2[0], "wynik_zapisu2" => $wynik_zapisu2]);
	}


	public function studiaUsun($get, $post){

		$wynik_usuwania2 = true;

		if(!empty($post["usuwacz"])){ 
			$wynik_usuwania2 = $this->model->usunBazaMysql2($post);
			if($wynik_usuwania2 === true){
				header("Location: /studia/pokaz");
				exit;
			}
		}

		$wyniki2 = $this->model->odczytBazaMysql2($get);

		$this->renderuj("studiaUsun.php", ["wyniki2" => $wyniki2, "wynik_usuwania2" => $wynik_usuwania2]);
	}


	public function studiaLogowanie($get, $post, &$sesja){

		$error = "";

		if(!empty($post)){
			$args = array(
				'Email'   => FILTER_VALIDATE_EMAIL,
				'Haslo'    => FILTER_SANITIZE_MAGIC_QUOTES
			);
			$post = filter_var_array($post, $args);
		}

		if (!empty($post['Email']) && !empty($post['Haslo'])) {

			$uzytkownikZBazy = $this->model->odczytPoEmailu($post['Email']);

			if (isset($uzytkownikZBazy[0]['Haslo'] ) && password_verify ( $post['Haslo'], $uzytkownikZBazy[0]['Haslo'] )) {

				$sesja['email'] = $post['Email'];
				header("Location: /studia/dodaj");
				exit;
			} else {
				$error .= "Niepoprawne dane logowania!";
			}
		}

		$this->renderuj("studiaLogowanie.php", ["error" => $error]);
	}


	public function studiaWylogowanie($get, $post){

		setcookie(session_name(), null, -1, '/');
		session_destroy();

		$this->renderuj("studiaWylogowanie.php");
	}

	private function renderuj($plik_widoku, $zmienne = []){
		$tytul = str_replace([".php"],[""],$plik_widoku);
		
		$tytul = preg_replace('/[^a-zA-Z0-9]/','',$tytul);
		include("layout.php");

	}


	
	public function studiaRejestracja($get, $post){

		$wynik_zapisu2 = "";
	
		if(!empty($post)){
			$args = array( 
				'Email'   => FILTER_VALIDATE_EMAIL,
				'Haslo'    => FILTER_SANITIZE_MAGIC_QUOTES
			);
			
			$post = filter_var_array($post, $args);
		}

		if(!empty($post["Email"]) && !empty($post["Haslo"])){
			$post["Haslo"] = password_hash($post["Haslo"], PASSWORD_DEFAULT);
			$wynik_zapisu2 = $this->model->zapiszBazaMysql3($post);
			if($wynik_zapisu2 === true){
				header("Location: /studia/logowanie");
				exit;
			}
		} elseif(!empty($post)) {
			$wynik_zapisu2 .= "Niepoprawna wartosc dla ";
			foreach($post as $key => $p){				
				if(empty($p)){
					$wynik_zapisu2 .= $key . " ";
				}
			}
		}

		$this->renderuj("rejestracja.php", ["wynik_zapisu2" => $wynik_zapisu2]);
	}

}
