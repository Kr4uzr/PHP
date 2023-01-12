$(document).ready(function () {
    carregarTabela();
});


//função para carregar datatable
function carregarTabela(){

    //monta o DataTable do Jquery
    $('#pessoas').DataTable( {
        //requisição via ajax
        ajax: {
            url: '/tabelaPessoas/views/ajax.php',
            type: 'POST',
            data: function () {

                return {
                    acao: 'carregarTabela',       
                }
            }
        }, 
        //conlunas para criar o DataTable
        columns: [
            { data: 'nome', className: 'text-left'},
            { data: 'sexo', className: 'text-left'},
            { data: 'cpf', className: 'text-left'},
            { data: 'nascimento', className: 'text-left'},
            { data: 'email', className: 'text-left'},
            { data: 'celular', className: 'text-left'},
            { data: 'profissao', className: 'text-left'}
        ],
        //configurações do DataTable
        responsive : false,
        scrollX : false,
        Filter : true,
        LengthChange : true,
        bInfo : true,
        Destroy : false,
        Retrieve : true,
        aaSorting : [0, 'asc'],
        Paginate: true, 
        AutoWidth : false,
        //definição da coluna de nascimento para ordenar data em formato brasileiro
        columnDefs: [{ 'targets': [3], type: 'date-br'}],
        lengthMenu: [
            [5, 10, 15, -1],
            [5, 10, 15, 'Tudo'],
        ],
        //tradução do DataTable
        language: {
           url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json'
        },
        fixedHeader : {
            header : true,
            headerOffset : 63
        }
    });

    //extend para ordenar data no formato brasileiro
    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        "date-br-pre": function ( a ) {
            if (a == null || a == "") {
                return 0;
            }
            let brDatea = a.split('/');
            return (brDatea[2] + brDatea[1] + brDatea[0]) * 1;
        },

        "date-br-asc": function ( a, b ) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },

        "date-br-desc": function ( a, b ) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    });
}
