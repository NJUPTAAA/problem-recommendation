<?php

namespace NJUPTAAA\ProblemRecommendation\Collaborative;

use NJUPTAAA\ProblemRecommendation\Interfaces\CollaborativeInterface;

/**
 * [Base]
 * 
 * @author Tiago A C Pereira <tiagocavalcante57@gmail.com>
 */
abstract class Base implements CollaborativeInterface
{
    protected $score;
    protected $object_id;
    protected $user_id;

    public function __construct($score = 'score', $object_id = 'object_id', $user_id = 'user_id')
    {
        $this->score = $score;
        $this->object_id = $object_id;
        $this->user_id = $user_id;
    }

    /** 
     * User rated product.
     * @var array
     */
    protected $product = [];

    /**
     * Product rated by other users. 
     * @var array
     */
    protected $other = [];

    /**
     * Get rated product.
     * @param array $table
     * @param mixed $user
     * 
     * @return [type]
     */
    protected function ratedProduct($table, $user)
    {
        foreach ($table as $item) {
            $item[$this->user_id] == $user ?  $this->product[] = $item : $this->other[] = $item;
        }
    }


    /**
     * Get filter rating.
     * Remove product that the user has rated.
     * @param array $data
     * 
     * @return array
     */
    protected function filterRating($data)
    {
        $myRank = $data;
        $rank = $myRank;
        for ($i = 0; $i < count($myRank); $i++) {
            foreach ($this->product as $item) {
                if ($item[$this->object_id] == key($myRank))
                    unset($rank[key($myRank)]); // remove product
            }
            next($myRank);
        }
        arsort($rank);
        return $rank;
    }
}
