# CRUD-BACK
## Ultilizando Codeigniter 3 + PHP

📋 Descrição
Este projeto é uma API RESTful desenvolvida em **CodeIgniter 3.1.1** e **PHP**. O objetivo é fornecer uma interface para operações de CRUD (Criar, Ler, Atualizar e Deletar) em um banco de dados de produtos. A API é projetada para ser simples e fácil de usar, permitindo que desenvolvedores integrem funcionalidades de gerenciamento de produtos em suas aplicações.

## 🚀 Funcionalidades

- **Listar produtos**: Obtenha todos os produtos ou um produto específico.
- **Criar produto**: Adicione novos produtos ao banco de dados.
- **Atualizar produto**: Modifique as informações de produtos existentes.
- **Deletar produto**: Remova produtos do banco de dados.
- **Upload de imagens**: Suporte para upload de imagens de produtos.

## 🛠️ Tecnologias Utilizadas

- [CodeIgniter 3.1.1](https://codeigniter.com/)
- PHP
- MySQL/PostgreSQL (dependendo da configuração do banco de dados)

## 🔧 Pré-requisitos

Antes de começar, você precisará ter o seguinte instalado em sua máquina:

- PHP 5.6 ou superior
- Composer (opcional, se você estiver usando pacotes)
- Um servidor web (Apache, Nginx, etc.)
- Um banco de dados (MySQL ou PostgreSQL)

 ## 🏃  Instalação

 1. **Clone o repositório:**

   ```bash
   git clone https://github.com/seu_usuario/seu_repositorio.git
   cd seu_repositorio
   ```

2. **Instale as dependências (se houver):**

   ```bash
   composer install
   ```

3. **Configuração do banco de dados:**

   - Crie um banco de dados no MySQL ou PostgreSQL.
   - Configure as credenciais do banco de dados no arquivo `application/config/database.php`.
  

  4. **Configuração do ambiente:**

   - Certifique-se de que o arquivo `.htaccess` está configurado corretamente para o seu servidor.
   - Ajuste o arquivo `application/config/config.php` conforme necessário, especialmente a URL base.

5. **Inicie o servidor:**

   - Se você estiver usando o PHP embutido, pode iniciar o servidor com o seguinte comando:

   ```bash
   php -S localhost:8080 -t application/
   ```

## ✨ Uso

- **Listar produtos:**
  - `GET /api/item` - Retorna todos os produtos.
  - `GET /api/item/{id}` - Retorna um produto específico.

- **Criar produto:**
  - `POST /api/item` - Envie os dados do produto no corpo da requisição.

- **Atualizar produto:**
  - `PUT /api/item/{id}` - Envie os dados atualizados do produto no corpo da requisição.

- **Deletar produto:**
  - `DELETE /api/item/{id}` - Remove o produto especificado.
 
  **Atualizar imagem do produto:**
  - `POST /api/item/{id}/imagem` - Envie a nova imagem do produto no corpo da requisição. A imagem deve ser enviada como um arquivo com o nome `imagem`. Se a imagem anterior existir, ela será removida.

# 👥 Contribuição

* Faça um fork do repositório
* Crie um branch para sua feature (git checkout -b feature/nova-funcionalidade)
* Commit suas mudanças (git commit -m 'Adiciona nova funcionalidade')
* Push para o branch (git push origin feature/nova-funcionalidade)
* Abra um Pull Request
