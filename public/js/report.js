

const now = new Date();
let perMode = $('#perMode')

function formatDateToDB(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const seconds = String(date.getSeconds()).padStart(2, '0');

    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}



let time = $('#time');
time.on('change', function () {
    const selectedValue = parseInt($(this).val());
    if (!isNaN(selectedValue)) {
        const newTime = new Date(now);

        if (selectedValue === 7) {
            perMode.attr('value', 2)
            newTime.setDate(newTime.getDate() - selectedValue);
        } else if (selectedValue <= 24) {
            perMode.attr('value', 1)
            newTime.setHours(newTime.getHours() - selectedValue);
        } else {
            perMode.attr('value', 2)
            const monthsToSubtract = selectedValue / 31;
            newTime.setMonth(newTime.getMonth() - monthsToSubtract);
        }

        const newFormattedDate = formatDateToDB(newTime);
        $('#from').attr('value', newFormattedDate);
    }
});


// Carregar o pacote do gráfico
google.charts.load('current', {
    packages: ['corechart', 'line']
});

// Função para desenhar o gráfico
google.charts.setOnLoadCallback(drawChart);

// Obter valores para labels e datasets
let createdAt = $('#created_at').val();
let umidade, temperatura, litros;

// Converter strings para arrays
createdAt = createdAt ? createdAt.split(',') : [];
// Formatar as datas para o formato d/m/y h:i:s
createdAt = createdAt.map(date => {
    const d = new Date(date);
    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = d.getFullYear();
    const hours = String(d.getHours()).padStart(2, '0');
    const minutes = String(d.getMinutes()).padStart(2, '0');
    const seconds = String(d.getSeconds()).padStart(2, '0');
    return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
});

if (perMode == 2) {
    umidade = $('#average_humidity').val();
    umidade = umidade ? umidade.split(',').map(Number) : [];

    temperatura = $('#average_temperature').val();
    temperatura = temperatura ? temperatura.split(',').map(Number) : [];

    litros = $('#average_liters').val();
    litros = litros ? litros.split(',').map(Number) : [];
} else {
    umidade = $('#humidity').val();
    umidade = umidade ? umidade.split(',').map(Number) : [];

    temperatura = $('#temperature').val();
    temperatura = temperatura ? temperatura.split(',').map(Number) : [];

    litros = $('#liters').val();
    litros = litros ? litros.split(',').map(Number) : [];
}
window.addEventListener('resize', drawChart);
// Função para desenhar o gráfico usando Google Charts
function drawChart() {
    const data = new google.visualization.DataTable();


    // Definindo as colunas
    data.addColumn('string', 'Data');
    data.addColumn('number', 'Umidade');
    data.addColumn('number', 'Temperatura');
    data.addColumn('number', 'Litros');

    // Adicionando as linhas de dados
    for (let i = 0; i < createdAt.length; i++) {
        data.addRow([createdAt[i], umidade[i], temperatura[i], litros[i]]);
    }

    // Definindo as opções do gráfico
    var options = {
        'title': 'Relatorio do Dispositivo',
        'width': '100%',
        'height': '50vh',
        colors: ['#0055ff', '#ff5900', '#9500ff'],
        curveType: 'function',
    };

    // Criar e desenhar o gráfico
    var chart = new google.charts.Line(document.getElementById('chart'));

    chart.draw(data, google.charts.Line.convertOptions(options));

    // NADA FUNCIONA AQ AKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAKAKKAKAKAKAKKAKAKAKKAKAKAKAKKAKAKAKAKAKAKAKAK

    // let googleError = $('[id^="google-visualization-errors-"]');


    // console.log(googleError)

    // if (googleError.length != 0) { // Verifica se o elemento existe
    //     $('#chart').css({
    //         'display': 'none'
    //     });
    //     $('.time').empty();
    //     html = '<p>Não foi possivel encontrar dados do ultimo periodo selecionado</p> <br> <p>Verifique a conexão de seu dispositivo com a internet</p>'

    //     // Ai depende de quanto tempo a pessoa tem o dispositivo ativado, e qual periodo ela selecionou, da pra fazer uma verificação e colocar um <p> personalizado dizendo o que pode ter ocorrido e o que fazer

    //     $('.time').html(html)
    // }
}

// Formatar a data atual
const today = new Date();
const date = `${String(today.getDate()).padStart(2, '0')}/${String(today.getMonth() + 1).padStart(2, '0')}/${today.getFullYear()}`;

$('.time').html(function (index, currentHtml) {
    return currentHtml + date;
});



