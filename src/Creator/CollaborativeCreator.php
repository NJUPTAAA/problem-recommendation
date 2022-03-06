<?php

namespace NJUPTAAA\ProblemRecommendation\Creator;

use NJUPTAAA\ProblemRecommendation\Interfaces\CollaborativeInterface;

abstract class CollaborativeCreator
{

    /**
     * @param CollaborativeInterface $col
     * @param array $table
     * @param mixed $user
     * @param mixed $score
     * 
     * @return [type]
     */
    protected abstract function factoryMethod(CollaborativeInterface $col, $table, $user, $score);

    /**
     * @param CollaborativeInterface $method
     * @param array $table
     * @param mixed $user
     * @param mixed $score
     * 
     * @return [type]
     */
    public function doFactory($method, $table, $user, $score)
    {
        return $this->factoryMethod($method, $table, $user, $score);
    }
}
