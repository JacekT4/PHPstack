<?php
	class Aplikacja{
		private $sciezka;
		private $get;
		private $post;
		private $model;
		private $controler;
		private $sesja;
		public function __construct(){            //tworzymy konstruktor tylko jeden dla klasy w php
		//php zawsze stworzy te zmienne globalne w momencie wywolania przez webserwer ale złą praktyką jest dzialanie na globalnych wiec przypisujemy do lokalnych i na 
		//nich dzialamy
			$get = $_GET;       //zmienne które dostajesz w pasku url, zawsze widoczne w url, do pobierania
			$post = $_POST;     //zmienne które dostajesz w formularzach, nie są widoczne w adresie url, 
			$server = $_SERVER;   //zawiera zmienne które zostały zadeklarowane przez przeglądarkę oraz twój webserwer (u nas nginx)
			$sciezka = $server["REQUEST_URI"];      //klucz tablicy - to co mamy w adrsie url po domenie (php sobie tak wymyslił a nginx mu dał - pozwolił)
											  //wszystko co klasa bedzie robic podajemy w konstruktorze żeby nie było zmiennych globalnych
			if (strpos($sciezka, "?") !== false){
				$sciezka = substr( $sciezka , 0 ,  strpos($sciezka, "?") );     //strpos funkcja php która wskazuje ci coś w danym stringu
			}    //substr ucina od 0 do "?"
			
			try{
				$dbh = new PDO('mysql:host=mysql;port=3306;dbname=pierwsza_baza', 'root', 'mypass');   //DODAŁEM
				$dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false); 
				$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);	
			} catch(\Throwable $e){
			//	throw new \Exception("Nie udało się połączyć z bazą danych");
				echo "Nie udało się połączyć z bazą danych";
				exit;
			}
			/*
//["HTTP_X_REQUESTED_WITH"]=> string(14) "XMLHttpRequest"
			var_dump($server);
			*/
		//	exit;
			session_start();
			$this->sesja = &$_SESSION;
			
			$this->sciezka = $sciezka;                                       //zmienna kluczowa this odnosi sie do obiektu, dostepna tylko wtedy kiedy stworzysz obiekt
			$this->get = $get;                                                 //tworzymy parametry obiektu
			$this->post = $post;
			//dodać tu TEN Z ZADANIA DOMOWEGO bdh lub inną nazwa ALE CHODZI O TO ŻEBY BYŁO NAD MODELEM
			$this->model = new Model($dbh);     //model dostaje dbh jako parametr bo tylko tam nam będzie potrzebny
			$this->controler = new Controler($this->model);
		}
		
		//ROUTER taka profesjonalna nazwa funkcji poniżej
		public function start(){                   //kazda funkcja musi miec unikalne imie  

			if (empty($this->sesja['email']) && in_array($this->sciezka, ["/studia/dodaj", "/studia/edytuj", "/studia/usun"])) {
				header("Location: /studia/logowanie");
				exit;
			}
			
			switch($this->sciezka){
				case "/":
				return $this->controler->stronaDomowa();    //jest return wiec nie trzeba uzywac break
				case "/kalendarz":
				return $this->controler->kalendarz();
				case "/dzialanie":
				return $this->controler->dzialanie($this->get);				
				case "/obecnywynik":
				return $this->controler->obecnywynik();		
				case "/emaile":
				return $this->controler->emaile($this->post);			
				case "/ksiazki":
				return $this->controler->ksiazki($this->post);
				case "/baza":
				return $this->controler->baza($this->get, $this->post);
				case "/studia/dodaj":
				return $this->controler->studiaDodaj($this->get, $this->post);
				case "/studia/pokaz":
				return $this->controler->studiaPokaz($this->get, $this->post, !empty($this->sesja['email']));
				case "/studia/edytuj":
				return $this->controler->studiaEdytuj($this->get, $this->post);
				case "/studia/usun":
				return $this->controler->studiaUsun($this->get, $this->post);
				case "/studia/logowanie":
				return $this->controler->studiaLogowanie($this->get, $this->post, $this->sesja);
				case "/studia/wylogowanie":
				return $this->controler->studiaWylogowanie($this->get, $this->post);
				case "/studia/rejestracja":
				return $this->controler->studiaRejestracja($this->get, $this->post);
			}
		}
	}
	//konstruktor używamy non stop a destruktor prawie wcale