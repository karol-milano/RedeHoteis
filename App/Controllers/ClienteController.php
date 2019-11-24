<?php

namespace App\Controllers;

use RH\Controller\Action;
use RH\Model\Container;

use App\Models\Cliente;

class ClienteController extends Action {

	public function cadastrarCliente() {

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$response = array(
				'status' => '',
				'mensagem' => ''
			);


			$nome 			= $_POST['nome'];
			$cpf 			= $_POST['cpf'];
			$celular 		= $_POST['celular'];
			$telefone 		= $_POST['telefone'];
			$dt_nascimento 	= $_POST['dt_nascimento'];
			$tp_logradouro 	= $_POST['tp_logradouro'];
			$logradouro 	= $_POST['logradouro'];
			$numero 		= $_POST['numero'];
			$bairro 		= $_POST['bairro'];
			$complemento 	= $_POST['complemento'];
			$cidade 		= $_POST['cidade'];
			$estado 		= $_POST['estado'];
			$cep 			= $_POST['cep'];
			$pais 			= $_POST['pais'];
			$email 			= $_POST['email'];
			$senha 			= $_POST['senha'];

			try {
				$cliente = Container::getModel('Cliente');
				$cliente->criarCliente($nome, $cpf, $celular, $telefone, $dt_nascimento, $tp_logradouro, $logradouro, $numero, $bairro, $complemento, $cidade, $estado, $cep, $pais, $email, $senha);

				if (($ultimoId = $cliente->recuperaId()) != 0) {
	            	$response['status'] = 'ok';
					$response['mensagem'] = '';
	            }
			} catch (\PDOException $e) {
				error_log($e->getCode(), $e->getMessage());

				$response['status'] = 'error';
				if (((int)$e->getCode()) == 23000) {					
					$response['mensagem'] = "E-mail já cadastrado.";
				}
				else {
					$response['mensagem'] = $e->getMessage();
				}
			}

			echo json_encode($response);
		}
		else {
			$this->render('cadastrarCliente', 'layout1');
		}
	}

	public function loginCliente() {

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$logado = false;
			$response = array(
				'status' => '',
				'mensagem' => ''
			);

			if (isset($_POST['email']) && isset($_POST['senha'])) {
				$clienteModel = Container::getModel('Cliente');
				try {
					$cliente = $clienteModel->logarCliente($_POST['email']);

					if ($cliente) {

						if ($cliente['senha'] === $_POST['senha']) {
							session_start();
							$_SESSION['clienteId'] = $cliente['id'];
							$_SESSION['clienteNome'] = $cliente['nome'];
							$_SESSION['clienteEmail'] = $cliente['email'];
							$_SESSION['clienteCelular'] = $cliente['celular'];

							$selector = base64_encode(random_bytes(8));
					        $token = bin2hex(random_bytes(32));

					        $cookieValue = $selector.':'.base64_encode($token);
					        $hashedToken = hash('sha256', $token);

					        $timestamp = time() + (86400 * 14);

					        setcookie('authToken', $cookieValue, $timestamp, NULL, NULL, NULL, true);

							$logado = true;
					        $response['status'] = 'ok';
						}
					}
				} catch (\PDOException $e) {
					error_log($e->getCode(), $e->getMessage());
				}
			}

			if ($logado == false) {
				$response['status'] = 'error';
				$response['mensagem'] = "Usuário/senha incorretos.";
			}

			echo json_encode($response);
		}
		else {
			$this->render('loginCliente', 'layout1');
		}
	}

	public function logoutCliente() {

		session_start();

		unset($_SESSION['clienteId']);
		unset($_SESSION['clienteNome']);
		unset($_SESSION['clienteEmail']);
		unset($_SESSION['clienteCelular']);
        setcookie('authToken', '', 1);
        unset($_COOKIE['authToken']);
		

        session_destroy(); 

		header('Location: /');
	}
}
