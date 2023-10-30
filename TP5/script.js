const inputCodeClient = document.getElementById('codeClient');
const inputNomMagasin = document.getElementById('nomMagasin');
const inputResponsable = document.getElementById('responsable');
const inputAdresse1 = document.getElementById('adresse1');
const inputAdresse2 = document.getElementById('adresse2');
const inputCodePostal = document.getElementById('cdp');
const inputVille = document.getElementById('ville');
const inputCategoire = document.getElementById('categorie');
const inputTelephone = document.getElementById('noTel');
const inputEmail = document.getElementById('mail');

regexCodePostal = new RegExp("^(0[1-9]|[1-8]\\d|9[0-8])\\d{3}$",'gm');
regexTelephone = new RegExp("^[0-9]{10}$",'gm');
regexMail = new RegExp('^[a-z0-9.-_]+@{1}[0-9a-z.-]{2,}[.]{1}[a-z]{2,5}$','i');

inputCodeClient.addEventListener('keypress', function (e) {
    console.log(inputCodeClient.value)
    if (inputCodeClient.value.length  > 15 || inputCodeClient.value === "") {
        inputCodeClient.labels[0].classList.add('enRouge');
    } else {
        inputCodeClient.labels[0].classList.remove('enRouge');
    }
})

inputNomMagasin.addEventListener('keypress', function (e) {
    if (inputNomMagasin.value.length  > 35 || inputNomMagasin.value === "") {
        inputNomMagasin.labels[0].classList.add('enRouge');
    } else {
        inputNomMagasin.labels[0].classList.remove('enRouge');
    }
})

inputResponsable.addEventListener('keypress', function (e) {
    if (inputResponsable.value.length  > 35 || inputResponsable.value === "") {
        inputResponsable.labels[0].classList.add('enRouge');
    } else {
        inputResponsable.labels[0].classList.remove('enRouge');
    }
})

inputAdresse1.addEventListener('keypress', function (e) {
    if (inputAdresse1.value.length  > 35 || inputAdresse1.value === "") {
        inputAdresse1.labels[0].classList.add('enRouge');
    } else {
        inputAdresse1.labels[0].classList.remove('enRouge');
    }
})

inputAdresse2.addEventListener('keypress', function (e) {
    if (inputAdresse2.value.length  > 35 || inputAdresse2.value === "") {
        inputAdresse2.labels[0].classList.add('enRouge');
    } else {
        inputAdresse2.labels[0].classList.remove('enRouge');
    }
})

inputCodePostal.addEventListener('keypress', function (e) {
    console.log(inputCodePostal.value)
    if (!regexCodePostal.test(inputCodePostal.value)) {
        inputCodePostal.labels[0].classList.add('enRouge');
    } else {
        inputCodePostal.labels[0].classList.remove('enRouge');
    }
})

inputVille.addEventListener('keypress', function (e) {
    if (inputVille.value.length  > 35 || inputVille.value === "") {
        inputVille.labels[0].classList.add('enRouge');
    } else {
        inputVille.labels[0].classList.remove('enRouge');
    }
})

//TODO
inputCategoire.addEventListener('keypress', function (e) {
    if (inputCategoire.value.length  > 15 || inputCategoire.value === "") {
        inputCategoire.labels[0].classList.add('enRouge');
    } else {
        inputCategoire.labels[0].classList.remove('enRouge');
    }
})

inputTelephone.addEventListener('keypress', function (e) {
    if (!regexTelephone.test(inputTelephone.value)) {
        inputTelephone.labels[0].classList.add('enRouge');
    } else {
        inputTelephone.labels[0].classList.remove('enRouge');
    }
})

inputEmail.addEventListener('keypress', function (e) {
    if (!regexMail.test(inputEmail.value)) {
        inputEmail.labels[0].classList.add('enRouge');
    } else {
        inputEmail.labels[0].classList.remove('enRouge');
    }
})
