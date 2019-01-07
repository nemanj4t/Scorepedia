<?php

namespace App\Auth;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Ahsan\Neo4j\Facade\Cypher;

class Neo4jUserProvider implements UserProvider
{

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $result = Cypher::run("MATCH (s) WHERE ID(s) = ".$identifier." RETURN s");

        $admin = new \App\Admin;
        $admin->id = $result->firstRecord()->values()[0]->identity();
        $admin->email = $result->firstRecord()->values()[0]->values()['email'];
        $admin->password = $result->firstRecord()->values()[0]->values()['password'];
        $admin->token = $result->firstRecord()->values()[0]->values()['token'];

        return $admin;
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed $identifier
     * @param  string $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $result = Cypher::run("MATCH (s) WHERE ID(s) = ".$identifier." AND s.token = '".$token."' RETURN s");

        $admin = new \App\Admin;
        $admin->id = $result->firstRecord()->values()[0]->identity();
        $admin->email = $result->firstRecord()->values()[0]->values()['email'];
        $admin->password = $result->firstRecord()->values()[0]->values()['password'];
        $admin->token = $result->firstRecord()->values()[0]->values()['token'];

        return $admin;
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        $user->setRememberToken($token);
        Cypher::run("MATCH (s) WHERE ID(s) = ".$user->id." SET s.token ='".$token."' RETURN s");
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $email = $credentials['email'];
        $password = $credentials['password'];

        $result = Cypher::run("MATCH (a:Admin) WHERE a.email ='".$email."' RETURN a");
        $admin = new \App\Admin;

        if ($result->hasRecord())
       {
            $passHashed = $result->firstRecord()->values()[0]->values()['password'];

            if (password_verify($password, $passHashed))
           {
                $admin->id = $result->firstRecord()->values()[0]->identity();
                $admin->email = $result->firstRecord()->values()[0]->values()['email'];
                $admin->password = $result->firstRecord()->values()[0]->values()['password'];
                $admin->token = $result->firstRecord()->values()[0]->values()['token'];
            }
        }

        return $admin;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return ($user->email == $credentials['email']) && (password_verify($credentials['password'], $user->password));
    }
}
