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
            $pessoas = $tabela->recuperar();

            //regras de negocio do resultado do banco
            $tableRetorno = [];
            foreach ($pessoas as $pessoa) {

                //padrão de data do banco de dados para o padrão brasileiro
                $pessoa['nascimento'] = implode('/', array_reverse(explode('-', $pessoa['nascimento'])));

                //confere se existe e formata cada posição do array para UTF-8
                !empty($pessoa['nome']) ? $pessoa['nome'] = iconv("ISO-8859-1", "UTF-8", $pessoa['nome']) : $pessoa['nome'] = 'Dado não encontrado';
                !empty($pessoa['sexo']) ? $pessoa['sexo'] = iconv("ISO-8859-1", "UTF-8",$pessoa['sexo']) : $pessoa['sexo'] = 'Dado não encontrado';
                !empty($pessoa['cpf']) ? $pessoa['cpf'] = iconv("ISO-8859-1", "UTF-8",$pessoa['cpf']) : $pessoa['cpf'] = 'Dado não encontrado';
                !empty($pessoa['nascimento']) ? $pessoa['nascimento'] = iconv("ISO-8859-1", "UTF-8",$pessoa['nascimento']) : $pessoa['nascimento'] = 'Dado não encontrado';
                !empty($pessoa['email']) ? $pessoa['email'] = iconv("ISO-8859-1", "UTF-8",$pessoa['email']) : $pessoa['email'] = 'Dado não encontrado';
                !empty($pessoa['celular']) ? $pessoa['celular'] = iconv("ISO-8859-1", "UTF-8",$pessoa['celular']) : $pessoa['celular'] = 'Dado não encontrado';
                !empty($pessoa['profissao']) ?$pessoa['profissao']  = iconv("UTF-8", "UTF-8",$pessoa['profissao']) : $pessoa['profissao'] = 'Dado não encontrado';

                //monta a tabela com as regras aplicadas
                $tableRetorno[] = [
                    'nome' => $pessoa['nome'],
                    'sexo' => $pessoa['sexo'],
                    // no CPF confere se está com a mascará corretamente, caso não esteja, aplica a mascará
                    'cpf' => strlen($pessoa['cpf']) != 14 ? $this->mascara($pessoa['cpf'], '###.###.###-##') : $pessoa['cpf'],
                    'nascimento' => $pessoa['nascimento'],
                    'email' => $pessoa['email'],
                    'celular' => $pessoa['celular'],
                    'profissao' => $pessoa['profissao'],
                ];
            }

            //se existir algo para retorna, retorna, caso não tiver, retorna string vazia para não quebrar o datatable
            return !empty($tableRetorno) ? $tableRetorno : '';

        } catch (Exception $e) {
            throw new Exception('Erro ao recuperar pessoas. '.$e->getMessage());
        }

    }

    //função para colocar mascará em string
    function mascara($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; ++$i) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if (isset($mask[$i])) {
                    $maskared .= $mask[$i];
                }
            }
        }
        return $maskared;
    }
}