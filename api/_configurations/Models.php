<?php

class Models
{
    public function _set($propiedad, $valor)
    {
        $this->$propiedad = $valor;
    }

    public function _get($propiedad)
    {
        return $this->$propiedad;
    }
}
