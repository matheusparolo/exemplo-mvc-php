<?php

// Inclui o Controller
include_once "src/Controllers/autenticarController.php";

// Define o controller e o metodo (action) padrão, isso caso um ou ambos não sejam definidos
$controller = 'homecontroller';
$action = 'index';

// Verifica se algum controller foi requisitado
if ($_SERVER['REQUEST_URI'] != '/') {

    // Subdivide a rota requisitada
    $route = explode('/', substr($_SERVER['REQUEST_URI'], 1));

    // recolhe o nome do controller requisitado, geralmente o nome da classe do controller segue como nomeController
    $controller =  $route[0] . 'Controller';

    // Verifica se existe metodo sendo indicado
    if(count($route) > 1){

        // Verifica se algum argumento foi indicado
        $params = strpos($route[1], "?");

        if ($params === false) {
            // Se não foi indicado só indica qual é a action diretamente na rota 1
            $action = $route[1];
        }
        else{
            // se foi indicado extrai a action da rota separando ela dos argumentos
            $action = substr($route[1], 0, $params);
        }
        // O trecho acima pode também ser escrito utilizando o operador ternario dessa maneira:
        // $action = $args === false ? $route[1] : substr($route[1], 0, $args);

    }

}
// Verifica qual o tipo de método de requisição utilizado
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // Caso seja "GET", os parametros foram enviados por GET
    $params = $_GET;
}
else if($_SERVER['REQUEST_METHOD'] == "POST"){
    // Caso seja "POST", os parametros foram enviados por POST
    $params = $_POST;
}

// Instancia o controller
$controller = new $controller;

// Envia os parametros para o método do controller
$controller->$action($params);