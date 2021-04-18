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

Instale as dependências e gere o banco inicial:
```sh
docker-compose run webserver composer install && composer migrate
```

Dê as permissões necessários no banco criado, para que o apache possa escrever:
```sh
chown -R :www-data database/hurb-challenge.db
chmod 664 database/hurb-challenge.db
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

## Setup de Sincronização

Crie um cron para sincronizar as taxas de câmbio de tempos em tempos:
```sh
crontab -e
```

Configure um cron de hora em hora no editor:

#### Projeto rodando no Docker:
```sh
0 * * * * cd /caminho/do/projeto && docker-compose exec webserver composer sync
```
#### Projeto rodando Local:
```sh
0 * * * * cd /caminho/do/projeto && composer sync >/dev/null 2>&1
```
<sub>Dependendo das configurações, será necessário definir o caminho completo dos comandos.</sub>

##


## Comandos

Rodar testes:
```sh
composer tests
```

Iniciar projeto utilizando php-cli:
```sh
composer start
```

Configurar/Limpar banco:
```sh
composer migrate
```

Sincronizar taxas de câmbio:
```sh
composer sync
```

## Endpoints

```
(doc)GET /
GET /currencies
POST /currencies
DELETE /currencies/{currency}
```

## Informações adicionais
---

#### A atualização das taxas de câmbio está acontecendo de hora em hora, através de um cron configurado dentro do Dockerfile. Não é possível aumentar, pois a API utilizada para consulta é gratuita, e só disponibiliza 1000 requisições por mês. O cálculo feito foi: 1000/31 = 32 requisições por dia (arredondando pra baixo), levando em consideração os testes (que fazem requisição também, 24 requisições por dia seria um número seguro).

---
