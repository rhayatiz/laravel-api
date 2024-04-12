##### Requirements
- php 8.2
- composer 2.5.8+


##### Notes
- La génération des tokens est gérée par Laravel Sanctum, certaines routes nécessitent une authentification par le biais du token (Bearer $token) qui doit être spécifié dans le header de la requête avec le nom 'Authorization'

##### Guide

- Installer les dépendances ```composer install```
- Créer les liens symboliques pour l'upload des fichiers ```php artisan storage:link```
- Configurez les identifiants de base de données dans .env, ou utilisez la configuration par défaut avec une base de données sqlite ```touch ./database/database.sqlite```
- Définir les identifiants administrateur dans votre fichier .env ```APP_ADMINISTRATEUR_EMAIL``` et ```APP_ADMINISTRATEUR_PASSWORD```
- Lancer les migrations et populer la base de données```php artisan migrate:fresh --seed```
- Les tests sont versionnées avec l'attribut Group de PHPUnit ```php artisan test --group apiv1  ```




## API 
| Route | Method | Description | Authentification | Champs nécessaires
| ------ | ------ | ------ | ------ | ------ |
| /api/v1/auth | GET | Authentification administrateur et génération du token | - | ```email: string``` <br/> ```password: string``` |
| /api/v1/auth | DELETE | Suppression des tokens | - | - |
| /api/v1/profil | GET | Retourne la liste des profils | - | - |
| /api/v1/profil/{id} | GET | Retourne le profil avec l'id spécifié| - | - |
| /api/v1/profil | POST | Créer un profil | Oui | ```nom: string``` <br/> ```prenom: string``` <br/> ```statut: string [en attente, inactif, actif]``` <br/> ```image: fichier (jpg, jpeg, png, bmp, gif, svg, or webp)``` |
| /api/v1/profil/{id} | POST | Modifier le profil | Oui | Au moins un champ <br/> ```nom: string``` <br/> ```prenom: string``` <br/> ```statut: string [en attente, inactif, actif]``` <br/> ```image: fichier (jpg, jpeg, png, bmp, gif, svg, or webp)```  |
| /api/v1/profil/{id} | DELETE | Supprime le profil specifié | Oui | - |

