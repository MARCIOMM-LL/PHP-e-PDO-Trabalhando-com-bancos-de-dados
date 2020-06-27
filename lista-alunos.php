<?php

#Importação da classe Student
use Alura\Pdo\Domain\Model\Student;

#Criando importação de classes com composer
require_once 'vendor/autoload.php';

#Criando conexão com o banco de dados
$databasePath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $databasePath);

$statement = $pdo->query('SELECT * FROM students;');
$studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
$studentList = [];

foreach ($studentDataList as $studentData) {
    $studentList[] = new Student(
        $studentData['id'],
        $studentData['name'],
        new \DateTimeImmutable($studentData['birth_date'])
    );
}

var_dump($studentList);

// echo $studentList[0][1];