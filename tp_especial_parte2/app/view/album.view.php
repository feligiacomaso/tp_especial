<?php

class AlbumView {
    protected $user;

    public function setUser($user) {
        $this->user = $user;
    }

    public function renderAlbumes($albumes) {
        require_once __DIR__ . '/templates/albumes.phtml';
    }

    public function renderDetalle($album) {
        require_once __DIR__ . '/templates/detalle_album.phtml';
    }

    public function renderAdmin($albumes) {
        require_once __DIR__ . '/templates/admin_albumes.phtml';
    }

    public function renderForm($album = null, $artistas = []) {
        require_once __DIR__ . '/templates/album_form.phtml';
    }
}