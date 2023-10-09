# Gestão de PDFs

Projeto destinado para testes de pessoas desenvolvedoras.

## Instalação

```
$ mkdir -p ~/.docker_cache/{composer,wp-cli} 
$ docker compose pull
$ docker compose build
$ docker compose -f docker-compose.tests.yml pull
$ docker compose -f docker-compose.tests.yml build
$ docker compose run --rm -u $(id -u):$(id -g) composer install
$ docker compose run --rm -u $(id -u):$(id -g) composer-7.4 install
$ setfacl -R -m u:$USER:rwx -m u:82:rwx public/packages/uploads 
$ setfacl -Rd -m u:$USER:rwx -m u:82:rwx public/packages/uploads 
```

## Serviço

```
$ docker compose up -d server
```

O ambiente é servido no endereço http://localhost com um usuário `admin / admin`.

## Testes de aceitação

Os testes de aceitação ajudam a validar se as requisições da aplicação estão funcionando conforme esperado.

A construção dos testes é realizada utilizando [Codeception](https://codeception.com/) com o auxílio do [WPBrowser](https://github.com/lucatume/wp-browser). Os testes estão no diretório `tests`.

```
$ docker compose -f docker-compose.tests.yml up -d chrome
$ docker compose -f docker-compose.tests.yml run --rm codecept run
```
É possível que a execução possua um erro se o teste for rodado logo após levantar os serviços. Isso porque o banco de dados estará ainda inicializando.

```
Db: SQLSTATE[HY000] [2002] Connection refused while creating PDO connection
```

## Integração com VSCode

No projeto temos já configuradas as [extensões que recomendamos utilizar](.vscode/launch.json) e a [configuração de depuração do PHP](.vscode/launch.json).

## Ferramentas de apoio

### Xdebug

O projeto já está completamente integrado para rodar a [depuração com o VSCode](https://code.visualstudio.com/docs/editor/debugging) sem a necessidade de configuração extra. A depuração de código faz parte do nosso dia-a-dia e pode ser uma aliada para a resolução dos desafios propostos durante o teste.

### Padrão de código

Valida se o código está no padrão desejado.

O código segue o [padrão de código do WordPress](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/), ser compatível com a versão 8.2 do PHP e utilizar [`strict_types`](https://www.php.net/manual/en/language.types.declarations.php#language.types.declarations.strict).

A validação do código é feita através da ferramenta [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer).

```
$ docker compose run --rm -u $(id -u):$(id -g) phpcs
```

É possível aplicar correções automática utilizando o comando PHPCBF.

```
$ docker compose run --rm -u $(id -u):$(id -g) --entrypoint=phpcbf phpcs
```

### Tipagem

Valida se o código está utilizando tipagem em suas declarações. Isso reduz validações de tipo no meio do código, a quantidade de testes e de bugs.

A validação do código é feita através da ferramenta [PHPStan](https://phpstan.org/).

```
$ docker compose run --rm -u $(id -u):$(id -g) phpstan
```

## Usuários que não utilizam Linux e VSCode

Nossa preferência é rodar nossos projetos em ambiente Linux pela melhor integração com o Docker. Principalmente em relação a performance.

No caso do VSCode. Normalmente nossos desenvolvedores utilizam VSCode. Mas somos agnósticos a IDEs e nos adaptamos a IDE que cada pessoa se sinta mais produtiva.

Caso utilizará outro SO ou IDE para o teste, nos avise previamente para que possamos nos preparar. Os ajustes no ambiente será realizado antes do teste.
