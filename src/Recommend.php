<?php

namespace NJUPTAAA\ProblemRecommendation;

use NJUPTAAA\ProblemRecommendation\Collaborative\EuclideanCollaborative;
use NJUPTAAA\ProblemRecommendation\Collaborative\RankingCollaborative;
use NJUPTAAA\ProblemRecommendation\Collaborative\SlopeOneCollaborative;
use NJUPTAAA\ProblemRecommendation\Factories\CollaborativeFactory;

/**
 * [class Recommend]
 * 
 * @package recommendation
 * @author Tiago A C Pereira
 */
class Recommend
{
    protected $method;

    protected $score;
    protected $object_id;
    protected $user_id;

    public function __construct($score = 'score', $object_id = 'object_id', $user_id = 'user_id')
    {
        $this->score = $score;
        $this->object_id = $object_id;
        $this->user_id = $user_id;

        $this->method = new CollaborativeFactory();
    }

    /**
     * Get ranking | collaborative filtering algorithm.
     * @param array $table
     * @param mixed $user
     * @param mixed $score
     *
     * @return array
     */
    public function ranking($table, $user, $score = 0)
    {
        return $this->method->doFactory(new RankingCollaborative($this->score, $this->object_id, $this->user_id), $table, $user, $score);
    }

    /**
     * Get euclidean | collaborative filtering algorithm.
     * @param array $table
     * @param mixed $user
     * @param mixed $score
     * 
     * @return array
     */
    public function euclidean($table, $user, $score = 0)
    {
        return $this->method->doFactory(new EuclideanCollaborative($this->score, $this->object_id, $this->user_id), $table, $user, $score);
    }

    /**
     * Get slope one | collaborative filtering algorithm.
     * @param array $table
     * @param mixed $user
     * @param mixed $score
     * 
     * @return [type]
     */
    public function slopeOne($table, $user, $score = 0)
    {
        return $this->method->doFactory(new SlopeOneCollaborative($this->score, $this->object_id, $this->user_id), $table, $user, $score);
    }
}
