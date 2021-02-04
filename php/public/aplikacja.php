<?php
	class Aplikacja{
		private $sciezka;
		private $get;
		private $post;
		private $model;
		private $controler;
		private $sesja;
		public function __construct(){            
			$get = $_GET;
			$post = $_POST;
			$server = $_SERVER;
			$sciezka = $server["REQUEST_URI"];

			if (strpos($sciezka, "?") !== false){
				$sciezka = substr( $sciezka , 0 ,  strpos($sciezka, "?") );
			}
			
			try{
				$dbh = new PDO('mysql:host=mysql;port=3306;dbname=pierwsza_baza', 'root', 'mypass');
				$dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false); 
				$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);	
			} catch(\Throwable $e){
				echo "Nie udało się połączyć z bazą danych";
				exit;
			}

			session_start();
			$this->sesja = &$_SESSION;
			
			$this->sciezka = $sciezka;
			$this->get = $get;
			$this->post = $post;
			$this->model = new Model($dbh);
			$this->controler = new Controler($this->model);
		}
		
		public function start(){

			if (empty($this->sesja['email']) && in_array($this->sciezka, ["/studia/dodaj", "/studia/edytuj", "/studia/usun"])) {
				header("Location: /studia/logowanie");
				exit;
			}
			
			switch($this->sciezka){
				case "/":
				return $this->controler->stronaDomowa();
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