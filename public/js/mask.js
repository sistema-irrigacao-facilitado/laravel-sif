$(function () {

    $('.date').mask('00/00/0000');
    $('.cem').mask('000');
    $('.numbering').mask('00000000');
    $('.time').mask('00:00:00');
    $('.date_time').mask('00/00/0000 00:00:00');
    $('.cep').mask('00000-000');
    $('.phone').mask('(00) 0000-0000');
    $('.phone_with_ddd').mask('(00) 0000-0000');
    $('.phone_us').mask('(000) 000-0000');
    $('.ip_address').mask('099.099.099.099');
    $('.percent').mask('##0,00%', { reverse: true });
    $('.clear-if-not-match').mask("00/00/0000", { clearIfNotMatch: true });
    $('.placeholder').mask("00/00/0000", { placeholder: "__/__/____" });
    $('.fallback').mask("00r00r0000", {
        translation: {
            'r': {
                pattern: /[\/]/,
                fallback: '/'
            },
            placeholder: "__/__/____"
        }
    });
    $('.selectonfocus').mask("00/00/0000", { selectOnFocus: true });
    $('.whatsapp').mask('(00) 00000-0000', {
        placeholder: "(__) _____-____"
    });
    $('.money').mask('###0.00', { reverse: true });
    $('.cpf').mask('000.000.000-00', { reverse: true });
    $('.cnpj').mask('00.000.000/0000-00', { reverse: true });
    $(".cpf_cnpj").keydown(function () {
        try {
            $(this).unmask();
        } catch (e) { }
        var tamanho = $(this).val().length;
        if (tamanho < 11) {
            $(this).mask("999.999.999-99");
        } else {
            $(this).mask("99.999.999/9999-99");
        }
        // ajustando foco
        var elem = this;
        setTimeout(function () {
            // mudo a posição do seletor
            elem.selectionStart = elem.selectionEnd = 10000;
        }, 0);
        // reaplico o valor para mudar o foco
        var currentValue = $(this).val();
        $(this).val('');
        $(this).val(currentValue);
    });
    $('.letters-only').on('input', function () {
        this.value = this.value.replace(/[^a-zA-Z]/g, '');
    });
})
