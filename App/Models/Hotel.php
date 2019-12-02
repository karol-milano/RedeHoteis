<?php

namespace App\Models;

use RH\Model\Model;

class Hotel extends Model {

	public function getHotelById($id) {
		$query = "SELECT * FROM hotel WHERE id = :id";
		$sth = $this->db->prepare($query);
		$sth->execute(array('id' => $id));
		return $sth->fetch();
	}

	public function getHoteis($cidade = '') {
		$query = "SELECT * FROM hotel";

		if ($cidade != '') {
			$query .= " WHERE cidade LIKE '%$cidade%'";

			$sth = $this->db->prepare($query);
			$sth->execute();

			return $sth->fetchAll();
		}
		else {
			return $this->db->query("SELECT * FROM hotel")->fetchAll();
		}
	}

	public function gravarHotel($nomeHotel, $cnpj, $telefone, $pais, $estado, $cidade, $bairro, $rua, $numero, $cep, $email, $senha, $descricao, $imagem1, $imagem2, $imagem3) {

		$dadosHotel = array(
			'nomeHotel'	=> $nomeHotel,
			'telefone'	=> $telefone,
			'cnpj'		=> $cnpj,
			'pais'		=> $pais,
			'cidade'	=> $cidade,
			'estado'	=> $estado,
			'bairro'	=> $bairro,
			'rua'		=> $rua,
			'numero'	=> $numero,
			'cep'		=> $cep,
			'email'		=> $email,
			'imagem1'	=> $imagem1,
			'imagem2'	=> $imagem2,
			'imagem3'	=> $imagem3,
			'descricao'	=> $descricao,
			'senha'		=> $senha
		);

		$this->db->prepare("INSERT INTO hotel(nomeHotel, telefone, cnpj, pais,cidade, estado, bairro, rua,numero, cep, email, imagem1, imagem2, imagem3, descricao, senha) VALUES (:nomeHotel, :telefone, :cnpj, :pais,:cidade, :estado, :bairro, :rua,:numero,:cep,:email,:imagem1,:imagem2,:imagem3,:descricao,:senha)")
		->execute($dadosHotel);
	}

	public function atualizarHotel($id, $nomeHotel, $cnpj, $telefone, $pais, $estado, $cidade, $bairro, $rua, $numero, $cep, $email, $senha, $descricao, $imagem1, $imagem2, $imagem3) {

		$dadosHotel = array(
			'id'		=> $id,
			'nomeHotel'	=> $nomeHotel,
			'telefone'	=> $telefone,
			'cnpj'		=> $cnpj,
			'pais'		=> $pais,
			'cidade'	=> $cidade,
			'estado'	=> $estado,
			'bairro'	=> $bairro,
			'rua'		=> $rua,
			'numero'	=> $numero,
			'cep'		=> $cep,
			'email'		=> $email,
			'descricao'	=> $descricao,
			'senha'		=> $senha
		);

		$str = "UPDATE hotel SET nomeHotel = :nomeHotel, telefone = :telefone, cnpj = :cnpj, pais = :pais,cidade = :cidade, estado = :estado, bairro = :bairro, rua = :rua,numero = :numero, cep = :cep, email = :email, descricao = :descricao, senha = :senha";

		if ($imagem1 != null) {
			$dadosHotel['imagem1'] = $imagem1;
			$str .=  ", imagem1 = :imagem1";
		}

		if ($imagem2 != null) {
			$dadosHotel['imagem2'] = $imagem2;
			$str .=  ", imagem2 = :imagem2";
		}

		if ($imagem3 != null) {
			$dadosHotel['imagem3'] = $imagem3;
			$str .=  ", imagem3 = :imagem3";
		}

		$str .=  " WHERE id = :id";

		$this->db->prepare($str)
		->execute($dadosHotel);
	}

	public function logarHotel($email) {
		$sth = $this->db->prepare("SELECT * FROM hotel WHERE email = :email");
		$sth->execute(array('email' => $email));
		return $sth->fetch(\PDO::FETCH_ASSOC);
	}

	public function recuperaId() {
		return $this->db->lastInsertId();
	}

	public function errorInfo() {
		return $this->db->errorInfo();
	}
}