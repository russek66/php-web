<?php

namespace App\User;

use App\Core\DatabaseFactory;

readonly class UserData
{

    public function __construct(
        private mixed $data,
        private mixed $database = new DatabaseFactory()
    )
    {

    }

    public function getUserDataById(): mixed
    {
        $sql = "SELECT 
                    *
                FROM 
                    users
                WHERE 
                    user_id = :user_id
                LIMIT 1";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query?->execute(array(
                ':user_id' => $this->data->userId
            )
        );

        return $query?->fetch();
    }

    public function getUserTokenById(): mixed
    {
        $sql = "SELECT 
                    user_access_token
                FROM 
                    users
                WHERE 
                    user_id = :user_id
                LIMIT 1";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query->execute(array(
                ':user_id' => $this->data["user_id"]
            )
        );

        return $query->fetch();
    }

    public function getUserIdBySocialId(): mixed
    {
        $sql = "SELECT 
                    user_id
                FROM 
                    users
                WHERE 
                    user_id_social = :user_id_social
                AND 
                    user_provider_type = :user_provider_type
                LIMIT 1";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query->execute(array(
                ':user_id_social' => $this->data["user_id_social"],
                ':user_provider_type' => $this->data["user_provider_type"]
            )
        );

        return $query->fetch();
    }
}
