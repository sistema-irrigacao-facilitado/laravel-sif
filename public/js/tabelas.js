$(document).ready(function() {
    $('.table').DataTable({
      "language": {
        "sEmptyTable": "Nenhum dado disponível na tabela",
        "sInfo": "Mostrando de _START_ a _END_ de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
        "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
        "sInfoPostFix": "",
        "sInfoThousands": ".",
        "sLengthMenu": "Mostrar _MENU_ registros por página",
        "sLoadingRecords": "Carregando...",
        "sProcessing": "Processando...",
        "sSearch": "Pesquisar:",
        "sZeroRecords": "Nenhum registro encontrado",
        "oPaginate": {
          "sFirst": "Primeiro",
          "sLast": "Último",
          "sNext": "Próximo",
          "sPrevious": "Anterior"
        },
        "oAria": {
          "sSortAscending": ": ativar para classificar coluna em ordem crescente",
          "sSortDescending": ": ativar para classificar coluna em ordem decrescente"
        }
      }
    });
  });