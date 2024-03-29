<?php

namespace RH\Controller;

Abstract class Action
{
    protected $view;

    public function __consctruct() {
        $this->view = new stdClass();
        // Objetos vazios que poderam dinamicamente ser compostos de atributos durante a lógica de processamento da aplicação.
    }

    //Traz o bloco de código para dentro do contexto.
    protected function render($view, $layout) {
        $this->view->page = $view;

		if(file_exists("../App/Views/".$layout.".phtml")) {
			require_once "../App/Views/".$layout.".phtml";
		} else {
			$this->content();
		}
	}

    protected function content() {
		$classAtual = get_class($this);

		$classAtual = str_replace('App\\Controllers\\', '', $classAtual);

		$classAtual = strtolower(str_replace('Controller', '', $classAtual));
             
		require_once "../App/Views/".$classAtual."/".$this->view->page.".phtml";
	}
}
