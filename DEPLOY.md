# Guia de Deploy no cPanel - Refeições Santa Helena

Como este é um site construído com React (Vite), você precisará seguir estes passos para colocá-lo no ar usando o seu cPanel:

## 1. Preparar os arquivos
No seu computador (ou ambiente de desenvolvimento), execute:
```bash
npm run build
```
Isso criará uma pasta chamada `dist`. É o conteúdo desta pasta que deve ir para o servidor.

## 2. Enviar para o cPanel
1. Acesse o seu cPanel.
2. Abra o **Gerenciador de Arquivos** (File Manager).
3. Navegue até a pasta `public_html` (ou a pasta do seu domínio).
4. Clique em **Carregar** (Upload) e envie todos os arquivos e pastas que estão dentro da sua pasta `dist` local.
   - *Dica: Você pode zipar o conteúdo da pasta `dist`, enviar o arquivo .zip e depois extraí-lo no cPanel.*

## 3. Configurações Necessárias no cPanel

### A. Roteamento (Importante para o React)
Já incluímos um arquivo chamado `.htaccess` na pasta `public`. Ele garante que, quando você atualizar a página ou acessar um link direto (como `/sobre`), o servidor saiba que deve carregar o `index.html` do React.
- Certifique-se de que o arquivo `.htaccess` foi enviado para o `public_html`. No Gerenciador de Arquivos, talvez precise habilitar "Mostrar arquivos ocultos" (Settings -> Show Hidden Files).

### B. Versão do Node.js (Opcional)
Se você for apenas hospedar o site estático (o que recomendamos para este projeto), **não precisa** habilitar o Node.js no cPanel. Basta enviar os arquivos da pasta `dist`.

Se você pretende rodar o comando de build direto no servidor (mais avançado):
1. Procure por **"Setup Node.js App"** no cPanel.
2. Crie uma nova aplicação, escolha a versão mais recente do Node.js (ex: 20 ou 22).
3. Defina a "Application startup file" como `index.html` (embora para estático isso não seja usado).

## 4. Credenciais do Admin
Para alterar o usuário e senha do painel administrativo no servidor:
- Você pode criar um arquivo chamado `.env` na raiz do seu projeto antes de fazer o build, com o seguinte conteúdo:
```env
VITE_ADMIN_USER=seu_usuario
VITE_ADMIN_PASSWORD=sua_senha_segura
```
- Depois, execute `npm run build` novamente e envie os arquivos atualizados.

## 5. Resumo do que "Habilitar"
1. **Domínio/Subdomínio**: Certifique-se de que o domínio está apontando para a pasta correta.
2. **Certificado SSL**: No cPanel, procure por **"LetsEncrypt SSL"** ou **"AutoSSL"** e garanta que o site esteja rodando em `https://`.
3. **MIME Types**: Geralmente o cPanel já reconhece arquivos `.js` e `.css`, mas se o site não carregar os estilos, verifique se os MIME types estão corretos.
