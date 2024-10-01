<?php

namespace app\controllers;

use app\database\builder\SelectQuery;
use app\database\builder\DeleteQuery;
use app\database\builder\InsertQuery;

class ControllerAnimal extends Base
{
    public function lista($request, $response)
    {
        try {
            $animais = (array) SelectQuery::select()
                ->from('animais')
                ->fetchAll();

            foreach ($animais as &$animal) {
                $animal['fotos'] = json_decode($animal['fotos'], true); // Decodifica as URLs
            }

            $TemplateData = [
                'titulo' => 'Lista de Animais',
                'animais' => $animais
            ];

            return $this->getTwig()
                ->render($response, $this->setView('listaAnimais'), $TemplateData)
                ->withHeader('Content-Type', 'text/html')
                ->withStatus(200);
        } catch (\Exception $e) {
            return $this->jsonResponse($response, false, 'Erro ao listar animais: ' . $e->getMessage(), 500);
        }
    }

    public function cadastro($request, $response)
    {
        $TemplateData = [
            'acao' => 'c',
            'titulo' => 'Cadastrar Animais'
        ];
        return $this->getTwig()
            ->render($response, $this->setView('cadastroAnimais'), $TemplateData)
            ->withHeader('Content-Type', 'text/html')
            ->withStatus(200);
    }

    public function alterar($request, $response, $args)
    {
        $id = filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $animal = (array) SelectQuery::select()
            ->from('animais')
            ->where('id', '=', $id)
            ->fetch();

        if (!$animal) {
            return $this->jsonResponse($response, false, 'Animal não encontrado.', 404);
        }

        $animal['fotos'] = json_decode($animal['fotos'], true); // Decodifica as URLs

        $TemplateData = [
            'id' => $id,
            'animal' => $animal,
            'acao' => 'e',
            'titulo' => 'Alterar Animal'
        ];
        return $this->getTwig()
            ->render($response, $this->setView('cadastroAnimais'), $TemplateData)
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

            $isDelete = DeleteQuery::table('animais')
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

    public function insert($request, $response)
    {
        try {
            $form = $request->getParsedBody();
            
            // Processar o upload das fotos
            $fotos = $_FILES['fotos'];
            $fotos_urls = [];

            foreach ($fotos['tmp_name'] as $key => $tmp_name) {
                $file_name = basename($fotos['name'][$key]);
                $target_file = 'caminho/do/diretorio/' . $file_name; // Defina o caminho correto
                move_uploaded_file($tmp_name, $target_file);
                $fotos_urls[] = $target_file; // Armazenar a URL
            }

            $data = [
                'nome' => filter_var($form['nome'], FILTER_SANITIZE_STRING),
                'especie' => filter_var($form['especie'], FILTER_SANITIZE_STRING),
                'raca' => filter_var($form['raca'], FILTER_SANITIZE_STRING),
                'idade' => filter_var($form['idade'], FILTER_SANITIZE_NUMBER_INT),
                'sexo' => filter_var($form['sexo'], FILTER_SANITIZE_STRING),
                'data_nascimento' => filter_var($form['data_nascimento'], FILTER_SANITIZE_STRING),
                'porte' => filter_var($form['porte'], FILTER_SANITIZE_STRING),
                'cor' => filter_var($form['cor'], FILTER_SANITIZE_STRING),
                'pelagem' => filter_var($form['pelagem'], FILTER_SANITIZE_STRING),
                'marcacoes' => filter_var($form['marcacoes'], FILTER_SANITIZE_STRING),
                'vacinas' => filter_var($form['vacinas'], FILTER_SANITIZE_STRING),
                'tratamentos' => filter_var($form['tratamentos'], FILTER_SANITIZE_STRING),
                'doencas' => filter_var($form['doencas'], FILTER_SANITIZE_STRING),
                'fotos' => json_encode($fotos_urls), // Armazenar como JSON
                'video' => filter_var($form['video'], FILTER_SANITIZE_STRING),
                'proprietario_nome' => filter_var($form['proprietario_nome'], FILTER_SANITIZE_STRING),
                'proprietario_contato' => filter_var($form['proprietario_contato'], FILTER_SANITIZE_STRING),
                'peso' => filter_var($form['peso'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'microchip' => filter_var($form['microchip'], FILTER_SANITIZE_STRING),
            ];

            $isSave = InsertQuery::table('animais')->save($data);

            if (!$isSave) {
                return $this->jsonResponse($response, false, 'Restrição ao salvar registro.', 403);
            }

            return $this->jsonResponse($response, true, 'Registro salvo com sucesso!', 201);
        } catch (\Exception $e) {
            return $this->jsonResponse($response, false, 'Erro: ' . $e->getMessage(), 500);
        }
    }

    public function jsonResponse($response, $success, $message, $statusCode)
    {
        // Configura o cabeçalho para JSON
        $response = $response->withHeader('Content-Type', 'application/json')
                             ->withStatus($statusCode);

        // Retorna a resposta JSON
        $data = [
            'status' => $success,
            'msg' => $message,
        ];

        // Codifica o array para JSON
        $response->getBody()->write(json_encode($data));

        return $response;
    }
}
