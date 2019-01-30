# Re-création de l'exercice Restaurant vec Symfony

> La méthodologie expliquée ici fonctionne jsqu'à Symfony 3.4
>
> Avec Symfony 4, qui est basé sur une nouvelle architecture appelée Flex, lescommandes ne sont plus les mêmes et la structure des dossiers change. Néanmoins, le rpincipe de fonctionnement de Symfony reste identique (MVC, bundles, etc.)
>
> Dans ce qui suit, les notations `<quelque_chose>` indiquent des valeurs variables.

## 1. Installation de Symfony 3.4

```shell
composer create-project symfony/framework-standard-edition <dossier>
```
Composer est le gestionnaire de dépendances de PHP. il crée le dossier `<dossier>` et installe à l'intérieur toutes les ressources du package `symfony/framework-standard-edition`.

## 2. Paramètres de l'application
Lors del'exécution de `create-project` le script pose quelques questions à l'utilisateur dont les principales concernent l'accès à la base de données. Tous les paramètres peuvent être ensuite chnagé très facilement en modifiant le fichier :
```shell
app > config > parameters.yml
```
Dès que le code duy framework est installé, l'application fonctionne et il est possiblede consulter la page d'accueil depuis le navigateur :
```shell
http://<domaine.tld>/<dossier-racine>/web/app_dev.php
```

## 3. Création de la base de données
La création de l'application se fait par la ligne de commande en utilisant la console de Symfony :
```shell
$ ./bin/console
```
En exécutant cette simple igne, vous pouvez voir toutes les commandes comprises par la console. Il est possible de consulter la documentation de chaque commande avec l'option `--help`
```shell
$ ./bin/console <commande> --help
```
Pour créer la base de données (dont le nom est dans le fichier `parameters.yml`), on utilise la commande :
```shell
$ ./bin/console doctrine:database:create
```
dont le rôle consiste simplement à créer la base MySQL et rien d'autre.

## 4. Création du modèle
La base étant créée, la tâche suivante est d'implémenter le `modèle conceptuel des données` que l'on aura préparé auparavant grâce des diagrammes **UML** ou autres.

Le modèle est constitué d'**entités**. Globalement, on parle pour cetype d'architecture d'un **modèle entité/relation**.

On utilise la commande :
```shell
$ ./bin/console doctrine:generate:entity
```
D'une manière générale les commandes assez bien documentées et il est **fortement** recommandé de lire et de respecter **strictement** ce qui est indiqué à l'écran.

Par ce script interactif, vous allez décrire toutes les caractéristiques de votre entité, qui correspondent exactement aux propritété de la classe PHP qui sera créée. De plus, on demande quelques informations (type, nullable, unique, etc.) qui serviront pour la table de la base de données.

**N.B.** : Pour les clefs étrangères, à ce stade, on les définit provisoirement avec le type 'object' ou, encore mieux, on les ignore simplement.

> Une entité a toujours deux faces : la face 'objet' (PHP) et la face 'relationnelle' (SQL).
>
> Ces deux faces sont correspondent à deux syntaxes différentes pour parler de la même chose : Les objets sont manipulés dans le programme et les relations dans la base. Le rôle de Symfony est de maintenir l'interopérabilité de ces des représentations, afin qu'un objet puisse est facilement convertie en un enregistrement MySQL et inversement.

Le script est interactif et il suffit de répondre aux questions *(souvent en laissant la valeur par défaut, qui suffit)*. La seule question sensible est le format de configuration, pour lequel je conseillerais de choisir soit `yml` (plus léger), soit `xml` (plus robuste), mais ça n'est pas crucial.

Si vous choisissez le format de configuration `annotation`, tout est intégralemnent fait pour vous. Si vous choisissez un autre format, Symfony 3 vous indiquera qu'il n'a pas pu terminer la création de l'entité. Vous voyez s'afficher 3 lignes de code :
```yaml
app_xxx:
  resource: @
  prefix: '/'
```
Vous devrez copier ces trois lignes à la fin du fichier :
```shell
app > config > routing.yml
```
qui est le fichier de configuration de toutes les routes disponilbes dans l'application *(donc essentiel)*

A la suite de ce processus, Symfony vous indique qu'un certain nombre de fichiers ont été créés :
* une classe pour représenter l'entité
* une classe pour le modèle de l'entité (les futures requêtes SQL)
* une classe de contrôleurs
* etc. (liste comlète à l'écran)

## 5. Création des tables SQL
Chaque entité *(i.e. classe PHP)* a un pendant dans la base qui est une table SQL (qui portera le même nom que l'entité à quelques variations typographiques près). Une fois l'étape 4 achevée, on peut créer le **schéma relationnel** de la base avec la commande :
```shell
$ ./bin/console doctrine:schema:create
```
Cette commande n'est exécutée qu'une seule fois.

## 6. Le cas des relations 1~n et des clefs étrangères.
Le fichier de description de référence des entités se trouve dans le dossier (le fichier est ici au format YAML) :
```shell
src > Appbundle > Resources > config > doctrine > <entity>.orm.yml
```
Le processus décrit précédemment ne crée que les propriétés simples. Si l'on veut lier les entités entre elles (un plat à une catégorie ou une commande à un client), on doi faire cela manuellement.

A la même indentation que la section 'fields', il faut ajouter une section `manyToOne` dans laquelle seront décrites toutes les relations. Ici un exemple pour lier une commande (Order) à un client (User) :
```yaml
manyToOne:
  userID: # Nom de la propriété de l'entité (Ordrer) --> clef étrangère
    targetEntity: User # L'entité liée
    joinColumn:
      name: user_id # nom de la colonne correspondante dans la table SQL 'order'
      referencedColimnName: id #  la colonne liée dans la table 'user' (i.e. la clef primaire de cette table)
      nullable: false
```
Une fois toutes les liaisons ajoutées, il faut régérérer le modèle, qui qui se fait en trois temps :
```shell
$ ./bin/console doctrine:generate:entities Appbundle
$ ./bin/console doctrine:schema:update --dump-sql
$ ./bin/console doctrine:schema:update --force
```
* La première commande met à jour les classes PHP et lde code de l'application
* La seconde vous permet de visualiser les requêtes de de modification de la base MySQL (mais ne fait rien)
* La troisième effectue véritablement la mise à jour de la base

**N.B.** Ce processus de modification des entités et de la base de données peut être effectuer indéfiniment et sans risque, pour supprimer, ajouter, modifier des propriétés/colonnes.

## 7. Engendrement du squelette de l'application
Maintenant que le modèle est prêt, on aimerait pouvoir jouer avec et utiliser les fonctionnalités de base de l'application, ce qu'on appelle couramment le CRUD.
```shell
$ ./bin/console doctrine:generate:crud Appbundle:<entity>
```
Cette commande crée toutes les ressources PHP/HTML nécessaires à la manipulation de basedes données.

## 8. Jouer avec l'architecture MVC

### a) Créer une route

Créer une route (toujours en utilisant le format YAML) se fait donc via les fichiers de routage qui ont été créés par Symfony dans les étapes précédentes et qui se trouvent dans le dossier :

```shell
$ cd src/AppBundle/Resources/config/routing
$ more <entity>.yml
```
> Pour être fonctionnel, le fichier `<entity>.yml` doit être déclaré dans le fichier de routage principal qui est dans le dossier app > config

Une route se définit ainsi :
```yaml
# Le nom de la route
meal_show:
  # Le schéma de la route
  # LEs noms entre accolades représentent des valeurs variables
  path:     /meal/{_locale}/{id}/{_format}
  # Eventuellement des valeurs par défaut
  # _controller indique quelle est la méthode associée à la route
  defaults: { _controller: AppBundle:Meal:show, _format: html }
  # Eventuellement des contraintes sur les variables de l'URL
  requirements:
      _locale:  en|fr
      _format:  html|json
      id:     \d+
```
On a maintenant une route complètement opérationnelle, à condition que le contrôleur associé existe.

### b) Définir le contrôleur
Les classes de contrôleurs sont elles aussi dans un dosseir spécifique :
```shell
$ cd src/AppBundle/Controller
$ more Mealcontroller.php
```
Comme on le voit, leur nom a un format contraint : `<Name>Controller.php`.
Les noms des méthodes (ou contrôleurs dans ce cas) associées aux routes ont elles aussi des contraintes de nommage : `<methode>Action`.
Ainsi dans pour l'exemple de la section précédente, on derit trouver dans une classe `MealController`, une fonction :
```php
  public function showAction(Request $request, int $id)
  {
    // code ...
  }
```
où `$request` contient toutes les données de la requête HTTP et `$id` est la variable définie dans la route (avec le même nom).

Le contrôleur est chargé de lancer la construction de la vue comme dernière étape du cycle d'exécution. Il y a deux syntaxes pour cela :
* Utiliser une annotation dans “docblock” de la méthode :
```php
// @Template("<chemin-ou-alias-du-template>")
```
Le contrôle se cntente de retourner un tableau (associatif) de toutes les variables utilisées dans la vue
* Utiliser la méthode `render`
```php
 return $this->render('<chemin-ou-alias-du-template>', $variables)
```

### c) Contruire la présentation dans la vue

#### 1) Twig
Symfony utilise (entre autres mais de manière privilégiée) le moteur de templating **Twig**.

Les éléments de base de la syntaxe Twig :

* Afficher une variable : **{{ x }}**
* Ajouter un modificateur à une variable : **{{ x | upper}}**
* Charger une ressource web : **{{ asset('bundles/<chemin-de la-ressource>') }}**
* Insérer des directives : **{% if X > 0 %} ... {% endif %}**
* Include un fragemnt de page : **{% include '<fragment>.html' with {'x': 10} %}**
* Définir un bloc : **{% block lateral %}{% endblock %}**
* Utiliser un “layout” pour la page **{% extends '<chemain-ou-alias-du fichier>'%}**
* Appeler un contrôleur

#### 2) Les ressources
Les “ressources web”, scripts JS,feuilles de styles CSS, images, etc. sont mises dans un dossier `public` à l'interieur du dossier `Resources`du *bundle*. A l'intérieur de ce dossier – reconnu par Symfony – l'arborescence des sous-dossiers est libre.

La racine de l'espace public du site est :
```shell
$ cd web
```
Pour transférer les ressources du bundle vers cet espace public, il existe une commande :
```shell
$ ./bin/console assets:install
```
Si ce n'est pas fait, Symfony crée alors un dossier `bundles`.
```shell
$ cd web/bundles
```

#### 3) Les vues (templates)
Les fichiers twig pour les vues peuvent être écrites à deux endroits différents :
1. le répertoire par défaut ans le bundle
```shell
$ cd src/AppBundle/Resources/views
```
A l'intérieur du dossier `views`, l'organisation est arbitraire.

1. le répertoire générique de Symfony, qui permet de “surcharger” des vues existantes
```shell
$ cd app/Resources/views
```


### d) Dialoguer avec le modèle

#### 1) Le manager d'entité
Lorsque l'on veut accéder au modèle, il faut appeler le manager d'entités :
```php
# Si c'dst dans un contrôleur :
$em = $this->getDoctrine();
```

#### 2) Les méthodes par défaut
Doctrine fournit pour chaque entité une série de méthodes :
```php
# Le manager d'entités permet d'accéder aà la classe de requêtes de l'entité en cours
$rep = $em->getRepositoty();

# Trouver un objet par son id
$entity = $rep->find(5);

# Trouver un objet par la valuer d'une (ou plusieurs) propriété(s)
$entities = $rep->findBy(['stock' => 0]);
$entities = $rep->findBy(['stock' => 0], ['category' => 1]);

# Alternative
$entities = $rep->findByStock(0);

#Trouver le premier objet
$entity = $rep->findOneBy(['stock' => 0]);
```

#### 3) Utiliser les classes “Repository”
Pour les requêtes plus complexes, il devient nécessaire de construire ses prompres méthodes de requête.
