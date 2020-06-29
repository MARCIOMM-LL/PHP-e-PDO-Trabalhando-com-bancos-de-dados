<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$sqlDelete = 'DELETE FROM  students WHERE id = ?;';
$prepareStatement = $pdo->prepare($sqlDelete);
$prepareStatement->bindValue(1, 1, PDO::PARAM_INT);
$prepareStatement->execute();