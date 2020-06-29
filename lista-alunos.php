<?php

#Importação da classe Student
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

#Criando importação de classes com composer
require_once 'vendor/autoload.php';

#Criando conexão com o banco de dados
$pdo = ConnectionCreator::createConnection();
$repository = new PdoStudentRepository($pdo);
$studentList = $repository->allStudents();

var_dump($studentList);

// echo $studentList[0][1];