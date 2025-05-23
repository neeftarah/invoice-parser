# Rappel des informations fournies :
## 📌 Consignes :

1. Fork le projet suivant : https://github.com/novalend/invoice-parser
2. Analyser le code pour identifier les améliorations possibles et le rendre le plus "clean" possible.
3. Améliorer le code autant que possible dans une limite d’environ 1 heure.
4. Créer une Pull Request (PR) avec vos modifications.
5. Décrire dans la PR les améliorations réalisées et proposer des optimisations supplémentaires qui n'ont pas pu être implémentées par manque de temps.
6. Nous envoyer le lien de la PR une fois terminée.


## 🔎 Objectif :
Le projet consiste à lire des fichiers contenant des lignes de factures, avec des extensions et formats potentiellement différents. L’enjeu est de réfléchir à une implémentation scalable et maintenable.

---

# Actions réalisées

- Ajout d'une CI avec execution des tests unitaires, des tests statiques (PSR, etc.)
- Correction de la présentation du code (installation et execution de PHP-CS-Fixer + revue manuelle)
- Ajout de commentaires et descriptions
- Ajout du maker Bundle pour simplifier la création de nouveau code et de migrations
- Ajout d'une colonne "date" à la table facture pour y stocker l'information et garder une trace des modifications
- Refactoring massif du parser :
    - Séparation des responsabilités : parsing, mapping, persistance.
    - Implémentation du pattern Strategy + Factory pour les parseurs CSV / JSON.
    - Ajout du typage partout où c'est possible
    - Ajout d'exception personnalisé et gestion des erreurs
- Ajout de tests unitaires pour les parseurs et factory

---

# Amélioration possible par la suite

Le temps imparti étant assez court et le context/échange limité, beaucoup d'autres améliorations sont possibles...

## Voici quelques améliorations auxquelles je pense :

- Ajout d'un mapping objet (DTO) aux parser afin de structurer les données
- Ajout de vérifications des données (Montants numériques et cohérents, date valide, devises supportées, etc.)
- Ajout de plus de parseurs (XML, YAML, etc.)
- Test fonctionnels
- Amélioration de la commande et des retours de celle-ci
- Améliorer la documentation, le README, un CHANGELOG
- Meilleure validation des fichiers (types MIME, format, scan antivirus, etc.)
- Ajout d'un "vrai" système de log...
  ==> Je n'ai pas retoucher ce point, mais actuellement les erreurs sont simplement affichées. Il serais judicieux d'ajouter un système de log (Monolog) pour conserver les trace de ce qui est fait. L'ajout d'un système centralisé (comme Sentry) permettrait également de visualiser / rechercher simplement dans les logs.
- Gestion des secrets (actuellement tout est versionner en clair = KO pour de la prod)

## D'autres amélioration que j'ai écartées car elles me paraissaient hors contexte, mais à réfléchir :

- Structure DDD ou architecture hexagonale
  ==> Trop lourde et complexe pour un projet de test aussi simple, mais pourrait être pertinent dans un gros projet
- configuration/chargement des fichiers / dossiers
  ==> Les fichiers sont chargé en dur pour le test, ce n'est pas top du tout... Néanmoins, sans plus de contexte, nous pourrions partir dans diverse solutions selon le contexte. Quelques exemples :
  - Ajout du fichier en configuration pour un chargement unique type batch journalier
  - Parsing d'un dossier complet pour un dépôt de factures clientes
  - Passage du chemin du fichier en paramètre pour une execution cron ou API
- Ajout d'interface API ou WEB pour visualiser les données, charger un nouveau fichier, etc.
- Modification du traitement en utilisant un système de messages asynchrones (RabbitMQ) pour paralléliser les traitements (/!\ ATTENTION à la surcharge de la BDD)

et sans doute bien d'autres...