<?php
    /*Default*/
    class ReviewDAO{
        public function add($review, $db){
            return $db->insert('review', [
                "title"=>$review["title"],
                "content"=>$review["content"],
                "score"=>$review["score"],
                "phone"=>$review["phone"],
                "createdDate"=>$review["createdDate"],
                "post_id"=>$review["post_id"],
                "user_id"=>$review["user_id"],
            ])->rowCount();
        }
        public function getByScore($review, $db){
            return $db->select('review', '*', [
                "score"=>$review["score"],
            ]);
        }
        public function getByPost($review, $db){
            return $db->select('review', '*', [
                "post_id"=>$review["post_id"],
            ]);
        }
        public function getByUser($review, $db){
            return $db->select('review', '*', [
                "user_id"=>$review["user_id"],
            ]);
        }
        public function update($review, $db){
            return $db->update('review', $review, [
                "id"=>$review["id"],
            ])->rowCount();
        }
        public function delete($review, $db){
            return $db->delete('review', [
                "AND"=>[
                    "id"=>$review["id"]
                ]
            ])->rowCount();
        }
    }
    return new ReviewDAO();
?>