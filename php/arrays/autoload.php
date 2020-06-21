<?php
spl_autoload_register(
    function(string $namespaceClasse):void {
        $caminho = '\\src';

        $diretorioClasse = str_replace('\\', DIRECTORY_SEPARATOR, $namespaceClasse);
        @require_once getcwd() . $caminho . DIRECTORY_SEPARATOR . $diretorioClasse . ".php";
    }
);