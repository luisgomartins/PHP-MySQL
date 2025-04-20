## 🧑‍💻 Guia para Rodar Localmente

Este projeto está configurado com Docker. Cada integrante possui uma branch separada para desenvolver suas tarefas.

---

## ✅ Pré-requisitos
- [Docker Desktop](https://www.docker.com/products/docker-desktop) instalado
- [Git](https://git-scm.com) instalado

## 1️⃣ Clonar o repositório
Abra o terminal bash e execute:

git  clone https://github.com/luisgomartins/PHP-MySQL
cd PHP-MySQL

## 2️⃣ Acessar sua branch pessoal

# Filipe
git checkout filipe
# Hullian
git checkout hullian
# Thiago
git checkout thiago

## 3️⃣ Rodar com Docker 
docker-compose up --build

## 4️⃣ Acessar no navegador
🕸️ Sistema PHP (site):
http://localhost:8080

🛠️ phpMyAdmin (banco):
http://localhost:8081

Login phpMyAdmin:
Usuário: root
Senha: rootpassword

## 5️⃣ Parar os containers
Quando terminar:
docker-compose down

# PHP-MySQL
Repositório compartilhado para projeto de PHP-MySQL - Programação de Computadores II
# Bash para rodar a docker
docker-compose up -d



# Estrutura do Sistema
/projeto-ToDo
|-index.php (Tela Inicial)
|-register.php (cadastro)
|-login.php (login)
|-styles.css

/projeto-ToDo/user/
|- dashboard.php (painel de tarefas)
|- add_task.php (adicionar tarefa)
|- edit_task.php (editar tarefa)
|- profile.php (editar perfil)
|- report.php (relatório/gráfico)
|- logout.php

/projeto-ToDo/includes/
|- db.php (conexão com MySQL)
|- auth.php (verificação de login)

/projeto-ToDo/uploads/
|- (imagens anexadas)