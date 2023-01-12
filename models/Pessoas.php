<?php

namespace tabelaPessoas\models;

use PDO;
use PDOException;

//constantes para conexão com o banco de dados
CONST Server = 'mysql';
CONST Host = '107.180.57.185';
CONST Db = 'dz_dev_test';
CONST User = 'dz_dev';
CONST Port = '';
CONST Password = 'p?%3DY?#*LBW';

class Pessoas {

	//função para conectar no banco de dados usando o PDO
	public function conectarBanco(){
		try {
			//cria a variavel de conexão com o banco
			$conectarBanco = new PDO(Server . ":host=" . Host . ";port=" . Port . ";dbname=" . Db, User, Password);
			
			return $conectarBanco;
		} catch (PDOException $e) {
			throw new PDOException ('Erro ao conectar no banco' . $e->getMessage ());
		}
	}

	//função para recuperar os dados do banco
	public function recuperar() {
		try {
			//conecta no banco
			$conexao = $this->conectarBanco();
			//cria a query
			$query = "SELECT pessoa.nome, pessoa.sexo, pessoa.cpf, pessoa.nascimento, pessoa.email, pessoa.celular, prof.nome AS profissao
					  FROM dz_dev_test.pessoas AS pessoa
					  LEFT JOIN dz_dev_test.profissoes AS prof ON pessoa.profissao_id = prof.id
					  WHERE pessoa.sexo = 'Feminino' AND YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(pessoa.nascimento))) > 20;";
			
			//prepara e executa a query
			$busca = $conexao->prepare($query);
			$busca->execute();

			//da um fetch nos resultados para retornar
			$resultados = $busca->fetchAll(PDO::FETCH_ASSOC); 
			
			//retorna o array de resultados da pesquina no banco
			return $resultados;

		} catch (PDOException $e) {
			throw new PDOException ('Erro: ' . $e->getMessage ());
		}
	}
}