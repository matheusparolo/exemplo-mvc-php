<?php

// DAO base para conexão com o banco de dados
class BaseDAO{

    private $conn;

    // Constantes com as configurações para a conexão
    private const SGBD = "mysql";
    private const HOST = "localhost";
    private const DBNAME = "db";
    private const DBUSER = "root";
    private const DBPASS = "root";

    public function __construct()
    {

        // Bloco de tentiva, caso não consiga conectar lança um erro e para a aplicação
        try {

            // Define as configurações de DSN
            $dsn = self::SGBD . ":host=" . self::HOST . ";dbname=" . self::DBNAME . ";charset=utf8";

            // Inicia a conexão
            $this->conn = new PDO($dsn, self::DBUSER, self::DBPASS, [
                // Define que todos os erros serão exceções
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                // Define que o modo de retorno padrão é o FETCH_ASSOC
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // Desabilita a emulação de preparação de requisições por segurança
                PDO::ATTR_EMULATE_PREPARES => false
            ]);

        }
        catch(PDOException $e){

            // Erro caso não consiga
            exit("Erro no banco de dados");

        }

    }

    public function query($query, $params = [])
    {
        // Onde é feita todas as querys onde o retorno não é importante

        // Bloco de tentiva, caso não consiga executar lança um erro e para a aplicação
        try {
            // Prepara a query
            $stmt = $this->conn->prepare($query);

            // Seta os valores
            $this->setValues($stmt, $params);

            // Executa
            $stmt->execute();
        }
        catch(PDOException $e){

            // Erro caso não consiga
            exit("Erro no banco de dados");

        }

    }


    public function select($query, $params = [])
    {
        // Onde é feita todas as querys onde o retorno é importante, geralmente só o select

        // Bloco de tentiva, caso não consiga executar lança um erro e para a aplicação
        try {

            // Prepara a query
            $stmt = $this->conn->prepare($query);

            // Seta os valores
            $this->setValues($stmt, $params);

            // Executa
            $stmt->execute();

            return $stmt->fetchAll();
        }
        catch(PDOException $e){

            // Erro caso não consiga
            exit("Erro no banco de dados");

        }

    }

    private function setValues($stmt, $params = [])
    {

        // Percorre os parametros
        foreach($params as $key => $value)
        {

            // Requisita o "Bind" nos valores da query
            $this->bindValue($stmt, $key, $value);

        }

    }

    private function bindValue($stmt, $key, $value)
    {

        // Realiza o "Bind" nos valores da query
        $stmt->bindValue($key, $value);

    }

}