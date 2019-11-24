<?php
//Bootstrap termo utilizado para Scripts de inicialização

namespace RH\Init;


//Classe com métodos relativos ao Framework
abstract class Bootstrap
{
		//Inicia as rotas e faz com que as rotas requisitadas disparem o controlador e a action desejada.
	private $routes;

	abstract protected function initRoutes();


	public function __construct()
	{
			$this->initRoutes();   
			   // Executa o método Init Routes
			
			$this->run($this->getUrl());
		}


		public function getRoutes()
		{
			return $this->routes;
		}


		public function setRoutes(array $routes)
		{
			$this->routes = $routes;
		}



		protected function run($url)
		{
			foreach ($this->getRoutes() as $key => $route) {

				if($url == $route['route'])
				{

					$class ="App\\Controllers\\".ucfirst($route['controller']);

				//$class= 'App\Controllers\IndexController';

					

					$controller = new $class;
					
					
					$action = $route['action'];

					$controller->$action();
				}
				
			}


		}

		protected function getUrl()
		{
			return parse_url($_SERVER ['REQUEST_URI'], PHP_URL_PATH);  
										// Retorna a super global $_Server
										 // Que retorna a URI

										 // parse_url  recebe a URL Interpreta a respectiva URL e retorna seus respectivos componentes (Um array detalhando quais são os componentes da URL).
										 // PHP_URL_PATH, a string quando  submetida ao parse_Url, faz com que o retorno seja apenas a String relacionada ao path.

		//return parse_url("www.google.com/gmail?x10");
		}



	}


?>