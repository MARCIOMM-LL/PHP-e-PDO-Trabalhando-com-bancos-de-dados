<?php

namespace Alura\Pdo\Domain\Repository;

use Alura\Pdo\Domain\Model\Student;

#Aqui na interface está o conceito a ser implementado
interface StudentRepository
{
    public function allStudents(): array;
    public function studentsWithPhones(): array;
    public function StudentsBirthAt(\DateTimeImmutable $birthDate): array;
    public function save(Student $student): bool;
    public function remove(Student $student): bool;
}