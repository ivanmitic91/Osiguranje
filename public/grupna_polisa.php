<?php
require_once '../private/includes/header.php';

$id =  htmlspecialchars($_GET['id_polisa']);
$grupne_polise =  Modeli::prikaziGrupu($id);

?>
<h1>Grupa</h1>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Ime i prezime:</th>
                <th>Datum rodjenja:</th>
                <th>Broj pasosa:</th>
                <th>Email:</th>
                <th>Telefon:</th>
            </tr>
        </thead>
        <?php
        foreach ($grupne_polise as $polisa) {

            ?>
            <tbody id="tbody">
                <tr>
                    <td>
                        <?= $polisa->ime_i_prezime; ?>
                    </td>
                    <td>
                        <?= Procisti::prikaziDatum($polisa->datum_rodjenja, 'd/m/Y'); ?>
                    </td>
                    <td>
                        <?= $polisa->broj_pasosa; ?>
                    </td>
                    <td>
                        <?= $polisa->email; ?>
                    </td>
                    <td>
                        <?= $polisa->telefon; ?>
                    </td>
                </tr>
            </tbody>
        <?php
        }
        ?>

    </table>

</div>

<?php
require_once '../private/includes/footer.php';
