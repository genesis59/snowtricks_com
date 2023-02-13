secrets:generate-keys
# snowtricks_com [![Codacy Badge](https://app.codacy.com/project/badge/Grade/031726461c12457dbfab0c0a13228764)](https://www.codacy.com/gh/genesis59/snowtricks_com/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=genesis59/snowtricks_com&amp;utm_campaign=Badge_Grade)
## Environnement de développement
### Prérequis
* git https://git-scm.com/downloads
* composer https://getcomposer.org/
* PHP 8
* Symfony CLI https://github.com/symfony-cli/symfony-cli
### Installation du projet
1. Cloner le projet à l'aide de la commande git clone via HTTPS:
   ```bash
   git clone https://github.com/genesis59/snowtricks_com.git
   ```
   ou par SSH nécessite que votre clé SSH soit configurée sur GitHub
   ```bash
   git clone git@github.com:genesis59/snowtricks_com.git
   ```
   puis entrez dans le projet
   ```bash
   cd snowtricks_com
   ```
   
2. Variables d'environnement
    * Renseignez avec vos données les variables d'environnement DATABASE_URL et MAILER_DSN dans le fichier .env
3. Installer les dépendances PHP :
    ```bash
    composer install
    ```
4. Installer les dépendances JS :
    ```bash
    yarn install --force
    ```
5. Pour configurer une base de données locale :
    ```bash
    symfony console doctrine:database:create
    symfony console doctrine:migrations:migrate
    symfony console doctrine:fixtures:load
   ```
***
5. Pour lancer le serveur PHP depuis la racine du projet
   ```bash
   symfony serve
   ```
<p>
    <a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img style="border:0;width:88px;height:31px"
            src="http://jigsaw.w3.org/css-validator/images/vcss"
            alt="CSS Valide !" />
    </a>
   <a href="http://jigsaw.w3.org/css-validator/check/referer">
       <img style="border:0;width:88px;height:31px"
           src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
           alt="CSS Valide !" />
    </a>
</p>