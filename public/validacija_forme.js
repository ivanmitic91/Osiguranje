function crveniOkvir(o) {

    if (o.value === '') {
        o.style.backgroundColor = '#F6DDDF';
    } else {

        o.style.backgroundColor = '';
    }

}


function jsValidacija() {

    document.forms[0].ime_i_prezime.addEventListener("keyup", function () {
        validate('ime_i_prezime')
    });
    document.forms[0].datumRodjenja.addEventListener("keyup", function () {
        validate('datumRodjenja')
    });
    document.forms[0].datumPutovanjaOd.addEventListener("keyup", function () {
        validate('datumPutovanjaOd')
    });
    document.forms[0].datumPutovanjaDo.addEventListener("keyup", function () {
        validate('datumPutovanjaDo')
    });
    document.forms[0].brojPasosa.addEventListener("keyup", function () {
        validate('brojPasosa')
    });
    document.forms[0].email.addEventListener("keyup", function () {
        validate('email')
    });
    document.forms[0].onsubmit = function () {

        if (validate('ime_i_prezime') && validate('datumRodjenja') && validate('datumPutovanjaOd') && validate('datumPutovanjaDo') && validate('brojPasosa') && validate('email')) {
            alert("Podaci su ispravni");
            return true;
        } else {
            document.getElementById('unos').style.borderColor = 'red';
            return false;
        }
    };

    function validate(f) {
        var val = document.forms[0][f].value;
        switch (f) {
            case 'ime_i_prezime':
                var RegExp = /^[a-z ,.'-]+$/i;
                var poruka = "Dozvoljena su samo slova";
                break;
            case 'email':
                var RegExp = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                var poruka = "Pogresan format datuma";
                break;
            case 'brojPasosa':
                var RegExp = /^[0-9]{9}$/;
                var poruka = "Unesite 9 cifara";
                break;
        }
        if (!(RegExp.test(val))) {
            document.getElementById(f + '_v').innerHTML = "<span style='color:red'>" + poruka + '</span>';
            return false;
        } else {
            document.getElementById(f + '_v').innerHTML = "<span style='color:green'>Ispravno</span>";
            return true;
        }
    }

}

