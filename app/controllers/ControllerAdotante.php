<?php

namespace app\controllers;

use app\database\builder\SelectQuery;
use app\database\builder\InsertQuery;


class ControllerAdotante extends Base



{   #FUNÇÃO DE LISTAGEM DE ADOTANTES:
    public function lista($request, $response)
    {
        try {
            $adotantes = (array) SelectQuery::select()
                ->from('adotante')
                ->fetchAll();
            $TemplateData = [
                'titulo' => 'Módulo: Adotantes',
                'adotante' => $adotantes
            ];
            #renderiza a página de adotantes
            return $this->getTwig()
                ->render($response, $this->setView('adotantes'), $TemplateData)
                ->withHeader('Content-Type', 'text/html')
                ->withStatus(200);
        } catch (\Exception $e) {
            throw new \Exception("Restrição: " . $e->getMessage(), 1);
        }
    }
        


    #FUNÇÃO DE CADASTRO DE ADOTANTES

    public function insert($request, $response)
    {
        try {
            #Recupera os dados do nome e converte para uma string.
            $form = $request->getParsedBody();
            $nome = filter_var($form['nome'], FILTER_UNSAFE_RAW);
            $telefone = filter_var($form['telefone'], FILTER_UNSAFE_RAW);
            $email = filter_var($form['email'], FILTER_UNSAFE_RAW);
            $endereco = filter_var($form['endereco'], FILTER_UNSAFE_RAW);
            $cpf = filter_var($form['cpf'], FILTER_UNSAFE_RAW);
            $rg = filter_var($form['rg'], FILTER_UNSAFE_RAW);



            $IsSave = InsertQuery::table('adotante')
                ->save([

                    'nome'      => $nome,
                    'telefone'  => $telefone,
                    'email'     => $email,
                    'endereco'  => $endereco,
                    'cpf'       => $cpf,
                    'rg'        => $rg
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
