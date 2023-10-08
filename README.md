# Gestão de PDFs

Projeto destinado para testes de pessoas desenvolvedoras.

## Instalação

```
$ mkdir -p ~/.docker_cache/{composer,wp-cli}
$ docker compose pull
$ docker compose build
$ docker compose run --rm -u $(id -u):$(id -g) composer install
```

## Serviço

```
$ docker compose up -d server
```

O ambiente é servido no endereço http://localhost com um usuário `admin / admin`.

## Integração com VSCode

No projeto temos já configuradas as [extensões que recomendamos utilizar](.vscode/launch.json) e a [configuração de depuração do PHP](.vscode/launch.json).

## Ferramentas de apoio

### Xdebug

O projeto já está completamente integrado para rodar a [depuração com o VSCode](https://code.visualstudio.com/docs/editor/debugging) sem a necessidade de configuração extra. A depuração de código faz parte do nosso dia-a-dia e pode ser uma aliada para a resolução dos desafios propostos durante o teste.

## Usuários que não utilizam Linux e VSCode

Nossa preferência é rodar nossos projetos em ambiente Linux pela melhor integração com o Docker. Principalmente em relação a performance.

No caso do VSCode. Normalmente nossos desenvolvedores utilizam VSCode. Mas somos agnósticos a IDEs e nos adaptamos a IDE que cada pessoa se sinta mais produtiva.

Caso utilizará outro SO ou IDE para o teste, nos avise previamente para que possamos nos preparar. Os ajustes no ambiente será realizado antes do teste.
