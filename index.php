<?php
    echo "Servidor de Testes";


/*
// tempo de execução do teste, em segundos
$tempo = 60;

$inicio = microtime(true);
$contador = 0;

while ((microtime(true) - $inicio) < $tempo) {

    // Cálculos matemáticos relativamente pesados
    for ($i = 1; $i <= 100000; $i++) {
        $x = $i;

        $x = sqrt($x);
        $x = pow($x, 3.1415926535);
        $x = sin($x);
        $x = cos($x);
        $x = tan($x);
        $x = log(abs($x) + 1);
        $x = exp($x / 100);
    }

    $contador++;
}

$duracao = microtime(true) - $inicio;

echo "<h1>Teste de carga concluído</h1>";
echo "<p>Tempo: " . round($duracao, 2) . " segundos</p>";
        */
echo "<p>Iterações: " . number_format($contador) . "</p>";
