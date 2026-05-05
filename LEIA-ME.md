# Guia de Instalação PHP - Refeições Santa Helena

Este site foi desenvolvido em PHP para ser facilmente hospedado no seu cPanel. Ele inclui um sistema automático para configurar o banco de dados.

## 1. Como publicar no cPanel
1. Entre no seu cPanel e abra o **Gerenciador de Arquivos**.
2. Vá para a pasta `public_html`.
3. Suba todos os arquivos e pastas do projeto (incluindo `admin`, `includes`, `uploads`, etc.).
4. Certifique-se de que a pasta `uploads` tenha permissão de escrita (geralmente `755` ou `775`).

## 2. Configurando o Banco de Dados (Passo Principal)
Existem duas formas de configurar:

**Opção A: Automática (Recomendada)**
1. Antes de tudo, crie um Banco de Dados MySQL vazio no seu cPanel.
2. No seu navegador, acesse: `http://seu-dominio.com.br/setup.php`
3. Preencha os dados e clique em **Instalar**. O sistema criará o arquivo `config.php` e as tabelas para você.

**Opção B: Manual**
1. Renomeie o arquivo `includes/config-sample.php` para `includes/config.php`.
2. Edite o arquivo com os dados do seu banco de dados.
3. Importe as tabelas manualmente (se precisar do SQL, ele está dentro do arquivo `setup.php`).

## 3. Acesso Administrativo
- Após a instalação, o acesso padrão é:
  - **URL**: `http://seu-dominio.com.br/admin/login.php`
  - **Usuário**: `admin`
  - **Senha**: `admin123`
- **IMPORTANTE**: Após logar, você pode apagar o arquivo `setup.php` do seu servidor por segurança.

## 4. Recursos do Site
- **Cardápio Dinâmico**: Adicione fotos e vídeos dos pratos.
- **Responsivo**: Funciona perfeitamente em celulares e computadores.
- **Identidade Visual**: Cores azul e branco conforme solicitado.
- **Página da Empresa e Contato**: Inclusas no menu principal.
