# About

Repository for evaluating and integration of [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer)/[PHPCS Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) rule sets into [easy-coding-standard](https://github.com/easy-coding-standard/easy-coding-standard).

# Features

- dockerized development environment

- batteries included (PHP, Composer, PHP-CS-Fixer, PHPCS, easy-coding-standard)

- xdebug enabled by default (vscode launch configuration + xdebug configuration in dockerized PHP)

# Prerequisites

- Docker

- vscode

# Usage

- clone this repository

- open the repository in vscode

- run `pnpm build` to build the dockerized development environment

- run `pnpm start` to go into the dockerized development environment

  - set a breakpoint in vscode and start the provided 'xdebug' launch configuration
  
  - start a php program in the docker container

  And voilà, you can debug your PHP program in vscode. 


