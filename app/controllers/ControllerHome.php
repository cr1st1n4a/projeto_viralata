<?php

namespace app\controllers;

class ControllerHome extends Base
{
    public function home($request, $response)
    {
        $TempleteData = [
            'titulo' => 'VOCÊ TÁ NO COMEÇO'
        ];
        return $this->getTwig()
            ->render($response, $this->setView('pagina-inicial'), $TempleteData)
            ->withHeader('Content-Type', 'text/html')
            ->withStatus(200);
    }
}
