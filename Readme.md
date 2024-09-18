# Tigrino Framework

[![Build Status](https://app.travis-ci.com/Tigrino22/Framework.svg?token=FPUmKFe4CQMxCyKoJYqM&branch=main)](https://app.travis-ci.com/Tigrino22/Framework)

Bienvenue dans le **Tigrino Framework**, un framework PHP léger et flexible conçu pour vous aider à développer des applications web avec facilité.

## Table des Matières

- [Introduction](#introduction)
- [Installation](#installation)
- [Configuration](#configuration)
  - [Configuration du Framework](#configuration-du-framework)
- [Création de Modules](#création-de-modules)
- [Commandes](#commandes)
- [Exemple d'Utilisation](#exemple-dutilisation)
- [Contribution](#contribution)
- [Licence](#licence)

## Introduction

Le Tigrino Framework est conçu pour être simple à utiliser tout en étant puissant et extensible. Il fournit une base solide pour le développement d'applications web, avec une structure modulaire et des outils flexibles.

## Installation

Pour installer le Tigrino Framework via Composer, exécutez la commande suivante :

```bash
composer require tigrino/tigrino-framework
```

## Configuration

### Configuration du Framework

Après avoir installé le framework, vous devrez configurer certains aspects pour l'adapter à votre projet.

1. **Copie des Fichiers de Configuration**

   Copiez les fichiers de configuration par défaut du framework dans le dossier `Config/` ainsi que le fichier `index.php` du dossier `Public/` de votre projet :

   ```bash
   ./vendor/tigrino-framework/bin/config-project
   ```

   Vous pouvez maintenant personnaliser les fichiers du dossier Config/ en fonction de vos besoins.

   Assurez-vous que le serveur web est configuré pour utiliser ce fichier comme point d'entrée.

## Création de Modules

Le Tigrino Framework permet la création facile de modules. Pour créer un nouveau module, utilisez la commande suivante :

```bash
./vendor/tigrino-framework/bin/create-module NomDuModule
```

Cela créera la structure de base du module dans le dossier `src/`, y compris les fichiers de configuration, contrôleurs, entités, et plus encore.

## Commandes

Voici quelques-unes des commandes disponibles avec le Tigrino Framework :

- `./vendor/tigrino-framework/bin/create-module [NomDuModule]` : Crée un nouveau module avec la structure de base.
- `./vendor/tigrino-framework/bin/start-server` : Démarre le serveur de développement intégré.

## Exemple d'Utilisation

Voici un exemple rapide de configuration et d'utilisation du framework :

1. **Créer un Nouveau Module**

   ```bash
   ./vendor/tigrino-framework/bin/create-module Blog
   ```

2. **Configurer les Routes**

   Éditez le fichier `Config/Routes.php` pour ajouter les routes spécifiques à votre module.
   Il existe plusieurs niveaux de routes, celui à la racine dans le `./Config/Routes.php`.
   Mais également au sein de vos propres modules.

3. **Développer votre Application**

   Développez vos contrôleurs, modèles, et autres composants dans le dossier `src/` comme nécessaire.

## Contribution

Les contributions sont les bienvenues ! Si vous souhaitez contribuer au Tigrino Framework, veuillez consulter les [guidelines de contribution](CONTRIBUTING.md) pour plus d'informations.

## Licence

Ce projet est sous la licence [MIT](LICENSE).
