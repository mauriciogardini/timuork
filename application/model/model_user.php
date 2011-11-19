<?php
    require_once(INCLUDES_PATH . "/session_includes.php");
    require_once(INCLUDES_PATH . "/validation_includes.php");
    require_once(INCLUDES_PATH . "/security_includes.php");
    require_once(INCLUDES_PATH . "/user_includes.php");

    class model_user extends Application {
        function __construct() {
            //
        }

        function get_user_session() {
            return check_session();
        }

        function add($user) {
            if(validate_username($user->username)) {
                if(validate_password($user->password)) {
                    if(validate_email($user->email)) {
                        $crypted_password = crypt_word($user->password);
                        if ($crypted_password != NULL)
                        {
                            $user->password = $crypted_password;
                            if(user_create($user)) {
                                return  "O usuário " . $user->name . " foi cadastrado com sucesso.";
                            }
                            else {
                                return  "Já existe um usuário utilizando este username.";
                            }    
                        }
                        else
                        {
                            return "O sistema estea indisponível. Tente novamente mais tarde.";
                        }       
                    }
                    else {
                        return "E-mail inválido.";
                    }
                }
                else {
                    return "O password informado precisa ter entre 6 e 24 caracteres."; 
                }
            }
            else {
                return "O username só pode conter letras, números e '_'";
            }
        }

        function select() {
        
        }

        function authenticate($auth_user) {
            return user_authenticate($auth_user);
        }
    }
?>
