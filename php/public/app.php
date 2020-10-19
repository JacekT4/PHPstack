<?php
/*
class ClassG {
   public $a = 'a w klasie';
   protected $b = 'b w klasie';
   private $c = 'c w klasie';

   protected function zrobCos() {
        return 'cos zrobione';
   }
}

$kaszana = 'kaszanka pyszna';

class ClassJ extends ClassG {
    private $c = ' extra blah';

    public $testowa_zmienna = 'test 123';

    public function __construct($wartosc_kaszany) {
        $this->kaszana = $wartosc_kaszany;
    }

    public function getA() {
       return $this->a;
    }

    public function getB() {
       return $this->b;
    }

    public function getC() {
       return $this->c;
    }

    public function wezWszystkie() {
        return $this->getA() . ' ' . $this->getB() . ' ' . $this->zrobCos() . ' ' . $this->testowa_zmienna . ' ' . $this->kaszana;
    }
}




$a = 123;
$b = 'salata';
$c = [1,2,3,'kotlet']; // ['0' => 1, '1' => 1, '2' => 3, '3' => 'kotlet']
$d = ['cos' => 'tamto', 'kloce' => 'jajca'];
$e = 123.12;
$f = function($dupa) {
  return 'test funkcji' . $dupa;
};
$g = new ClassG();

$h = $g->a;
$j = new ClassJ($kaszana);

$k = $j->a . ' wziete z clasy j';
$l = $j->getA() . ' wziete z clasy j';
$m = $j->getB() . ' wziete z klasy j getB method';
$n = $j->getC() . ' wziete z klasy j getC method';
$o = $j->wezWszystkie();

echo '<pre>';
var_dump($a, $b, $c, $d, $e, $f, $f('daj mi to'), $g, $h, $k, $l, $m, $n, $o);










var_dump('koniec');exit;
*/
	require_once('aplikacja.php');
	require_once('controler.php');
	require_once('model.php');

	$aplikacja = new Aplikacja();    //new słowo kluczowe do tworzenia obiektu i konstuktor | z argumentem
	$aplikacja->start();                      // -> wywołanie funkcji na obiekcie (metody)
