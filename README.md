# 🔐 Sistema de Autenticação e Perfil Simples (PHP)

Um sistema de login e personalização de perfil minimalista desenvolvido em arquivo único utilizando **PHP** puro e **CSS3**. Projetado para demonstração, aprendizado ou pequenos projetos que necessitam de autenticação em memória sem a complexidade de um banco de dados.

---

## 🚀 Funcionalidades

- **Autenticação em Memória:** Validação de e-mail e senha diretamente no script PHP (sem banco de dados).
- **Gerenciamento de Sessão (`$_SESSION`):**
  - Armazenamento dos dados do usuário logado.
  - Proteção de exibição de tela (Login vs. Perfil).
  - Encerramento seguro de sessão com limpeza de cookies (Logout).
- **Personalização de Interface:**
  - Seletor de cores (`<input type="color">`) para alterar o fundo da aplicação em tempo real.
  - Persistência da preferência de cor durante a navegação/sessão.
- **Design Responsivo e Moderno:** Interface centralizada e estilizada com CSS Flexbox.

---

## 🛠️ Tecnologias Utilizadas

- **PHP 7.x / 8.x** (Manipulação de sessões e lógica de servidor)
- **HTML5 & CSS3** (Estruturação e estilização visual)

---

## 📋 Pré-requisitos

Para executar este projeto, você precisará apenas de um ambiente PHP funcional em sua máquina:

- Servidor web local como [XAMPP](https://www.apachefriends.org/), [WAMP](https://www.wampserver.com/), [Laragon](https://laragon.org/), ou
- CLI do PHP instalada em seu sistema.

---

## 🔧 Como Executar

### Opção 1: Usando o Servidor Embutido do PHP (Mais Rápido)

1. Baixe ou copie o código fonte e salve-o em um arquivo chamado `index.php`.
2. Abra o terminal ou prompt de comando na mesma pasta onde o arquivo foi salvo.
3. Inicie o servidor PHP integrado executando:
   ```bash
   php -S localhost:8000
   ```
4. Abra o navegador e acesse: [http://localhost:8000](http://localhost:8000)

### Opção 2: Usando XAMPP/WAMP

1. Copie o arquivo para a pasta de hospedagem local (ex: `htdocs/meu-projeto/index.php`).
2. Inicie o serviço Apache no seu painel de controle (XAMPP/WAMP).
3. Acesse no navegador: `http://localhost/meu-projeto/index.php`

---

## 🔑 Credenciais de Acesso (Padrão)

Utilize as seguintes credenciais para testar o login:

- **E-mail:** `admin@teste.com`
- **Senha:** `123456`

---

## 📁 Estrutura do Código

A aplicação utiliza uma estrutura de **arquivo único** (`Single File Application`):

1. **Início da Sessão (`session_start`):** Garante a persistência de dados.
2. **Lógica de Controle (PHP):**
   - Vetor `$usuarios_cadastrados` atuando como base de dados temporária.
   - Trata requisições de `Logout` limpando cookies e destruindo a sessão.
   - Trata requisições `POST` para validação de login e alteração de preferências visuais.
3. **Interface (HTML/CSS):**
   - Renderização condicional dependendo do status de autenticação (`$usuarioAutenticado`).

---

## 📄 Licença

Este projeto é totalmente livre para fins educacionais e de estudos.
