
# Framework PHP AM/GB 🚀

![Version](https://img.shields.io/badge/Version-1.0.0-brightgreen)

![PHP](https://img.shields.io/badge/PHP-7.0%2B-blue)

O framework tem como objetivo otimizar, qualificar e padronizar o desenvolvimento 
afim de gerar melhores projetos e reduzir tempo e índices de manutenibilidade dos códigos.

Atualmente é possível utilizar o framework nos servidores com php 7+

## Documentação

Em nossa documentação está descrito como utilizar cada uma das funcionalidades, 
o passo a passo de instalação de libs javascript e outros.


[Clique aqui](https://link-da-documentação) para visualizar a documentação do projeto


## Instalação

Para que possamos levar o projeto para a estação de trabalho, é necessário ter o git instalado e também estar autenticado no gitlab.

Verifique se suas configurações de proxy estão atualizadas e configuradas para obter o repositório.

```git
    git clone http://172.30.0.94:8888/amsted-development-team/framework.git
```

Após o clone do repositório, é necessário remover a pasta .git (pasta oculta) 
para que quando utilizar o versionamento, o repositório do framework não seja atingido.
    
## Atualização de dependências

Após obter o framework para sua estação de trabalho, 
é necessário baixar as dependências do projeto, 
tais como Plates, Dumper e outras. 
Para isso é necessário ter o composer instalado e executar o seguinte código

```bash
  composer update
```


## Variáveis de Ambiente

Para rodar o seu projeto, você vai precisar adicionar as seguintes variáveis
 de ambiente no seu env.php

`define('URL_BASE', "{$_SERVER['HTTP_HOST']}/amsted/project-name");`

É de extrema importância esta variável, pois ela é utilizada em conjunto com 
o sistema de roteamento da aplicação além de ser a base dos helpers

## Demonstração
A abaixo está presente a interface inicial da aplicação, a qual é renderizada pelo `HomeController` e que pode ser alterado quando quiser ou excluído.
![Demonstration](http://172.30.0.94/amsted/framework-documentation/assets/images/initial_1.png)
