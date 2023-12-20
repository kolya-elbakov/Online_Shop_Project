<?php
class UserController
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", "dbuser", "dbpwd");
    }

    public function getRegistrate(): void
    {
        require_once './../View/registrate.php';
    }
    public function registrate(): void
    {
        $errors = $this->validateReg($_POST);

        if(empty($errors)) {
            $password = $_POST['psw'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($password, PASSWORD_DEFAULT);

            $statement = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);

            header("Location: /login");
        }

        require_once './../View/registrate.php';
    }

    private function validateReg(array $data): array
    {
        $errors = [];

        $name = $data['name'];
        if(strlen($name) < 2) {
            $errors['name']= 'Имя указано неверно';
        }

        $email = $data['email'];
        if(strlen($email) < 4) {
            $errors['email']= 'Email указан неверный';
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email должен содержать @';
            }
        }

        $password = $data['psw'];
        if(strlen($password) < 8) {
            $errors['password'] = 'Пароль должен быть не менее 8 символов';
        }

        $psw_repeat = $data['psw-repeat'];
        if ($psw_repeat !== $password){
            $errors['repeat-psw'] = 'Пароли не совпадают';
        }
        return $errors;
    }

    public function getLogin()
    {
        require_once './../View/login.php';
    }
    public function login()
    {
        $errors = $this->validateLog($_POST);
        $password = $_POST['password'];
        $email = $_POST['email'];

        if(empty($errors)) {
            $statement = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $statement->execute(['email' => $email]);
            $data = $statement->fetch();

            if(empty($data)) {
                $errors['email'] = 'Пользователя не существует';
            } else {
                if(password_verify($password, $data['password'])) {
                    session_start();
                    $_SESSION['user_id'] = $data['id'];
                    header("Location: /main");
                } else {
                    $errors['password'] = 'Неверный логин или пароль';
                }
            }
        }
        require_once './../View/login.php';
    }

    public function validateLog(array $data): array
    {
        $errors = [];

        $email = $data['email'];
        if(empty($email)){
            $errors['email'] = 'Введите email';
        }

        $password = $data['password'];
        if(empty($password)) {
            $errors['password'] = 'Введите пароль';
        }
        return $errors;
    }

    public function logout(): void
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            session_destroy();
            header('Location: /login' );
        }
    }
}