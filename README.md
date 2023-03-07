# webastrio
**CRUD des Personnes avec Symfony et OpenAPI**
Ce projet Symfony est une application CRUD simple pour la gestion de personnes, utilisant des endpoints OpenAPI. Le code est disponible sur https://github.com/doric/webastrio.

Voici un bref aperçu du contenu du dépôt et de l'utilisation du code:

Dossiers et fichiers
src/: Ce dossier contient le code source du projet, notamment les contrôleurs, les entités et les services.
config/: Ce dossier contient les fichiers de configuration du projet, y compris la configuration de la base de données et de routage.
public/: Ce dossier contient les fichiers accessibles publiquement pour le projet, tels que les images, les fichiers CSS et JavaScript.
openapi.yaml: Ce fichier contient la spécification OpenAPI pour le projet, y compris les points de terminaison pour créer, lire, mettre à jour et supprimer des personnes.
Utilisation du code
Pour utiliser le code, vous devrez cloner le dépôt et installer les dépendances à l'aide de Composer. Une fois que vous avez installé les dépendances, vous pouvez exécuter le projet en utilisant le serveur web intégré de Symfony en exécutant la commande symfony server:start.

Les points de terminaison OpenAPI pour la gestion de personnes peuvent être accessibles via une API RESTful. Les points de terminaison disponibles sont :

- GET /api/personnes: Récupérer une liste de toutes les personnes enregistrées, triées par ordre alphabétique et avec leur âge actuel.
- POST /api/personne: Créer une nouvelle personne. Attention, seules les personnes de moins de 150 ans peuvent être enregistrées, sinon une erreur sera renvoyée.
Vous pouvez interagir avec ces points de terminaison en utilisant un outil comme Postman ou en effectuant des requêtes HTTP directement depuis votre code.

Il convient de noter qu'il peut être nécessaire de configurer une base de données ou de configurer l'authentification pour utiliser le projet. Malheureusement, sans plus d'informations ou de documentation, il est difficile de fournir un README plus détaillé.

Si vous avez des questions ou des problèmes avec le code, vous pouvez envisager de contacter le mainteneur du projet pour obtenir de l'aide supplémentaire.
