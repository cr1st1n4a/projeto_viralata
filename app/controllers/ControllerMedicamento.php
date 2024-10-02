<?php

namespace app\controllers;

use app\database\builder\SelectQuery;
use app\database\builder\InsertQuery;
use app\database\builder\DeleteQuery;
use app\database\builder\UpdateQuery;


class ControllerMedicamento extends Base



{   #FUNÇÃO DE LISTAGEM DE MEDICAMENTOS:
    public function lista($request, $response)
    {
        try {
            $medicamentos = (array) SelectQuery::select()
                ->from('medicamentos')
                ->fetchAll();
            $TemplateData = [
                'titulo' => 'Lista de Medicamentos',
                'medicamentos' => $medicamentos
            ];
            #renderiza a página de medicamentos
            return $this->getTwig()
                ->render($response, $this->setView('medicamentos'), $TemplateData)
                ->withHeader('Content-Type', 'text/html')
                ->withStatus(200);
        } catch (\Exception $e) {
            throw new \Exception("Restrição: " . $e->getMessage(), 1);
        }
    }



    #FUNÇÃO DE CADASTRO DE medicamentos

    public function insert($request, $response)
    {
        try {
            #Recupera os dados do nome e converte para uma string.
            $form = $request->getParsedBody();
            $nome = filter_var($form['nome'], FILTER_UNSAFE_RAW);
            $quantidade = filter_var($form['quantidade'], FILTER_UNSAFE_RAW);
            $validade = filter_var($form['validade'], FILTER_UNSAFE_RAW);



            $IsSave = InsertQuery::table('medicamentos')
                ->save([

                    'nome'      => $nome,
                    'quantidade'  => $quantidade,
                    'validade'  => $validade
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

    public function alterar($request, $response, $args)
    {
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $medicamento = (array) SelectQuery::select()
            ->from('medicamentos')
            ->where('id', '=', $id)
            ->fetch();

        if (!$medicamento) {
            return $this->jsonResponse($response, false, 'Medicamento não encontrado.', 404);
        }

        $TemplateData = [
            'id' => $id,
            'medicamento' => $medicamento,
            'acao' => 'e',
            'titulo' => 'Alterar Medicamento'
        ];
        return $this->getTwig()
            ->render($response, $this->setView('listamedicamentos'), $TemplateData)
            ->withHeader('Content-Type', 'text/html')
            ->withStatus(200);
    }




    
    public function delete($request, $response, $args)
    {
        try {
            $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
            if (is_null($id)) {
                return $this->jsonResponse($response, false, 'Por favor informe o código do registro a ser excluído!', 403);
            }

            $isDelete = DeleteQuery::table('medicamentos')
                ->where('id', '=', $id)
                ->delete();

            if (!$isDelete) {
                return $this->jsonResponse($response, false, 'Restrição ao excluir registro.', 403);
            }

            return $this->jsonResponse($response, true, 'Registro excluído com sucesso!', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse($response, false, 'Erro: ' . $e->getMessage(), 500);
        }
    }









}
