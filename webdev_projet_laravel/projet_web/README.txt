PROJET : PLATEFORME DE MISE EN RELATION PRESTATAIRES (BIEN-ÊTRE)

Ce projet est une application Laravel tournant sous Docker (Sail).

Il permet de gérer des prestataires de services avec fiches signalétiques,
catégories et un espace d'administration.


INSTALLATION ET LANCEMENT (DOCKER SAIL)

Suivez ces étapes pour configurer le projet localement :

A. Récupération du projet :
git clone <URL_DE_VOTRE_DEPOT>
cd <NOM_DU_DOSSIER_DU_PROJET>

B. Configuration de l'environnement :
cp .env.example .env

C. Installation des dépendances (PHP) via Docker :
docker run --rm -u "

(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php82-composer:latest composer install --ignore-platform-reqs

D. Démarrage des conteneurs :
./vendor/bin/sail up -d

E. Initialisation de l'application :
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail artisan storage:link

F. Compilation du Frontend :
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev



COMPTES DE TEST ET JEUX DE DONNÉES


La base de données contient 6 catégories et 1 prestataire par ville
(Paris, Lyon, Marseille, Lille, Bordeaux, Bruxelles).

MOT DE PASSE UNIQUE : password123

ADMINISTRATEUR : admin@test.com

UTILISATEUR : user@test.com

PRESTATAIRE (Service du mois) : pro.massages-relaxants@test.com

PRESTATAIRE (Lyon) : pro.soins-energetiques@test.com

PRESTATAIRE (Marseille) : pro.yoga-meditation@test.com

STRUCTURE DU PROJET

ACCUEIL : Recherche par ville et catégorie.

ESPACE PRESTATAIRE : Gestion du Logo, Slider, TVA et Coordonnées.

ESPACE ADMIN : Validation des services et gestion des bannissements.

NOTES TECHNIQUES IMPORTANTES

Le dossier ".data/" est ignoré par Git (fichiers système MariaDB).

