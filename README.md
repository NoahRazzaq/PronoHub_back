# Pronohub

Coter front du site Pronohub. Pronohub est un site de pronostic avec une charte graphique inspiré d'un certain site. 
Mention d'honneur a nos 4 développeur : Ismael, Noah, Alexis, Denis 

## Ordre d'installation des différentes parties du projet

- Back Office
- API
- Front

## Ordre de Run

- API:
    ```bash
    php bin/console doctrine:schema:update --force
    ```
    ```bash
    symfony serve
    ```
- Back Office:
    ```bash
    php bin/console doctrine:schema:update --force
    ```
    ```bash
    symfony serve
    ```
- Front:
    ```bash
    npm install
    ```
    ```bash
    npm start
    ```

# API De PronoHub

Assurez-vous d'avoir installé PHP et Symfony CLI avant de poursuivre.

## Installation

1. Clonez le projet depuis le dépôt Git :

    ```bash
    git clone https://github.com/NoahRazzaq/PronoHub_back.git
    ```

2. Installez les dépendances :

    ```bash
    cd PronoHub_back
    ```
    ```bash
    npm install
    ```

## Configuration de la base de données

1. Génération des clés nécessaire

Créez un dossier jwt dans le dossier config existant.
Il faut ensuite créer vos clés via ces commandes :

```bash
    openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa _keygen_bits:4096
```
```bash
    openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```

2. Paramétrage du .env.local

Par la suite, le .env.local doit etre le même que celui du back office. Dupliquez celui créé dans le back office ou le .env existant de l'api et modifiez-le afin qu'il fonctionne pour votre base de donnée.

Il est obligatoire de décommenter certaines informations afin de faire le lien entre l'application et la base de donnée. Voici les informations qui vous sont nécessaires : 
  ```bash
  ###> symfony/framework-bundle ###
  APP_ENV=***
  APP_SECRET=***********
  ###< symfony/framework-bundle ###

  DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8.0.32&charset=utf8mb4" (avec les modification permettant l\'accès à votre base de donnée)
  ```

N'oubliez pas d'y ajouter vos clés, vous devez avoir quelque chose commme ceci à la fin de votre .env.local : 
(la ligne "JWT_PASSPHRASE" contenant le mot de passe que vous avez rentré plus tot hashé)

  ```bash
  ###> lexik/jwt-authentication-bundle ###
  JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
  JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
  JWT_PASSPHRASE=f7c11c58e4cb9488a31bad8ce6b4a1885c9b8053e661b6dd2bbeba146b10fa15
  ###< lexik/jwt-authentication-bundle ###
  ```

3. Mettre à jour la base de donnée

Ayant fait la création de la base de donnée via le back office, il vous faut faire une update de celle-ci via l'API : 

```bash
    php binn/console d:s:u --f
```

## Lancement de l'application 

Il est important de lancer l'API avant le back office, sinon il faudra que vous modifiez les ports dans le .env.local afin que ceux-ci correspondent. 

Pour lancer l'API : 

```bash
    symfony serve
```

Si tout est bien paramétré tout devrait fonctionner ! (en ajoutant '/api' dans l'URL de votre localhost vous pouvez voir des routes classiques disponible généré par API Platform) 



