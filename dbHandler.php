<?php

class dbHandler {

    private $servername = "localhost";
    private $username = "XXXXX";
    private $password = "XXXXX";
    private $database = "XXXXX";

    private $conn;
    private $array_titel_id = array();
    private $date_id;


    //Die Funktion stellt eine Verbindung zur Datenbank her
    public function connect() {

        //Create connection
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);

        //Check connection
        if($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error) . "<br>";
        }
    }

    /* Die Funktion schreibt das Datum an dem die Daten verarbeitet wurden in die Datenbank
     * Parameter: $date = Datum der Verarbeitung
     * Rückgabewert: Primarykey des neu angelegten Datensatzes
     * */
    private function writeDate($date) {

        //SQL Befehl um das Datum an dem die Daten ausgelesen wurden, in die Datenbank zu schreiben
        $sql_date = "INSERT INTO Datum (Datum) VALUES ('" . $date . "')";
        if($this->conn->query($sql_date) === TRUE) {
            $this->date_id = $this->conn->insert_id;
        } else {
            echo "Error: " . $sql_date . "<br>" . $this->conn->error . "<br>";
        }
    }

    /* Die Funktion durchläuft die eingelesenen Titel und fügt nur neue Titel der Datenbank hinzu.
     * Parameter: $titelliste = Liste mit allen Songtiteln, die von der Webseite gelesen wurden
     * Rückgabewert: Liste mit allen Primärschlüssen der neu hinzugefügten Titeln und der bereits vorhandenen Titeln
     */ 
    private function writeTitel($titelliste) {

        foreach($titelliste as $song) {

            $sql_titel = "SELECT COUNT(Titel) FROM Songtitel WHERE Titel = '" . $this->conn->real_escape_string($song) . "'";
            //Prüft ob die SQL-Abfrage erfolgreich war
            if($result = $this->conn->query($sql_titel)) {

                //echo "Returned rows are: " . $result->num_rows . "<br>";
                $rowcount = $result->fetch_row(); 
                //echo "Fetched result: " . $rowcount[0] . "<br>";     
                    
                //Wenn $rowcount == 0 ist noch kein Eintrag mit dem Titel vorhanden. Ein neuer Datensatz wird in die Tabelle eingefügt
                if($rowcount[0] == 0) {

                    //SQL Befehl zum Hinzufügen des Titels in die Tabelle
                    $sql_titel_insert = "INSERT INTO Songtitel (Titel) VALUES ('" . $this->conn->real_escape_string($song) . "')";
                    if($this->conn->query($sql_titel_insert) === TRUE) {
                        //Der Primärschlüssel des neu hinzugefügten Datensatzes wird in ein Array geschrieben, 
                        //welches später genutzt wird um die Daten in die Tabelle "Abgespielt" zu schreiben
                        array_push($this->array_titel_id, $this->conn->insert_id);

                    } else {
                        echo "Error: " . $sql_titel_insert . "<br>" . $this->conn->error;
                    }
                }
                //Es existiert bereits ein Datensatz mit dem Titel, entsprechend muss dessen ID ermittelt werden.
                elseif ($rowcount[0] == 1) {

                    //SQL-Befehl um die ID zum Songtitel zu finden
                    $sql_titel_getID = "SELECT Titel_ID FROM Songtitel WHERE Titel = '" . $this->conn->real_escape_string($song) . "'";
                    $result = $this->conn->query($sql_titel_getID);

                    if ($result->num_rows > 0) {
                        //Ermittelte ID des Titels wird dem Array aller IDs hinzugefügt
                        while($row = $result->fetch_assoc()) {
                            //echo $row["Titel_ID"] . "<br";
                            array_push($this->array_titel_id, $row["Titel_ID"]);
                        }
                    }
                }
            } else {
                echo "Error: " . $sql_titel . "<br>" . $this->conn->error . "<br>";
            }
        }
    }

    private function writePlaylist() {

        //Die Schleife durchläuft das Array mit allen IDs der Titel und fügt die Datensätze + Datum in die Tabelle ein.
        foreach($this->array_titel_id as $titel_id) {
            
             $sql_abgespielt = "INSERT INTO Playlist (Datum_ID, Songtitel_ID) VALUES ('" . $this->date_id . "' ,'" . $titel_id . "')";
             if($this->conn->query($sql_abgespielt) === FALSE) {
                echo "Error: " . $sql_abgespielt . "<br>" . $this->conn->error;
            }
        }
    }

    public function write($html_Handler) {
        
        $this->writeDate($html_Handler->getDate());
        $this->writeTitel($html_Handler->getTitelliste());
        $this->writePlaylist();
    }

    public function close() {
        $this->conn->close();
    }
    
    //Gibt die Anzahl aller erfassten Tage zurück
    public function getDate() {

        $this->connect();
        $sql_date = "SELECT COUNT(*) FROM Datum";

        //Prüft ob die SQL-Abfrage erfolgreich war
        if($result = $this->conn->query($sql_date)) {

            $rowcount = $result->fetch_row();
            mysqli_close($this->conn); //Verbindung wird geschlossen
            return $rowcount[0];
        }
        return "Error: " . $sql_date . "<br>" . $this->conn->error . "<br>";
    }
    
    //Gibt das erste Datum seit Datenerfassung zurück
    public function getFirstDate() {
        
        $this->connect();
        $sql_date = "SELECT MIN(Datum) FROM Datum";

        //Prüft ob die SQL-Abfrage erfolgreich war
        if($result = $this->conn->query($sql_date)) {

            $rowcount = $result->fetch_row();
            mysqli_close($this->conn); //Verbindung wird geschlossen
            return $rowcount[0];
        }
        return "Error: " . $sql_date . "<br>" . $this->conn->error . "<br>";
    }
    
    //Gibt das letzte Datum das Erfasst wurde zurück
    public function getLastDate() {
        
        $this->connect();
        $sql_date = "SELECT MAX(Datum) FROM Datum";

        //Prüft ob die SQL-Abfrage erfolgreich war
        if($result = $this->conn->query($sql_date)) {

            $rowcount = $result->fetch_row();
            mysqli_close($this->conn); //Verbindung wird geschlossen
            return $rowcount[0];
        }
        return "Error: " . $sql_date . "<br>" . $this->conn->error . "<br>";
    }
    
    //Die Funktion gibt die Anzahl der abgespielten Songs zurück.
    public function getSongs() {

        $this->connect();
        $sql = "SELECT COUNT(*) FROM Playlist";

        //Prüft ob die SQL-Abfrage erfolgreich war
        if($result = $this->conn->query($sql)) {

            $rowcount = $result->fetch_row();
            mysqli_close($this->conn); //Verbindung wird geschlossen
            return $rowcount[0];
        }
        return "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
    }

    //Die Funktion gibt die Anzahl aller einzeln abgespielten Songs zurück
    public function getSingleTitel() {

        $this->connect(); //Verbindung zur Datenbank wird hergestellt
        $sql = "SELECT COUNT(*) FROM Songtitel";

        //Prüft ob die SQL-Abfrage erfolgreich war
        if($result = $this->conn->query($sql)) {

            $rowcount = $result->fetch_row();
            mysqli_close($this->conn); //Verbindung wird geschlossen
            return $rowcount[0];
        }
        return "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
    }
    
    //Die Funktion gibt die Anzahl, wie oft ein Song, in den letzten X-Tagen gespielt wurde zurück
    //Parameter: $range = Anzahl der Songs die zurückgegeben werden sollen
    //Rückgabewert: 
    public function getNumberOfRepetitions($range, $datumVon, $datumBis) {
        
        $this->connect(); //Verbindung zur Datenbank wird hergestellt
        $sql = "SELECT Songtitel.Titel, COUNT(Playlist.Songtitel_ID) AS 'Anzahl'
                FROM Playlist
                JOIN Songtitel
                ON Playlist.Songtitel_ID = Songtitel.Titel_ID
                JOIN Datum
                ON Playlist.Datum_ID = Datum.Datum_ID
                WHERE Datum BETWEEN \"" . $datumVon . "\" AND \"" . $datumBis . "\"
                GROUP BY Songtitel.Titel
                ORDER BY COUNT(Playlist.Songtitel_ID) DESC";
        
        //Prüft ob die SQL-Abfrage erfolgreich war
        if($result = $this->conn->query($sql)) {
            
            $data = array();
            $rowCount = 0;
            //Die Schleife durchläuft das Ergebnis der SQL-Abfrage und speichert entsprechend $range Datensätze in $data ab.
            foreach ($result as $row) {
                
                if($rowCount < $range) {
                    
                    $data[] = $row;
                    $rowCount++;
                }
                else
                    break;
            }
            mysqli_close($this->conn); //Verbindung wird geschlossen
            return json_encode($data); //Datensätze werden als JSON-Datei decodiert
        }
        return "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
    }
    
    /*
     * Die Funktion prüft ob das Datum in der Datenbank vorhanden ist
     * Parameter: $datum das geprüft werden soll im Format: YYYY-MM-dd
     * Rückgabewert: True = Datum existiert in Datenbank
                     False = Datum existiert nicht in Datenbank
    */
    public function dateExist($date) {
        
        $this->connect();
        $sql_date = "SELECT Datum FROM Datum WHERE Datum = \"" . $date . "\"";

        //Prüft ob die SQL-Abfrage erfolgreich war
        if($result = $this->conn->query($sql_date)) {

            $rowcount = $result->num_rows; //Gibt die Anzahl der Zeilen der SQL-Abfrage zurück
            
            mysqli_close($this->conn); //Verbindung wird geschlossen
            
            if($rowcount == 1)
                return true;
            else
                return false;
        }
        return "Error: " . $sql_date . "<br>" . $this->conn->error . "<br>";
    }
}

?>
