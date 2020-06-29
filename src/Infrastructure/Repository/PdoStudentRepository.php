<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Model\Phone;
use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;

#O processo de extrair toda a lógica de acesso ao
#repositório/dados do nosso domínio é um padrão chamado
#de Repository. Um repositório nada mais é do que uma classe
#que permite o acesso aos nossos dados, independentemente
#de onde eles estejam em forma de coleção. As formas de nomear
#os métodos que lembra uma coleção é que define um repositório
#Se tivéssemos os 4 métodos métodos/cruds, aí seria o padrão DAO/DataAccessObjec 
class PdoStudentRepository implements StudentRepository
{
    private \PDO $connection;

    #O conceito aplicado aqui é chamado de injeção de dependência
    #que ao invés de criar a dependência dentro da classe, ele 
    #pede para que alguém envie essa dependência através de uma
    #classe, que neste caso é a classe PDO
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function allStudents(): array
    {
        $sqlQuery ='SELECT * FROM students;';
        $stmt = $this->connection->query($sqlQuery);

        return $this->hydrateStudentList($stmt);
    }

    public function StudentsBirthAt(\DateTimeImmutable $birthDate): array
    {
        $sqlQuery = 'SELECT * FROM students WHERE birth_date = ?;';
        $stmt = $this->connection->prepare($sqlQuery);
        $stmt->bindValue(1, $birthDate->format('Y-m-d'));
        $stmt->execute();

        return $this->hydrateStudentList($stmt);
    }

    #O conceito de hydrate é um padrão que traz dados
    #de uma camada para outra, aqui no caso estamos
    #trazendo do banco para o nosso negócio
    public function hydrateStudentList(\PDOStatement $stmt): array
    {
        $studentDataList = $stmt->fetchAll();
        $studentList = [];

        foreach ($studentDataList as $studentData){
            $studentList[] = new Student(
                $studentData['id'],
                $studentData['name'],
                new \DateTimeImmutable($studentData['birth_date'])
            );
        }

        return $studentList;
    }

    public function save(Student $student): bool
    {
        if ($student->id() === null) {
            return $this->insert($student);
        }

        return $this->update($student);
    }

    public function insert(Student $student): bool
    {
        $insertQeury = 'INSERT INTO students (name, birth_date) VALUES (:name, :birth_date);';
        $stmt = $this->connection->prepare($insertQeury);

        #Passando o bindParam ou bindValue direto no execute 
        $success = $stmt->execute([
            ':name' => $student->name(),
            ':birth_date' => $student->birthDate()->format('Y-m-d')
        ]);

        if ($success){ #O lastInsertId é uma método do PDO
            $student->defineId($this->connection->lastInsertId());
        }

        return $success;
    }

    public function update(Student $student)
    {
        $updateQuery = 'UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id;';
        $stmt = $this->connection->prepare($updateQuery);
        $stmt->bindValue(':name', $student->name());
        $stmt->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'));
        $stmt->bindValue(':id', $student->id(), \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function remove(Student $student): bool
    {
        $stmt = $this->connection->prepare('DELETE FROM  students WHERE id = ?;');
        $stmt->bindValue(1, $student->id, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function studentsWithPhones(): array
    {
        $sqlQuery = 'SELECT students.id,
                            students.name,
                            students.birth_date,
                            phones.id AS phone_id,
                            phones.area_code,
                            phones.number
                       FROM students
                       JOIN phones ON students.id = phones.student_id;';
        $stmt = $this->connection->query($sqlQuery);
        $result = $stmt->fetchAll();
        $studentList = [];

        foreach ($result as $row) {
            if (!array_key_exists($row['id'], $studentList)) {
                $studentList[$row['id']] = new Student(
                    $row['id'],
                    $row['name'],
                    new \DateTimeImmutable($row['birth_date'])
                );
            }
            $phone = new Phone($row['phone_id'], $row['area_code'], $row['number']);
            $studentList[$row['id']]->addPhone($phone);
        }

        return $studentList;
    }
}