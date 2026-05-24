<?php

require_once __DIR__ . '/../model/artista.model.php';
require_once __DIR__ . '/../model/album.model.php';

require_once __DIR__ . '/../view/artista.view.php';
require_once __DIR__ . '/../view/error.view.php';

class ArtistaController {

    private $model;
    private $albumModel;
    private $view;
    private $errorView;

    public function __construct() {
        $this->model = new ArtistaModel();
        $this->albumModel = new AlbumModel();

        $this->view = new ArtistaView();
        $this->errorView = new ErrorView();
    }
    public function showForm($req) {

    $this->view->setUser($req->user);
    $this->view->renderForm();
}
    public function showAll($req) {
        $artistas = $this->model->getAll();

        $this->view->setUser($req->user);
        $this->view->renderArtistas($artistas);
    }

    public function show($req) {
        $id = $req->id;

        $artista = $this->model->get($id);

        if (!$artista) {
            return $this->errorView->renderError("El artista no existe");
        }

        $albumes = $this->albumModel->getByArtista($id);

        $this->view->setUser($req->user);
        $this->view->renderDetalle($artista, $albumes);
    }

    public function showAdmin($req) {
        $artistas = $this->model->getAll();

        $this->view->setUser($req->user);
        $this->view->renderAdmin($artistas);
    }

    public function add($req) {

        if (
            !isset($_POST['nombre_artistico']) || empty($_POST['nombre_artistico']) ||
            !isset($_POST['nombre_completo']) || empty($_POST['nombre_completo']) ||
            !isset($_POST['fecha_nacimiento']) || empty($_POST['fecha_nacimiento']) ||
            !isset($_POST['genero']) || empty($_POST['genero']) ||
            !isset($_POST['imagen']) || empty($_POST['imagen'])
        ) {
            return $this->errorView->renderError('Complete todos los campos');
        }

            $nombre_artistico = $_POST['nombre_artistico'];
            $nombre_completo = $_POST['nombre_completo'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $genero = $_POST['genero'];
            $imagen = $_POST['imagen'];

        $id = $this->model->insert($nombre_artistico,$nombre_completo, $fecha_nacimiento,$genero, $imagen);
        if(empty($id)){
            return $this->errorView->renderError("Error al agregar el artista. Intente nuevamente.");
        }
        header('Location: ' . BASE_URL . 'adminArtistas');
    }

    public function delete($req) {
        $id = $req->id;

        $artista = $this->model->get($id);

        if (!$artista) {
            return $this->errorView->renderError("El artista no existe");
        }

        $albumes = $this->albumModel->getByArtista($id);

        if (count($albumes) > 0) {
            return $this->errorView->renderError(
                'No se puede eliminar un artista que tiene álbumes asociados'
            );
        }

        $this->model->delete($id);

        header('Location: ' . BASE_URL . 'adminArtistas');
    }

    public function edit($req) {
    $id = $req->id;
    $artista = $this->model->get($id);
    if (!$artista) {
        return $this->errorView->renderError('Artista no encontrado');
    }

    $this->view->setUser($req->user);
    $this->view->renderForm($artista);
}
public function update($req) {

    $id = $req->id;

    if (
        empty($_POST['nombre_artistico']) ||
        empty($_POST['nombre_completo']) ||
        empty($_POST['fecha_nacimiento']) ||
        empty($_POST['genero']) ||
        empty($_POST['imagen'])
    ) {
        return $this->errorView->renderError('Complete todos los campos');
    }

    $this->model->update(
        $id,
        $_POST['nombre_artistico'],
        $_POST['nombre_completo'],
        $_POST['fecha_nacimiento'],
        $_POST['genero'],
        $_POST['imagen']
    );

    header('Location: ' . BASE_URL . 'adminArtistas');
}
}