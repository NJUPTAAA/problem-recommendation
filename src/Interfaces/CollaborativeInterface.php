<?php

namespace NJUPTAAA\ProblemRecommendation\Interfaces;

interface CollaborativeInterface
{
    public function recommend($table, $user, $score = 0);
}
