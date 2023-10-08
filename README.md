# Travailler sur le projet en local

  - ### Installer et configurer MAMP
    - Installez [MAMP](https://www.mamp.info/en/downloads) à l'emplacement par défaut et en décochant l'installation des programmes additionnels _MAMP PRO_ et _Apache Bonjour_.
    - Activez l'affichage des erreurs PHP en indiquant `display_errors = on` dans <a href="C:\MAMP\conf\php8.1.0\php.ini">php.ini</a> à la ligne `374`.
    - Spécifiez la version 8.1.0 dans _MAMP > Préférences > PHP_.
    - Glissez le projet dans <a href="C:\MAMP\htdocs">htdocs</a>.
    >   MAMP permet de facilement mettre en place un serveur PHP Apache et MySQL sous l'interface phpMyAdmin.
  
  - ### Installer les dépendances
    - Installez [Composer](http://getcomposer.org/download) sans cocher le mode développeur, et en spécifiant 
      l'éxecutable PHP 8.1.0 de MAMP 
      `C:\MAMP\bin\php\php8.1.0\php.exe`.
    - Déplacez votre <a href="C:\MAMP\conf\php8.1.0\php.ini">php.ini</a> depuis <a href="C:\MAMP\conf\php8.1.0">conf\php8.1.0</a> dans <a href="C:\MAMP\bin\php\php8.1.0">bin\php\php8.1.0</a>.
    - Éxecutez les commandes suivantes pour installer les dépendances spécifiées dans [composer.json](composer.json).
    ```bash
    composer config -g -- disable-tls false 
    ```
    ```bash
    composer install
    ```
    > Composer est utilisé dans le cadre du développement d’applications PHP pour gérer des dépendances. Les fichiers des dépendances se trouveront dans un dossier [vendor](vendor) qui est spécifié dans [.gitignore](.gitignore) en raison de sa taille.
  
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

- Installez [Node.js](http://nodejs.org/en/download).
- Executez la commande suivante pour installer les dépendances spécifiées dans [package.json](package.json).
```bash
npm install
```
- Installez le plugin [Tailwind CSS](https://tailwindcss.com/docs/installation) depuis _Paramètres > Plugins_ pour bénénificier des suggestions de complétions.
> Nous utilisons ici Node.js pour gérer des dépendances JavaScript qui offrent plus de fonctionnalités notamment sur les fichier CSS.

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
    return new ControllerResponse(
        templatePath: "user/sign-in/identifier.html.twig",
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
        throw new ServiceException(
            message: "L'adresse mail ou le mot de passe est incorrect.",
            redirection: RouteName::SIGN_IN_FORM,
            params: ["email" => $email]
        );
    UserConnection::signIn($user);
    return new ControllerResponse(
        redirection: RouteName::HOME,
        statusCode: StatusCode::CREATED
    );
}
```