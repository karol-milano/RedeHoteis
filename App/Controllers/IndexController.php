<?php

namespace App\Controllers;

use RH\Controller\Action;

class IndexController extends Action {

	public function index() {
		$this->render('index', 'layout1');
	}
	
	public function sobreNos() {
		$this->render('sobreNos', 'layout1');
	}

	public function contato() {
		$this->render('contato', 'layout1');
	}
}
