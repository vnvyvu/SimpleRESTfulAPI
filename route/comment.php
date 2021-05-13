<?php
    /*Default*/
    class CommentDAO{
        public function add($comment, $db){
            return $db->insert('comment', [
                "content"=>$comment["content"],
                "createdDate"=>$comment["createdDate"],
                "user_id"=>$comment["user_id"],
                "review_id"=>$comment["review_id"],
            ])->rowCount();
        }
        public function getByUser($comment, $db){
            return $db->select('comment', '*', [
                "user_id"=>$comment["user_id"],
            ]);
        }
        public function getByReview($comment, $db){
            return $db->select('comment', '*', [
                "review_id"=>$comment["review_id"],
            ]);
        }
        public function update($comment, $db){
            return $db->update('comment', $comment, [
                "id"=>$comment["id"],
            ])->rowCount();
        }
        public function delete($comment, $db){
            return $db->delete('comment', [
                "AND"=>[
                    "id"=>$comment["id"]
                ]
            ])->rowCount();
        }
    }
    return new CommentDAO();
?>