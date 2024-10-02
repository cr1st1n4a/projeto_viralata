<?php

namespace app\controllers;

use app\database\builder\SelectQuery;
use app\database\builder\InsertQuery;


class ControllerResgate extends Base



{   #FUNÇÃO DE LISTAGEM DE PEDIDOS DE RESGATE:
    public function lista($request, $response)
    {
        try {
            $resgates = (array) SelectQuery::select()
                ->from('resgates')
                ->fetchAll();
            $TemplateData = [
                'titulo' => 'Pedidos de Resgate',
                'resgates' => $resgates
            ];
            #renderiza a página de adotantes
            return $this->getTwig()
                ->render($response, $this->setView('resgates'), $TemplateData)
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
            $contato = filter_var($form['contato'], FILTER_UNSAFE_RAW);
            $endereco = filter_var($form['endereco'], FILTER_UNSAFE_RAW);
            $bairro = filter_var($form['bairro'], FILTER_UNSAFE_RAW);
            $especie = filter_var($form['especie'], FILTER_UNSAFE_RAW);
            $sexo = filter_var($form['sexo'], FILTER_UNSAFE_RAW);
            $urgencia = filter_var($form['urgencia'], FILTER_UNSAFE_RAW);
            $observacoes = filter_var($form['observacoes'], FILTER_UNSAFE_RAW);


            
                    

            $IsSave = InsertQuery::table('resgates')
                ->save([

                    'nome'      => $nome,
                    'contato'   => $contato,
                    'endereco'       => $endereco,
                    'bairro'    => $bairro,
                    'especie'   => $especie,
                    'sexo'      => $sexo,
                    'urgencia'  => $urgencia,
                    'observacoes'=> $observacoes
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
