<?php
declare(strict_types=1);

class ErrorExcept{
    public static function getError(Error $error):string{
        return "Alerta : {$error->getMessage()}<br /> no arquivo {$error->getFile()}<br /> na linha {$error->getLine()}";
    }
}