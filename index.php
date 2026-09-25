<?php

// Configurações do banco
$host = 'database-1.clw6mw6uwbt5.us-east-2.rds.amazonaws.com';
$port = '5432';
$dbname = 'meubanco';
$user = 'postgres';
$password = 'BER6j4L3N8xpxgFxqKX63SX9ENtTjPsSQR';

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

    // Consulta
    $sql = "SELECT id, nome, cpf, rg FROM clientes ORDER BY id";
    $stmt = $pdo->query($sql);

    // Obtém os registros
    $clientes = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Erro ao conectar ou consultar o banco: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }
    </style>
</head>

<body>

<h1>Clientes</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>RG</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($clientes as $cliente): ?>

            <tr>
                <td><?= htmlspecialchars($cliente['id']) ?></td>
                <td><?= htmlspecialchars($cliente['nome']) ?></td>
                <td><?= htmlspecialchars($cliente['cpf']) ?></td>
                <td><?= htmlspecialchars($cliente['rg']) ?></td>
            </tr>

        <?php endforeach; ?>

    </tbody>
</table>

</body>
</html>
