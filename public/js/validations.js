jQuery(document).ready(function () {

    $('.valSoloTexto').on('input', function (e) {
        if (!/^[a-zA-ZÁáÀàÉéÈèÍíÌìÓóÒòÚúÙùÑñüÜ ]*$/i.test(this.value)) {
            this.value = this.value.replace(/[^a-zA-ZÁáÀàÉéÈèÍíÌìÓóÒòÚúÙùÑñüÜ]+/ig, "");
        }
    });

    $('.valCaracteresRepetidos').on('input', function (e) {
        var cadena = this.value.length;
        if (cadena > 2) {
            var caracterPrimero = this.value[cadena - 3].toLowerCase();
            var caracterUltimo = this.value[cadena - 1].toLowerCase();
            var caracterSegundo = this.value[cadena - 2].toLowerCase();
            if (caracterPrimero === caracterUltimo && caracterSegundo.trim() !== '' && caracterPrimero === caracterSegundo) {
                this.value = this.value.slice(0, -1);
            }
        }
    });
    $('.valCaracteresInvalidos').on('input', function (e) {
        if (/no |tengo|nombre|algo/g.test(this.value.toLowerCase())) {
            this.value = this.value.replace(/no |tengo|nombre|algo/ig, "");
        }
    });
    $('.valSoloNumero').on('input', function (e) {
        if (!/^[0-9]*$/i.test(this.value)) {
            this.value = this.value.replace(/[^0-9]+/ig, "");
        }
    });

});
