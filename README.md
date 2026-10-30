# Retrô FC - Sócio-Torcedor

Projeto Laravel para cadastro e consulta de sócios-torcedores do Retrô FC, com um catálogo complementar de produtos e benefícios para a torcida.

## Funcionalidades

- Página inicial do programa de sócio-torcedor.
- Cadastro de sócios com nome, CPF, telefone, e-mail, data de nascimento e plano.
- Listagem dos sócios cadastrados.
- Cadastro e listagem de categorias.
- Cadastro e catálogo de produtos/benefícios, com descrição, valor, imagem, destaque e disponibilidade.
- Relacionamento entre empresas, categorias e produtos.

## Estrutura do banco de dados

As migrations do Laravel criam as seguintes tabelas principais:

- `empresas`: dados cadastrais, contato, endereço e configuração visual da empresa.
- `users`: usuários do sistema, com vínculo opcional a uma empresa, papel e status.
- `socios`: informações dos sócios-torcedores e plano escolhido.
- `categorias`: nome e ícone da categoria, com vínculo opcional a uma empresa.
- `produtos`: categoria, empresa, nome, descrição, valor, imagem, destaque e disponibilidade.

As tabelas `categorias` e `produtos` usam exclusão lógica (`deleted_at`). Os vínculos com empresa e categoria seguem as chaves estrangeiras definidas nas migrations.

## Como executar

1. Instale as dependências do projeto:

   ```bash
   composer install
   npm install
   ```

2. Crie o arquivo de ambiente e gere a chave da aplicação:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. Configure no `.env` os dados do banco que será utilizado. O exemplo do projeto está configurado para PostgreSQL (`DB_CONNECTION=pgsql`).

4. Execute as migrations para criar as tabelas:

   ```bash
   php artisan migrate
   ```

5. Em outro terminal, compile os arquivos de interface e inicie o servidor:

   ```bash
   npm run build
   php artisan serve
   ```

6. Acesse `http://127.0.0.1:8000`.

## Rotas principais

- `/` — página inicial.
- `/cadastro` — formulário de cadastro do sócio.
- `/socios` — relação de sócios cadastrados.
- `/produtos` — catálogo de produtos e benefícios disponíveis.
- `/produtos/cadastro` — formulário de cadastro de produto/benefício.
- `/categorias` — relação de categorias.
- `/categorias/cadastro` — formulário de cadastro de categoria.

> As telas de cadastro de produtos e categorias seguem a estrutura acadêmica do projeto de referência. O controle de acesso administrativo/autenticação não foi acrescentado, para preservar o escopo e o funcionamento que o projeto original já possuía.

## Observação sobre `sistema.db`

O arquivo `sistema.db` que acompanha os arquivos de referência contém somente uma tabela legada chamada `usuarios`; ele não contém registros de categorias ou produtos. Por isso, as novas tabelas e seus relacionamentos foram adicionados pelas migrations do Laravel, sem importar esse registro legado para o cadastro de sócios.
