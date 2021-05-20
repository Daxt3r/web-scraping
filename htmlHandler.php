<?php
class htmlHandler {

	//file_get_contents('https://www.hr3.de/playlist/playlist_hrthree-100~_date-');the html returned from the following url
	//static URL https://www.hr3.de/playlist/playlist_hrthree-100~
	//URL to create ~_date-2021-04-07_hour-0.html
	private $url =  "https://www.hr3.de/playlist/playlist_hrthree-100~_date-";
	private $date;
	private $array_titelliste = array(); //Array mit allen Songtiteln


	private function buildURL_Date() {

		$this->date = date("Y-m-d", strtotime('-1 day')); //Vorheriges Datum wird ermittelt (warum auch immer muss ich hier -2 machen)
		$this->url .= $this->date . "_hour-"; //Baut die URL soweit zusammen, dass nur noch die Stunden erstellt werden m�ssen


	}

	private function buildURL_Date_Hour($hour) {

		return $this->url . $hour. ".html"; //Baut die URL soweit zusammen, dass nur noch die Stunden erstellt werden m�ssen
	}

	/*Die Funktion liest die HTML-Seite und verarbeitet diese entsprechend
	 * Parameter: $url = Die zu lesende URL (einschlie�lich Datum und Uhrzeit)
	 * Rückgabewert: $titelliste = Liste mit allen Songtiteln
	 * Quelle: https://gist.github.com/anchetaWern/6150297
	 * */
	private function readHTML() {

		for($i = 0; $i <= 23; $i++) {

			$html_hr3 = file_get_contents($this->buildURL_Date_Hour($i)); //the html returned from the given url

			if(!empty($html_hr3)){ //if any html is actually returned

				$hr3_doc = new DOMDocument();

				libxml_use_internal_errors(TRUE); //disable libxml errors

				$hr3_doc->loadHTML($html_hr3); //Load the html that was returned in $html
				libxml_clear_errors(); //remove errors for yucky html

				$hr3_xpath = new DOMXPath($hr3_doc); //new instance of DOMXpath

				//Alle Songlieder werden entsprechend aufgelistet
				$classname = "c-epgBroadcast__headline";
				//array_push($this->songs, $hr3_xpath->query("//*[contains(@class, '$classname')]"));
				$newList = $hr3_xpath->query("//*[contains(@class, '$classname')]");

				if($newList->length > 0){
					foreach($newList as $song) {
						//echo $song->nodeValue . "<br/>";
						array_push($this->array_titelliste, trim($song->nodeValue));
					}
				}
			}
		}
	}

	public function getDate() {

		if(empty($this->date))
			return 0;
		else
			return $this->date;
	}

	public function getTitelliste() {

		if(empty($this->array_titelliste))
			return 0;
		else
			return $this->array_titelliste;
	}

	public function scrapSongs() {

		$this->buildURL_Date();
		$this->readHTML();
	}

	public function displaytitelliste() {

		echo $this->getDate() . "<br/>";


		if(sizeof($this->array_titelliste) > 0) {
			foreach($this->array_titelliste as $song) {
				echo $song . "<br/>";
			}
			echo "Anzahl Titel: " . sizeof($this->array_titelliste) . "<br/>";
		}
		else
			echo "Es wurden keine Elemente in dem Array gefunden!";
	}
}

?>
