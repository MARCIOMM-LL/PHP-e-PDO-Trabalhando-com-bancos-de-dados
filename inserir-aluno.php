<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$student = new Student(
    null, 
    'Marcio', 
    new \DateTimeImmutable('1988-09-22'));

#Preparando a consulta para evitar SQLINJECTION 
$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (?, ?);";
$statement = $pdo->prepare($sqlInsert); 
$statement->bindValue(1, $student->name());        
$statement->bindValue(2, $student->birthDate()->format('Y-m-d'));

if($statement->execute()){
    echo 'Inserido';
}    

// var_dump($pdo->exec($sqlInsert));