>  This is a challenge by [Coodesh](https://coodesh.com/)

# Backend Challenge 20230105

REST API para utilizar os dados do projeto Open Food Facts, que é um banco de dados aberto com informação nutricional de diversos produtos alimentícios.

## Tecnologias Utilizadas

- **Linguagem:** PHP
- **Framework:** Laravel
- **Serviços:** Docker
- **Banco de Dados:** MySQL
- **Servidor Web:** Apache2

## Instalação e Uso

### Pré-requisitos

- Docker e Docker Compose instalados na sua máquina.
- Git instalado.

### Passo a Passo

1. **Clone o repositório:**

   ```bash
   git clone https://github.com/nixs-dev/coodesh-test.git
   cd coodesh-test/src```

2. **Construa o contêiner:**

    ```docker-compose up -d```

3. **Execute as migrations:**

    ```docker-compose exec app php artisan migrate```