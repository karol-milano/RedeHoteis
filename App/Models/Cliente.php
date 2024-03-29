<?php

namespace App\Models;

use RH\Model\Model;

class Cliente extends Model {

	public function criarCliente($nome, $cpf, $celular, $telefone, $dt_nascimento, $tp_logradouro, $logradouro, $numero, $bairro, $complemento, $cidade, $estado, $cep, $pais, $email, $senha) {

		$dadosCliente = array(
			'nome' => $nome, 
			'cpf' => $cpf, 
			'celular' => $celular, 
			'telefone' => $telefone, 
			'dt_nascimento' => date('Y-m-d H:i:s', strtotime($dt_nascimento)),
			'tp_logradouro' => $tp_logradouro, 
			'logradouro' => $logradouro, 
			'numero' => $numero, 
			'bairro' => $bairro, 
			'complemento' => $complemento, 
			'cidade' => $cidade, 
			'estado' => $estado, 
			'cep' => $cep, 
			'pais' => $pais, 
			'email' => $email, 
			'senha' => $senha
		);

		$this->db->prepare("INSERT INTO cliente(nome, cpf, celular, telefone, dt_nascimento, tp_logradouro, logradouro, numero, bairro, complemento, cidade, estado, cep, pais, email, senha) VALUES (:nome, :cpf, :celular, :telefone, :dt_nascimento, :tp_logradouro, :logradouro, :numero, :bairro, :complemento, :cidade, :estado, :cep, :pais, :email, :senha)")
		->execute($dadosCliente);
	}

	public function editarCliente($id, $nome, $cpf, $celular, $telefone, $dt_nascimento, $tp_logradouro, $logradouro, $numero, $bairro, $complemento, $cidade, $estado, $cep, $pais, $email, $senha) {

		$dadosCliente = array(
			'id'			=> $id,
			'nome' 			=> $nome, 
			'cpf' 			=> $cpf, 
			'celular' 		=> $celular, 
			'telefone' 		=> $telefone, 
			'dt_nascimento' => date('Y-m-d H:i:s', strtotime($dt_nascimento)),
			'tp_logradouro' => $tp_logradouro, 
			'logradouro' 	=> $logradouro, 
			'numero' 		=> $numero, 
			'bairro' 		=> $bairro, 
			'complemento' 	=> $complemento, 
			'cidade'		=> $cidade, 
			'estado' 		=> $estado, 
			'cep' 			=> $cep, 
			'pais' 			=> $pais, 
			'email' 		=> $email, 
			'senha' 		=> $senha
		);

		$this->db->prepare("UPDATE cliente SET nome = :nome, cpf = :cpf, celular = :celular, telefone = :telefone, dt_nascimento = :dt_nascimento, tp_logradouro = :tp_logradouro, logradouro = :logradouro, numero = :numero, bairro = :bairro, complemento = :complemento, cidade = :cidade, estado = :estado, cep = :cep, pais = :pais, email = :email, senha = :senha WHERE id = :id")
		->execute($dadosCliente);
	}

	public function logarCliente($email) {
		$sth = $this->db->prepare("SELECT * FROM cliente WHERE email = :email");
		$sth->execute(array('email' => $email));
		return $sth->fetch(\PDO::FETCH_ASSOC);
	}

	public function getClienteById($id) {
		$query = "SELECT * FROM cliente WHERE id = :id";
		$sth = $this->db->prepare($query);
		$sth->execute(array('id' => $id));
		return $sth->fetch();
	}
	
	public function recuperaId() {
		return $this->db->lastInsertId();
	}

	public function errorInfo() {
		return $this->db->errorInfo();
	}
}