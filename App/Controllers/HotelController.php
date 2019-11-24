<?php

namespace App\Controllers;

use RH\Controller\Action;
use RH\Model\Container;

use App\Models\Hotel;

class HotelController extends Action {

    public function buscarHoteis() {

        $cidade = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['cidade'])) {
                $cidade = $_POST['cidade'];
            }
        }

        $hotel = Container::getModel('Hotel');
        $hoteis = $hotel->getHoteis($cidade);
        $this->view->dados = $hoteis;
        $this->render('mostraHoteis', 'layout1');
    }

    public function cadastrarHotel() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $response = array(
                'status' => '',
                'mensagem' => ''
            );

            $nomeHotel  = $_POST['nomeHotel'];
            $cnpj       = $_POST['cnpj'];
            $telefone   = $_POST['telefone'];
            $pais       = $_POST['pais'];
            $estado     = $_POST['estado'];
            $cidade     = $_POST['cidade'];
            $bairro     = $_POST['bairro'];
            $rua        = $_POST['rua'];
            $numero     = $_POST['numero'];
            $cep        = $_POST['cep'];
            $email      = $_POST['email'];
            $senha      = $_POST['senha'];
            $descricao  = $_POST['descricao'];
            $imagem1    = '';
            $imagem2    = '';
            $imagem3    = '';

            if (isset($_FILES['imagem1'])) {
                $fileExtension = strtolower(end(explode(".", $_FILES['imagem1']['name'])));
                $imagem1 = md5(time() . $_FILES['imagem1']['name']) . '.' . $fileExtension;
            }

            if (isset($_FILES['imagem2'])) {
                $fileExtension = strtolower(end(explode(".", $_FILES['imagem2']['name'])));
                $imagem2 = md5(time() . $_FILES['imagem2']['name']) . '.' . $fileExtension;
            }

            if (isset($_FILES['imagem3'])) {
                $fileExtension = strtolower(end(explode(".", $_FILES['imagem3']['name'])));
                $imagem3 = md5(time() . $_FILES['imagem3']['name']) . '.' . $fileExtension;
            }

            $hotel = Container::getModel('Hotel');
            try {
                $hotel->gravarHotel($nomeHotel, $cnpj, $telefone, $pais, $estado, $cidade, $bairro, $rua, $numero, $cep, $email, $senha, $descricao, $imagem1, $imagem2, $imagem3);

                if (($ultimoId = $hotel->recuperaId()) != 0) {

                    $diretorio = '../public/storage/'.$ultimoId.'/';
                    mkdir($diretorio, 0755, true);

                    if (isset($_FILES['imagem1']['tmp_name'])) {
                        move_uploaded_file($_FILES['imagem1']['tmp_name'], $diretorio.$imagem1);
                    }

                    if (isset($_FILES['imagem2']['tmp_name'])) {
                        move_uploaded_file($_FILES['imagem2']['tmp_name'], $diretorio.$imagem2);
                    }

                    if (isset($_FILES['imagem3']['tmp_name'])) {
                        move_uploaded_file($_FILES['imagem3']['tmp_name'], $diretorio.$imagem3);
                    }

                    $response['status'] = 'ok';
                    $response['mensagem'] = '';
                }
                else {
                    $response['status'] = 'error';
                    $response['mensagem'] = $hotel->errorInfo();
                }

            } catch (\PDOException $e) {
                $response['status'] = 'error';
                $response['mensagem'] = $e->getTrace();
            }

            echo json_encode($response);
        }
        else {
            $this->render('cadastrarHotel', 'layout1');
        }
    }

    public function editarHotel() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $response = array(
                'status' => '',
                'mensagem' => ''
            );

            $id         = $_POST['id'];
            $nomeHotel  = $_POST['nomeHotel'];
            $cnpj       = $_POST['cnpj'];
            $telefone   = $_POST['telefone'];
            $pais       = $_POST['pais'];
            $estado     = $_POST['estado'];
            $cidade     = $_POST['cidade'];
            $bairro     = $_POST['bairro'];
            $rua        = $_POST['rua'];
            $numero     = $_POST['numero'];
            $cep        = $_POST['cep'];
            $email      = $_POST['email'];
            $senha      = $_POST['senha'];
            $descricao  = $_POST['descricao'];
            $imagem1    = '';
            $imagem2    = '';
            $imagem3    = '';

            if (isset($_FILES['imagem1'])) {
                $fileExtension = strtolower(end(explode(".", $_FILES['imagem1']['name'])));
                $imagem1 = md5(time() . $_FILES['imagem1']['name']) . '.' . $fileExtension;
            }

            if (isset($_FILES['imagem2'])) {
                $fileExtension = strtolower(end(explode(".", $_FILES['imagem2']['name'])));
                $imagem2 = md5(time() . $_FILES['imagem2']['name']) . '.' . $fileExtension;
            }

            if (isset($_FILES['imagem3'])) {
                $fileExtension = strtolower(end(explode(".", $_FILES['imagem3']['name'])));
                $imagem3 = md5(time() . $_FILES['imagem3']['name']) . '.' . $fileExtension;
            }

            $hotel = Container::getModel('Hotel');
            try {
                $hotel->atualizarHotel($id, $nomeHotel, $cnpj, $telefone, $pais, $estado, $cidade, $bairro, $rua, $numero, $cep, $email, $senha, $descricao, $imagem1, $imagem2, $imagem3);


                $diretorio = '../public/storage/'.$Id.'/';

                if (isset($_FILES['imagem1']['tmp_name'])) {
                    move_uploaded_file($_FILES['imagem1']['tmp_name'], $diretorio.$imagem1);
                }

                if (isset($_FILES['imagem2']['tmp_name'])) {
                    move_uploaded_file($_FILES['imagem2']['tmp_name'], $diretorio.$imagem2);
                }

                if (isset($_FILES['imagem3']['tmp_name'])) {
                    move_uploaded_file($_FILES['imagem3']['tmp_name'], $diretorio.$imagem3);
                }

                $response['status'] = 'ok';
                $response['mensagem'] = '';

            } catch (\PDOException $e) {
                $response['status'] = 'error';
                $response['mensagem'] = $e->getTrace();
            }

            echo json_encode($response);
        }
        else {
            $hotel = Container::getModel('Hotel')->getHotelById($_GET['hotelId']);
            $this->view->dados = $hotel;
            $this->render('editarHotel', 'layout1');
        }
    }

    public function detalharHotel() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            if (isset($_GET['id'])) {
                $hotel = Container::getModel('Hotel')->getHotelById($_GET['id']);
                $this->view->dados = $hotel;
            }
            $this->render('detalharHotel', 'layout1');
        }
    }

    public function reservarHotel() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['hotel'])) {
                $response = array(
                    'status' => '',
                    'mensagem' => ''
                );

                $hotel = $_POST['hotel'];

                $from = "redehoteis@redehoteis.com";
                $to = $hotel['email'];
                $subject = "Reserva de quarto";
                $mensagem = "<p>À<br />" . $hotel['nomeHotel'] . " , </p>
                            <p>Venho por meio desta solicitar a reserva de um quarto de casal";

                $epoca = "";
                if (isset($_POST['entrada'])) {
                    $epoca = "com entrada em " . $_POST['entrada'];

                    if (isset($_POST['saida'])) {
                        $epoca .= " e saída em " . $_POST['saida'];
                    }
                }

                $mensagem .= $epoca . ".</p>";

                $mensagem .= "<p>Solicito ser comunicado da confirmação desta reserva, assim como de quais são os dados necessários e quais os valores e formas de pagamento.</p>";

                $mensagem .= "<p>Atenciosamente,</p><br />";
                $mensagem .= "<p>" . $_SESSION['clienteNome'] . "</p>";
                $mensagem .= "<p>E-mail: " . $_SESSION['clienteEmail'] . "</p>";
                $mensagem .= "<p>Telefone: " . $_SESSION['clienteCelular'] . "</p>";

                $headers = "From:" . $from;

                $response['status'] = "error";
                if (mail($to, $subject, $mensagem, $headers)) {
                    $response['status'] = "ok";
                }
                else {
                    $response['mensagem'] = "Erro ao enviar e-mail.";
                }

                echo json_encode($response);
            }
        }
    }

    public function loginHotel() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $logado = false;
            $response = array(
                'status' => '',
                'mensagem' => ''
            );

            if (isset($_POST['email']) && isset($_POST['senha'])) {
                $hotelModel = Container::getModel('Hotel');
                try {
                    $hotel = $hotelModel->logarHotel($_POST['email']);

                    if ($hotel) {

                        if ($hotel['senha'] === $_POST['senha']) {
                            session_start();
                            $_SESSION['hotelId'] = $hotel['id'];
                            $_SESSION['hotelNome'] = $hotel['nomeHotel'];
                            $_SESSION['hotelEmail'] = $hotel['email'];

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
            $this->render('loginHotel', 'layout1');
        }
    }

    public function logoutHotel() {

        session_start();

        unset($_SESSION['hotelId']);
        unset($_SESSION['hotelNome']);
        unset($_SESSION['hotelEmail']);
        setcookie('authToken', '', 1);
        unset($_COOKIE['authToken']);
        

        session_destroy(); 

        header('Location: /');
    }
}