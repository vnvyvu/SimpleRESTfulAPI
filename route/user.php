<?php
    /*Default*/
    class UserDAO{
        public function add($user, $db){
            return $db->insert('user', [
                "username"=>$user["username"],
                "password"=>$user["password"],
                "email"=>$user["email"],
                "phone"=>$user["phone"],
                "createdDate"=>$user["createdDate"],
            ])->rowCount();
        }
        public function authenticate($user, $db){
            return $db->select('user', '*', [
                "AND"=>[
                    "username"=>$user["username"],
                    "password"=>$user["password"]
                ]
            ]);
        }
        public function getUser($o, $db){
            return $db->select('user', '*', [
                "id"=>$o["user_id"],
            ]);
        }
        public function forgotPassword($user, $db){
            return $db->update('user', [
                "password"=>$user["password"],
            ], [
                "AND"=>[
                    "username"=>$user["username"],
                    "email"=>$user["email"]
                ]
            ])->rowCount();
        }
        public function update($user, $db){
            return $db->update('user', $user, [
                "id"=>$user["id"],
            ])->rowCount();
        }
        public function delete($user, $db){
            return $db->delete('user', [
                    "id"=>$user["id"]
                ]
            )->rowCount();
        }
    }
    return new UserDAO();
?>