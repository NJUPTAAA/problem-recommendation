# NOJ Problem Recommendation

NOJ Problem Recommendation based on awesome algorithm by [tigoCaval](https://github.com/tigoCaval/recommendation-algorithm).

## Getting started

For PHP >= 7.0, require package using composer:

```bash
composer require njuptaaa/problem-recommendation
```

## Supporting Algorithms

- ranking
- euclidean
- slope one

## Introduction

Recommend a problem using collaborative filtering:

```php
/**
 * $table gets the array from the database.
 * $user is the foreign key that represents the user who will receive the recommendation.
 */
use NJUPTAAA\ProblemRecommendation\Recommend;

$client = new Recommend();
$client->ranking($table, $user); // optional third parameter refers to the score not accepted
$client->euclidean($table, $user); // optional third parameter refers to the minimum accepted score
$client->slopeOne($table, $user); // optional third parameter refers to the minimum accepted score
```

### Configuration

```php
$client = new Recommend('score', 'pid', 'uid');
```
