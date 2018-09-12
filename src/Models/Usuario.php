<?php

// Requere o usuario DAO que será utilizado para se comunicar com o banco de dados
require_once "src/DAO/UsuarioDAO.php";

class Usuario
{

    private $usuarioDAO;

    // Função construtora da classe, é chamada toda vez que a classe é instanciada
    public function __construct()
    {

        // Instancia o "usuarioDAO" sempre que a classe "Usuario" for instanciada
        $this->usuarioDAO = new UsuarioDAO();

    }

    // Função que tenta realizar o login e retorna verdadeiro ou falso
    public function entrar($params)
    {

        // Busca as informações do usuario se baseando no email
        $usuarioInformacoes = $this->encontrar_por_email($params["email"]);

        // Verifica se alguma informação foi encontrada referente aquele email (o valor é falso quando nada é encontrado)
        if($usuarioInformacoes != false)
        {
            // Caso o email conste no banco de dados

            // Verifica se a senha do usuario vinda do DB é igual a informada pelo usuario
            // Não esqueça que o $usuarioInformacoes é uma instancia da Entity UsuarioEntity
            if($usuarioInformacoes->getSenha() == $params["senha"])
            {

                // Inicia a sessão
                session_start();

                // Adiciona a array de sessão desse usuario suas informações
                $_SESSION["id"] = $usuarioInformacoes->getId();
                $_SESSION["nome"] = $usuarioInformacoes->getNome();
                $_SESSION["email"] = $usuarioInformacoes->getEmail();
                // A senha não será armazenada na array de sessão

                // Retorna verdadeiro para finalizar o login
                return true;

            }
            else{
                // Caso não seja o login é rejeitado e será retornado falso.
                return false;
            }

        }else{
            // Se nada foi encontrado então o email não consta no banco de dados
            return false;

        }

    }

    // Função que encontra as informações de um usuário se baseando em seu email
    public function encontrar_por_email($email)
    {

        // Requisita a DAO pelas informações
        return $this->usuarioDAO->encontrar_por_email($email);

    }

}