<?php
session_start();
require_once 'db-config.php';

$erro_mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    $sql = "SELECT id, nome, senha FROM administrador WHERE email = ?";
    $stmt = db2_prepare($conn, $sql);

    if ($stmt) {
        db2_execute($stmt, array($email));
        
        if ($row = db2_fetch_assoc($stmt)) {
            if ($senha === $row['SENHA']) {
                $_SESSION['usuario_id']   = $row['ID'];
                $_SESSION['usuario_nome'] = $row['NOME'];
                $_SESSION['usuario_tipo'] = 'admin';
                
                header("Location: dashboard.php");
                exit;
            } else {
                $erro_mensagem = "Senha institucional incorreta.";
            }
        } else {
            $erro_mensagem = "E-mail administrativo não cadastrado.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>VOLUNTARIE - Acesso Administrativo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="logo">VOLUNTARIE</div>
        <div class="sublogo">Portal de acesso Administrativo</div>
        
        <?php if (!empty($erro_mensagem)): ?>
            <div style="color: #e74c3c; margin-bottom: 15px; font-size: 14px; font-weight: bold;">
                <?php echo $erro_mensagem; ?>
            </div>
        <?php endif; ?>

        <form action="login-admin.php" method="POST">
            <input type="email" name="email" placeholder="Email institucional" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit" class="btn btn-admin">ENTRAR</button>
        </form>
        <br>
        <a href="index.php" style="color:#95a5a6; text-decoration: none; font-weight: bold;">← VOLTAR</a>
    </div>
</body>
</html>