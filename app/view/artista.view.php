<?php

class ArtistaView {
    protected $user;

    public function setUser($user) {
        $this->user = $user;
    }

    public function renderArtistas($artistas) {
        require_once __DIR__ . '/templates/artistas.phtml';
    }

    public function renderDetalle($artista, $albumes) {
        require_once __DIR__ . '/templates/detalle_artista.phtml';
    }

    public function renderAdmin($artistas) {
        require_once __DIR__ . '/templates/admin_artistas.phtml';
    }

    public function renderForm($artista = null) {
        require_once __DIR__ . '/templates/artista_form.phtml';
    }
}
