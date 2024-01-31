
<?php

class controlador
{
    public function modelo($modelo)
    {
        require_once '../app/modelos/' . $modelo . '.php';
        return new $modelo();
    }

    public function view($view, $dados = [])
    {
        require_once '../imagens/' . $view . '.php';
    }
}