<?php

use tabelaPessoas\controller\pessoasController;

require $_SERVER['DOCUMENT_ROOT'] . '/tabelaPessoas/controller/pessoasController.php';

//verifica se existe uma ação no $_REQUEST
$acao = (!empty($_REQUEST['acao'])) ? $_REQUEST['acao'] : '';

//switch de ações
switch ($acao) {
    //ação carregarTabela
    case 'carregarTabela':
        try {
            //envia para controller e retorna para o front o resultado
            $tabela = new pessoasController;
            $tabela = $tabela->recuperarTabela();

            //retorna para o javascript
            echo json_encode([
                'success' => true,
                'data' =>  $tabela,
            ]);
            
        } catch (Exception $e) {
            throw new Exception("Erro ao carregar a tabela", $e->getMessage());
        }
    break;

}
