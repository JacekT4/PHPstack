<?php
//TUTAJ KOPIUJE KODy z app1 żeby miec je z komentarzami i przykładami
        // zmienne kalendarza
        $t = date('t'); // liczba dni w miesiącu
        $j = date('j'); // dzień miesiąca
        $f = date('F'); // nazwa miesiąca
        $m = date('m'); // obecny miesiąc
        $y = date('Y'); // rok YYYY
        $pierwszy = date('w', mktime(0, 0, 0, $m, 1, $y)); // nazwa pierwszego dnia w miesiącu
        $line = 7; // ile w linii
        
        // tablica miesięcy
		$miesiace = array('January' => 'Styczeń', 'February' => 'Luty', 'March' => 'Marzec',
		 'April' => 'Kwiecień', 'May' => 'Maj', 'June' => 'Czerwiec', 'July' => 'Lipiec',
		 'August' => 'Sierpień', 'September' => 'Wrzesień', 'October' => 'Październik',
		 'November' => 'Listopad', 'December' => 'Grudzień');
         
        // tabelka
        print '<table>';
        print '<tr><td style="font-size: 10px; text-align: center;" colspan="'.$line.'">
               <b>'.$miesiace[$f].' '.$y. '</b></td></tr>';
        print '<tr style="font-size: 10px; text-align: center; font-weight: bold;"><td>Pn</td>
               <td>Wt</td><td>Sr</td><td>Cz</td><td>Pt</td><td>So</td><td style="color: red;">Ni</td></tr><tr>';
               
        // pętla
        for($i=1; $i<=$t; $i++)
        {
			if($i <= $pierwszy)
			{
				print '<td bgcolor="white"></td>';
			}
			if($i % $line == 0)
			{
				print '</tr>';
			}
			if($i == $j)
			{
				print '<td style="padding: 2px; margin: 1px; background-color: #FFFFFF; color: #000000;
				text-align: center; font-size: 10px;"><b> '.$i. '</b></td>';
			}
			if($i == $j) continue;     //nie bedzie robił nic po continue
          
				print '<td style="padding: 2px; margin: 1px; background-color: #000000; color: #FFFFFF;
				text-align: center; font-size: 10px;" border="1"><a href="">'.$i. '</a></td>';
        }
        print '</table>';












	$a = ["haslo"=>"cokolwiek","id"=>"1",[5,10,20]];
	
	file_put_contents("hasla2.json", json_encode($a));
	
	var_dump($hasla);
	












/* //PIERWSZY KOD PHP	
	$obrazek = '<div><img src="logo1.png"></div>'; //zmienna
	$tablica = [1, 2, "jabłko", 4];    
	
	foreach ($tablica as $i) {
		echo '<div>' . $i . '</div>';
	}
	
	foreach ($tablica as $i => $j) {
		echo '<div> na indexie ' . $i . ' jest wartosc ' . $j . '</div>';
	}


	
	if (file_exists('baza.txt')) {
		$baza = file_get_contents('baza.txt');
		$baza = json_decode($baza, true);
	} else {
		$baza=[];
	}
	
	$baza = array_merge($baza, $_GET);
	
	var_dump($baza);
	
	file_put_contents('baza.txt' , json_encode($baza));
	*/