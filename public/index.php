<?php
require_once '../private/includes/header.php';

$data = Procisti::proveriPolja();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//ako atribut greska vraca false , unesi u bazu
if (Procisti::proveriStatusGresaka() === false) {

    Modeli::unesiPolisu($data);
    Modeli::unesiKorisnika($data);
    Modeli::unesiPolisaOsiguranik();
    Modeli::unesiGrupu($_POST);

    /////////////////////////////////// Generisi PDF

    if (isset($_POST["create_pdf"])) {

        $korisnici = Modeli::svePolise();
        function unesiUPdf($korisnici)
        {

            $output = '';

            foreach ($korisnici as $korisnik) {

                $output .= "
        <tr>
            <td>" . Procisti::prikaziDatum($korisnik->datum_unosa_polise, 'd/m/Y') . "</td>
            <td> " . $korisnik->ime_i_prezime  . "</td>
            <td>" . Procisti::prikaziDatum($korisnik->datum_rodjenja, 'd/m/Y') . "</td>
            <td>" . $korisnik->broj_pasosa . "</td>
            <td>" .  $korisnik->email . "</td>

        </tr>";
            }

            return $output;
        }


        require_once('../private/classes/tcpdf/tcpdf.php');
        $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $obj_pdf->SetCreator(PDF_CREATOR);
        $obj_pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");
        $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $obj_pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $obj_pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $obj_pdf->SetDefaultMonospacedFont('helvetica');
        $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
        $obj_pdf->setPrintHeader(false);
        $obj_pdf->setPrintFooter(false);
        $obj_pdf->SetAutoPageBreak(TRUE, 10);
        $obj_pdf->SetFont('helvetica', '', 12);
        $obj_pdf->AddPage();
        $content = '';
        $content .= '  
        <table class="table">
        <thead>
            <tr>
                <th>Datum unosa polise:</th>
                <th>Ime i prezime:</th>
                <th>Datum rodjenja:</th>
                <th>Broj pasosa:</th>
                <th>Email:</th>
            </tr>
        </thead> 
     ';
        $content .= unesiUPdf($korisnici);
        $content .= '</table>';
        $obj_pdf->writeHTML($content);

        $attachment = $obj_pdf->Output(__DIR__ . "/fajlovi/Osiguranje.pdf/", 'F');
        ob_end_clean();


        ///////////////////////////////////// end pdf 

        require '../private/classes/phpmailer/vendor/autoload.php';

        $mail = new PHPMailer(true);

        //$mail->SMTPDebug = 2;                                  
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'osiguranjetest@gmail.com';
        $mail->Password   = 'osiguranjeTest1';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress($data['email'], 'Joe User');

        $body = "Pozdrav";

        $mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');

        // Attachments

        $my_path = "fajlovi/Osiguranje.pdf";
        $mail->addAttachment($my_path, 'polisa.pdf');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Here is the subject';
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body);


        if ($mail->Send()) {
            header("Location: index.php");
        }

        // Obrisi PDF Fajl iz foldera 'public/fajlovi'
        $unlink_path = "fajlovi";
        unlink($unlink_path . "/Osiguranje.pdf");

        echo 'Uspesno uneti podaci';
    }
}

// ponovo vrati format datuma u input prikaz /dan/mesec/godina
if (isset($_POST['datumRodjenja']) && isset($_POST['datumPutovanjaOd']) && isset($_POST['datumPutovanjaDo'])) {

    $data['datumRodjenja'] = Procisti::vratiDatum($_POST['datumRodjenja']);
    $data['datumPutovanjaOd'] = Procisti::vratiDatum($_POST['datumPutovanjaOd']);
    $data['datumPutovanjaDo'] = Procisti::vratiDatum($_POST['datumPutovanjaDo']);
}

// ///////////// Email kraj 
?>
<section id="prijava">

    <header>
        <h1 class="text-center">Prijava za putno osiguranje</h1>
    </header>

    <form id='unos' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='POST'>

        <div class="form-group">
            <label for="ime">Ime i Prezime nosioca osiguranja<sup class="text-danger">*</sup></label>
            <input type="text" onblur=crveniOkvir(this); name="ime_i_prezime" id="ime_i_prezime" class="form-control" value="<?= $data['ime_i_prezime'] ?? ''; ?>">
            <span class="text-danger" id="ime_i_prezime_v"> <?php echo $data['ime_i_prezimeErr'] ?? '' ?></span>
        </div>

        <div class="form-group">
            <label for="">Datum rodjenja<sup class="text-danger">*</sup></label>
            <input type='text' autocomplete=off onblur=crveniOkvir(this) placeholder='Izaberite datum' name="datumRodjenja" value="<?= $data['datumRodjenja'][0] ?? ''; ?>" id="datumRodjenja" class='datepicker-here' data-language='en' />
            <span class="text-danger" id="datumRodjenja_v"> <?php echo $data['datumErr'] ?? '' ?></span>
        </div>
        <div class="form-group">
            <label for="">Datum putovanja<sup class="text-danger">*</sup></label>
            <div>
                <span>Od: </span>
                <input type='text' onblur=crveniOkvir(this); onblur=crveniOkvir(this) autocomplete=off placeholder='Izaberite datum' name="datumPutovanjaOd" id="datumPutovanjaOd" class='datepicker-here' data-language='en' />
                <span class="text-danger" id="datumPutovanjaOd_v"> <?php echo $data['putovanjeOdErr'] ?? '' ?></span>
            </div>
            <div>
                <span>Do: </span>
                <input type='text' onblur=crveniOkvir(this); autocomplete=off placeholder='Izaberite datum' name="datumPutovanjaDo" id="datumPutovanjaDo" class='datepicker-here' data-language='en' />
                <span class="text-danger" id="datumPutovanjaDo_v"> <?php echo $data['putovanjeDoErr'] ?? '' ?></span>
            </div>
            <div>
                <p>Broj dana:<span id="brojDana"></span></p>
            </div>
        </div>
        <div class="form-group">
            <label for="">Broj pasosa<sup class="text-danger">*</sup></label>
            <input type="text" onblur=crveniOkvir(this); name="brojPasosa" id="brojPasosa" class="form-control" value="<?= $data['brojPasosa'] ?? ''; ?>">
            <span class="text-danger" id="brojPasosa_v"> <?php echo $data['pasosErr'] ?? '' ?></span>
        </div>
        <div class="form-group">
            <label for="">Telefon</label>
            <input type="text" name="telefon" id="telefon" class="form-control" value="<?= $data['telefon'] ?? ''; ?>">
            <span class="text-danger"> <?php echo $data['telefonErr'] ?? '' ?></span>
        </div>
        <div class="form-group">
            <label for="">Email<sup>*</sup class="text-danger"></label>
            <input type="text" onblur=crveniOkvir(this); name="email" id="email" class="form-control" value="<?= $data['email'] ?? ''; ?>">
            <span class="text-danger" id="email_v"> <?php echo $data['emailErr'] ?? '' ?></span>
        </div>
        <div class="form-group">
            <label for="polisaOsiguranja">Vrsta polise osiguranja</label>
            <select class="form-control" name="polisaOsiguranja" id="polisaOsiguranja">
                <option value="1">Individualno</option>
                <option value="2">Grupno</option>
            </select>
        </div>

        <div id="grupnoOsiguranje">


        </div>
        <button id="dodajPolje" class="mb-4 ml-4 p-2 slova dugmePrikazi d-none">+</button>
        <button id="obrisiPolje" class="mb-4 p-2 slova dugmePrikazi d-none">-</button>


        <div id="primarno">
            <button type="submit" class="btn btn-primary ml-4">Unesi</button>
        </div>
        <input type="hidden" class='form-control' name="create_pdf" class="btn btn-danger" value="Create PDF" />
    </form>

</section>
<?php
require_once '../private/includes/footer.php';
