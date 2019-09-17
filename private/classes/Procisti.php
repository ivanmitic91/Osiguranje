<?php

class Procisti
{

    private static $greske = true; // ako ima gresaka je true
    public static $podatak = [];


    // proveri da na sta je setovan atribut greska
    public static function proveriStatusGresaka()
    {
        return self::$greske;
    }

    // procisti popodatakk
    public static function ProcistiString($podatak)
    {

        $podatak = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        return $podatak;
    }

    // greska ako nisu slova 
    public static function neSamoSlova($string)
    {

        return !preg_match("/^[a-zA-Z ]*$/", $string);
    }

    // formatiraj datum pogodan za unos u bazu
    public static function formatirajDatum($datumString)
    {

        if (!empty($_POST['datumPutovanjaOd']) && !empty($_POST['datumPutovanjaDo'])) {

            $datum = self::ProcistiString($_POST);

            $datum = explode('/', $datum[$datumString]);

            $datum = "$datum[2]" . "-" . $datum[1] . "-" . $datum[0];

            $datum = trim($datum, '-');

            return $datum;
        }
    }

    // formatiraj datum pogodan za prikaz korisniku
    public static function vratiDatum($datumString = '')
    {

        if (!empty($datumString)) {


            $datum = self::ProcistiString($datumString);

            $datum = explode('-', $datumString);

            if (!strpos($datumString, '/')) {

                $datum = "$datum[2]" . "/" . $datum[1] . "/" . $datum[0];

                $datum = trim($datum, '/');
            }


            return $datum;
        }
    }

    public static function prikaziDatum($datumIVreme, $format)
    {


        return $datumIvreme  = date($format, strtotime($datumIVreme));
    }

    // proveri sve unose korisnika
    public static function proveriPolja()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {


            $provereno = self::ProcistiString($_POST);

            if (empty($_POST["ime_i_prezime"])) {
                self::$podatak['ime_i_prezimeErr'] = "Ime i Prezime su obavezni";
            } else {
                if (self::neSamoSlova($_POST["ime_i_prezime"])) {
                    self::$podatak['ime_i_prezimeErr'] = "Samo slova su dozvoljena";
                    self::$podatak['ime_i_prezime'] = $provereno['ime_i_prezime'];
                } else {
                    if (strlen($_POST["ime_i_prezime"]) < 5) {
                        self::$podatak['ime_i_prezimeErr'] = "Ime i Prezime treba da sadrze najmanje 5 karaktera";
                        self::$podatak['ime_i_prezime'] = $provereno['ime_i_prezime'];
                    } else {
                        self::$podatak['ime_i_prezime'] = $provereno['ime_i_prezime'];
                    }
                }
            }


            if (empty($_POST["datumRodjenja"])) {
                self::$podatak['datumErr'] = "Datum rodjenja je obavezan";
            } else {
                self::$podatak['datumRodjenja'] = self::formatirajDatum('datumRodjenja');
            }

            if (empty($_POST["brojPasosa"])) {
                self::$podatak['pasosErr'] = "Broj pasosa  je obavezan";
            } else {
                if (strlen($_POST["brojPasosa"]) !== 9) {
                    self::$podatak['pasosErr'] = "Broj pasosa mora sadrzati 9 cifara";
                    self::$podatak['brojPasosa'] = $provereno['brojPasosa'];
                } else {

                    self::$podatak['brojPasosa'] = $provereno['brojPasosa'];
                }
            }

            if (!empty($provereno['telefon'])) {

                if (strlen($_POST["telefon"]) > 15) {
                    self::$podatak['telefonErr'] = "Telefon ne sme da prelazi 15 cifara";
                    self::$podatak['telefon'] = $provereno['telefon'];
                } else {
                    if (strlen($_POST["telefon"]) < 6) {
                        self::$podatak['telefonErr'] = "Minimalan broj cifara za telefon je 6";
                        self::$podatak['telefon'] = $provereno['telefon'];
                    } else
                    if (!is_numeric($provereno['telefon'])) {
                        self::$podatak['telefonErr'] = "Samo numericki karaktri su dozvoljeni";
                        self::$podatak['telefon'] = $provereno['telefon'];
                    } else {

                        self::$podatak['telefon'] = filter_var($provereno['telefon'], FILTER_SANITIZE_NUMBER_INT);
                    }
                }
            }

            if (empty($_POST["email"])) {
                self::$podatak['emailErr'] = "Email  je obavezan";
            } else {
                if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                    self::$podatak['emailErr'] = "Nedozvoljen format emaila";
                    self::$podatak['email'] = $provereno['email'];
                } else {

                    self::$podatak['email'] = $provereno['email'];
                }
            }


            if (empty($_POST["datumPutovanjaOd"])) {
                self::$podatak['putovanjeOdErr'] = "Datum putovanja je obavezan";
                self::$podatak['datumPutovanjaOd'] = self::formatirajDatum('datumPutovanjaOd');
            } else {

                self::$podatak['datumPutovanjaOd'] = self::formatirajDatum('datumPutovanjaOd');
            }

            if (empty($_POST["datumPutovanjaDo"])) {
                self::$podatak['putovanjeDoErr'] = "Datum putovanja je obavezan";
                self::$podatak['datumPutovanjaDo'] = self::formatirajDatum('datumPutovanjaDo');
            } else {

                self::$podatak['datumPutovanjaDo'] = self::formatirajDatum('datumPutovanjaDo');
            }

            if (empty($_POST["polisaOsiguranja"])) {
                self::$podatak['polisaErr'] = "Polisa osiguranja je obavezna";
            } else {

                self::$podatak['polisaOsiguranja'] = $provereno['polisaOsiguranja'];
            }


            // ako nema gresaka unesi u bazu
            if (
                empty(self::$podatak['ime_i_prezimeErr'])
                && empty(self::$podatak['datumErr'])
                && empty(self::$podatak['pasosErr'])
                && empty(self::$podatak['telefonErr'])
                && empty(self::$podatak['emailErr'])
                && empty(self::$podatak['putovanjeOdErr'])
                && empty(self::$podatak['putovanjeDoErr'])

            ) {

                // setuj atribut greska na false ako ne postoje greske
                self::$greske = false;
            }

            // vrati sve podatke ako su validni  

            return self::$podatak;
        }
    }
}
