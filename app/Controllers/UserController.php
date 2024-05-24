<?php
include __DIR__ . "/../core/Controller.php";
include __DIR__ . "/../Models/user.php";
include __DIR__ . "/../core/Session.php";

class UserController extends Controller
{
    private $user;
    private $session;
    private $privileges;
    private $role;
    private $group;

    public function __construct()
    {
        parent::__construct(); // call parent constructor
        $this->user = new User();
        $this->session = new Session();
    }

    public function index()
    {
        if ($this->session->has('uuid')) {
            header('Location: /user/liste');
        }
        return parent::view("user.index", array(), false);
    }

    public function liste()
    {
        if ($this->session->has('uuid')) {
            // Define how many results you want per page
            $results_per_page = 5;
            // Find out the total number of results in the database
            $count = $this->user->count()['count'];
            // Calculate the total number of pages
            $total_pages = ceil($count / $results_per_page);
            // Get the number of the current page from url
            $current_page = parent::getRequestData('page', 1);
            // Calculate the offset for the query
            $offset = ($current_page - 1) * $results_per_page;
            $users = $this->user->getAll($offset, $results_per_page);
            $pagination = parent::getPaginate($current_page, $total_pages);
            return parent::view('user.liste', array("users" => $users, "pagination" => $pagination, "privileges" => $this->privileges));
        } else {
            header('Location: /user/index');
        }
    }

    public function inscription()
    {
        return parent::view("user.inscription", array("privileges" => $this->privileges), false);
    }

    public function inscrire()
    {
        $request = parent::validateRequest([
            "nom" => "required",
            "prenom" => "required",
            "email" => "required|email|unique:user.email",
            "password" => "required|minLength:6",
            "password_confirm" => "required|minLength:6|confirm:password"
        ]);
        if ($request['errors']) {
            return parent::view("user.inscription", array("request" => $request, "privileges" => $this->privileges), false);
        } else {
            $this->user->save($request['nom']['value'], $request['prenom']['value'], $request['email']['value'], HelperFunctions::encrypt_decrypt("encrypt", $request['password']['value']), 2);
            header('Location: /user/index');
        }
    }

    public function connexion()
    {
        $request = parent::validateRequest([
            "email" => "required|email",
            "password" => "required|minLength:6"
        ]);
        if ($request['errors']) {
            return parent::view("user.index", array("privileges" => $this->privileges, "request" => $request), false);
        } else {
            $email = parent::getRequestData('email');
            $password = HelperFunctions::encrypt_decrypt("encrypt", parent::getRequestData('password'));

            $connexion = $this->user->getConnexion($email, $password);
            if ($connexion['count'] == 1) {
                $this->session->setParameter('uuid', $connexion['uuid']);
                $this->session->setParameter('nom', $connexion['nom']);
                $this->session->setParameter('prenom', $connexion['prenom']);
                $this->setPrivileges($connexion['uuid']);
                $this->getDefaultPage($this->privileges);
            } else {
                return parent::view("user.index", array("privileges" => $this->privileges, "error" => "Échec de connexion. Veuillez réessayer en utilisant des identifiants valides."), false);
            }
        }
    }

    public function create()
    {
        return parent::view('user.create', array(), false);
    }

    public function add()
    {
        $request = parent::validateRequest([
            "nom" => "required",
            "prenom" => "required",
            "email" => "required|email|unique:user.email",
            "password" => "required|minLength:6",
            "group" => "required"
        ]);
        if ($request['errors']) {
            return parent::view("user.create", array("request" => $request), false);
        } else {
            $this->user->save($request['nom']['value'], $request['prenom']['value'], $request['email']['value'], HelperFunctions::encrypt_decrypt("encrypt", $request['password']['value']), $request['group']['value']);
            header('Location: /user/liste');
        }
    }

    public function update()
    {
        if ($this->session->has('uuid')) {
            return parent::view('user.update', array("privileges" => $this->privileges));
        } else {
            header('Location: /user/index');
        }
    }

    public function delete()
    {
        if ($this->session->has('uuid')) {
            $uuid = parent::getRequestData('uuid');
            $this->user->delete($uuid);
        } else {
            header('Location: /user/index');
        }
    }

    public function profil()
    {
        if ($this->session->has('uuid')) {
            $uuid = $this->session->getParameter('uuid');
            $user = $this->user->getByUuid($uuid);
            return parent::view("user.profil", array("privileges" => $this->privileges, "user" => $user));
        }
    }

    public function isOldPassword()
    {
        if ($this->session->has('uuid')) {
            $uuid = $this->session->getParameter('uuid');
            $old_password = HelperFunctions::encrypt_decrypt("encrypt", parent::getRequestData("old_password"));
            $count = $this->user->checkPassword($uuid, $old_password);
            if ($count) {
                $response = array("valid" => true, "message" => "Mot de passe correct.");
                echo json_encode($response);
            } else {
                $response = array("invalid" => true, "message" => "Mot de passe incorrect.");
                echo json_encode($response);
            }
        }
    }

    public function updatePassword()
    {
        if ($this->session->has('uuid')) {
            $uuid = $this->session->getParameter('uuid');
            $old_password = HelperFunctions::encrypt_decrypt("encrypt", parent::getRequestData("old_password"));
            $password1 = HelperFunctions::encrypt_decrypt("encrypt", parent::getRequestData("password1"));
            $password2 = HelperFunctions::encrypt_decrypt("encrypt", parent::getRequestData("password2"));
            $count = $this->user->checkPassword($uuid, $old_password);
            if ($count and $password1 == $password2) {
                $this->user->updatePassword($password1, $uuid);
                echo true;
            } else {
                echo false;
            }
        }
    }

    public function deconnexion()
    {
        $this->session->destroy();
        header('Location: /user/index');
    }

    public function search()
    {
        if ($this->session->has('uuid')) {
            $key = parent::getRequestData('key');
            $results = "";
            if ($key != '') {
                $users = $this->user->search($key);
                foreach ($users as $user) {
                    $uuid = $user['uuid'];
                    $prenom = $user['prenom'];
                    $nom = $user['nom'];
                    $results .= "<a href='#' onclick='getUser(\"" . $uuid . "\")' class='list-group-item list-group-item-action'>" . $prenom . " " . $nom . "</a>";
                }
            }
            echo $results;
        }
    }

    public function setPrivileges($uuid)
    {
        $roles = $this->role->getRolesByUser($uuid);
        foreach ($roles as $privilege) {
            array_push($this->privileges, $privilege["code"]);
        }

        $roles = $this->role->getRolesByGroup($uuid);
        foreach ($roles as $privilege) {
            array_push($this->privileges, $privilege["code"]);
        }
    }
}
