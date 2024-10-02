<?php

namespace app\database;
//faz uso da biblioteca PDO
use PDO;
//cria a classe Connection
class Connection
{ //mantém a conexão com o banco de dados aberta ao final do script
    private static $pdo = null;
    //cria a =
    public static function open(): PDO
    {
        try {
            #verifica se existe a conexão e retorna se sim
            if (static::$pdo) {
                return static::$pdo;
            }
            #define opções de conexão
            $options = [
                #configura modo de tratamento de erros
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                #define o modo padrão de busca de dados. No caso abaixo foi utilizado o array associativo (fetch_assoc)
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                #desativa emulação de prepared statements
                PDO::ATTR_EMULATE_PREPARES => false,
                #ativa conexão persistente (otimização de memória)
                PDO::ATTR_PERSISTENT => true,
                #força o uso de strings na requisição de busca  
                PDO::ATTR_STRINGIFY_FETCHES => true,
            ];
            //atribui o valor da classe PDO para a variável PDO. Por conveção é esperado nos campos a seguir o local do host e porta onde será feita a conexão,
            //o nome do banco de dados, login e usuário do banco de dados. No caso abaixo também, foi carregada a variárel $options para determinar as opções de conexão 
            static::$pdo = new PDO('pgsql:host=localhost;port=5432;dbname=cursosenac', 'guilhermebsilva', 'guilherme10', $options);
            //executa um comando externo, SET NAMES é uma declaração SQL que autoriza o uso de acentos e caracteres especiais 
            static::$pdo->exec("SET NAMES 'utf8'");
            return static::$pdo;
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
            //lança exceção ou mensagem de erro
            throw new \PDOException("ERRO ERRO ERRO ERRO ERRO ERRO ERRO" . $e->getMessage());
        }
    }
}
