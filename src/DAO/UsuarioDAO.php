<?php

require_once "src/DAO/BaseDAO.php";
require_once "src/DAO/Entities.php";

class UsuarioDAO
{

    private $conn;

    public function __construct()
    {

        // Inicia a conexão
        $this->conn = new BaseDAO();

    }

    public function encontrar_por_email($email)
    {

        // Requisita o DB a retornar os valores que possuem aquele email
        $usuarioInformacoes = $this->conn->select("select usuario where email = :email", ["email" => $email]);

        // Verifica se alguma informação foi encontrada
        if(!empty($usuarioInformacoes))
        {

            // Se foi, seleciona apenas a linha com as informações do usuario
            $usuarioInformacoes = $usuarioInformacoes[0];

            // Cria a entidade do usuario
            $entidade = new UsuarioEntity(
                $usuarioInformacoes["id"],
                $usuarioInformacoes["nome"],
                $usuarioInformacoes["email"],
                $usuarioInformacoes["senha"]
            );

            // Retorna a entidade
            return $entidade;

        }else{

            // Se não foi, retorna falso
            return false;

        }

    }

}