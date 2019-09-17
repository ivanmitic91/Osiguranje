<?php
class Modeli
{

    private static $id_polise;
    private static $idKorisnika;

    public static function unesiPolisu($data)
    {

        Konekcija::query('INSERT INTO polisa (datum_putovanja_od, datum_putovanja_do, tip_polise) VALUES (:datum_putovanja_od, :datum_putovanja_do, :tip_polise)');

        Konekcija::bind(':datum_putovanja_od', $data['datumPutovanjaOd']);
        Konekcija::bind(':datum_putovanja_do', $data['datumPutovanjaDo']);
        Konekcija::bind(':tip_polise', $data['polisaOsiguranja']);

        Konekcija::execute();

        self::$id_polise = Konekcija::lastInsertId();
    }


    public static function unesiKorisnika($data)
    {

        Konekcija::query('INSERT INTO korisnik (ime_i_prezime, datum_rodjenja, broj_pasosa, email, telefon) VALUES (:ime_i_prezime, :datum_rodjenja, :broj_pasosa, :email, :telefon)');

        Konekcija::bind(':ime_i_prezime', $data['ime_i_prezime']);
        Konekcija::bind(':datum_rodjenja', $data['datumRodjenja']);
        Konekcija::bind(':broj_pasosa', $data['brojPasosa']);
        Konekcija::bind(':email', $data['email']);
        Konekcija::bind(':telefon', $data['telefon']);


        Konekcija::execute();

        self::$idKorisnika = Konekcija::lastInsertId();
    }


    public static function unesiPolisaOsiguranik()
    {


        Konekcija::query('INSERT INTO polisaosiguranik (polisa_id, korisnik_id, nosioc) VALUES (:polisa_id, :korisnik_id, :nosioc)');

        Konekcija::bind(':polisa_id', self::$id_polise);
        Konekcija::bind(':korisnik_id', self::$idKorisnika);
        Konekcija::bind(':nosioc', 1);

        Konekcija::execute();
    }


    public static function unesiGrupu($data)
    {


        if (isset($data['grupno'])) {


            foreach ($data['grupno'] as $korisnik) {


                Konekcija::query('INSERT INTO korisnik (ime_i_prezime, datum_rodjenja, broj_pasosa) VALUES (:ime_i_prezime, :datum_rodjenja, :broj_pasosa)');

                Konekcija::bind(':ime_i_prezime', $korisnik['ime_i_prezime']);
                Konekcija::bind(':datum_rodjenja', $korisnik['datum_rodjenja']);
                Konekcija::bind(':broj_pasosa', $korisnik['broj_pasosa']);

                Konekcija::execute();

                self::$idKorisnika = Konekcija::lastInsertId();


                Konekcija::query('INSERT INTO polisaosiguranik (polisa_id, korisnik_id, nosioc) VALUES (:polisa_id, :korisnik_id, :nosioc)');


                Konekcija::bind(':polisa_id', self::$id_polise);
                Konekcija::bind(':korisnik_id', self::$idKorisnika);
                Konekcija::bind(':nosioc', 0);

                Konekcija::execute();
            }
        }
    }


    public static function svePolise()
    {
        Konekcija::query("SELECT * FROM polisa JOIN polisaosiguranik ON polisaosiguranik.polisa_id = polisa.id JOIN korisnik ON korisnik.id = polisaosiguranik.korisnik_id");

        return Konekcija::resultSet(PDO::FETCH_OBJ);
    }

    public static function prikaziGrupu($id_polisa)
    {

        Konekcija::query("SELECT * FROM korisnik WHERE korisnik.id IN (SELECT polisaosiguranik.korisnik_id FROM polisaosiguranik WHERE polisaosiguranik.polisa_id = :polisa_id)");

        Konekcija::bind(':polisa_id', (int) $id_polisa);

        return Konekcija::resultSet(PDO::FETCH_OBJ);
    }

    public static function pronadjiPolisu($id)
    {

        Konekcija::query(
            'SELECT * FROM korisnik JOIN polisaosiguranik ON polisaosiguranik.korisnik_id = korisnik.id JOIN polisa ON polisa.id = polisaosiguranik.polisa_id WHERE korisnik.id = :id_korisnik'
        );

        Konekcija::bind(':id_korisnik', $id);

        $row = Konekcija::single();

        return $row;
    }

    public static function svePoliseSortiranjePo($sort)
    {

        Konekcija::query("SELECT * FROM polisa JOIN polisaosiguranik ON polisaosiguranik.polisa_id = polisa.id JOIN korisnik ON korisnik.id = polisaosiguranik.korisnik_id  order by polisa.{$sort} asc");

        return Konekcija::resultSet(PDO::FETCH_OBJ);
    }
}
