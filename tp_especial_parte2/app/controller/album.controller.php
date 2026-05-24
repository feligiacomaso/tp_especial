<?php
require_once __DIR__ . '/../model/album.model.php';
require_once __DIR__ . '/../model/artista.model.php';

require_once __DIR__ . '/../view/album.view.php';
require_once __DIR__ . '/../view/error.view.php';

class AlbumController {

    private $model;
    private $artistaModel;
    private $view;
    private $errorView;

    public function __construct() {
        $this->model = new AlbumModel();
        $this->artistaModel = new ArtistaModel();

        $this->view = new AlbumView();
        $this->errorView = new ErrorView();
    }

    public function showForm($req) {

    $artistas = $this->artistaModel->getAll();

    $this->view->setUser($req->user);
    $this->view->renderForm(null, $artistas);
}

    public function showAll($req) {
        $albumes = $this->model->getAll();
        $this->view->setUser($req->user);
        $this->view->renderAlbumes($albumes);
    }

    public function show($req) {
        $id = $req->id;

        $album = $this->model->get($id);

        if (!$album) {
            return $this->errorView->renderError("El album no existe");
        }

        $this->view->setUser($req->user);
        $this->view->renderDetalle($album);
    }

    public function showAdmin($req) {
        $albumes = $this->model->getAll();

        $this->view->setUser($req->user);
        $this->view->renderAdmin($albumes);
    }

    public function add($req) {
        if (
             !isset($_POST['nombre']) ||empty($_POST['nombre']) ||
             !isset($_POST['fecha_lanzamiento']) || empty($_POST['fecha_lanzamiento']) ||
             !isset($_POST['cantidad_canciones']) || empty($_POST['cantidad_canciones']) ||
             !isset($_POST['imagen']) || empty($_POST['imagen']) ||
             !isset($_POST['id_artista']) || empty($_POST['id_artista'])
        ) {
            return $this->errorView->renderError('Complete todos los campos');
        }

       
            $nombre = $_POST['nombre'];
            $fecha_lanzamiento = $_POST['fecha_lanzamiento'];
            $cantidad_canciones = $_POST['cantidad_canciones'];
            $imagen = $_POST['imagen'];
            $id_artista = $_POST['id_artista'];
             $id = $this->model->insert($nombre,$fecha_lanzamiento, $cantidad_canciones, $imagen, $id_artista);
        if (empty($id)) {
            return $this->errorView->renderError('Error al agregar álbum');
        }

        header('Location: ' . BASE_URL . 'adminAlbumes');
    }

    public function delete($req) {
        $id = $req->id;

        $album = $this->model->get($id);

        if (!$album) {
            return $this->errorView->renderError("El album no existe");
        }

        $this->model->delete($id);

        header('Location: ' . BASE_URL . 'adminAlbumes');
    }

   public function edit($req) {
    $id = $req->id;
    $album = $this->model->get($id);
    if (!$album) {
        return $this->errorView->renderError('Álbum no encontrado');
    }
    $artistas = $this->artistaModel->getAll();

    $this->view->setUser($req->user);
    $this->view->renderForm($album, $artistas);
}
public function update($req) {

    $id = $req->id;

    if (
        empty($_POST['nombre']) ||
        empty($_POST['fecha_lanzamiento']) ||
        empty($_POST['cantidad_canciones']) ||
        empty($_POST['imagen']) ||
        empty($_POST['id_artista'])
    ) {
        return $this->errorView->renderError('Complete todos los campos');
    }

    $this->model->update(
        $id,
        $_POST['nombre'],
        $_POST['fecha_lanzamiento'],
        $_POST['cantidad_canciones'],
        $_POST['imagen'],
        $_POST['id_artista']
    );

    header('Location: ' . BASE_URL . 'adminAlbumes');
}
}