<?php

class autenticarController
{

    public function getEntrar($params)
    {

        // Requere a inserção do arquivo de visualização
        require_once "src/Views/Autenticar/entrar.php";

    }

    public function postEntrar($params)
    {

        // Requere o arquivo que contem a Bean do Usuário
        require_once "src/Models/Usuario.php";

        //Faz uma instancia da classe Usuario
        $usuario = new Usuario();

        // Requisita o metodo entrar e, se o usuario conseguir entrar, recebera o valor "true"
        $entrou = $usuario->entrar($params);

        if($entrou)
        {

            // Se o usuário entrar, vai para a pagina inicial
            require_once "src/Views/home/home.php";

        }else{

            // Se não, volta para a pagina de entrada
            require_once "src/Views/Autenticar/entrar.php";

        }

    }

}