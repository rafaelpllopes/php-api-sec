<?php

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\User;
use Exception;
use PDO;

class UserRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function add(User $user): bool
    {
        $sql = 'INSERT INTO users (email, password) VALUES (?, ?)';
        $statement = $this->pdo->prepare($sql);

        $hash = password_hash($user->password, PASSWORD_ARGON2ID);

        $statement->bindValue(1, $user->email);
        $statement->bindValue(2, $hash);

        $result = $statement->execute();
        $id = $this->pdo->lastInsertId();

        $user->setId(intval($id));

        return $result;
    }

    public function remove(int $id): bool
    {
        $sql = 'DELETE FROM users WHERE id = ?';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $id);

        return $statement->execute();
    }

    public function update(User $user): bool
    {
        $sql = 'UPDATE users SET email = :email, password = :password WHERE id = :id;';
        $statement = $this->pdo->prepare($sql);

        $hash = password_hash($user->password, PASSWORD_ARGON2ID);

        $statement->bindValue(':url', $user->email);
        $statement->bindValue(':password', $hash);
        $statement->bindValue(':id', $user->id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function updatePassword(string $password, int $id): bool
    {
        $sql = 'UPDATE users SET password = :password WHERE id = :id;';
        $statement = $this->pdo->prepare($sql);

        $hash = password_hash($password, PASSWORD_ARGON2ID);

        $statement->bindValue(':password', $hash);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }

    /**
     * @return User[]
     */
    public function all(): array
    {
        $userList = $this->pdo
            ->query('SELECT * FROM users;')
            ->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(
            $this->hydrateUser(...),
            $userList
        );
    }

    public function find(int $id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM users WHERE id = ?;');
        $statement->bindValue(1, $id, \PDO::PARAM_INT);
        $statement->execute();

        return $this->hydrateUser($statement->fetch(\PDO::FETCH_ASSOC));
    }

    public function login(string $email): ?User
    {
        $sqlQuery = "SELECT * FROM users WHERE email = ?;";
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->bindValue(1, $email, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        return $this->hydrateUser($result);
    }

    private function hydrateUser(array $userData): User
    {
        $user = new user($userData['email'], $userData['password']);
        $user->setId($userData['id']);

        return $user;
    }
}
