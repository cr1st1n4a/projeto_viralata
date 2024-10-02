<?php

namespace app\controllers;

use app\database\builder\SelectQuery;


class ControllerLogin extends Base
{
    public function autenticacao($request, $response)
    {
        try {
            //captura dos dados de formulário
            $form = $request->getParsedBody();
            $usuario = filter_var($form['login']?? null, FILTER_UNSAFE_RAW);
            $password = filter_var($form['password']?? null, FILTER_UNSAFE_RAW);
                
            if (empty($usuario) || empty($$password)) {
                $data = [
                        
                    'status' => false,
                    'msg' => 'Usuário não encontrado ou senha inválida!'
                ];

            }
            




            $user = SelectQuery::select()
                ->from('usuario')
                ->where('login', '=', $usuario)
                ->fetch();
                //checagem do usuario   
                if ($user != true) {
                    $data = [
                        
                        'status' => false,
                        'msg' => 'Usuário não encontrado!'
                    ];
                    
                    
                    $json = json_encode($data, JSON_UNESCAPED_UNICODE);
                    $response->getBody()
                    ->write($json);
                    return $response->withStatus(403)
                    ->withHeader('Content-type', 'application/json');
                }
                //checagem de senha
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                if (!password_verify($password, $hashed_password)) {
                    
                    $data = [
                        'status' => false,
                        'msg' => 'Senha incorreta!'
                    ];
                    
                    $json = json_encode($data, JSON_UNESCAPED_UNICODE);
                    $response->getBody()
                    ->write($json);
                    return $response->withStatus(403)
                    ->withHeader('Content-type', 'application/json');
                    
            }
            //criação da sessão do usuário
            $_SESSION['usuario'] =

                [
                    'logado' => true,
                    'nome' => $usuario
                ];
            $data = [
                'status' => true,
                'msg' => 'Usuário logado!'
            ];

            $json = json_encode($data, JSON_UNESCAPED_UNICODE);
            $response->getBody()
                ->write($json);
            return $response->withStatus(200)
                ->withHeader('Content-type', 'application/json');
        } catch (\Exception $e) {

            var_dump($e->getMessage());
            throw new \PDOException("grosopis: " . $e->getMessage());
        }
    }
    //renderização da tela de login
    public function login($request, $response)
    {
        $TempleteData = [
            'titulo' => 'Página de Login'
        ];
        return $this->getTwig()
            ->render($response, $this->setView('autenticacao'), $TempleteData)
            ->withHeader('Content-Type', 'text/html')
            ->withStatus(200);
    }
}
