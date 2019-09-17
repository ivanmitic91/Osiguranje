<?php
require_once '../private/includes/header.php';

$nosioc = Modeli::pronadjiPolisu(filter_input(INPUT_GET, 'id_nosioca'));

?>

<div class='jumbotron'>
    <h1 class="text-center mb-4">Nosioc</h1>
    <ul class='list-group'>
        <li class="list-group-item pl-5">datum unosa polise: <?= Procisti::prikaziDatum($nosioc->datum_unosa_polise, 'd/m/Y H:i:s'); ?></li>
        <li class="list-group-item pl-5">ime i prezime: <?= $nosioc->ime_i_prezime; ?></li>
        <li class="list-group-item pl-5">datum rodjenja: <?= Procisti::prikaziDatum($nosioc->datum_rodjenja, 'd/m/Y'); ?></li>
        <li class="list-group-item pl-5">broj pasosa: <?= $nosioc->broj_pasosa; ?></li>
        <li class="list-group-item pl-5">email: <?= $nosioc->email; ?></li>
        <li class="list-group-item pl-5">datum putovanja od: <?= Procisti::prikaziDatum($nosioc->datum_putovanja_od, 'd/m/Y H:i:s'); ?></li>
        <li class="list-group-item pl-5">datum putovanja do: <?= Procisti::prikaziDatum($nosioc->datum_putovanja_do, 'd/m/Y H:i:s'); ?></li>
        <li class="list-group-item pl-5">vrsta polise: <?= $nosioc->tip_polise == 0 ? 'Individualna' : "Grupna"  ?>


            <?= "<a href=\"grupna_polisa?id_polisa=$nosioc->id\" class='btn btn-secondary'>Prikazi</a>" ?>

        </li>
    </ul>




</div>

<?php

require_once '../private/includes/footer.php';
