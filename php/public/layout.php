<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <title>
            <?php 
                echo $tytul;    
            ?>
        </title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
            integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" href="/style.css">
        
    </head>
    <body>
        <section class="py-3 text-center container">
            <div class="row py-lg-3">
                <div class="col-lg-10 mx-auto">
                <p>
                    <a href="/" class="btn btn-secondary my-2">Strona domowa</a>
                    <a href="/studia/dodaj" class="btn btn-secondary my-2">Dodaj</a>
                    <a href="/studia/pokaz" class="btn btn-secondary my-2">Pokaz</a>
                    <a href="/studia/edytuj" class="btn btn-secondary my-2">Edytuj</a>
                    <a href="/studia/usun" class="btn btn-secondary my-2">Usun</a>
                    <a href="/studia/logowanie" class="btn btn-secondary my-2">Logowanie</a>
                    <a href="/studia/wylogowanie" class="btn btn-secondary my-2">Wylogowanie</a>
                    <a href="/studia/rejestracja" class="btn btn-secondary my-2">Rejestracja</a>
                </p>

                <?php
                
                    include($plik_widoku);

                ?>
                
                </div>
            </div>
        </section>

        <script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script> <!-- WIĘKSZA wersja z AJAXEM -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" 
            integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" 
            integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        
    </body>
</html>