<?php
session_start();
// ==============================================================================
// 1. DADOS DE USUÁRIOS (EM MEMÓRIA - SEM BANCO DE DADOS)
// ==============================================================================
$usuarios_cadastrados = [
    [
        'id' => 1,
        'nome' => 'Usuário Desafio',
        'email' => 'admin@teste.com',
        'senha' => '123456'
    ]
];
// ==============================================================================
// 2. CONTROLE DE AÇÕES (LOGOUT E TROCA DE COR)
// ==============================================================================
$pagina_atual = $_SERVER['PHP_SELF'];
$acao = $_GET['acao'] ?? '';
// Ação de Logout
if ($acao === 'logout') {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
    header("Location: " . $pagina_atual);
    exit();
}
// Ação de Alterar Cor de Fundo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cor_fundo'])) {
    $_SESSION['cor_fundo'] = $_POST['cor_fundo'];
}
// Processamento do Login sem DB
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    if (!empty($email) && !empty($senha)) {
        $usuario_encontrado = null;
        foreach ($usuarios_cadastrados as $u) {
            if ($u['email'] === $email && $u['senha'] === $senha) {
                $usuario_encontrado = $u;
                break;
            }
        }
        if ($usuario_encontrado) {
            $_SESSION['usuario_id'] = $usuario_encontrado['id'];
            $_SESSION['usuario_nome'] = $usuario_encontrado['nome'];
            $_SESSION['usuario_email'] = $usuario_encontrado['email'];
            header("Location: " . $pagina_atual);
            exit();
        } else {
            $erro = "E-mail ou senha incorretos.";
        }
    } else {
        $erro = "Preencha todos os campos!";
    }
}
// Cor de fundo atual
$corFundo = $_SESSION['cor_fundo'] ?? '#f4f6f9';
$usuarioAutenticado = isset($_SESSION['usuario_id']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $usuarioAutenticado ? 'Perfil do Usuário' : 'Login - Sistema' ?></title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: <?= htmlspecialchars($corFundo) ?>;
            transition: background-color 0.4s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .card {
            background: #ffffff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            width: 100%;
            max-width: 420px;
            text-align: center;
        }
        h2 { color: #2c3e50; margin-bottom: 20px; }
        .form-group { text-align: left; margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #555; font-size: 14px; font-weight: 600; }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }
        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-primary:hover { background-color: #0056b3; }
        .btn-danger { background-color: #dc3545; color: white; margin-top: 15px; }
        .btn-danger:hover { background-color: #c82333; }
        .btn-success { background-color: #28a745; color: white; width: auto; padding: 10px 15px; }
        .btn-success:hover { background-color: #218838; }
        .erro {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .avatar {
            width: 80px;
            height: 80px;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 15px auto;
            font-weight: bold;
        }
        .box-customizacao {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .color-picker-group {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
        input[type="color"] {
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 6px;
            cursor: pointer;
            background: transparent;
        }
        p.email { color: #6c757d; margin-top: -10px; margin-bottom: 20px; }
        .dica {
            font-size: 12px;
            color: #888;
            background: #eee;
            padding: 8px;
            border-radius: 6px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="card">
        <?php if (!$usuarioAutenticado): ?>
            <h2>🔑 Entrar no Sistema</h2>
            <?php if (!empty($erro)): ?>
                <div class="erro"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>
            <form action="<?= htmlspecialchars($pagina_atual) ?>" method="POST">
                <input type="hidden" name="login" value="1">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" required placeholder="admin@teste.com">
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required placeholder="123456">
                </div>
                <button type="submit" class="btn btn-primary">Acessar Perfil</button>
            </form>
            <div class="dica">
                📌 <strong>Dados para teste:</strong><br>
                E-mail: <code>admin@teste.com</code><br>
                Senha: <code>123456</code>
            </div>
        <?php else: ?>
            <div class="avatar">
                <?= strtoupper(substr($_SESSION['usuario_nome'], 0, 1)) ?>
            </div>
            <h2>Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>! 👋</h2>
            <p class="email"><?= htmlspecialchars($_SESSION['usuario_email']) ?></p>
            <div class="box-customizacao">
                <form action="<?= htmlspecialchars($pagina_atual) ?>" method="POST">
                    <label for="cor_fundo">🎨 Personalize a cor de fundo:</label>
                    <div class="color-picker-group">
                        <input type="color" id="cor_fundo" name="cor_fundo" value="<?= htmlspecialchars($corFundo) ?>">
                        <button type="submit" class="btn btn-success">Aplicar Cor</button>
                    </div>
                </form>
            </div>
            <a href="<?= htmlspecialchars($pagina_atual) ?>?acao=logout" class="btn btn-danger">🚪 Sair do Sistema</a>
        <?php endif; ?>
    </div>
</body>
</html>