<?php

namespace App\Controllers;
use App\Models\UserModel;

class UserController extends MainController {
    
      public function renderUser(): void
    {
        if ($this->view === 'logout') {
            $this->logout();
        } else {      
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if (isset($_POST["registerForm"])) {
                    $this->register();
             } 
                elseif (isset($_POST["loginForm"])) {
                    $this->login();
                }
            }
        }
        // dans tous les cas on construit la page
        $this->render();
    }
    
    
        // méthode permettant l'inscription d'un utilisateur
    public function register(): void
    {

        $errors = 0;
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');
        $name = filter_input(INPUT_POST, 'name');

        if (!$email || !$password || !$name) {
            $errors = 1;
            $this->data[] = '<div class="" role="alert">Tous les champs sont obligatoires</div>';
        }

        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        if ($email === false) {
            $errors = 1;
            $this->data[] = '<div class="alert alert-danger" role="alert">Le format de l\'email n\'est pas valide.</div>';
        }
        if (strlen($password) < 8) {
            $errors = 1;
            $this->data[] = '<div class="alert alert-danger" role="alert">Le mot de passe doit contenir au moins 8 caractères.</div>';
        }

        if ($errors < 1) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $user = new UserModel();
            $user->setEmail($email);
            $user->setPassword($hashedPassword);
            $user->setName($name);
            $user->setRole(3);

            if ($user->checkEmail()) {
                $errors = 1;
                $this->data[] = '<div class="alert alert-danger" role="alert">Cet email est déjà pris, veuillez en choisir un autre.</div>';
            }
            if ($errors < 1) {
                if ($user->registerUser()) {
                    $this->data[] =  '<div class="alert alert-success" role="alert">Enregistrement réussi, vous pouvez maintenant vous connecter</div>';
                } else {
                    $this->data[] = '<div class="alert alert-danger" role="alert">Il y a eu une erreur lors de l\enregistrement</div>';
                }
            }
        }
    }

  public function login(): void
    {

        // on commence sans erreurs
        $errors = 0;
        // on instancie un nouveau UserModel
        $user = new UserModel();
        // on récupère l'utilisateur via son email
        $user = $user->getUserByEmail($_POST['email']);
        // si user renvoie false
        if (is_null($user)) {
            // il y a eu une erreur
            $errors = 1;
        } else {
            // sinon on vérifie si le mot de passe de l'utilisateur en bdd et celui renseigné dans le formulaire concordent
            if (password_verify($_POST['password'], $user->getPassword())) {
                // si c'est le cas, on stocke notre objet user dans la session
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user_role'] = $user->getRole(); 
                 $_SESSION['user_name'] = $user->getName(); 
                // on stocke un message dans la propriété data pour l'afficher dans la vue
                $this->data[] =  '<div class="alert alert-success" role="alert">connexion réussie !</div>';

                // on créé une url de redirection
                $base_uri = explode('index.php', $_SERVER['SCRIPT_NAME']);
                // on redirige vers la page admin
                if($user->getRole() < 3){
                    header('Location:' . $base_uri[0] . 'admin');
                }                
            } else {
                // sinon si les mots de passe ne concordent pas, il y'a une erreur
                $errors = 1;
            }
        }
        // s'il y à des erreurs
        if ($errors > 0) {
            //On stock dans data le message d'erreur à afficher dans la vue
            $this->data[] = '<div class="alert alert-danger" role="alert">Email ou mot de passe incorrect</div>';
        }
    }

    public function logout(): void
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_role']);
        session_destroy();
        $base_uri = explode('index.php', $_SERVER['SCRIPT_NAME']);
        header('Location:' . $base_uri[0] . 'home');
    }
}
