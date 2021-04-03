<div align="center">
    <h1 align="center">Backend Challenge - Sabido</h1>
</div>

## Apresentação

Este repositório visa fornecer o ambiente necessário para seu desafio, utilizando o framework symfony 5.2.

Existem ferramentas complementares para teste, formatação de código e busca por erros de implementação. O ambiente utiliza composer/docker/docker-compose.


## Começando

Clone este repositório, crie uma nova _branch_, como por exemplo `backend-challenge`.

Em seu ambiente local, você só precisa ter o [Composer](https://getcomposer.org/download/), [Docker](https://www.docker.com/get-started) e o [Docker Compose](https://docs.docker.com/compose/) instalados.

Para rodar o repositório, basta usar o comando abaixo no raiz do projeto. Ele ira configurar a aplicação.

```bash
composer setup
```

Agora vamos deixar sua aplicação rodando utilizando o `docker-compose`.
Garanta que a porta `80` de sua máquina não esteja sendo utilizada e rode o comando abaixo:

```bash
docker-compose up
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
---

Caso deseje rodar todas as checagens de qualidade de código, rode o comando abaixo:

```bash
docker-compose exec app composer grum
```

O comando abaixo serve para padronizar seu código com as PSR's predefinidas:

```bash
docker-compose exec app composer format
```

E por meio do stan você pode buscar por problemas que possam existir na sua implementação:

```bash
docker-compose exec app composer stan
```

Para checar em detalhes a cobertura de código da aplicação, após rodar o _grum_,
abra o arquivo `build/coverage/index.html` em seu navegador.


# Desafio

Nós te fornecemos uma estrutura para começar, para se preocupar somente com a lógica do desafio.
Pense num banco com diversos itens a serem avaliados, divididos em categorias, aonde estes podem ser reavaliados após um período predeterminado.

Queremos que você implemente a lógica para voto online com algumas premissas:
* Uma pessoa só pode votar uma vez por conjunto categoria/candidato.
* Uma pessoa só pode votar 3 vezes por categoria.
* Depois de 30 dias, a pessoa pode votar novamente, limitando-se as regras anteriores.
* Se for o primeiro voto dessa pessoa na plataforma, queremos dela um feedback descritivo antes da votação.
* A estrutura de voto é qualitativa, numa escala de 1 a 5.
* O voto é anônimo.

Qualquer alteração em banco de dados deve ser feita por migrations.

## Avaliação

Será avaliado a qualidade do código implementado e sua cobertura. Os pontos mais importantes são:
* todos as premissas atendidas
* cobertura de testes unitários (seja criativo)
* corrigir possíveis testes existentes com erro
* ampliar cobertura (positiva e negativa dos testes de endpoints)
* qualidade do seu código (padrão de escrita, performance, OOP, MVC)
* praticidade na apresentação do desafio, o que envolve documentação de acesso aos recursos (endpoints, outputs?)
* não se limite em usar quantas libs/tools opensource, ou mesmo em como persistir os dados


## Considerações finais

Você não precisa de uma camada de visualização para concluir o desafio.

Ao final de seu teste, abra uma PR para o repositório com as informações que julgar necessárias (recomendações, feedbacks).

Boa sorte!
