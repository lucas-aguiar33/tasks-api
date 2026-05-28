# 📌 API de Tarefas - Laravel

Esta API foi desenvolvida como projeto de estudo com foco em boas práticas no desenvolvimento backend utilizando Laravel.

O sistema permite autenticação de usuários e gerenciamento de tarefas através de uma API RESTful segura, organizada e escalável.
---

# 🚀 Tecnologias Utilizadas

- PHP 8+
- Laravel 12
- Laravel Sanctum
- MySQL 
- Eloquent ORM

---

# 📦 Funcionalidades

- Cadastro de usuários
- Login e logout
- Autenticação via token
- CRUD completo de tarefas
- Validações com FormRequest
- Respostas padronizadas com API Resources
- Eager Loading para otimização de consultas
- Paginação de resultados

---

# 📁 Estrutura do Projeto

```bash
app/
├── Http/
│   ├── Controllers/
│   │   ├── ApiAuthController.php
│   │   └── TaskController.php
│   │
│   ├── Requests/
│   │   ├── LoginRequest.php
│   │   ├── RegisterRequest.php
│   │   ├── StoreTaskRequest.php
│   │   ├── UpdateTaskRequest.php
│   │
│   └── Resources/
│       ├── TaskResource.php
│       └── UserResource.php
│
├── Models/
│   ├── Task.php
│   └── User.php
```

---

# ⚙️ Instalação do Projeto

## 1. Clone o repositório

```bash
git clone https://github.com/seu-usuario/api-tarefas.git
```

---

## 2. Acesse a pasta do projeto

```bash
cd api-tarefas
```

---

## 3. Instale as dependências

```bash
composer install
```

---

## 4. Copie o arquivo `.env`

```bash
cp .env.example .env
```

---

## 5. Configure o banco de dados no `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api_tarefas
DB_USERNAME=root
DB_PASSWORD=
```

---

## 6. Gere a chave da aplicação

```bash
php artisan key:generate
```

---

## 7. Execute as migrations

```bash
php artisan migrate
```

---

## 8. Inicie o servidor

```bash
php artisan serve
```

A aplicação estará disponível em:

```bash
http://127.0.0.1:8000
```

---

# 🔐 Autenticação

A autenticação da API é feita utilizando Laravel Sanctum.

Após realizar login, será retornado um token que deve ser enviado no header das requisições autenticadas:

```http
Authorization: Bearer seu_token
```

---

# 👤 Rotas de Autenticação

## Registrar usuário

### Endpoint

```http
POST /api/register
```

### Body

```json
{
  "name": "João",
  "email": "joao@email.com",
  "password": "password",
}
```

---

## Login

### Endpoint

```http
POST /api/login
```

### Body

```json
{
  "email": "joao@email.com",
  "password": "password",
  "password_confirmation": "password"
}
```

---

## Logout

### Endpoint

```http
POST /api/logout
```

### Headers

```http
Authorization: Bearer seu_token
```

---

# 📋 Rotas de Tarefas

Todas as rotas abaixo requerem autenticação.

---

## Listar tarefas

### Endpoint

```http
GET /api/tasks
```


- A listagem de tarefas utiliza paginação para otimizar performance e organização dos dados. Cada página retorna até 10 tarefas.

### Query Params

| Parâmetro | Tipo | Descrição |
|---|---|---|
| page | integer | Número de página |

### Exemplo de requisição

``` http
GET /api/tasks?page=1
```

### Exemplo de resposta

``` json

{
  "data": [
    {
      "id": 1,
      "title": "Estudar Laravel",
      "description": "Aprender sobre API Resources",
      "status": "in_progress",
      "created_at": "28/05/2026"
    },
    {
      "id": 2,
      "title": "Criar documentação",
      "description": "Documentar endpoints da API",
      "status": "pending",
      "created_at": "28/05/2026"
    },
    {
      "id": 3,
      "title": "Implementar autenticação",
      "description": "Adicionar login com Sanctum",
      "status": "completed",
      "created_at": "28/05/2026"
    }
  ],
  "links": {
    "first": "http://127.0.0.1:8000/api/tasks?page=1",
    "last": "http://127.0.0.1:8000/api/tasks?page=5",
    "prev": null,
    "next": "http://127.0.0.1:8000/api/tasks?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 5,
    "path": "http://127.0.0.1:8000/api/tasks",
    "per_page": 10,
    "to": 10,
    "total": 50
  },
  "success": true
}
```

---

## Buscar tarefa por ID

### Endpoint

```http
GET /api/tasks/{id}
```


## Criar tarefa

### Endpoint

```http
POST /api/tasks
```

### Body

```json
{
  "title": "Estudar Laravel",
  "description": "Aprender sobre API Resources",
  "status": "in_progress"
}
```

---

## Atualizar tarefa

### Endpoint

```http
PUT /api/tasks/{id}
```

### Body

```json
{
  "title": "Novo título",
  "description": "Nova descrição",
  "status": "pending"
}
```

---

## Deletar tarefa

### Endpoint

```http
DELETE /api/tasks/{id}
```

---

# 🧪 Como testar a API

Você pode testar a API utilizando:
- Postman
- Insomnia
- Thunder Client (VSCode)

As rotas autenticadas requerem um token Bearer gerado no login.

---

# ✅ Validações com FormRequest

O projeto utiliza FormRequests separados para manter as validações organizadas.

## RegisterRequest

- name obrigatório
- email obrigatório e único
- password obrigatória e confirmada

## LoginRequest

- email obrigatório
- password obrigatória

## StoreTaskRequest

- title obrigatório
- description opcional
- status obrigatório e deve ser: pending, in_progress ou completed

## UpdateTaskRequest

- validação utilizando `sometimes`
- atualização parcial dos campos

---

# 🔄 API Resources

As respostas da API são padronizadas utilizando Laravel Resources.

## Exemplo de resposta

```json
{
  "data": {
    "id": 1,
    "title": "Estudar Laravel",
    "description": "Aprender API Resources",
    "status": "in_progress",
    "created_at": "27/05/2026"
  },
  "success": true
}
```

---

# ⚡ Eager Loading

O projeto utiliza Eager Loading para evitar problemas de performance relacionados ao N+1 Query Problem.

## Exemplo

```php
Task::with('user')->get();
```

---

# 🧠 Boas Práticas Aplicadas

- Controllers enxutos
- Responsabilidades separadas
- Validações centralizadas
- Respostas padronizadas com API Resources
- Autenticação segura
- Código organizado e escalável
- Consultas otimizadas com Eager Loading
- Paginação para melhor performance e escalabilidade

---

# 📌 Melhorias Futuras

- Filtros por status
- Upload de arquivos
- Testes automatizados
- Docker

---

# 🧑‍💻 Autor

Desenvolvido por Lucas Aguiar

---

# 📄 Licença

Este projeto está licenciado sob a licença MIT.