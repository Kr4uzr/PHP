<?php

namespace tabelaPessoas\controller;

require $_SERVER['DOCUMENT_ROOT'] . '/tabelaPessoas/models/Pessoas.php';

use Exception;
use tabelaPessoas\models\Pessoas;

class pessoasController {

    //função controller para enviar a requisição para model e tratar os dados retornado do banco
    public function recuperarTabela(){
        try {
            //envia para model e guarda o resultado em uma variavel
            $tabela = new Pessoas;
            $retorno = $tabela->recuperar();

            //se existir algo para retorna, retorna, caso não tiver, retorna string vazia para não quebrar o datatable
            return !empty($retorno) ? $retorno : '';

        } catch (Exception $e) {
            throw new Exception('Erro ao recuperar. '.$e->getMessage());
        }

    }
}
