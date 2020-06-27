<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $databasePath);

$sqlDelete = 'DELETE FROM  students WHERE id = ?;';
$prepareStatement = $pdo->prepare($sqlDelete);
$prepareStatement->bindValue(1, 2, PDO::PARAM_INT);
$prepareStatement->execute();