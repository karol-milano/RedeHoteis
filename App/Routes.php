<?php

namespace App;

use RH\Init\Bootstrap;

class Routes extends Bootstrap{

    public function initRoutes()
    {
    	$routes['home'] = array(
    		'route' => '/',
    		'controller' => 'IndexController',
    		'action' => 'index'
    	);  

    	// $routes[home] Define qual o controlador que entrará em ação, também define qual será a ação dentro do controlador que será disparada em função do path.
    	$routes['sobre_nos'] = array(
    		'route' =>'/sobreNos',
    		'controller' =>'IndexController',
    		'action' =>'sobreNos'
    	);

        $routes['cadastrarCliente'] = array(
            'route' =>'/cadastrarCliente',
            'controller' =>'ClienteController',
            'action' =>'cadastrarCliente'
        );

        $routes['loginCliente'] = array(
            'route' =>'/loginCliente',
            'controller' =>'ClienteController',
            'action' =>'loginCliente'
        );

        $routes['logoutCliente'] = array(
            'route' =>'/logoutCliente',
            'controller' =>'ClienteController',
            'action' =>'logoutCliente'
        );

        $routes['cadastrarHotel'] = array(
            'route' =>'/cadastrarHotel',
            'controller' =>'HotelController',
            'action' =>'cadastrarHotel'
        );

        $routes['buscarHoteis'] = array(
            'route' =>'/buscarHoteis',
            'controller' =>'HotelController',
            'action' =>'buscarHoteis'
        );

        $routes['detalharHotel'] = array(
            'route' =>'/detalharHotel',
            'controller' =>'HotelController',
            'action' =>'detalharHotel'
        );
        $routes['editarHotel'] = array(
            'route' =>'/editarHotel',
            'controller' =>'HotelController',
            'action' =>'editarHotel'
        );

        $routes['reservarHotel'] = array(
            'route' =>'/reservarHotel',
            'controller' =>'HotelController',
            'action' =>'reservarHotel'
        );

        $routes['loginHotel'] = array(
            'route' =>'/loginHotel',
            'controller' =>'HotelController',
            'action' =>'loginHotel'
        );

        $routes['logoutHotel'] = array(
            'route' =>'/logoutHotel',
            'controller' =>'HotelController',
            'action' =>'logoutHotel'
        );
        
        $routes['contato'] = array(
            'route' =>'/contato',
            'controller' =>'IndexController',
            'action' =>'contato'
        );

    	$this->setRoutes($routes); // passa o array de rotas para o set Routes
    }   
}