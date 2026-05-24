<?php
require_once __DIR__ . '/app/controller/artista.controller.php';
require_once __DIR__ . '/app/controller/album.controller.php';
require_once __DIR__ . '/app/controller/auth.controller.php';

require_once __DIR__ . '/app/middlewares/session.middleware.php';
require_once __DIR__ . '/app/middlewares/guard.middleware.php';

session_start();


define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');
/**  TABLA DE RUTEO
 *
 *  PUBLICAS
 *  /home                  ---> ArtistaController::showAll();
 *  /artista/:id           ---> ArtistaController::show();
 *  /albumes               ---> AlbumController::showAll();
 *  /album/:id             ---> AlbumController::show();
 *
 *  AUTENTICACION
 *  /login_form            ---> AuthController::showForm();
 *  /login                 ---> AuthController::login();
 *  /logout                ---> AuthController::logout();
 *
 *  ADMIN ARTISTAS
 *  /adminArtistas         ---> ArtistaController::showAdmin();
 *  /addArtista            ---> ArtistaController::add();
 *  /deleteArtista/:id     ---> ArtistaController::delete();
 *  /editArtista/:id       ---> ArtistaController::edit();
 *
 *  ADMIN ALBUMES
 *  /adminAlbumes          ---> AlbumController::showAdmin();
 *  /addAlbum              ---> AlbumController::add();
 *  /deleteAlbum/:id       ---> AlbumController::delete();
 *  /editAlbum/:id         ---> AlbumController::edit();
 *
 **/

// accion por default
$action = 'home';


if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

// parseo
$params = explode('/', $action);
// request
$req = new StdClass();
$req = (new SessionMiddleware())->run($req);

// router
switch ($params[0]) {
    case 'home':
        $controller = new ArtistaController();
        if(isset($params[1])){
            $req-> id = $params[1];
            $controller -> show ($req);
        }else{
            $controller -> showAll($req);
        }
        break;
    case 'album':
        $controller = new AlbumController();
        if(isset($params[1])){
            $req -> id = $params[1];
            $controller -> show($req);
        }else{
            $controller->showAll($req);
        }
        break;
    case 'login_form':
        $controller = new AuthController();
        $controller->showForm($req);
        break;
    case 'login':
        $controller = new AuthController();
        $controller->login($req);
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout($req);
        break;
    case 'showFormArtista':
    $req = (new GuardMiddleware())->run($req);
    $controller = new ArtistaController();
    $controller->showForm($req);
    break;
    case 'showFormAlbum':
    $req = (new GuardMiddleware())->run($req);
    $controller = new AlbumController();
    $controller->showForm($req);
    break;
    case 'adminArtistas':
        $req = (new GuardMiddleware())->run($req);
        $controller = new ArtistaController();
        $controller->showAdmin($req);
        break;
    case 'addArtista':
        $req = (new GuardMiddleware())->run($req);
        $controller = new ArtistaController();
        $controller->add($req);
        break;
    case 'deleteArtista':
        $req = (new GuardMiddleware())->run($req);
        $controller = new ArtistaController();
        $req->id = $params[1];
        $controller->delete($req);
        break;
    case 'editArtista':
        $req = (new GuardMiddleware())->run($req);
        $controller = new ArtistaController();
        $req->id = $params[1]; 
        $controller->edit($req);
        break;
    case 'updateArtista':
        $req = (new GuardMiddleware())->run($req);
        $controller = new ArtistaController();
        $req->id = $params[1];
        $controller->update($req);
        break;
     case 'adminAlbumes':
        $req = (new GuardMiddleware())->run($req);
        $controller = new AlbumController();
        $controller->showAdmin($req);
        break;
     case 'addAlbum':
        $req = (new GuardMiddleware())->run($req);
        $controller = new AlbumController();
        $controller->add($req);
        break;
     case 'deleteAlbum':
        $req = (new GuardMiddleware())->run($req);
        $controller = new AlbumController();
        $req->id = $params[1];
        $controller->delete($req);
        break;
    case 'editAlbum':
        $req = (new GuardMiddleware())->run($req);
        $controller = new AlbumController();
        $req->id = $params[1];
        $controller->edit($req);
        break;
    case 'updateAlbum':
        $req = (new GuardMiddleware())->run($req);
        $controller = new AlbumController();
        $req->id = $params[1];
        $controller->update($req);
        break;
    default:
        echo '404 error';
        break;
}

