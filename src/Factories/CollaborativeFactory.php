<?php

namespace NJUPTAAA\ProblemRecommendation\Factories;

use NJUPTAAA\ProblemRecommendation\Creator\CollaborativeCreator;
use NJUPTAAA\ProblemRecommendation\Interfaces\CollaborativeInterface;

class CollaborativeFactory extends CollaborativeCreator
{
    /**
     * @param CollaborativeInterface $col
     * @param array $table
     * @param mixed $user
     * @param mixed $score
     * 
     * @return [type]
     */
    protected function factoryMethod(CollaborativeInterface $col, $table, $user, $score)
    {
        return $col->recommend($table, $user, $score);
    }
}
