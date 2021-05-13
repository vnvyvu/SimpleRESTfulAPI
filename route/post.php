<?php
    /*Default*/
    class PostDAO{
        public function add($post, $db){
            return $db->insert('post', [
                "name"=>$post["name"],
                "detail"=>$post["detail"],
                "image"=>$post["email"],
                "createdDate"=>$post["createdDate"],
                "user_id"=>$post["user_id"],
            ])->rowCount();
        }
        public function getByTitle($post, $db){
            return $db->select('post', '*', [
                "title[~]"=>mb_split("/[\W]+/", $post["title"]),
            ]);
        }
        public function getByUser($post, $db){
            return $db->select('post', '*', [
                "user_id"=>$post["user_id"],
            ]);
        }
        public function update($post, $db){
            return $db->update('post', $post, [
                "id"=>$post["id"],
            ])->rowCount();
        }
        public function delete($post, $db){
            return $db->delete('post', [
                "AND"=>[
                    "id"=>$post["id"]
                ]
            ])->rowCount();
        }
    }
    return new PostDAO();
?>