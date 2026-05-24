<?php
require_once __DIR__ . '/../model/users.model.php';
require_once __DIR__ . '/../view/auth.view.php';
require_once __DIR__ . '/../view/error.view.php';

class AuthController {
    private $model;
    private $view;
    private $errorView;
    
    public function __construct() {
        $this->model = new UsersModel();
        $this->view = new AuthView();
        $this->errorView = new ErrorView();
    }
    
    public function showForm($req){
        $this->view->showForm();
    }

    public function login($req){
        if(empty($_POST["email"]) || empty($_POST["password"]))
            return $this->view->showForm();

        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = $this->model->getByEmail($email);

        if(!$user) {
            return $this->errorView->renderError("Usuario o contraseña incorrecta");
        }

        if(!password_verify($password, $user->password)) {
            return $this->errorView->renderError("Usuario o contraseña incorrecta");
        }

        $_SESSION["id"] = $user->id_user;
        $_SESSION["email"] = $user->email;

        header("Location: ". BASE_URL);
    }
    public function logout($req){
        session_destroy();
        header('location:' . BASE_URL);
    }
}
