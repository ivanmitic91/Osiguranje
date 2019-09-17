var brojac = 1;

$('#polisaOsiguranja').change(function (e) {
    if (this.value == 2) {
        $('.dugmePrikazi').removeClass("d-none");
        napuni(1)

    } else {

        $('.dugmePrikazi').addClass("d-none");
        $('#grupnoOsiguranje').empty();


    }
});

$('#dodajPolje').on('click', function (e) {
    e.preventDefault();
    brojac++;
    napuni(brojac);


});

function napuni(broj) {
    $('#grupnoOsiguranje').append('<div class="polje"><div class=""><fieldset><legend>Osiguranik ' + broj + ':</legend > <label for="">Ime i Prezime<sup>*</sup class ="text-danger"></label> <input type="text" required onblur=crveniOkvir(this);         name="grupno[' + broj + '][ime_i_prezime]" class="form-control"><span class="text-danger"></span></div><div class="form-group"><label for="">Datum rodjenja<sup>*</sup class ="text-danger"></label><input type="date" onblur=crveniOkvir(this); required name="grupno[' + broj + '][datum_rodjenja]" class="form-control"><span class="text-danger"></span></div><div class="form-group"><label for="">Broj pasosa<sup>*</sup class ="text-danger"></label><input type="number" placeholder="potrebno je uneti 9 cifara" required  onkeyup=validBroj(this); name="grupno[' + broj + '][broj_pasosa]" class="form-control"><span class="text-danger"></span></div>');
}


function validBroj(t) {

    var value = $(t).val();

    if (value.length !== 9) {

        $(t).addClass('border border-danger');

    } else {
        $(t).removeClass("border border-danger");
    }
}


$('#obrisiPolje').on('click', function (e) {

    e.preventDefault();

    brojac--;

    $(".polje").last().remove();

    if (brojac < 1) {

        brojac = 0;

    }

});


$("#datumPutovanjaDo").datepicker({
    onSelect: function (dateText, inst) {


        if ($("#datumPutovanjaOd").val() !== '') {

            const datumPutovanjaOd = new Date($("#datumPutovanjaOd").datepicker({ dateFormat: 'yyyy, mm, dd' }).val());
            const datumPutovanjaDo = new Date($("#datumPutovanjaDo").datepicker({ dateFormat: 'yyyy, mm, dd' }).val());


            $("#datumPutovanjaOd").datepicker({ dateFormat: 'dd/mm/yyyy' });
            $("#datumPutovanjaDo").datepicker({ dateFormat: 'dd/mm/yyyy' });


            var brojDana = parseInt((datumPutovanjaDo - datumPutovanjaOd) / (1000 * 60 * 60 * 24));

            if (brojDana < 1) {
                $('#brojDana').html('Datum "Do" je manji od pocetnog').addClass('text-danger');
            } else {
                $('#brojDana').html(brojDana);

            }

        }
    }
});


