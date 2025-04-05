<?php
class myAuthClass
{
    public static function is_auth($current_session)
    {
        if (isset($current_session['user']) && !empty($current_session['user']))
            return true;
        return false;
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
        return $result;
    } else {
        // Le mot de passe est incorrect
        return false;
    }
}
}
