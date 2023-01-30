<?php

namespace tabelaPessoas\models;

use PDO;
use PDOException;

//constantes para conexão com o banco de dados
CONST Server = '';
CONST Host = '';
CONST Db = '';
CONST User = '';
CONST Port = '';
CONST Password = '';

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
			$query = "SELECT * FROM 'bancoDeDados' WHERE 1=1;";
			
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
