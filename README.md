# Travailler sur le projet en local

  - ### Installer et configurer MAMP
    - Installez [MAMP](https://www.mamp.info/en/downloads) à l'emplacement par défaut et en décochant l'installation des programmes additionnels _MAMP PRO_ et _Apache Bonjour_.
    - Spécifiez la version 8.1.0 dans _MAMP > Préférences > PHP_ et redémarrez le serveur.
    - Activez l'affichage des erreurs PHP en indiquant `display_errors = on` dans <a href="C:\MAMP\conf\php8.1.0\php.ini">php.ini</a> à la ligne `374`.
    - Glissez le projet dans <a href="C:\MAMP\htdocs">htdocs</a>.
    >   MAMP permet de facilement mettre en place un serveur PHP Apache et MySQL sous l'interface phpMyAdmin.
  
  - ### Insérer les tables dans la base de données
    - Ouvrez <a href="http://localhost/Stageo/assets/php/database.php">database.php</a> et collez le texte dans <a href="http://localhost/phpMyAdmin/index.php?route=/server/sql">phpMyAdmin > SQL</a>
  
Accédez au site après avoir lancé le serveur MAMP depuis ce [lien](http://localhost/Stageo)

# Travailler sur le projet à distance

  - ### Installer et utiliser FileZilla
    - Installez [FileZilla](https://filezilla-project.org/download.php)
    - Ajoutez une nouvelle connexion depuis _File > Site Manager > New site_. Remplissez le formulaire avec les informations suivantes:
      - **Protocol:** `SFTP - SSH File Transfer Protocol`
      - **Host:** `ftpinfo.iutmontp.univ-montp2.fr`
      - **Logon Type:** `Ask for password`
      - **User:** `riosq`
      - **Password:** `04092023`
  
    Accédez au site après avoir lancé le serveur MAMP depuis ce [lien](https://webinfo.iutmontp.univ-montp2.fr/~riosq/Stageo). Double-cliquez sur les fichiers à transférer sur le dépôt à distance. Pour plus facilement 
    naviguer, vous pouvez activer l'option _View > Synchronized browsing_ en vous mettant au même répertoire des 2 côtés.
    > FileZilla est un programme qui permet de gérer des dépôts sous forme d'un explorateur de fichier en se connectant en FTP à des clients.

# Modifier le style du projet

> Nous utilisons ici Node.js pour gérer des dépendances JavaScript qui offrent plus de fonctionnalités notamment sur les fichier CSS.
- Installez [Node.js](http://nodejs.org/en/download).
- Executez la commande suivante pour installer les dépendances spécifiées dans [package.json](package.json).
```bash
npm install
```
- Installez le plugin [Tailwind CSS](https://tailwindcss.com/docs/installation) depuis _Paramètres > Plugins_ pour bénénificier des suggestions de complétions.*
- Executer la commande suivante à chaque redémarrage de l'IDE pour activer l'auto-compilation du fichier [main.pcss](assets/css/main.pcss) en [main.css](assets/css/main.css).
```bash
npx postcss assets/css/main.pcss -o assets/css/main.css -w
```

# Ajouter une fonction dans le projet

- Indiquez le nom de la route dans [RouteName](src\Lib\enums\RouteName.php) afin de bénéficier de l'auto-complétion.
```php
case SIGN_IN_FORM = "signInForm";
case SIGN_IN = "signIn";
```
- Ajouter les informations de route dans le tableau `$routes` de la fonction getRoutesCollection dans [Router](src\Lib\Router.php).
  - **path:** Chemin vers l'action. Mettez les arguments entre accolades, rajoutez un `?` si l'argument est optionnel.
  - **defaults:** Fonction du controller à appeler au format _[callable](https://www.php.net/manual/fr/language.types.callable.php)_.
  - **methods:** Méthode `GET` ou `POST` dans le cas où 2 routes se partage le même chemin (optionnel).
```php
[
  "name" => RouteName::SIGN_IN_FORM,
  "route" => new Route(
    path: "/sign-in/{email?}",
    defaults: ["_controller" => [UserController::class, "signIn"]],
    methods: "GET"
  )
],
[
  "name" => RouteName::SIGN_IN,
  "route" => new Route(
    path: "/sign-in/{token}",
    defaults: ["_controller" => [UserController::class, "signInForm"]],
    methods: "POST"
  )
]
```

- Ajoutez une fonction dans le [controller](src/Controller) correspondant en passant en paramètres variables avec lesquelles l'action du controller est appelé (voir `path` de la route correspondante). Un action d'un controller doit toujours retourner un [ControllerResponse](src/Controller/ControllerResponse.php) demandant les paramètres suivants, 1 seul des 2 premiers doit être spécifié:
  - **template:** Chemin vers une vue Twig à afficher.
  - **redirection:** Un [RouteName](src\Lib\enums\RouteName.php) si la fonction doit plutôt rediriger vers une autre route.
  - **statusCode:** Un [StatusCode](src\Lib\enums\StatusCode.php) adapté à renvoyer au client (par défaut `StatusCode::OK`).
  - **params:** Un tableau associatif de paramètres optionnels qui seront passé à la vue Twig, ou dans l'URL de la route redirigée.
```php
public function signInForm(string $email = null): ControllerResponse
{
    UserConnection::signOut();
    //affiche la vue sign-in.html.twig et lui passe des variables
    return new ControllerResponse(
        template: "user/sign-in.html.twig",
        params: [
            "token" => Token::generateToken(RouteName::IDENTIFIER_SIGN_IN_FORM)],
            "email" => $email
        ]
    );
}

public function signIn(string $token): ControllerResponse
{
    if (!Token::verify($token)) throw new InvalidTokenException();
    $user = $this->repository->getByEmail($_POST["email"]);
    if (Password::verify($_POST["password"], $user->getHashedPassword())
        //redirige en arrière avec un message flash et passe $email en paramètre
        throw new ServiceException(
            message: "L'adresse mail ou le mot de passe est incorrect.",
            redirection: RouteName::SIGN_IN_FORM,
            params: ["email" => $email]
        );
        
    UserConnection::signIn($user);
    //redirige vers la page d'accueil
    return new ControllerResponse(
        redirection: RouteName::HOME
    );
}
```

# Utiliser les [repository](src/Model/Repository)

> Les attributs des [objets](src/Model/Object) sont fortement reliés à la base de données _(ils doivent exactement le même nom d'ailleurs)_.
Tous les [repository](src/Model/Repository) hérite de [CoreRepository](src/Model/Repository/CoreRepository.php), ils ont donc accès aux fonctions select(), insert(), update() et delete().
- ### Select

La fonction select() pour récupérer des objets depuis la base de données demande une instance de [QueryCondition](src/Lib/Database/QueryCondition.php), cet objet réalise l'équivalent de "**WHERE $column $comparisonOperator $value**".

```php
//retourne un tableau d'objet étudiant
(new EtudiantRepository)->select(
    new QueryCondition(
        column: "login",
        comparisonOperator: ComparisonOperator::EQUAL,
        value: $login
    )
);
```
Des fonctions dans les [repository](src/Model/Repository) peuvent être préfaite pour les attributs souvent utilisé (ceux en clé primaire ou unique) pour récupérer les objets depuis la base de données peuvent remplacer le code précédent par facilité:
```php
//retourne l'objet de l'étudiant ayant $login comme login 
(new EtudiantRepository)->getByLogin($login);
```

- ### Insert

Vous pouvez insérer directement les instances d'objet dans la base de données grâce à la fonction insert(). La grande majorité des attributs peuvent être `null`, ces attributs seront ignoré lors de l'insertion et prendront la valeur par défaut (souvent NULL).
```php
//retourne l'id de l'objet venant d'être inséré, ou false en cas d'erreur
(new EtudiantRepository)->insert(
    new Etudiant(
        login: $login,
        hashed_password: Password::hash($password)
    )
);
```
Tous les objets héritent tous de [CoreObject](src/Model/Object/CoreObject.php), c'est grâce à cette classe que CoreRepository peut récupérer les noms des attributs des objets.

- ### Update
La fonction update() utilise à la fois une instance de [CoreObject](src/Model/Object/CoreObject.php) et une de [QueryCondition](src/Lib/Database/QueryCondition.php). Utiliser une instance de [NullDataType](src/Lib/Database/NullDataType.php) pour mettre la valeur en base de données à NULL. Car les attributs avec la valeur `null` sont tout simplement ignorés.
```php
//met le prénom à NULL et donne la civilité F
//à tous les étudiants ayants un téléphone commençant par 06
(new EtudiantRepository)->update(
    object: new Etudiant(
        prenom: new NullDataType(),
        civilite: 'F'
    ),
    condition: new QueryCondition(
        column: "telephone",
        comparisonOperator: ComparisonOperator::LIKE,
        value: "06%"
    )
);
//retourne un bool selon la réussite de l'update
```

- ### Delete
La fonction delete() utilise tout simplement une instance de [QueryCondition](src/Lib/Database/QueryCondition.php) pour supprimer des données.
```php
//supprime tous les étudiants mâles de la base de données 
(new EtudiantRepository)->delete(
    QueryCondition("civilite", ComparisonOperator::EQUAL, 'M');
);
//retourne un bool selon la réussite de la suppression
```