$(document).ready(function () {
    const diasDaSemana = $('#hrLigar');
    const periodo = $('.periodoContainer')
    let modoRadio = $('input[name="modoRadio"]');
    let a = $('input[name="modoRadio"]:checked')
    let elementoModo = $('#modo');
    elementoModo.attr('value', a.val());
    let qtd = 0

    if (a.val() == '2') {
        diasDaSemana.css('display', 'flex');
        periodo.css('display', 'flex');
        $('.l').css('display', 'flex');
    } else{
        diasDaSemana.css('display', 'none');
        periodo.css('display', 'none');
        $('.l').css('display', 'none');
    }

    let vazao = $('#vazao').val()

    let pertime = $('#pertime').val()
    if (pertime && vazao && qtd) {
        calcLitros(vazao, pertime, qtd)
    }

    $('#pertime').change(function () {

        pertime = $('#pertime').val()

        if (vazao && qtd) {
            calcLitros(vazao, pertime, qtd)
        }
    })


    modoRadio.on('change', function () {
        const valorSelecionado = $(this).val();
        elementoModo.attr('value', valorSelecionado);
        if ($(this).val() === '2') {
            diasDaSemana.css('display', 'flex');
            periodo.css('display', 'flex');
            $('.l').css('display', 'flex');
        } else {
            diasDaSemana.css('display', 'none');
            periodo.css('display', 'none');
            $('.l').css('display', 'none');
        }
    });

    $('.day-btn').on('change', function () {
        var day = $(this).val();
        var dayName = $(this).attr('id');

        if ($(this).is(':checked')) {
            var newDiv = $('<div class="day-container" data-day="' + day + '">')
                .append('<div class="hr-text">' + dayName + '</div>')
                .append('<button class="add-time-btn btn btn-primary">Adicionar Horário</button>');

            var timeContainer = $('<div class="time-inputs"></div>');
            newDiv.append(timeContainer);

            $('.time').append(newDiv);
        } else {
            $('.time .day-container[data-day="' + day + '"]').remove();
        }
    });

    $('.time').on('click', '.add-time-btn', function () {
        var timeContainer = $(this).closest('.day-container').find('.time-inputs');
        var numberOfInputs = timeContainer.children('.time-input-container').length;

        if (numberOfInputs < 4) {
            var newInput = $('<div class="time-input-container input-group">')
                .append('<input type="time">')
                .append('<button class="remove-time-btn btn btn-danger">X</button>');
            timeContainer.append(newInput);
            qtd++
            if (vazao && pertime) {
                calcLitros(vazao, pertime, qtd)
            }
        }


    });


    $('.time').on('click', '.remove-time-btn', function () {
        $(this).parent().remove();
        qtd--
        if (pertime && vazao) {
            calcLitros(vazao, pertime, qtd)
        }
    });

    let storedSchedule = $('.hrLigarInput').val();
    if (storedSchedule) {
        const scheduleData = JSON.parse(storedSchedule);

        $.each(scheduleData, function (day, times) {
            $(`.day-btn[value="${day}"]`).prop('checked', true);
            const newDiv = $('<div class="day-container" data-day="' + day + '">')
                .append('<div class="hr-text">' + dia(day) + '</div>')
                .append('<button class="add-time-btn btn btn-primary">Adicionar Horário</button>');

            const timeContainer = $('<div class="time-inputs"></div>');
            newDiv.append(timeContainer);

            $.each(times, function (index, time) {
                const newInput = $('<div class="time-input-container input-group">')
                    .append('<input type="time" value="' + time + '">')
                    .append('<button class="remove-time-btn btn btn-danger">X</button>');
                timeContainer.append(newInput);
                qtd++
            });

            $('.time').append(newDiv);
            if (pertime && vazao) {
                calcLitros(vazao, pertime, qtd)
            }
        });
    }
    $('.modal-footer .btn-success').on('click', function () {
        const scheduleData = {};


        $('.day-container').each(function () {
            const day = $(this).data('day');
            const times = [];
            $(this).find('input[type="time"]').each(function () {
                times.push($(this).val());
            });
            scheduleData[day] = times;
        });

        const jsonData = JSON.stringify(scheduleData, null, 2);
        $('.hrLigarInput').attr('value', jsonData)

        $('#periodo').attr('value', pertime)

        $('#formModo button').click()

    });
    $('#pertime').mask('00:00', {
        reverse: true,
    });

});
function dia(int) {
    switch (int) {
        case '0':
            return "Domingo"
            break;
        case '1':
            return "Segunda"
            break;
        case '2':
            return "Terça"
            break;
        case '3':
            return "Quarta"
            break;
        case '4':
            return "Quinta"
            break;
        case '5':
            return "Sexta"
            break;
        case '6':
            return "Sábado"
            break;

        default:
            alert('Opção inválida');
    }
}

function calcLitros(vazao, pertime, qtd) {
    if (!vazao || !pertime || !qtd) {
        $('.l').empty();
        return;
    }
    let segundosTotal = 0;

    if (pertime.includes(':')) {
        let [minutos, segundos] = pertime.split(':').map(Number);
        segundosTotal = (minutos * 60) + (segundos || 0);
    } else {
        segundosTotal = parseInt(pertime, 10);
    }

    let milissegundos = segundosTotal * 1000;
    let tempo = milissegundos * qtd;
    let litrosGastos = (tempo / 60000.0) * parseFloat(vazao);
    let texto = `<p>Litros: ${litrosGastos.toFixed(2)} </p>`;

    $('.l').empty();
    $('.l').append(texto);
}
