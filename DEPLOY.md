# ⚠️ ATENÇÃO: Como publicar seu site no cPanel

Se você subiu os arquivos e não apareceu nada, é porque você subiu o **CÓDIGO FONTE** (arquivos como `src`, `package.json`, `App.jsx`). O servidor (cPanel) não entende esses arquivos.

O que o cPanel entende são arquivos **HTML, CSS e JS puros**.

### 1. O Formato Correto
Você precisa gerar a pasta **`dist`**. É dentro dela que estão os arquivos prontos para o seu site.

**O que deve estar dentro da sua pasta `public_html` no cPanel deve ser exatamente isso:**
```text
/public_html
  ├── assets/          (Pasta com CSS e JS compilados)
  ├── .htaccess        (Arquivo de rotas)
  ├── favicon.svg      (Ícone)
  └── index.html       (O arquivo principal)
```

### 2. Passo a Passo para Gerar os Arquivos Certos

1. No seu computador, abra o terminal na pasta do projeto.
2. Digite o comando:
   ```bash
   npm run build
   ```
3. Uma pasta chamada **`dist`** será criada.
4. **IMPORTANTE**: Não suba a pasta `dist` inteira. Suba **o que está dentro** dela para o seu `public_html`.

---

### FAQ - Erros Comuns:

*   **"Subi tudo e vejo uma lista de pastas (src, public, node_modules)":**
    Você subiu o código fonte. Apague tudo e suba apenas o conteúdo da pasta `dist`.
*   **"Subi a pasta dist e agora o link é meu-site.com.br/dist/":**
    Você subiu a pasta em vez do conteúdo. Mova os arquivos de dentro de `dist` para a raiz do seu `public_html`.
*   **"A página inicial funciona, mas se eu atualizar dá erro 404":**
    Certifique-se de que o arquivo `.htaccess` que eu criei foi enviado para o servidor. Ele é invisível no computador (começa com ponto), então verifique se ele foi copiado.

### Como eu posso te ajudar agora?
Se você não tem o Node.js instalado no seu computador para rodar o comando `npm run build`, me avise. Eu já deixei o projeto configurado, mas para o cPanel, o passo final é sempre gerar esse "build".
