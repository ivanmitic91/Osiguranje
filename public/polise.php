<?php ob_start();
require_once '../private/includes/header.php';

$korisnici = null;
if (isset($_GET['sortBy'])) {
    $sortBy = htmlspecialchars(trim($_GET['sortBy']));

    $korisnici = Modeli::svePoliseSortiranjePo($sortBy);
} else {
    $korisnici = Modeli::svePolise();
}

?>

<!-- html -->

<h1 class="text-center mb-4">Nosioci</h1>
<div class="form-group">
    <form action="" method="get" class="p-0 w-50">
        <select class='p-2 form-control w-100' name="sortBy" id="">
            <option class='slova' value="id">id polise</option>
            <option class='slova' value="datum_unosa_polise">datum unosa</option>
            <option class='slova' value="datum_putovanja_od">datum putovanja od</option>
            <option class='slova' value="datum_putovanja_do">datum putovanja do</option>
        </select>

        <button class='p-1 slova w-100' type="submit">Sortiraj po</button>
    </form>
</div>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Datum unosa polise:</th>
                <th>Ime i prezime:</th>
                <th>Datum rodjenja:</th>
                <th>Broj pasosa:</th>
                <th>Email:</th>
                <th>Broj dana:</th>
                <th>Tip osiguranja:</th>
                <th>Pojedninacni prikaz</th>
            </tr>
        </thead>
        <?php
        foreach ($korisnici as $korisnik) {

            $datetime1 = date_create($korisnik->datum_putovanja_od);
            $datetime2 = date_create($korisnik->datum_putovanja_do);

            $brojDana = date_diff($datetime1, $datetime2)->days;

            ?>
            <tbody id="tbody">
                <tr>
                    <td>
                        <?= Procisti::prikaziDatum($korisnik->datum_unosa_polise, 'd/m/Y H:i:s'); ?>
                    </td>
                    <td>
                        <?= $korisnik->ime_i_prezime; ?>
                    </td>
                    <td>
                        <?= Procisti::prikaziDatum($korisnik->datum_rodjenja, 'd/m/Y'); ?>
                    </td>
                    <td>
                        <?= $korisnik->broj_pasosa; ?>
                    </td>
                    <td>
                        <?= $korisnik->email; ?>
                    </td>
                    <td>
                        <?= $brojDana; ?>
                    </td>
                    <td>
                        <?= $korisnik->nosioc == 0 ? 'Individualno' : 'Grupno' ?>
                    </td>
                    <td>

                        <?php if ($korisnik->nosioc == 1) :  ?>

                            <a href="nosioc.php?id_nosioca=<?= $korisnik->id ?>" class="btn btn-secondary">Prikazi</a>

                        <?php endif; ?>
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

?>