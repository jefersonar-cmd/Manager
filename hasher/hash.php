<?php
function geraHashUnic(){
    $caracters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    $tamanho = 64;

    $hash = '';
    $tamanhoPerm = strlen($caracters);
    for($i = 0; $i < $tamanho; $i++) {
        $hash .= $caracters[random_int(0, $tamanhoPerm -1)];
    }

    return $hash;
}