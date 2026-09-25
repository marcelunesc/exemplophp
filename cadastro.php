<?php

include '../../banco.php';

$mensagem = '';
$tipoMensagem = '';

try {
    // Conexão com PostgreSQL
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    // Processa o formulário
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nome = trim($_POST['nome'] ?? '');
        $cpf  = trim($_POST['cpf'] ?? '');
        $rg   = trim($_POST['rg'] ?? '');

        // Validação
        if ($nome === '' || $cpf === '' || $rg === '') {

            $mensagem = 'Preencha todos os campos.';
            $tipoMensagem = 'erro';

        } else {

            // Remove pontos e hífen do CPF
            $cpfBanco = preg_replace('/\D/', '', $cpf);

            // Verifica se o CPF possui 11 dígitos
            if (strlen($cpfBanco) !== 11) {

                $mensagem = 'O CPF deve possuir 11 dígitos.';
                $tipoMensagem = 'erro';

            } else {

                // Verifica se o CPF já existe
                $stmt = $pdo->prepare(
                    'SELECT id FROM clientes WHERE cpf = :cpf'
                );

                $stmt->execute([
                    ':cpf' => $cpfBanco
                ]);

                if ($stmt->fetch()) {

                    $mensagem = 'Este CPF já está cadastrado.';
                    $tipoMensagem = 'erro';

                } else {

                    // Insere o cliente
                    $stmt = $pdo->prepare(
                        'INSERT INTO clientes (nome, cpf, rg)
                         VALUES (:nome, :cpf, :rg)'
                    );

                    $stmt->execute([
                        ':nome' => $nome,
                        ':cpf'  => $cpfBanco,
                        ':rg'   => $rg
                    ]);

                    $mensagem = 'Cliente cadastrado com sucesso!';
                    $tipoMensagem = 'sucesso';

                    // Limpa os campos após o cadastro
                    $nome = '';
                    $cpf = '';
                    $rg = '';
                }
            }
        }
    }

} catch (PDOException $e) {

    $mensagem = 'Erro ao acessar o banco de dados.';
    $tipoMensagem = 'erro';
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Cadastro de Cliente</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;

            display: flex;
            justify-content: center;
            align-items: center;

            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 500px;

            background: white;

            padding: 30px;

            border-radius: 10px;

            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 25px;

            text-align: center;

            color: #333;
        }

        .campo {
            margin-bottom: 18px;
        }

        label {
            display: block;

            margin-bottom: 7px;

            font-weight: bold;

            color: #444;
        }

        input {
            width: 100%;

            padding: 12px;

            border: 1px solid #ccc;

            border-radius: 5px;

            font-size: 16px;
        }

        input:focus {
            outline: none;

            border-color: #007bff;

            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.1);
        }

        button {
            width: 100%;

            padding: 13px;

            border: none;

            border-radius: 5px;

            background: #007bff;

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .mensagem {
            padding: 12px;

            margin-bottom: 20px;

            border-radius: 5px;

            text-align: center;
        }

        .sucesso {
            background: #d4edda;
            color: #155724;
        }

        .erro {
            background: #f8d7da;
            color: #721c24;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>Cadastro de Cliente</h1>

    <?php if ($mensagem !== ''): ?>

        <div class="mensagem <?= htmlspecialchars($tipoMensagem) ?>">
            <?= htmlspecialchars($mensagem) ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <div class="campo">

            <label for="nome">
                Nome
            </label>

            <input
                type="text"
                id="nome"
                name="nome"
                maxlength="150"
                value="<?= htmlspecialchars($nome ?? '') ?>"
                required
            >

        </div>

        <div class="campo">

            <label for="cpf">
                CPF
            </label>

            <input
                type="text"
                id="cpf"
                name="cpf"
                maxlength="14"
                placeholder="000.000.000-00"
                value="<?= htmlspecialchars($cpf ?? '') ?>"
                required
            >

        </div>

        <div class="campo">

            <label for="rg">
                RG
            </label>

            <input
                type="text"
                id="rg"
                name="rg"
                maxlength="20"
                value="<?= htmlspecialchars($rg ?? '') ?>"
                required
            >

        </div>

        <button type="submit">
            Cadastrar Cliente
        </button>

    </form>

</div>

</body>

</html>
