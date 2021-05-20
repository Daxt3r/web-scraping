<!DOCTYPE html>
<html lang="de">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Leaderboard</title>
        
        <!-- Die beiden Dateien stylen den Datepicker -->
        <link href="css/normalize.css" rel="stylesheet" type="text/css"/>
        <link href="css/datepicker.css" rel="stylesheet" type="text/css"/>
        
        <link rel="stylesheet" href="font-awesome/fontawesome-free-5.15.3-web/css/all.css">
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.0/chart.min.js" integrity="sha512-RGbSeD/jDcZBWNsI1VCvdjcDULuSfWTtIva2ek5FtteXeSjLfXac4kqkDRHVGf1TwsXCAqPTF7/EYITD0/CTqw==" crossorigin="anonymous"></script>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> <!-- jQuery -->
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> <!-- jQuery-ui -->
       
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/leaderboard.css">
        
        <script src="js/leaderboard.js"></script>
        
    </head>

    <body>
        <div class="header">
                <a href="index.php" class="mouseover">
                    <div>
                        <h2>Startseite</h2>
                    </div>
                </a>

                <a href="datenbank.php" class="mouseover">
                    <div>
                        <h2>Datenbank</h2>
                    </div>
                </a>
             
                <a href="analyse.php" class="mouseover">
                    <div>
                        <h2>Analyse</h2>
                    </div> 
                </a>
            
            <div class="menu">
                <h2>Einstellungen</h2>
                
                <form>
                    <input type="hidden" name="functionName" value="leaderboard">
                    
                    <label for="number">Anzahl Songtitel:</label> <br>
                    <input type="text" id="number" name="number"><br>
                    
                    <p>Von: <input type="text" id="datepickerVon" name="datepickerVon"></p>
                    <p>Bis: <input type="text" id="datepickerBis" name="datepickerBis"></p>
                    
                    <input type="submit" value="Submit" name="test">
                </form>
                
            </div>
            
           <div class="content">
                <h2>Leaderboard</h2>
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </body>
</html>