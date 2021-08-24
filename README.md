<div align="center">
    <h1 align="center">Backend Challenge - Sabido</h1>
</div>

## Apresentação

Este repositório contêm instruções para ter o ambiente necessário para seu desafio, utilizando o framework symfony 5.3.

O ambiente utiliza composer/docker/docker-compose.

## Começando

Clone este repositório, crie uma nova _branch_, como por exemplo `backend-challenge`.

Em seu ambiente local, você só precisa ter o [Docker](https://www.docker.com/get-started) e o [Docker Compose](https://docs.docker.com/compose/) instalados.

Para rodar o repositório, basta usar o comando abaixo no raiz do projeto. Ele ira configurar a aplicação.

```bash
bin/composer setup
```

Agora vamos deixar sua aplicação rodando utilizando o `docker-compose`.
Garanta que a porta `80` de sua máquina não esteja sendo utilizada e rode o comando abaixo:

```bash
docker-compose up
```

Para configurar o primeiro acesso a aplicação:

```bash
docker-compose exec app composer configure
```

Para popular o banco de dados com alguns registros, use o comando a seguir:

```bash
docker-compose exec app composer load-fixtures-db
```

A partir daqui, está tudo configurado 🚀

## Testando

Para debugar a aplicação, basta que vc utilize o xdebug com sua IDE de preferência:

Já existe um script para rodar os testes da aplicação, utilizando o [phpunit](https://phpunit.de/):

```bash
docker-compose exec app composer test
```

# Desafio

Nós te fornecemos uma estrutura para começar, para focar somente com a lógica do desafio.

## Cenário

Pense num banco com diversos itens a serem avaliados, divididos em categorias, aonde estes podem ser reavaliados após um período predeterminado.

## Escopo

Queremos que você implemente a lógica para voto online com algumas premissas:
* Uma pessoa só pode votar uma vez por conjunto categoria/candidato.
* Uma pessoa só pode votar 3 vezes por categoria.
* Depois de 30 dias, a pessoa pode votar novamente, limitando-se as regras anteriores.
* Se for o primeiro voto dessa pessoa na plataforma, queremos dela um feedback descritivo antes da votação.
* A estrutura de voto é qualitativa, numa escala de 1 a 5.
* O voto é anônimo.

Qualquer alteração em banco de dados deve ser feita por migrations.

# Avaliação

A avaliação objetiva usaremos os comandos para avaliar parte de seu código:
```bash
bin/stan
bin/ecs
bin/md
```

Consideraremos na avaliação qualitativa os pontos mais importantes:
* todos as premissas atendidas
* cobertura de testes unitários (seja criativo)
* corrigir possíveis testes existentes com erro
* ampliar cobertura (positiva e negativa dos testes de endpoints)
* qualidade do seu código (padrão de escrita, performance, OOP, MVC)
* praticidade na apresentação do desafio, o que envolve documentação de acesso aos recursos (endpoints, outputs?)
* não se limite em usar quantas libs/tools opensource, ou mesmo em como persistir os dados

## O que não será avaliado

* Frontend (camada de visualização e templates).
* Autenticação.

## Considerações finais

Fique a vontade para implementar melhorias ao processo e desafio (eventos assíncronos, serviços em background, etc).

Ao final de seu teste, abra uma PR para o repositório com as informações que julgar necessárias (recomendações, feedbacks).

Boa sorte!
