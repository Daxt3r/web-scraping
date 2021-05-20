<!DOCTYPE html>
<html lang="de">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Radio Playlist Analyse</title>
        
        <link rel="stylesheet" href="font-awesome/fontawesome-free-5.15.3-web/css/all.css">
 
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/carousel.css">
    </head>

    <body onload="setInterval(interval, 5000)">
        <div class="container">
            <div class="slider">
                <div class="carousel">
                    <div class="carousel__track-container">
                        <ul class="carousel__track">
                            <li class="carousel__slide current-slide">
                                <div>
                                    <h2>Datenbank</h2>
                                    <i class="fas fa-database fa-6x"></i>
                                    <h3>Lade dir die erfassten Daten herunter!</h3>
                                </div>
                            </li>
                            <li class="carousel__slide">
                                <div>
                                    <h2>Leaderboard</h2>
                                    <i class="fas fa-medal fa-6x"></i>
                                    <h3>Siehe dir die Rangliste der meistgespielten Songs an!</h3>
                                </div>>
                            </li>
                            <li class="carousel__slide">
                                <div>
                                    <h2>Analyse</h2>
                                    <i class="fas fa-chart-bar fa-6x"></i>
                                    <h3>Führe selber Analysen durch!</h3>
                                </div>
                            </li>
                            <li class="carousel__slide">
                                <div>
                                    <h2>GitHub</h2>
                                    <i class="fab fa-github fa-6x"></i>
                                    <h3>Schon gewusst, das Projekt ist OpenSource!</h3>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="carousel__nav">
                        <button class="carousel__indicator current-slide"></button>
                        <button class="carousel__indicator"></button>
                        <button class="carousel__indicator"></button>
                        <button class="carousel__indicator"></button>
                    </div>
                </div>
            </div>
            
            <div>
                <div class="nested">
                    <div class="single">
                        <h4>Einzelne Songtitel <i class="fas fa-music"></i></h4>
                        
                        <?php 
                            require_once('dbHandler.php');
                            
                            $db_Handler = new dbHandler();
                            echo "<h2>" . $db_Handler->getSingleTitel() . "</h2>";
                        ?>
                    </div>
                    <div class="days">
                        <h4>Erfasste Tage <i class="far fa-calendar-alt"></i></h4>
                        <?php 
                            require_once('dbHandler.php');
                            
                            $db_Handler = new dbHandler();
                            echo "<h2>" . $db_Handler->getDate() . "</h2>";
                        ?>
                    </div>
                    <div class=nested-footer>
                        <h4>Insgesamte Songtitel <i class="fas fa-music"></i></h4>
                        
                        <?php 
                            require_once('dbHandler.php');
                            
                            $db_Handler = new dbHandler();
                            echo "<h2>" . $db_Handler->getSongs() . "</h2>";
                        ?>
                    </div>
               </div>
            </div> 
            
            <a href="datenbank.php" class="mouseover">
                <div>
                    <h2>Datenbank</h2>
                    <i class="fas fa-database fa-10x"></i>
                </div>
            </a>
            
            <a href="leaderboard.php" class="mouseover">
                <div>
                    <h2>Leaderboard</h2>
                    <i class="fas fa-medal fa-10x"></i>
                </div>
            </a>
            
            <a href="analyse.php" class="mouseover">
                <div>
                    <h2>Analyse</h2>
                    <i class="far fa-chart-bar fa-10x"></i>
                </div> 
            </a>
            
            <a href="#0" class="mouseover">
                <div class="footer-left">
                    <h2>GitHub</h2>
                    <i class="fab fa-github fa-10x"></i>
                </div>
            </a>

            <div class="footer">
                <h2>Motivation</h2>
                <p><k><b>"Echte Abwechslung...</b></k> oder auch <k><b>"Abwechslung die man wirklich hört..."</b></k> sind regelmäßige Aussagen, die im Radiosender hr3 zu hören sind. Doch bei mir als gelegentlicher Zuhörer stoßen diese Sätze auf unverständnis.
                <u>Da gefühlt immer die gleichen Song gespielt werden.</u> <b>Um dieser subjektiven Wahrnehmung nachzugehen und mit Zahlen und Fakten zu belegen oder zu widerlegen, habe ich diese Webseite entwickelt.</b>
                Täglich werden die gespielten Songs des Vortages von der offizielen hr3-Webseite in eine Datenbank gespeichert. Diese werden für weitere Analysen genutzt, welche hier eingesehen werden können.</p>
            </div>
        </div>
        
        <script src="js/carousel.js"></script>
    </body>
</html>