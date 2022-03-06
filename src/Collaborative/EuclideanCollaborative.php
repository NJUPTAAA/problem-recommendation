<?php

namespace NJUPTAAA\ProblemRecommendation\Collaborative;

use NJUPTAAA\ProblemRecommendation\Collaborative\Base;
use NJUPTAAA\ProblemRecommendation\Traits\OperationTrait;

/**
 * Collaborative filtering [recommendation algorithm EuclideanCollaborative].
 * Using the Euclidean distance formula and applying a weighted average.
 * 
 * @author Tiago A C Pereira <tiagocavalcante57@gmail.com>
 */
class EuclideanCollaborative extends Base
{

    use OperationTrait;

    /**
     * Get recommend.
     * @param array $table
     * @param mixed $user
     * @param mixed $score
     * 
     * @return array
     */
    public function recommend($table, $user, $score = 0)
    {
        $data = $this->average($table, $user, $score);
        return $this->filterRating($data);
    }

    /**
     * Get users who rated the same product.
     * @param array $table
     * @param mixed $user
     * @param mixed $score
     * 
     * @return array
     */
    private function userRated($table, $user, $score)
    {
        $this->ratedProduct($table, $user);
        $rated = []; //get user rating
        foreach ($this->product as $myProduct) {
            foreach ($this->other as $item) {
                if ($myProduct[$this->object_id] == $item[$this->object_id]) {
                    if ($myProduct[$this->score] >= $score && $item[$this->score] >= $score) {
                        if (!in_array($item[$this->user_id], $rated)) // check if user already exists
                            $rated[] = $item[$this->user_id]; //add user
                    }
                }
            }
        }
        return $rated;
    }

    /**
     * Get operation|using part of the euclidean formula (p-q).
     * @param array $table
     * @param mixed $user
     * @param mixed $score
     * 
     * @return array
     */
    private function operation($table, $user, $score)
    {
        $rated = $this->userRated($table, $user, $score);
        $data = [];
        foreach ($this->product as $myProduct) {
            for ($i = 0; $i < count($rated); $i++) {
                foreach ($this->other as $itemOther) {
                    if (
                        $itemOther[$this->user_id] == $rated[$i] &&
                        $myProduct[$this->object_id] == $itemOther[$this->object_id]
                        && $myProduct[$this->score] >= $score && $itemOther[$this->score] >= $score
                    ) {
                        $data[$itemOther[$this->user_id]][$myProduct[$this->object_id]] = abs($itemOther[$this->score] - $myProduct[$this->score]);
                    }
                }
            }
        }
        return $data;
    }

    /**
     * Using the metric distance formula and convert value to percentage.
     * @param array $table
     * @param mixed $user
     * @param mixed $score
     *  
     * @return array
     */
    private function metricDistance($table, $user, $score)
    {
        $data = $this->operation($table, $user, $score);
        $element = [];
        foreach ($data as $item) {
            foreach ($item as $value) {
                if (!isset($element[key($data)]))
                    $element[key($data)] = 0;
                $element[key($data)] += pow($value, 2);
            }
            $similarity = round(sqrt($element[key($data)]), 2); //similarity rate
            $element[key($data)] =  round(1 / (1 + $similarity), 2); //convert value
            next($data);
        }
        return $element;
    }


    /**
     * Get weighted average.
     * @param array $table 
     * @param mixed $user
     * @param mixed $score
     * 
     * @return array
     */
    private function average($table, $user, $score)
    {
        $metric = $this->metricDistance($table, $user, $score);
        $similarity = [];
        $element = [];
        foreach ($metric as $itemMetric) {
            foreach ($this->other as $itemOther) {
                if ($itemOther[$this->user_id] == key($metric) && $itemOther[$this->score] >= $score) {
                    if (!isset($element[$itemOther[$this->object_id]])) {
                        $element[$itemOther[$this->object_id]] = 0;
                        $similarity[$itemOther[$this->object_id]] = 0;
                    }
                    $element[$itemOther[$this->object_id]] += ($itemMetric * $itemOther[$this->score]);
                    $similarity[$itemOther[$this->object_id]] += $itemMetric;
                }
            }
            next($metric);
        }
        return $this->division($element, $similarity);
    }
}
