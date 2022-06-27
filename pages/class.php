<?php

class App {

    static $db = NULL;
    static $cat;
    static $filterSearch;

    // instanciation de la Database si elle n'existe pas sinon retourner l'objet existant
    static function getDatabase() {
        if(!self::$db) {
            self::$db = new Database('root', 'root', 'my_shop');
        }
        return self::$db;
    }

    static function close_db($query, $db) {
        $query = NULL;
        $db = NULL;
    }

    // gestion des cookies et sessions
    static function remove_cookie($cookieName) {
        if(isset($cookieName)) {
            setcookie($cookieName, "", time() - (10 * 365 * 24 * 60 * 60), "/");
        }
    }
    
    static function set_cookie($cookieName, $cookieValue) {
            setcookie($cookieName, $cookieValue, time() + (10 * 365 * 24 * 60 * 60), "/");
    }
    
    static function set_session($sessionName, $sessionValue) {
        $_SESSION[$sessionName] = $sessionValue;
    }

    static function remove_session() {
        session_unset();
        session_destroy();
        session_reset();
    }

    // affichage du nom sur la page admin
    static function display_name() {
        if(isset($_COOKIE['my_shop-user'])) {
            echo $_COOKIE['my_shop-user'] . " san";
        }
        if(isset($_SESSION['my_shop-user'])) {
            echo $_SESSION['my_shop-user'] . " san";
        }
    }

    // affichage du nom sur le site
    static function display_name_index() {
        if(isset($_COOKIE['my_shop-user'])) {
            echo "Welcome " . $_COOKIE['my_shop-user'] . " san";
        } else if (isset($_SESSION['my_shop-user'])) {
            echo "Welcome " . $_SESSION['my_shop-user'] . " san";
        } else {
            echo "Welcome honorable guest";
        }
    }

    // affichage de la nav bar sur l'index
    static function display_nav() {
        if(isset($_COOKIE['my_shop-user']) || isset($_SESSION['my_shop-user'])) {
            echo  "<li class=\"nav-item dropdown\">
                <a class=\"nav-link dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">";
                if(isset($_COOKIE['my_shop-avatar']) && !empty($_COOKIE['my_shop-avatar'])) {
                    echo "<img class=\"index-avatar\" src=\"" . USER_IMG . $_COOKIE['my_shop-avatar'] . "\" alt=\"user avatar\"></img>";
                }
                if(isset($_SESSION['my_shop-avatar']) && !empty($_SESSION['my_shop-avatar'])) {
                    echo "<img class=\"index-avatar\" src=\"" . USER_IMG . $_SESSION['my_shop-avatar'] . "\" alt=\"user avatar\"></img>";
                }
                    self::display_name();
            echo "</a>
                <div class=\"dropdown-menu\">
                  <form method=\"post\"><p><button type=\"submit\" class=\"btn\" id=\"profile\" name=\"profile\">Profile</button></form></p></form>";
                        if(isset($_COOKIE['my_shop-user']) || isset($_SESSION['my_shop-user'])) {
                            if(isset($_POST['profile'])) {
                                self::display_profile();
                            }
                            if(isset($_COOKIE['my_shop-role']) && $_COOKIE['my_shop-role'] == true) {
                                echo "<form method=\"post\"><p><button type=\"submit\" class=\"btn\" id=\"admin-page\" name=\"admin-page\">Admin</button></p></form>";
                            }
                            if(isset($_SESSION['my_shop-role']) && $_SESSION['my_shop-role'] == true) {
                                echo "<form method=\"post\"><p><button type=\"submit\" class=\"btn\" id=\"admin-page\" name=\"admin-page\">Admin</button></p></form>";
                            }
                            if(isset($_POST['admin-page'])) {
                                header("Location: ./pages/admin.php");
                                die();
                            }  
                                echo "<div class=\"dropdown-divider\"></div>";
                                echo "<form method=\"post\"><p><button type=\"submit\" class=\"btn\" id=\"logout\" name=\"logout\">Log out</button></form></p></form>";
                                if(isset($_POST['logout'])) {
                                    self::log_out();
                                }
                        }
            echo "</div>
              </li>"; } else {
                echo "
                <form method=\"post\">
                    <button type=\"submit\" class=\"btn\" id=\"login\" name=\"login\">Login</button>
                    <button type=\"submit\" class=\"btn\" id=\"register\" name=\"register\">Register</button>
                </form>
                ";
                if(isset($_POST['login'])) {
                    self::log_in();
                }   
                if(isset($_POST['register'])) {
                    self::sign_up();
                }  
              }
    }

    // affichage de la nav bar sur le profil et le détail
    static function display_nav_profile() {
        if(isset($_COOKIE['my_shop-user']) || isset($_SESSION['my_shop-user'])) {
            echo  "<li class=\"nav-item dropdown\">
                <a class=\"nav-link dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">";
                if(isset($_COOKIE['my_shop-avatar']) && !empty($_COOKIE['my_shop-avatar'])) {
                    echo "<img class=\"index-avatar\" src=\"." . USER_IMG . $_COOKIE['my_shop-avatar'] . "\" alt=\"user avatar\"></img>";
                }
                if(isset($_SESSION['my_shop-avatar']) && !empty($_SESSION['my_shop-avatar'])) {
                    echo "<img class=\"index-avatar\" src=\"." . USER_IMG . $_SESSION['my_shop-avatar'] . "\" alt=\"user avatar\"></img>";
                }
                self::display_name();
            echo "</a>
                <div class=\"dropdown-menu\">
                  <form method=\"post\"><p><button type=\"submit\" class=\"btn\" id=\"profile\" name=\"profile\">Profile</button></form></p></form>";
                        if(isset($_COOKIE['my_shop-user']) || isset($_SESSION['my_shop-user'])) {
                            if(isset($_POST['profile'])) {
                                header("Location: ./profile.php");
                                die();
                            }
                            if(isset($_COOKIE['my_shop-role']) && $_COOKIE['my_shop-role'] == true) {
                                echo "<form method=\"post\"><p><button type=\"submit\" class=\"btn\" id=\"admin-page\" name=\"admin-page\">Admin</button></p></form>";
                            }
                            if(isset($_SESSION['my_shop-role']) && $_SESSION['my_shop-role'] == true) {
                                echo "<form method=\"post\"><p><button type=\"submit\" class=\"btn\" id=\"admin-page\" name=\"admin-page\">Admin</button></p></form>";
                            }
                            if(isset($_POST['admin-page'])) {
                                header("Location: ./admin.php");
                                die();
                            }  
                                echo "<div class=\"dropdown-divider\"></div>";
                                echo "<form method=\"post\"><p><button type=\"submit\" class=\"btn\" id=\"logout\" name=\"logout\">Log out</button></form></p></form>";
                                if(isset($_POST['logout'])) {
                                    self::log_out_admin();
                                }
                        }
            echo "</div>
              </li>"; } else {
                echo "
                <form method=\"post\">
                    <button type=\"submit\" class=\"btn\" id=\"login\" name=\"login\">Login</button>
                    <button type=\"submit\" class=\"btn\" id=\"register\" name=\"register\">Register</button>
                </form>
                ";
                if(isset($_POST['login'])) {
                    self::log_in();
                }   
                if(isset($_POST['register'])) {
                    self::sign_up();
                }  
              }
    }

    // procédure de sign_in
    static function sign_in() {
        try {
            $db = self::getDatabase();
            $query = "SELECT * FROM users WHERE email = ?";
            $param = [$_POST['email']];
            $result = $db->query($query, $param)->fetch(PDO::FETCH_ASSOC);
    
            if(password_verify($_POST['password'], $result['password'])) {
                if(isset($_POST['remember_me'])) {
                    self::set_cookie("my_shop-user", $result['username']);
                    self::set_cookie("my_shop-email", $result['email']);
                    self::set_cookie("my_shop-role", $result['admin']);
                    self::set_cookie("my_shop-avatar", $result['avatar']);
                } else {
                    if(isset($_COOKIE['my_shop-user']) || isset($_COOKIE['my_shop-email']) || isset($_COOKIE['my_shop-role'])) {
                        self::remove_cookie("my_shop-user");
                        self::remove_cookie("my_shop-email");
                        self::remove_cookie("my_shop-role");
                        self::remove_cookie("my_shop-avatar");
                    }
                    self::set_session('my_shop-user', $result['username']);
                    self::set_session('my_shop-email', $result['email']);
                    self::set_session('my_shop-role', $result['admin']);
                    self::set_session('my_shop-avatar', $result['avatar']);
                }
                if($result['admin'] == true) {
                    // rediriger vers la page admin
                    header("Location: ./admin.php");
                    die();
                } else {
                    // rediriger vers l'index;
                    header("Location: ../index.php");
                    die();
                }
                close_db($result, $pdo);
            } else {
                    echo "<div class=\"connection_error\" id=\"hideMe\">
                            <p>Wrong username or password</p>
                        </div>";
            }
        }
        catch (PDOException $e) {
            error_log($e->getMessage()."\n", 3, ERROR_LOG_FILE);
            echo "<div class=\"connection_error\" id=\"hideMe\">
                    <p>MySQL : An error occurred please try again later.</p>
                </div>";        
        }
    
    }

    // procédure d'enregistrement d'un nouveau user
    static function register() {
        // vérifier que les champs sont remplis sinon afficher un message d'erreur
       if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        
        $userName = $_POST['name'];
        $userEmail = $_POST['email'];
        $userPwd = $_POST['password'];
        $userIsAdmin = 0;       

        $db = self::getDatabase();
        $query = "SELECT username, email FROM users WHERE email = ? OR username = ?";
        $param = [$userEmail, $userName];
        $result = $db->query($query, $param)->fetchAll(PDO::FETCH_ASSOC);
    
            // tester si l'email ou le name est déjà enregistré dans la DB
            if(!$result) {      
                $userHash = password_hash($userPwd, PASSWORD_DEFAULT);
                try {
                    $params = [$userName, $userHash, $userEmail, $userIsAdmin];
                    $sql = $db->query("INSERT INTO users (username, password, email, admin) VALUES (?, ?, ?, ?);", $params);
                    // Si la requête a été exécutée alors on place les variables cookie/session
                    if(isset($_POST['remember_me'])) {
                        // si le user a opté pour les cookies
                        self::set_cookie("my_shop-user", $userName);
                        self::set_cookie("my_shop-email", $userEmail);
                        self::set_cookie("my_shop-role", $userIsAdmin);
                    } else {
                        // sinon on alimente la session
                        if(isset($_COOKIE['my_shop-user']) || isset($_COOKIE['my_shop-email']) || isset($_COOKIE['my_shop-role'])) {
                            self::remove_cookie("my_shop-user");
                            self::remove_cookie("my_shop-email");
                            self::remove_cookie("my_shop-role");
                        }
                        self::set_session('my_shop-user', $userName);
                        self::set_session('my_shop-email', $userEmail);
                        self::set_session('my_shop-role', $userIsAdmin);
                    }
                    // rediriger vers l'index car un nouveau user n'est pas admin
                    self::close_db($result, $db);
                    header("Location: ../index.php");
                    die();
                }
                catch (PDOException $e) {
                    error_log($e->getMessage()."\n", 3, ERROR_LOG_FILE);
                    echo "<div class=\"connection_error\" id=\"hideMe\">
                            <p>MySQL : An error occurred please try again later.</p>
                        </div>";
                }
            } else {
                echo "<div class=\"connection_error\" id=\"hideMe\">";
                foreach ($result as $key => $value) {
                    if($value['username'] == $userName) {
                        echo "<p>This name is already in use</p>";
                    }
                    if($value['email'] == $userEmail) {
                        echo "<p>This email is already registered</p>";
                    }
                }
                echo "</div>";
                echo "<div class=\"text-center\">
                        <p>Already a member? <a href=\"./signin.php\">Sign in</a></p>
                    </div>";
            }   
       } else {
        echo "<div class=\"connection_error\" id=\"hideMe\">
                <p>You must fill in all the fields before submit</p>
              </div>";
       }
    }    


    static function log_out() {
        if(isset($_COOKIE['my_shop-user']) || isset($_COOKIE['my_shop-role'])) {
            self::remove_cookie("my_shop-user");
            self::remove_cookie("my_shop-role");
            self::remove_cookie("my_shop-avatar");
        } else {
            self::remove_session();
        }
        header("Location: ./index.php");
        die();    
    }
    
    static function log_in() {
        header("Location: ./pages/signin.php");
        die();
    }    

    static function display_profile() {
        header("Location: ./pages/profile.php");
        die();
    }    

    static function sign_up() {
        header("Location: ./pages/signup.php");
        die();
    }    

    static function filter_reset() {
        header("Location: ./index.php");
        die();  
    }

    static function log_out_admin() {
        if(isset($_COOKIE['my_shop-user']) || isset($_COOKIE['my_shop-role'])) {
            self::remove_cookie("my_shop-user");
            self::remove_cookie("my_shop-role");
        } else {
            self::remove_session();
        }
        header("Location: ../index.php");
        die();    
    }

    // vérification du niveau d'accréditation du user
    // pour empêcher d'atteindre l'admin par l'url
    static function authCheck() {        
    if(isset($_SESSION['my_shop-role']) || isset($_COOKIE['my_shop-role'])) {
        if(isset($_SESSION['my_shop-role']) && $_SESSION['my_shop-role'] == 0) {
            header("Location: ../index.php");
            die();
        }
        if(isset($_COOKIE['my_shop-role']) && $_COOKIE['my_shop-role'] == false) {
            header("Location: ../index.php");
            die();
        }
    } else {
        header("Location: ../index.php");
        die();
    }
    }

    // affichage du texte correspondant à l'option true/false du champ admin de la table users
    static function isAdmin($param) {
        if($param == true) {
            return 'admin';
        } else {
            return 'user';
        }
    }

    // affichage des users sur l'admin
    static function getUsers() {
        $db = self::getDatabase();
        $query = "SELECT id, username, email, admin FROM users";
        $result = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);

        // display en mono page de la table users avec bouton edit et delete
        echo "<table>";
        echo "<caption>Watching table : users</caption>";
        echo "<tr>";
        echo "<th scope=\"col\">ID</th>";
        echo "<th scope=\"col\">username</th>";
        echo "<th scope=\"col\">email</th>";
        // Si on veut gérer le password des users en mode admin
        // echo "<th scope=\"col\">password</th>";
        echo "<th scope=\"col\">role</th>";
        echo "</tr>";
        foreach ($result as $key => $value) {
            echo "<tr>";
                echo "<td id=\"td-id\" class=\"td-id\">" . $value['id'] . "</td>";
                echo "<td>" . $value['username'] . "</td>";
                echo "<td>" . $value['email'] . "</td>";
                // Si on veut gérer le password des users en mode admin
                // echo "<td></td>";
                echo "<td>" . self::isAdmin($value['admin']) . "</td>";
                echo "<td class=\"td-btn-user\">
                        <form action=\"\" method=\"post\">
                            <button type=\"submit\" class=\"btn btn-warning\" id=\"edit-users\" name=\"edit-user\" value=\"" . $value['id'] . "\">Edit</button>
                            <button type=\"submit\" class=\"btn btn-danger\" id=\"delete-user\" name=\"delete-user\" value=\"" . $value['id'] . "\">Delete</button>
                        </form>
                    </td>";
            echo "</tr>";
        }       
        echo "</table>";
        // bouton pour ajouter un user depuis l'admin
        echo "<form action =\"\" method=\"post\"><button type=\"submit\" class=\"btn btn-primary\" id=\"add-user\" name=\"add-user\">New user</button></form>";
    }

    // éditer un user depuis l'admin
    static function editUsers() {
        if(isset($_POST['edit-user'])) {
            $db = App::getDatabase();
            $param = [$_POST['edit-user']];
            $user = $db->query('SELECT * FROM users WHERE id=?', $param)->fetch(PDO::FETCH_ASSOC);
            
            // affichage mono page des détails du user à éditer
            echo "<p class=\"action\">Editing user ID #" . $_POST['edit-user'] . "</p>";
            echo "
            <form action =\"\" method=\"post\" enctype=\"multipart/form-data\">
            <p>
            <label for=\"edit-user-id\">ID</label>
            <input type=\"text\" id=\"edit-user-id\" name=\"edit-user-id\" value=\"" . $user['id'] ."\" readonly/>
            </p>
            <p>
            <label for=\"edit-user-name\">Username</label>
            <input type=\"text\" id=\"edit-user-name\" name=\"edit-user-name\" value=\"" . $user['username'] ."\" required/>
            </p>
            <p>
            <label for=\"edit-user-email\">Email</label>
            <input type=\"hidden\" id=\"auth-email\" name=\"auth-email\" value=\"" . $user['email'] ."\"/>
            <input type=\"email\" id=\"edit-user-email\" name=\"edit-user-email\" value=\"" . $user['email'] ."\" required/>
            </p>
            <p>
            <label for=\"edit-user-admin\">Role</label>
            <select id=\"edit-user-admin\" name=\"edit-user-admin\">
                <option value=0>user</option>";
            if($user['admin'] == 1) {
                echo "<option value=1 selected>admin</option>";
            } else {
                echo "<option value=1>admin</option>";
            }
            echo "</select>
            </p>";
            if(isset($user['avatar'])) {
                echo "
                <p>
                <label for=\"edit-user-picture\">Avatar</label>
                <input type=\"hidden\" id=\"edit-user-picture\" name=\"edit-user-picture\" value=\"" . $user['avatar'] ."\" readonly/>
                <img class=\"current-pic\" src=\"." . USER_IMG . $user['avatar'] . "\" alt=\"user avatar\"></img>
                </p>";
            } else {
                echo "
                <p>
                <label for=\"edit-user-picture\">Avatar</label>
                <input type=\"hidden\" id=\"edit-user-picture\" name=\"edit-user-picture\" value=\"\" readonly/>
                </p>";
            }
            echo "<button type=\"submit\" class=\"btn btn-success\" id=\"sub-edit-user\" name=\"sub-edit-user\">Submit</button>
            </form>";

        }
        // exécuter la requête d'insert si on valide le formulaire d'édition
        if(isset($_POST['sub-edit-user'])) {
            if( (isset($_SESSION['my_shop-email']) && $_SESSION['my_shop-email'] != $_POST['auth-email']) || (isset($_COOKIE['my_shop-email']) && $_COOKIE['my_shop-email'] != $_POST['auth-email']) ) {            
                $db = self::getDatabase();
                $query = "UPDATE users SET username = ?, email = ? , admin = ? WHERE id = ? ";
                $param = [$_POST['edit-user-name'], $_POST['edit-user-email'], $_POST['edit-user-admin'], $_POST['edit-user-id']];
                try {
                    $db->query($query, $param);
                    echo "<div id=\"hideMe\"><p>user ID #" . $_POST['edit-user-id'] . " has been modified</p></div>";                    
                }
                catch (PDOException $e) {
                    error_log($e->getMessage()."\n", 3, ERROR_LOG_FILE);
                    echo "<div class=\"connection_error\" id=\"hideMe\">
                            <p>MySQL : An error occurred please try again later.</p>
                        </div>";
                }
            } else {
                echo "<div class=\"connection_error\" id=\"hideMe\">
                        <p>Not allowed: You can't edit your own profile !</p>
                    </div>";
            }
            // revenir sur la page d'affichage de la table users
                self::getUsers();            
            }
    }
    
    // suppression user depuis l'admin
    static function deleteUsers() {
        if(isset($_POST['delete-user'])) {
            $db = App::getDatabase();
            $param = [$_POST['delete-user']];
            $user = $db->query('SELECT * FROM users WHERE id=?', $param)->fetch(PDO::FETCH_ASSOC);
            
            // affichage mono page des informations du user à delete
            echo "<p class=\"action\">Deleting user ID #" . $_POST['delete-user'] . "</p>";
            echo "
            <form action =\"\" method=\"post\">
            <p>
            <label for=\"delete-user-id\">ID</label>
            <input type=\"text\" id=\"delete-user-id\" name=\"delete-user-id\" value=\"" . $user['id'] ."\" readonly/>
            </p>
            <p>
            <label for=\"delete-user-name\">Username</label>
            <input type=\"text\" id=\"delete-user-name\" name=\"delete-user-name\" value=\"" . $user['username'] ."\" readonly/>
            </p>
            <p>
            <label for=\"delete-user-email\">Email</label>
            <input type=\"email\" id=\"delete-user-email\" name=\"delete-user-email\" value=\"" . $user['email'] ."\" readonly/>
            </p>
            <p>
            <label for=\"delete-user-admin\">Role</label>";
            if($user['admin'] == 1) {
                echo "<input type=\"text\" id=\"delete-user-admin\" name=\"delete-user-admin\" value=\"admin\" readonly/>";
            } else {
                echo "<input type=\"text\" id=\"delete-user-admin\" name=\"delete-user-admin\" value=\"user\" readonly/>";
            }
            echo "
            </p>";
            if(isset($user['avatar'])) {
                echo "
                <p>
                <label for=\"delete-user-picture\">Avatar</label>
                <input type=\"hidden\" id=\"delete-user-picture\" name=\"delete-user-picture\" value=\"" . $user['avatar'] ."\" readonly/>
                <img class=\"current-pic\" src=\"." . USER_IMG . $user['avatar'] . "\" alt=\"user current avatar\"></img>
                </p>";
            } else {
                echo "
                <p>
                <label for=\"delete-user-picture\">Avatar</label>
                <input type=\"hidden\" id=\"delete-user-picture\" name=\"delete-user-picture\" value=\"\" readonly/>
                </p>";
            }
            echo "<p class=\"warning\">You are about to delete this user. Are you sure ?</p>
            <button type=\"submit\" class=\"btn btn-danger\" id=\"sub-delete-user\" name=\"sub-delete-user\">Submit</button>
            </form>";

        }

        // exécution de la requête de suppression après validation
        if(isset($_POST['sub-delete-user'])) {
            if( (isset($_SESSION['my_shop-email']) && $_SESSION['my_shop-email'] != $_POST['delete-user-email']) || (isset($_COOKIE['my_shop_email']) && $_COOKIE['my_shop-email'] != $_POST['delete-user-email']) ) {
                $db = self::getDatabase();
                $query = "DELETE FROM users WHERE id = ?";
                $param = [$_POST['delete-user-id']];

                try {
                    $db->query($query, $param);
                    echo "<div id=\"hideMe\"><p>User profile ID #" . $_POST['delete-user-id'] . " has been removed from database</p></div>";                    
                    if(!empty($_POST['delete-user-picture'])) {
                        $file = "." . USER_IMG . $_POST['delete-user-picture'];
                        unlink($file);
                    }
                }
                catch (PDOException $e) {
                    error_log($e->getMessage()."\n", 3, ERROR_LOG_FILE);
                    echo "<div class=\"connection_error\" id=\"hideMe\">
                            <p>MySQL : An error occurred please try again later.</p>
                        </div>";
                }
            } else {
                echo "<div class=\"connection_error\" id=\"hideMe\">
                        <p>Not allowed: You can't delete your own profile !</p>
                    </div>";
            }
            // revenir sur la page d'affichage de la table users
            self::getUsers();            
        }
    }    

    // ajouter un utilisateur depuis l'admin
    static function addUsers() {
        if(isset($_POST['add-user'])) {
            // affichage mono page d'un formulaire vide
            echo "<form action =\"\" method=\"post\" enctype=\"multipart/form-data\">
            <p>
            <label for=\"add-user-name\">Name</label>
            <input type=\"text\" id=\"add-user-name\" name=\"add-user-name\" required/>
            </p>
            <p>
            <label for=\"add-user-email\">Email</label>
            <input type=\"email\" id=\"add-user-email\" name=\"add-user-email\" required/>
            </p>
            <p>
            <label for=\"add-user-password\">Password</label>            
            <input type=\"password\" id=\"add-user-password\" name=\"add-user-password\" required/>
            </p>
            <p>
            <label for=\"add-user-admin\">Role</label>
            <select id=\"add-user-admin\" name=\"add-user-admin\">
                <option value=0 selected>user</option>
                <option value=1>admin</option>
            </select>
            </p>
            <button type=\"submit\" class=\"btn btn-primary\" id=\"sub-add-user\" name=\"sub-add-user\">Add user</button>
            </form>";
        }

        if(isset($_POST['sub-add-user'])) {
            // vérifier que les champs sont remplis sinon afficher un message d'erreur
            if(!empty($_POST['add-user-name']) && !empty($_POST['add-user-email']) && !empty($_POST['add-user-password'])) {
                
                $userName = $_POST['add-user-name'];
                $userEmail = $_POST['add-user-email'];
                $userPwd = $_POST['add-user-password'];
                $userIsAdmin = $_POST['add-user-admin'];       

                $db = self::getDatabase();
                $query = "SELECT username, email FROM users WHERE email = ? OR username = ?";
                $param = [$userEmail, $userName];
                $result = $db->query($query, $param)->fetchAll(PDO::FETCH_ASSOC);
            
                    // tester si l'email ou le name est déjà enregistré dans la DB
                    if(!$result) {      
                        $userHash = password_hash($userPwd, PASSWORD_DEFAULT);
                        try {
                            $params = [$userName, $userHash, $userEmail, $userIsAdmin];
                            $sql = $db->query("INSERT INTO users (username, password, email, admin) VALUES (?, ?, ?, ?);", $params);
                        }
                        catch (PDOException $e) {
                            error_log($e->getMessage()."\n", 3, ERROR_LOG_FILE);
                            echo "<div class=\"connection_error\" id=\"hideMe\">
                                    <p>MySQL : An error occurred please try again later.</p>
                                </div>";
                        }
                    } else {
                        echo "<div class=\"connection_error\" id=\"hideMe\">";
                        foreach ($result as $key => $value) {
                            if($value['username'] == $userName) {
                                echo "<p>This name is already in use</p>";
                            }
                            if($value['email'] == $userEmail) {
                                echo "<p>This email is already registered</p>";
                            }
                        }
                        echo "</div>";
                        echo "<div class=\"text-center\">
                                <p>Already a member? <a href=\"./signin.php\">Sign in</a></p>
                            </div>";
                    }   
            } else {
                echo "<div class=\"connection_error\" id=\"hideMe\">
                        <p>You must fill in all the fields before submit</p>
                    </div>";
            }
            // revenir sur la page d'affichage de la table users
            self::getUsers();
        }
    }
    
    // affichage de la table products
    static function getProducts() {
        $db = self::getDatabase();
        $query = "SELECT * FROM products";
        $result = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);

        // affichage mono page du contenu de la table products avec boutons edit et delete
        echo "<table>";
        echo "<caption>Watching table : products</caption>";
        echo "<tr>";
        echo "<th scope=\"col\">ID</th>";
        echo "<th scope=\"col\">name</th>";
        echo "<th scope=\"col\">price</th>";
        echo "<th scope=\"col\">category_id</th>";
        echo "<th scope=\"col\">description</th>";
        echo "<th scope=\"col\">picture</th>";
        echo "</tr>";
        foreach ($result as $key => $value) {
            echo "<tr>";
                echo "<td class=\"td-id\">" . $value['id'] . "</td>";
                echo "<td>" . $value['name'] . "</td>";
                echo "<td>" . $value['price'] . "</td>";
                echo "<td>" . $value['category_id'] . "</td>";
                if(isset($value['description']) && strlen($value['description']) > 25){
                    echo "<td>" . substr($value['description'], 0, 22) . "..." . "</td>";
                } else {
                    echo "<td>" . $value['description'] . "</td>";
                }
                echo "<td>" . $value['picture'] . "</td>";
                echo "<td class=\"td-btn-product\">
                        <form action=\"\" method=\"post\">
                            <button type=\"submit\" class=\"btn btn-warning\" id=\"edit-product\" name=\"edit-product\" value=\"" . $value['id'] . "\">Edit</button>
                            <button type=\"submit\" class=\"btn btn-danger\" id=\"delete-product\" name=\"delete-product\" value=\"" . $value['id'] . "\">Delete</button>
                        </form>
                    </td>";
            echo "</tr>";
        }
        echo "</table>";

        // affichage d'un bouton pour ajouter un produit
        echo "<form action =\"\" method=\"post\"><button type=\"submit\" class=\"btn btn-primary\" id=\"add-product\" name=\"add-product\">New product</button></form>";
    }

    // modifier u nproduit existant
    static function editProducts() {
        if(isset($_POST['edit-product'])) {
            $db = App::getDatabase();
            $param = [$_POST['edit-product']];
            $product = $db->query('SELECT * FROM products WHERE id=?', $param)->fetch(PDO::FETCH_ASSOC);
            
            // affichage mono page des informations du produit à modifier
            echo "<p class=\"action\">Editing product ID #" . $_POST['edit-product'] . "</p>";
            echo "
            <form action =\"\" method=\"post\" enctype=\"multipart/form-data\">
            <p>
            <label for=\"edit-product-id\">ID</label>
            <input type=\"text\" id=\"edit-product-id\" name=\"edit-product-id\" value=\"" . $product['id'] ."\" readonly/>
            </p>
            <p>
            <label for=\"edit-product-name\">Name</label>
            <input type=\"text\" id=\"edit-product-name\" name=\"edit-product-name\" value=\"" . $product['name'] ."\" required/>
            </p>
            <p>
            <label for=\"edit-product-price\">Price</label>
            <input type=\"number\" id=\"edit-product-price\" name=\"edit-product-price\" value=\"" . $product['price'] ."\" required/>
            </p>
            <p>
            <label for=\"edit-product-category_id\">Category_id</label>
            <select id=\"edit-product-category_id\" name=\"edit-product-category_id\" required>"
            . self::listCategories($product['category_id']) . 
            "</select>
            </p>
            <p>
            <label for=\"edit-product-description\">Description</label>
            <textarea type=\"text\" id=\"edit-product-description\" name=\"edit-product-description\" required>" . $product['description'] . "</textarea>
            </p>
            <p>
            <label for=\"actual-product-picture\">Current picture</label>
            <input type=\"hidden\" id=\"actual-product-picture\" name=\"actual-product-picture\" value=\"" . $product['picture'] ."\" readonly/>
            <img class=\"current-pic\" src=\"." . PRODUCTS_IMG . $product['picture'] . "\" alt=\"product picture\"></img>
            </p>
            <p>
            <label for=\"edit-product-picture\">New picture</label>
            <input type=\"file\" id=\"edit-product-picture\" name=\"edit-product-picture\" />
            <p class=\"picture-format\">supported format: jpg, png</p>
            <p class=\"picture-size\">max size: 2Mo</p>
            </p>
            <button type=\"submit\" class=\"btn btn-success\" id=\"sub-edit-product\" name=\"sub-edit-product\">Submit</button>
            </form>";

        }
        // après validation du bouton de validation
        if(isset($_POST['sub-edit-product'])) {                
            $db = self::getDatabase();

            // gestion des erreurs
            if(isset($_FILES['edit-product-picture']) && !empty($_FILES['edit-product-picture']['name'])) { 
                $tmpName = $_FILES['edit-product-picture']['tmp_name'];
                $name = $_FILES['edit-product-picture']['name'];
                $size = $_FILES['edit-product-picture']['size'];
                $error = $_FILES['edit-product-picture']['error'];
                $tabExtension = explode('.', $name);
                // récupérer la dernière entrée du explode en cas de multiples . dans le nom du fichier
                $extension = strtolower(end($tabExtension));
                $maxsize = 2000000;
                // tableau des extensions acceptées
                $extensions = ['jpg', 'png', 'jpeg'];
                // générer un nom unique de fichier
                $uniqueName = uniqid('', true);
                $file = $uniqueName.".".$extension;

                if(in_array($extension, $extensions)){
                    if($size <= $maxsize) {
                        if($error == 0) {
                            $query = "UPDATE products SET name = ? , price = ? , category_id = ? , description = ? , picture = ? WHERE id = ? ";
                            $params = [$_POST['edit-product-name'], $_POST['edit-product-price'], $_POST['edit-product-category_id'], $_POST['edit-product-description'], $file, $_POST['edit-product-id']];
                            try {
                                $db->query($query, $params);
                                move_uploaded_file($tmpName, '../img/products/'.$file);
                            }
                            catch (PDOException $e) {
                                error_log($e->getMessage()."\n", 3, ERROR_LOG_FILE);
                                echo "<div class=\"connection_error\" id=\"hideMe\">
                                        <p>MySQL : An error occurred please try again later.</p>
                                    </div>";
                            }
                        } else {
                            echo "<div class=\"connection_error\" id=\"hideMe\">
                                    <p>Error: " . $error . "</p>
                                </div>";
                        }
                    } else {
                        echo "<div class=\"connection_error\" id=\"hideMe\">
                                <p>Error: file is too large to upload.</p>
                            </div>";
                    }
                }
                else{
                    echo "<div class=\"connection_error\" id=\"hideMe\">
                            <p>Error: format not supported.</p>
                        </div>";
                }            
            } else {
                $query = "UPDATE products SET name = ? , price = ? , category_id = ? , description = ? , picture = ? WHERE id = ? ";
                $param = [$_POST['edit-product-name'], $_POST['edit-product-price'], $_POST['edit-product-category_id'], $_POST['edit-product-description'], $_POST['actual-product-picture'], $_POST['edit-product-id']];
                try {
                    $db->query($query, $param);
                    echo "<div id=\"hideMe\"><p>Product ID #" . $_POST['edit-product-id'] . " has been modified</p></div>";                    
                }
                catch (PDOException $e) {
                    error_log($e->getMessage()."\n", 3, ERROR_LOG_FILE);
                    echo "<div class=\"connection_error\" id=\"hideMe\">
                            <p>MySQL : An error occurred please try again later.</p>
                        </div>";
                }
            }
            // revenir sur la page d'affichage de la table products
            self::getProducts();            
        }
    }

    // supprimer un produit
    static function deleteProducts() {
        if(isset($_POST['delete-product'])) {
            $db = App::getDatabase();
            $param = [$_POST['delete-product']];
            $product = $db->query('SELECT * FROM products WHERE id=?', $param)->fetch(PDO::FETCH_ASSOC);
            
            // affichage mono page des informations du produit à supprimer
            echo "<p class=\"action\">Deleting product ID #" . $_POST['delete-product'] . "</p>";
            echo "
            <form action =\"\" method=\"post\">
            <p>
            <label for=\"delete-product-id\">ID</label>
            <input type=\"text\" id=\"delete-product-id\" name=\"delete-product-id\" value=\"" . $product['id'] ."\" readonly/>
            </p>
            <p>
            <label for=\"delete-product-name\">Name</label>
            <input type=\"text\" id=\"delete-product-name\" name=\"delete-product-name\" value=\"" . $product['name'] ."\" readonly/>
            </p>
            <p>
            <label for=\"delete-product-price\">Price</label>
            <input type=\"number\" id=\"delete-product-price\" name=\"delete-product-price\" value=\"" . $product['price'] ."\" readonly/>
            </p>
            <p>
            <label for=\"delete-product-category_id\">Category_id</label>
            <input type=\"text\" id=\"delete-product-category_id\" name=\"delete-product-category_id\" value=\"" . $product['category_id'] ."\" readonly/>
            </p>
            <p>
            <label for=\"delete-product-description\">Description</label>
            <textarea type=\"text\" id=\"delete-product-description\" name=\"delete-product-description\" readonly>" . $product['description'] . "</textarea>
            </p>
            <p>
            <label for=\"delete-product-picture\">Picture</label>
            <input type=\"hidden\" id=\"delete-product-picture\" name=\"delete-product-picture\" value=\"" . $product['picture'] ."\" readonly/>
            <img class=\"current-pic\" src=\"." . PRODUCTS_IMG . $product['picture'] . "\" alt=\"product picture\"></img>
            </p>
            <p class=\"warning\">You are bout to delete this product. Are you sure ?</p>
            <button type=\"submit\" class=\"btn btn-danger\" id=\"sub-delete-product\" name=\"sub-delete-product\">Confirm</button>
            </form>";

        }
        // après validation via le bouton de confirmation
        if(isset($_POST['sub-delete-product'])) {
            $db = self::getDatabase();
            $query = "DELETE FROM products WHERE id = ?";
            $param = [$_POST['delete-product-id']];
            try {
                $db->query($query, $param);
                echo "<div id=\"hideMe\"><p>Product ID #" . $_POST['delete-product-id'] . " has been removed from database</p></div>";                    
                $file = "." . PRODUCTS_IMG . $_POST['delete-product-picture'];
                // suppression de l'image attachée au produit du répertoire idoine
                unlink($file);
            }
            catch (PDOException $e) {
                error_log($e->getMessage()."\n", 3, ERROR_LOG_FILE);
                echo "<div class=\"connection_error\" id=\"hideMe\">
                        <p>MySQL : An error occurred please try again later.</p>
                    </div>";
            }
            // revenir sur la page d'affichage de la table products
            self::getProducts();
        }
    }    

    // ajouter un nouveau produit
    static function addProducts() {
        if(isset($_POST['add-product'])) {
            // affichage mono page d'un formulaire vide
            echo "<form action =\"\" method=\"post\" enctype=\"multipart/form-data\">
            <p>
            <label for=\"add-product-name\">Name</label>
            <input type=\"text\" id=\"add-product-name\" name=\"add-product-name\" required/>
            </p>
            <p>
            <label for=\"add-product-price\">Price</label>
            <input type=\"number\" id=\"add-product-price\" name=\"add-product-price\" required/>
            </p>
            <p>
            <label for=\"add-product-category_id\">Category_id</label>            
            <select id=\"add-product-category_id\" name=\"add-product-category_id\" required/>"
            . self::listCategories() . 
            "</select>
            </p>
            <p>
            <label for=\"add-product-description\">Description</label>
            <textarea type=\"text\" id=\"add-product-description\" name=\"add-product-description\" required></textarea>
            </p>
            <p>
            <label for=\"add-product-picture\">Picture</label>
            <input type=\"file\" id=\"add-product-picture\" name=\"add-product-picture\" required/>
            <p class=\"picture-format\">supported format: jpg, png</p>
            <p class=\"picture-size\">max size: 2Mo</p>
            </p>
            <button type=\"submit\" class=\"btn btn-primary\" id=\"sub-add-product\" name=\"sub-add-product\">Add product</button>
            </form>";
        }

        // après validation de l'ajout d'un nouveau produit
        if(isset($_POST['sub-add-product'])) {
            $tmpName = $_FILES['add-product-picture']['tmp_name'];
            $name = $_FILES['add-product-picture']['name'];
            $size = $_FILES['add-product-picture']['size'];
            $error = $_FILES['add-product-picture']['error'];
            $tabExtension = explode('.', $name);
            // récupérer la dernière entrée du explode en cas de multiples . dans le nom du fichier
            $extension = strtolower(end($tabExtension));
            $maxsize = 2000000;
            // tableau des extensions acceptées
            $extensions = ['jpg', 'png', 'jpeg'];
            // générer un nom unique de fichier
            $uniqueName = uniqid('', true);
            $file = $uniqueName.".".$extension;


            // gestion des erreurs
            if(in_array($extension, $extensions)){
                if($size <= $maxsize) {
                    if($error == 0) {
                        try {
                            $db = self::getDatabase();    
                            $params = [$_POST['add-product-name'], $_POST['add-product-price'], $_POST['add-product-category_id'], $_POST['add-product-description'], $file];
                            $sql = $db->query("INSERT INTO products (name, price, category_id, description, picture) VALUES (?, ?, ?, ?, ?);", $params);
                            move_uploaded_file($tmpName, '../img/products/'.$file);
                        }
                        catch (PDOException $e) {
                            error_log($e->getMessage()."\n", 3, ERROR_LOG_FILE);
                            echo "<div class=\"connection_error\" id=\"hideMe\">
                                    <p>MySQL : An error occurred please try again later.</p>
                                </div>";
                        }
                    } else {
                        echo "<div class=\"connection_error\" id=\"hideMe\">
                                <p>Error: " . $error . "</p>
                            </div>";
                    }
                } else {
                    echo "<div class=\"connection_error\" id=\"hideMe\">
                            <p>Error: file is too large to upload.</p>
                        </div>";
                }
            }
            else{
                echo "<div class=\"connection_error\" id=\"hideMe\">
                        <p>Error: format not supported.</p>
                    </div>";
            }
            // revenir sur la page d'affichage de la table products
            self::getProducts();
        }
    }

    // affichage des catégories
    static function getCategories() {
        $db = self::getDatabase();
        $query = "SELECT * FROM categories";
        $result = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);

        // affichage mono page du contenu de la table categories
        echo "<table>";
        echo "<caption>Watching table : categories</caption>";
        echo "<tr>";
        echo "<th scope=\"col\">ID</th>";
        echo "<th scope=\"col\">name</th>";
        echo "<th scope=\"col\">parent_id</th>";
        echo "</tr>";
        foreach ($result as $key => $value) {
            echo "<tr>";
                echo "<td class=\"td-id\">" . $value['id'] . "</td>";
                echo "<td>" . $value['name'] . "</td>";
                echo "<td>" . $value['parent_id'] . "</td>";
                echo "<td class=\"td-btn-category\">
                        <form action=\"\" method=\"post\">
                            <button type=\"submit\" class=\"btn btn-warning\" id=\"edit-category\" name=\"edit-category\" value=\"" . $value['id'] . "\">Edit</button>
                            <button type=\"submit\" class=\"btn btn-danger\" id=\"delete-category\" name=\"delete-category\" value=\"" . $value['id'] . "\">Delete</button>
                        </form>
                    </td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<form action =\"\" method=\"post\"><button type=\"submit\" class=\"btn btn-primary\" id=\"add-category\" name=\"add-category\">New category</button></form>";
    }

    // modifier une category
    static function editCategories() {
        if(isset($_POST['edit-category'])) {
            $db = App::getDatabase();
            $param = [$_POST['edit-category']];
            $category = $db->query('SELECT * FROM categories WHERE id=?', $param)->fetch(PDO::FETCH_ASSOC);
            
            // affichage mono page des informations de la category à modifier
            echo "<p class=\"action\">Editing category ID #" . $_POST['edit-category'] . "</p>";
            echo "
            <form action =\"\" method=\"post\">
            <p>
            <label for=\"edit-category-id\">ID</label>
            <input type=\"text\" id=\"edit-category-id\" name=\"edit-category-id\" value=\"" . $category['id'] ."\" readonly/>
            </p>
            <p>
            <label for=\"edit-category-name\">Name</label>
            <input type=\"text\" id=\"edit-category-name\" name=\"edit-category-name\" value=\"" . $category['name'] ."\"/ required>
            </p>
            <p>
            <label for=\"edit-category-category_id\">Parent_id</label>
            <select id=\"edit-category-parent_id\" name=\"edit-category-parent_id\" required/>"
            . self::parentCategories($category['parent_id']) . 
            "</select>
            </p>
            <button type=\"submit\" class=\"btn btn-success\" id=\"sub-edit-category\" name=\"sub-edit-category\">Submit</button>
            </form>";

        }
        
        // après validation via le bouton submit
        if(isset($_POST['sub-edit-category'])) {
            $db = self::getDatabase();
            $query = "UPDATE categories SET name = ? , parent_id = ? WHERE id = ?";
            $param = [$_POST['edit-category-name'], $_POST['edit-category-parent_id'], $_POST['edit-category-id']];
            try {
                $db->query($query, $param);
                echo "<div id=\"hideMe\"><p>Category ID #" . $_POST['edit-category-id'] . " has been modified</p></div>";                    
            }
            catch (PDOException $e) {
                error_log($e->getMessage()."\n", 3, ERROR_LOG_FILE);
                echo "<div class=\"connection_error\" id=\"hideMe\">
                        <p>MySQL : An error occurred please try again later.</p>
                    </div>";
            }
            // revenir sur la page d'affichage de la table categories
            self::getCategories();            
        }
    }    

    // suppression d'une category
    static function deleteCategories() {
        if(isset($_POST['delete-category'])) {
            $db = App::getDatabase();
            $param = [$_POST['delete-category']];
            $category = $db->query('SELECT * FROM categories WHERE id=?', $param)->fetch(PDO::FETCH_ASSOC);
            
            // affichage mono page du détail de la category à delete
            echo "<p class=\"action\">Deleting category ID #" . $_POST['delete-category'] . "</p>";
            echo "
            <form action =\"\" method=\"post\">
            <p>
            <label for=\"delete-category-id\">ID</label>
            <input type=\"text\" id=\"delete-category-id\" name=\"delete-category-id\" value=\"" . $category['id'] ."\" readonly/>
            </p>
            <p>
            <label for=\"delete-category-name\">Name</label>
            <input type=\"text\" id=\"delete-category-name\" name=\"delete-category-name\" value=\"" . $category['name'] ."\" readonly/>
            </p>
            <p>
            <label for=\"delete-category-category_id\">Parent_id</label>
            <input type=\"text\" id=\"delete-category-parent_id\" name=\"delete-category-parent_id\" value=\"" . $category['parent_id'] ."\" readonly/>
            </p>
            <p class=\"warning\">You are bout to delete this product. Are you sure ?</p>
            <button type=\"submit\" class=\"btn btn-danger\" id=\"sub-delete-category\" name=\"sub-delete-category\">Confirm</button>
            </form>";

        }

        // après confirmation du delete via le bouton confirm
        if(isset($_POST['sub-delete-category'])) {
            $db = self::getDatabase();
            $query = "DELETE FROM categories WHERE id = ?";
            // màj des tables products et categories pour remplacer l'ID de category qui vient d'être delete
            $queryProd = "UPDATE products SET category_id = NULL WHERE category_id = ?";
            $queryCat = "UPDATE categories SET parent_id = NULL WHERE parent_id = ?";
            $param = [$_POST['delete-category-id']];
            try {
                $db->query($query, $param);
                $db->query($queryProd, $param);
                $db->query($queryCat, $param);
                echo "<div id=\"hideMe\"><p>Category ID #" . $_POST['delete-category-id'] . " has been removed from database</p></div>";                    
            }
            catch (PDOException $e) {
                error_log($e->getMessage()."\n", 3, ERROR_LOG_FILE);
                echo "<div class=\"connection_error\" id=\"hideMe\">
                        <p>MySQL : An error occurred please try again later.</p>
                    </div>";
            }
            // revenir sur la page d'affichage de la table categories
            self::getCategories();            
        }
    } 

    // ajouter une nouvelle category
    static function addCategories() {
        if(isset($_POST['add-category'])) {
            // affichage mono page d'un formulaire vide
            echo "<form action =\"\" method=\"post\">
            <p>
            <label for=\"add-category-name\">Name</label>
            <input type=\"text\" id=\"add-category-name\" name=\"add-category-name\" required/>
            </p>
            <p>
            <label for=\"add-category-parent_id\">Parent_id</label>            
            <select id=\"add-category-parent_id\" name=\"add-category-parent_id\" required/>"
            . self::parentCategories() . 
            "</select>
            </p>
            <button type=\"submit\" class=\"btn btn-primary\" id=\"sub-add-category\" name=\"sub-add-category\">Add category</button>
            </form>";
        }

        // après confirmation via le bouton add
        if(isset($_POST['sub-add-category'])) {
            try {
                $db = self::getDatabase();    
                $params = [$_POST['add-category-name'], $_POST['add-category-parent_id']];
                $sql = $db->query("INSERT INTO categories (name, parent_id) VALUES (?, ?);", $params);
            }
            catch (PDOException $e) {
                error_log($e->getMessage()."\n", 3, ERROR_LOG_FILE);
                echo "<div class=\"connection_error\" id=\"hideMe\">
                        <p>MySQL : An error occurred please try again later.</p>
                    </div>";
            }
            // revenir sur la page d'affichage de la table categories
            self::getCategories();
        }
    }

    // lister les categories existantes dans la DB pour limiter les erreurs de l'admin
    static function listCategories($param = NULL) {
        $db = self::getDatabase();
        $query = "SELECT id, name FROM categories";
        $categories = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
        $list = "";
        foreach ($categories as $key => $value) {
            if(isset($param) && $value['id'] == $param) {
                $list .= "<option value=" . $value['id'] . " selected>" . $value['name'] . "</option>";
            } else {
                $list .= "<option value=" . $value['id'] . ">" . $value['name'] . "</option>";
            }
        }
        return $list;
    }

    // lister les categories liées au parent_id existantes dans la DB pour limiter les erreurs de l'admin    
    static function parentCategories($param = NULL) {
        $db = self::getDatabase();
        $query = "SELECT id, name FROM categories";
        $categories = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
        $list = "<option value=NULL></option>";
        foreach ($categories as $key => $value) {
            if(isset($param) && $value['id'] == $param) {
                $list .= "<option value=" . $value['id'] . " selected>" . $value['name'] . "</option>";
            } else {
                $list .= "<option value=" . $value['id'] . ">" . $value['name'] . "</option>";
            }
        }
        return $list;
    }

    // préparation de la requête d'affichage des produits en fonction des filtres passés
    static function filter_products($param = NULL, $cat = NULL) {
        // vérifier si le texte tapé dans la searchbar est numérique ou non
        // si oui inclure le prix dans la requête de filtre
        // si non ne filtrer que sur name et description
        if(isset($_POST['filter_search']) && !empty($_POST['filter_search'])) {
            $fieldSearch = $_POST['filter_search'];
            if(is_numeric($_POST['filter_search'])) {
                $fieldName = "(price LIKE '%" . $fieldSearch . "%' OR name LIKE '%" . $fieldSearch . "%' OR description";
            } else {
                $fieldName = "(name LIKE '%" . $fieldSearch . "%' OR description";
            }
        }

        // gestion des options de tri de la requête
        if(isset($_POST['filter_sort']) && !empty($_POST['filter_sort'])) {
            $orderBy = " " . $_POST['filter_sort'] . " ";
        } else if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            switch ($_GET['sort']) {
                case 0:
                    $orderBy = " ORDER BY name ASC ";
                    break;
                case 1:
                    $orderBy = " ORDER BY name DESC ";
                    break;
                case 2:
                    $orderBy = " ORDER BY price ASC ";
                    break;
                case 3:
                    $orderBy = " ORDER BY price DESC ";
                    break;
                default:
                    $orderBy = " ";
            }
        } else {
            $orderBy = " ";
        }

        // filtrer sur le prix du range
        if(isset($_POST['filter_price']) && !empty($_POST['filter_price'])) {
            $price = " AND price <" . $_POST['filter_price'] . " ";
        } else {
            $price = " ";
        }

        // limiter la quantité de produit par page au nombre passé en paramètre
        if(isset($param)) {
            if(isset($cat)) {
                if(isset($_POST['filter_search']) && !empty($_POST['filter_search'])) {
                    $query = "SELECT * FROM products" . $cat . " AND " . $fieldName . " LIKE '%" . $fieldSearch . "%')" . $price . $orderBy . "LIMIT " . $param . ", " . NB_PER_PAGE;
                } else {
                    $query = "SELECT * FROM products" . $cat  . $price .  $orderBy . "LIMIT " . $param . ", " . NB_PER_PAGE;
                }
            } else {
                if(isset($_POST['filter_search']) && !empty($_POST['filter_search'])) {
                    $query = "SELECT * FROM products WHERE " . $fieldName . " LIKE '%" . $fieldSearch . "%')". $price . $orderBy . "LIMIT " . $param . ", " . NB_PER_PAGE;
                } else {
                    $query = "SELECT * FROM products" . $price . $orderBy . "LIMIT " . $param . ", " . NB_PER_PAGE;
                }
            }
        } else {
            if(isset($cat)) {
                if(isset($_POST['filter_search']) && !empty($_POST['filter_search'])) {
                    $query = "SELECT * FROM products" . $cat . " AND " . $fieldName . " LIKE '%" . $fieldSearch . "%')" . $price . $orderBy;
                } else {
                    $query = "SELECT * FROM products" . $cat . $price . $orderBy;
                }
            } else {
                if(isset($_POST['filter_search']) && !empty($_POST['filter_search'])) {
                    $query = "SELECT * FROM products WHERE " . $fieldName . " LIKE '%" . $fieldSearch . "%')" . $price . $orderBy;
                } else {
                    $query = "SELECT * FROM products" . $price . $orderBy;
                }
            }
        }
        return $query;
    }

    // filtrer la requête sur la categorie choisie par l'utilisateur
    // et les categories associées par méthode récursive
    // stocker le tout dans une variable static
    static function filter_categories($param = 0) {
        $db = self::getDatabase();
        $query = "SELECT * FROM categories WHERE parent_id = " . $param;
        $categories = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);

            foreach ($categories as $key => $value) {
                if(!empty($value['parent_id'])) {
                    self::$cat .= "," . $value['id'];
                    self::filter_categories($value['id']);
                } else {
                    self::$cat .= "," . $value['id'];
                }
            }
    }

    // récupérer les ID de category stockés dans la variable static
    // créer la sous-chaîne de la requête qui filtre les produits
    static function products_by_categories($arg) {
        //$arg = 2;
        self::filter_categories($arg);

        if(!is_null(self::$cat)) {
            return " WHERE category_id IN (" . $arg . "," . substr(self::$cat,1) . ")";
        } else {
            return " WHERE category_id IN (" . $arg . ")";
        }
    }

    // récupérer le tri choisi par le user pour gérer l'affichage des pages
    // en conservant le tri
    static function getFilter() {
        if(isset($_POST['filter_sort']) && !empty($_POST['filter_sort'])) {
            switch ($_POST['filter_sort']) {
                case "ORDER BY name ASC":
                    $orderBy = "&sort=0";
                    break;
                case "ORDER BY name DESC":
                    $orderBy = "&sort=1";
                    break;
                case "ORDER BY price ASC":
                    $orderBy = "&sort=2";
                    break;
                case "ORDER BY price DESC":
                    $orderBy = "&sort=3";
                    break;
                default:
                    $orderBy = "";
            }
        } else if (isset($_GET['sort']) && !empty($_GET['sort'])) {
            $orderBy = "&sort=" . $_GET['sort'];
        } else {
            $orderBy = "";
        }
            return $orderBy;
    }


    static function display_products($arg) {
        $db = self::getDatabase();
        // $arg contient $_POST de index.php
        $param = $arg['filter_category'];
        $order = $arg['filter_sort'];
        $price = $arg['filter_price'];
        $query = self::filter_products(NULL, self::products_by_categories($param));
        $products = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
        $nbProducts = count($products);
        $nbPages = ceil($nbProducts/NB_PER_PAGE);
        $nbPerPage = NB_PER_PAGE;

        // gestion de l'affichage des produits sur la page index
        if($nbProducts<=$nbPerPage) {
            // si le nombre de produit à afficher est inférieur ou égal à la limite fixée
            foreach ($products as $key => $value) {
                // réduction de la longueur de la description pour la page index
                if(strlen($value['description']) > 60) {
                    $shortDescription = substr($value['description'],0,57) . "...";
                } else {
                    $shortDescription = $value['description'];
                }           
                echo "<div class=\"card bg-light mb-3\">
                            <!-- <div class=\"card-header\">Header</div> -->
                            <div class=\"card-body\">
                                <a href=\"./pages/details.php?product=" . $value['id'] . "\">
                                <div class=\"card-img\">
                                <img src=\"". PRODUCTS_IMG . $value['picture'] . "\" alt=\"product's picture\"></img></div>
                                <h5 class=\"card-title\">" . $value['name'] . "<p>" . $value['price'] . "€</p></h5>
                                <p class=\"card-text\">" . $shortDescription . "</p></a>
                            </div>
                        </div>";
            }
            // footer avec pagination vide
            echo "</div><div class=\"page-footer\">
            <nav class =\"page-nav no-item\" aria-label=\"Page navigation example\">
                <ul class=\"pagination\">";
                echo "<li class=\"no-page-item\"></li>";
            echo "</ul>
                </nav>";            
        } else {
            // si le nombre de produit à afficher est supérieur à la limite fixée            
            if(isset($_GET['items'])) {
                $query = self::filter_products($_GET['items'], self::products_by_categories($param));
            } else {
                $query = self::filter_products(0, self::products_by_categories($param));
            }
            $products = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
            foreach ($products as $key => $value) {
                if(strlen($value['description']) > 60) {
                    $shortDescription = substr($value['description'],0,57) . "...";
                } else {
                    $shortDescription = $value['description'];
                }
                echo "<div class=\"card bg-light mb-3\">
                            <!-- <div class=\"card-header\">Header</div> -->
                            <div class=\"card-body\">
                                <a href=\"./pages/details.php?product=" . $value['id'] . "\">
                                <div class=\"card-img\">
                                <img src=\"". PRODUCTS_IMG . $value['picture'] . "\" alt=\"product's picture\"></img></div>
                                <h5 class=\"card-title\">" . $value['name'] . "<p>" . $value['price'] . "€</p></h5>
                                <p class=\"card-text\">" . $shortDescription . "</p></a>
                            </div>
                        </div>";
            }
            // footer avec pagination pleine
            echo "</div><div class=\"page-footer\">
            <nav class =\"page-nav\" aria-label=\"Page navigation example\">
                <ul class=\"pagination\">";
            $pageCount = 0;                
            for($i=0; $i<$nbPages; $i++) {
                echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?items=" . $pageCount . ""; echo self::getFilter(); echo "\">" . ($i + 1) . "</a></li>";
                $pageCount += $nbPerPage;
            }   
            echo "</ul>
                </nav>";
        }
    }

    // affichage des filtres dans l'encart supérieur gauche de la div content
    static function filter_bar() {    
        echo "<form class=\"filter_criteria\" action=\"\" method=\"post\">
        <input class=\"form-control\" type=\"search\" id=\"filter_search\" name=\"filter_search\" placeholder=\"search terms\" aria-label=\"Search\" value=\"";
            if(isset($_POST['filter_search'])) {echo $_POST['filter_search'];}
        echo "\">
        <label for=\"filter_sort\">sort by</label>
        <select class=\"dropdown-toggle\" name=\"filter_sort\" id=\"filter_sort\" aria-label=\"Sort results criteria\">
            <option value=\"ORDER BY name ASC\""; if(isset($_GET['sort']) && $_GET['sort'] == "0") { echo "selected"; } echo ">name alpha</option>
            <option value=\"ORDER BY name DESC\""; if(isset($_GET['sort']) && $_GET['sort'] == "1") { echo "selected"; } echo ">name reverse alpha</option>
            <option value=\"ORDER BY price ASC\""; if(isset($_GET['sort']) && $_GET['sort'] == "2") { echo "selected"; } echo ">price ASC</option>
            <option value=\"ORDER BY price DESC\""; if(isset($_GET['sort']) && $_GET['sort'] == "3") { echo "selected"; } echo ">price DESC</option>
        </select>
        <label for=\"filter_category\">filter by</label>
        <select class=\"dropdown-toggle\" name=\"filter_category\" id=\"filter_category\" aria-label=\"Filter categories criteria\">";
            if(isset($_POST['filter_category'])) {
                echo App::listCategories($_POST['filter_category']);
            } else {
                echo App::listCategories();
            }
        echo "</select>
        <label for=\"filter_price\">Price (lower than)</label><br />
        <div class=\"price_range\">
        <output>0</output>€     
        <input type=\"range\" id=\"filter_price\" name=\"filter_price\" value=\"";
            if(isset($_POST['filter_price'])) {echo $_POST['filter_price'];} else {echo 0;}
        echo "\" min=\"0\" max=\"500\" oninput=\"this.nextElementSibling.value = this.value\">
        <output>";
            if(isset($_POST['filter_price'])) {echo $_POST['filter_price'];} else {echo 0;}
        echo "</output>€
        </div> 
        <button type=\"submit\" class=\"btn btn-light\" id=\"filter_submit\" name=\"filter_submit\">Search products</button>
        <button type=\"submit\" class=\"btn btn-light\" id=\"filter_reset\" name=\"filter_reset\">Reset criteria</button>
    </form>";
    }

    // affichage des détails du produit sélectionné
    static function display_details() {
        if(isset($_GET['product']) && !empty($_GET['product'])) {
                    
            $db = self::getDatabase();
            $query = "SELECT * FROM products WHERE id=" . $_GET['product'];
            $value = $db->query($query)->fetch(PDO::FETCH_ASSOC);

            // détail produit avec description complète, image plus grande
            // et liens de partage twitter/facebook/email
            echo "<div class=\"detail--product\">
                        <div class=\"detail--product--img\"><img src=\".". PRODUCTS_IMG . $value['picture'] . "\" alt=\"product detailed picture\"></img></div>
                        <div class=\"detail--product--text\">
                            <h5 class=\"detail--product--text--title\">" . $value['name'] . "<p>" . $value['price'] . "€</p></h5>
                            <p class=\"detail--product--text--description\">" . $value['description'] . "</p>
                            <hr></hr>
                            <p>You like it ? Share it with your friends !</p>
                            <div class=\"social\">
                                <a class=\"twitter-share-button\" href=\"https://twitter.com/intent/tweet?text=I saw this and thought you would like it&url=https://www.myshop.com/pages/details.php?product=" . $value['id'] . "&hashtags=MyShop\" target=\"_blank\">
                                    <i class=\"bi bi-twitter\"></i>
                                </a>
                                <a href=\"https://www.facebook.com/sharer.php?u=https://www.myshop.com/pages/details.php?product=" . $value['id'] . "\" target=\"_blank\">
                                    <i class=\"bi bi-facebook\"></i>
                                </a>
                                <a href=\"mailto:?Subject=MyShop is awesome&amp;Body=I saw this and thought you would like it : https://www.myshop.com/pages/details.php?product=" . $value['id'] . "\">
                                    <i class=\"bi bi-envelope\"></i>
                                </a>
                            </div>
                        </div>
                    </div>";

            // lien pour revenir à la page index
            echo "<div class=\"back\"><a class=\"back--link\" href=\"../index.php\"><i class=\"bi bi-box-arrow-in-left\"></i> Back to main page</a></div>";
            echo "<div class=\"page-footer\">
            <nav class =\"page-nav no-item\" aria-label=\"Page navigation item details\">
                <ul class=\"pagination\">";
                echo "<li class=\"no-page-item\"></li>";
            echo "</ul>
                </nav>";              
        } else {
            // gestion d'erreur si le user tente de modifier l'url
            echo "<div class=\"detail--product\">";
            echo "An error occurred, please try again later";
            echo "</div>";
            echo "<div class=\"back\"><a class=\"back--link\" href=\"../index.php\"><i class=\"bi bi-box-arrow-in-left\"></i> Back to main page</a></div>";
            echo "<div class=\"page-footer\">
            <nav class =\"page-nav no-item\" aria-label=\"Page navigation item details\">
                <ul class=\"pagination\">";
                echo "<li class=\"no-page-item\"></li>";
            echo "</ul>
                </nav>";              
        }
    }

    // page de gestion du profil utilisateur
    // accessible depuis la nav bar
    static function manage_profile() {
        if(isset($_COOKIE['my_shop-user']) || isset($_SESSION['my_shop-user'])) {
            if(isset($_COOKIE['my_shop-user'])) {
                $email = [$_COOKIE['my_shop-email']];
            }
            if(isset($_SESSION['my_shop-user'])) {
                $email = [$_SESSION['my_shop-email']];
            }

            $db = self::getDatabase();
            $query = "SELECT id, username, email, avatar FROM users WHERE email=?";
            $user = $db->query($query, $email)->fetch(PDO::FETCH_ASSOC);

            echo "
            <form action =\"\" method=\"post\" enctype=\"multipart/form-data\">
            <p class=\"current-container\">";
            if(isset($user['avatar']) && !empty($user['avatar'])) {
                echo "<img class=\"current-pic\" src=\"." . USER_IMG . $user['avatar'] . "\" alt=\"user avatar\"></img>";
            } else {
                echo "<img class=\"current-pic\" src=\"." . USER_IMG . "default.jpg\" alt=\"default user avatar\"></img>";
            }
            echo "
            <input type=\"hidden\" id=\"edit-user-id\" name=\"edit-user-id\" value=\"" . $user['id'] ."\" readonly/>
            </p>
            <p class=\"current-element\">
            <label for=\"edit-user-name\">Your name</label>
            <input type=\"text\" id=\"edit-user-name\" name=\"edit-user-name\" value=\"" . $user['username'] ."\" required/>
            </p>
            <p class=\"current-element\">
            <label for=\"edit-user-email\">Your email</label>
            <input type=\"email\" id=\"edit-user-email\" name=\"edit-user-email\" value=\"" . $user['email'] ."\" required/>
            </p>
            <p class=\"current-element\">
            <input type=\"hidden\" id=\"actual-user-picture\" name=\"actual-user-picture\" value=\"" . $user['avatar'] ."\" readonly/>
            </p>
            <p class=\"current-element\">
            <label for=\"edit-user-picture\">Set a new avatar</label>
            <input type=\"file\" id=\"edit-user-picture\" name=\"edit-user-picture\" />
                <p class=\"picture-format\">supported format: jpg, png</p>
                <p class=\"picture-size\">max size: 2Mo</p>
            </p>                    
            <button type=\"submit\" class=\"btn btn-success\" id=\"sub-edit-user\" name=\"sub-edit-user\">Submit</button>
            </form>";

            if(isset($_POST['sub-edit-user'])) {                
                $db = self::getDatabase();
    
                // gestion des erreurs
                if(isset($_FILES['edit-user-picture']) && !empty($_FILES['edit-user-picture']['name'])) { 
                    $oldfile = "." . USER_IMG . $_POST['actual-user-picture'];
                    $tmpName = $_FILES['edit-user-picture']['tmp_name'];
                    $name = $_FILES['edit-user-picture']['name'];
                    $size = $_FILES['edit-user-picture']['size'];
                    $error = $_FILES['edit-user-picture']['error'];
                    $tabExtension = explode('.', $name);
                    // récupérer la dernière entrée du explode en cas de multiples . dans le nom du fichier
                    $extension = strtolower(end($tabExtension));
                    $maxsize = 2000000;
                    // tableau des extensions acceptées
                    $extensions = ['jpg', 'png', 'jpeg'];
                    // générer un nom unique de fichier
                    $uniqueName = uniqid('', true);
                    $file = $uniqueName.".".$extension;
    
                    if(in_array($extension, $extensions)){
                        if($size <= $maxsize) {
                            if($error == 0) {
                                $query = "UPDATE users SET username = ?, email = ? , avatar = ? WHERE id = ? ";
                                $params = [$_POST['edit-user-name'], $_POST['edit-user-email'], $file, $_POST['edit-user-id']];
                                try {
                                    $db->query($query, $params);
                                    unlink($oldfile);
                                    move_uploaded_file($tmpName, '.' . USER_IMG .$file);

                                    // le user a changé son profil => mettre à jour cookie/session en conséquence
                                    if(isset($_COOKIE['my_shop-user'])) {
                                        self::remove_cookie("my_shop-user");
                                        self::remove_cookie("my_shop-email");
                                        self::set_cookie("my_shop-user", $_POST['edit-user-name']);
                                        self::set_cookie("my_shop-email", $_POST['edit-user-email']);                                          
                                        self::set_cookie("my_shop-avatar", $file);                                          
                                    }
                                    if(isset($_SESSION['my_shop-user'])) {
                                        self::set_session('my_shop-user', $_POST['edit-user-name']);
                                        self::set_session('my_shop-email', $_POST['edit-user-email']);
                                        self::set_session('my_shop-avatar',$file);
                                    }
                                    
                                    echo "<div id=\"hideMe\"><p>Your profile has been modified</p></div>";                                        
                                }
                                catch (PDOException $e) {
                                    error_log($e->getMessage()."\n", 3, ERROR_LOG_FILE);
                                    echo "<div class=\"connection_error\" id=\"hideMe\">
                                            <p>MySQL : An error occurred please try again later.</p>
                                        </div>";
                                }
                            } else {
                                echo "<div class=\"connection_error\" id=\"hideMe\">
                                        <p>Error: " . $error . "</p>
                                    </div>";
                            }
                        } else {
                            echo "<div class=\"connection_error\" id=\"hideMe\">
                                    <p>Error: file is too large to upload.</p>
                                </div>";
                        }
                    } else{
                        echo "<div class=\"connection_error\" id=\"hideMe\">
                                <p>Error: format not supported.</p>
                            </div>";
                    }            
                } else {
                    // si le user n'a pas choisi une nouvelle image pour son avatar
                    $query = "UPDATE users SET username = ?, email = ? , avatar = ? WHERE id = ? ";
                    $param = [$_POST['edit-user-name'], $_POST['edit-user-email'], $_POST['actual-user-picture'], $_POST['edit-user-id']];
                    try {
                        $db->query($query, $param);
                        echo "<div id=\"hideMe\"><p>Your profile has been modified</p></div>";                    
                                    // le user a changé son profil => mettre à jour cookie/session en conséquence
                                    if(isset($_COOKIE['my_shop-user'])) {
                                        self::remove_cookie("my_shop-user");
                                        self::remove_cookie("my_shop-email");
                                        self::set_cookie("my_shop-user", $_POST['edit-user-name']);
                                        self::set_cookie("my_shop-email", $_POST['edit-user-email']);                                          
                                        self::set_cookie("my_shop-avatar", $_POST['actual-user-picture']);                                          
                                    }
                                    if(isset($_SESSION['my_shop-user'])) {
                                        self::set_session('my_shop-user', $_POST['edit-user-name']);
                                        self::set_session('my_shop-email', $_POST['edit-user-email']);
                                        self::set_session('my_shop-avatar', $_POST['actual-user-picture']);
                                    }
                    }
                    catch (PDOException $e) {
                        error_log($e->getMessage()."\n", 3, ERROR_LOG_FILE);
                        echo "<div class=\"connection_error\" id=\"hideMe\">
                                <p>MySQL : An error occurred please try again later.</p>
                            </div>";
                    }
                }
                header("Location: ./profile.php");
                die();    
            }
        }
    // afficher le lien pour revenir à la page index
    echo "<div class=\"back\"><a class=\"back--link\" href=\"../index.php\"><i class=\"bi bi-box-arrow-in-left\"></i> Back to main page</a></div>";
    }


}

class Database {

    private $pdo;

    // instanciation de PDO pour créer l'objet Database
    public function __construct ($login, $password, $db_name, $host = 'localhost', $port = 3306) {
        $this->pdo = new PDO("mysql:host=".$host.":".$port.";dbname=".$db_name, $login, $password);
    }

    // préparation de la requête pour la méthode query
    public function query ($query, $params = false) {
        if($params) {
            $req = $this->pdo->prepare($query);
            $req->execute($params);
        } else {
            $req = $this->pdo->query($query);
        }

        return $req;
    }
}