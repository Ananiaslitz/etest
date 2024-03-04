## Pré-requisitos
Antes de iniciar, certifique-se de que você tem o Docker e o Docker Compose instalados em sua máquina. Para instalar essas ferramentas, siga as instruções no site oficial do Docker:

Docker: https://docs.docker.com/get-docker/
Docker Compose: https://docs.docker.com/compose/install/

## Iniciando o Projeto
Para iniciar o projeto, execute o seguinte comando no diretório raiz do projeto:

```bash
docker-compose up -d
```

## Acessando a Documentação da API
Após iniciar os serviços com o Docker Compose, você pode acessar a documentação Swagger da API navegando até:

```php
http://localhost:8021/api/documentation
```


### Lembre-se de rodar as migrations.
