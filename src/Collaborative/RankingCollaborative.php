<?php

namespace NJUPTAAA\ProblemRecommendation\Collaborative;

use NJUPTAAA\ProblemRecommendation\Collaborative\Base;

/**
 * Collaborative filtering [recommendation algorithm RankingCollaborative].
 * The algorithm checks for similar ratings compared to other users,
 * and adds a weight score and generate a rating for each product.
 * Example: user1 liked [A, B, C, D] and user2 liked [A, B] 
 * recommend product [C, D] to user2 (product score = [C = 2 ; D = 2]).  
 * 
 * @author Tiago A C Pereira <tiagocavalcante57@gmail.com>
 */
class RankingCollaborative extends Base
{

    /**
     * Get Recommend.  
     * @param array $table
     * @param mixed $user
     * @param mixed $score
     * 
     * @return array
     */
    public function recommend($table, $user, $score = 0)
    {
        $data = $this->addRating($table, $user, $score);
        return $this->filterRating($data);
    }

    /**
     * Find similar users (Add weight score).
     * @param array $table
     * @param mixed $user
     * 
     * @return array
     */
    private function similarUser($table, $user)
    {
        $this->ratedProduct($table, $user); //get [product, other]    
        $similar = []; //get users with similar tastes
        $rank = [];
        foreach ($this->product as $myProduct) {
            foreach ($this->other as $item) {
                if ($myProduct[$this->object_id] == $item[$this->object_id]) {
                    if ($myProduct[$this->score] == $item[$this->score]) {
                        if (!isset($similar[$item[$this->user_id]]))
                            $similar[$item[$this->user_id]] = 0; //
                        $similar[$item[$this->user_id]] += 1; //assigning weight     
                    }
                }
            }
        }
        return $similar;
    }


    /**
     * Add Rating | Add a score (+value) for each recommended product.
     * @param array $table
     * @param mixed $user
     * @param mixed $score
     * 
     * @return array
     */
    private function addRating($table, $user, $score)
    {
        $similar =  $this->similarUser($table, $user);
        $rank = [];
        foreach ($this->other as $item) {
            foreach ($similar as $value) {
                if ($item[$this->user_id] == key($similar) && $item[$this->score] > $score) {
                    if (!isset($rank[$item[$this->object_id]]))
                        $rank[$item[$this->object_id]] = 0; //assign value for calculation
                    $rank[$item[$this->object_id]] += $value; //add   
                }
                next($similar);
            }
            reset($similar);
        }
        return $rank;
    }
}
