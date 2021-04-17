# Hurb - Challenge Bravo

Este projeto foi criado através do desafio proposto pelo hurb, seu objetivo é fazer conversão monetária entre duas moedas.

## Requisitos
- PHP 7.3 ou mais recente
- php-curl extension
- php-sqlite extension
- [composer](https://getcomposer.org/doc/00-intro.md)
- [docker-compose](https://docs.docker.com/compose/install) (caso use container)

## Docker Setup

Configure o arquivo .env seguindo as configurações do .env.example (para funcionar, basta copiar e colar o conteúdo).

Suba o container:
```sh
docker-compose up -d
```

Instale as dependências:
```sh
docker-compose run webserver composer install
```

A aplicação estará disponível no endereço: http://localhost:8000.
```sh
# Converção
curl 'http://localhost:8000/currencies?from=USD&to=BRL&amount=30'

# Adicionar Moeda
curl 'http://localhost:8000/currencies' -X 'POST' -d 'currency=CAD&usd_value=0.80'

# Remover Moeda
curl 'http://localhost:8000/currencies/CAD' -X 'DELETE'
```

## Setup

Instale as dependências:

```sh 
composer install
```

Configure o arquivo .env: *
```sh
nano .env
```
<sub>*Se o arquivo não for criado automaticamente depois do composer install, faça uma cópia do .env.example.</sub>

Rode as migrations e seeds:
```sh
composer migrate
```

## Comandos

Rodar testes:
```sh
composer tests
```

Iniciar projeto utilizando php-cli:
```sh
composer start
```

## Endpoints

```
(doc)GET /
GET /currencies
POST /currencies
DELETE /currencies/{currency}
```