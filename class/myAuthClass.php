<?php
class myAuthClass
{
    // URL de l'API définie comme constante de classe
    const API_LOGIN_URL = 'http://62.72.18.63:11042/user/login';
    
    public static function is_auth($current_session)
    {
        if (isset($current_session['user']) && !empty($current_session['user']))
            return true;
        return false;
    }

    // Fonction d'obtention du token déplacée au niveau de la classe
    private static function getAPIToken($email, $password)
    {
        $login_data = [
            'email' => $email,
            'password' => $password
        ];
        
        $ch = curl_init(self::API_LOGIN_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($login_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Débogage de la réponse API
        error_log("API Login Response [Code: $http_code]: " . substr($response, 0, 500));
        
        curl_close($ch);
        if ($http_code === 201) {
            $response_data = json_decode($response, true);
            if (isset($response_data['data']['token'])) {
                return $response_data['data']['token'];
            }
        }
        
        return null;
    }

    public static function authenticate($email, $password)
    {
        $db = require(dirname(__FILE__) . '/../lib/mypdo.php');
        $fields = array(
            'id',
            'password',
            'email',
            'is_admin',
        );
        $sql = 'SELECT '.implode(', ', $fields).' ';
        $sql .= 'FROM users ';
        $sql .= 'WHERE email = :email';
        $statement = $db->prepare($sql);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($password, $result['password'])) {
            // Le mot de passe est correct
            
            // Obtention du token API
            $api_token = self::getAPIToken($email, $password);
            
            // Vérification du token avant de le stocker
            if ($api_token) {
                $_SESSION['token_api'] = $api_token;
                error_log("Token API obtenu et stocké pour l'utilisateur: $email");
            } else {
                error_log("Échec de l'obtention du token API pour l'utilisateur: $email");
                $_SESSION['token_api'] = null;
            }

            return $result;
        } else {
            // Le mot de passe est incorrect
            return false;
        }
    }
}