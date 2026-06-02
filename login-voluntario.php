<?php
session_start();
require_once 'db-config.php';

$erro_mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // Query preparada para o DB2
    $sql = "SELECT id, nome, senha FROM voluntario WHERE email = ?";
    $stmt = db2_prepare($conn, $sql);

    if ($stmt) {
        // Executa passando o e-mail com segurança
        db2_execute($stmt, array($email));
        
        // Busca os resultados (DB2 costuma retornar chaves em MAIÚSCULO)
        if ($row = db2_fetch_assoc($stmt)) {
            
            // Validação da senha (pode ser substituído por password_verify se usar hash)
            if ($senha === $row['SENHA']) {
                $_SESSION['usuario_id']   = $row['ID'];
                $_SESSION['usuario_nome'] = $row['NOME'];
                $_SESSION['usuario_tipo'] = 'voluntario';
                
                header("Location: dashboard.php");
                exit;
            } else {
                $erro_mensagem = "Senha incorreta.";
            }
        } else {
            $erro_mensagem = "E-mail não encontrado na base de voluntários.";
        }
    } else {
        $erro_mensagem = "Erro interno ao processar consulta no banco.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>VOLUNTARIE - Acesso Voluntário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="logo">VOLUNTARIE</div>
        <div class="sublogo">Portal de acesso do Voluntário</div>
        
        <?php if (!empty($erro_mensagem)): ?>
            <div style="color: #e74c3c; margin-bottom: 15px; font-size: 14px; font-weight: bold;">
                <?php echo $erro_mensagem; ?>
            </div>
        <?php endif; ?>

        <form action="login-voluntario.php" method="POST">
            <input type="email" name="email" placeholder="Email cadastrado" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit" class="btn btn-voluntario">ENTRAR</button>
        </form>
        
        <div style="margin-top: 15px; font-size: 13px;">
            <a href="#" style="color: #666; text-decoration: none; display: block; margin-bottom: 10px;">Redefinir a senha</a>
            <span>Não possui cadastro? <a href="#" style="color: var(--cor-voluntario); font-weight: bold;">CADASTRAR</a></span>
        </div>
        <br>
        <a href="index.php" style="color:#95a5a6; text-decoration: none; font-weight: bold;">← VOLTAR</a>
    </div>
</body>
</html>