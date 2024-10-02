<?php

namespace app\controllers;

use app\database\builder\InsertQuery;

class ControllerUsuario extends Base
{
    public function insert($request, $response)
    {
        try {
            #Recupera os dados do nome e converte para uma string.
            $form = $request->getParsedBody();
            $nome = filter_var($form['nome'], FILTER_UNSAFE_RAW);
            $telefone = filter_var($form['telefone'], FILTER_UNSAFE_RAW);
            $email = filter_var($form['email'], FILTER_UNSAFE_RAW);
            $usuario = filter_var($form['usuario'], FILTER_UNSAFE_RAW);
            $senha = filter_var($form['senha'], FILTER_UNSAFE_RAW);

            
            $IsSave = InsertQuery::table('usuario')
                ->save([

                    'nome'      => $nome,
                    'telefone'  => $telefone,
                    'email'     => $email,
                    'usuario'   => $usuario,
                    'senha'     => $senha
                ]);

                    
            if ($IsSave != true) {
                $data = [
                    'status' => false,
                    'msg' => 'Restrição: ' . $IsSave,
                    'id' => 0
                ];
                $json = json_encode($data, JSON_UNESCAPED_UNICODE);
                $response->getBody()
                    ->write($json);
                return $response->withStatus(403)
                    ->withHeader('Content-type', 'application/json');
            }

            $data = [
                'status' => true,
                'msg' => 'Registro salvo com sucesso!',
                'id' => 0
            ];
            $json = json_encode($data, JSON_UNESCAPED_UNICODE);
            $response->getBody()
                ->write($json);
            return $response
                ->withStatus(201)
                ->withHeader('Content-type', 'application/json');
        } catch (\Exception $e) {

            var_dump($e->getMessage());
            throw new \PDOException("ERRO ERRO ERRO ERRO ERRO ERRO ERRO" . $e->getMessage());
        }
    }
}
