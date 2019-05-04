<?php


class QueryBuilder
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function __destruct()
    {
        $this->pdo = null;
    }

    public function showColumns($table)
    {
        $sql = "DESCRIBE {$table}";
        $statement = $this->pdo->query($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getAll($table)
    {
        $sql = "SELECT * FROM {$table}";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne($table, $id)
    {
        $sql = "SELECT * FROM {$table} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($table, $data)
    {
        $keys = array_keys($data);
        $allowed = implode(",", $keys);
        $values = ":" . implode(",:", $keys);

        $sql = "INSERT INTO {$table} ($allowed) VALUES ($values)";
        $statement = $this->pdo->prepare($sql);
        return $statement->execute($data);
    }

    public function update($table, $data, $id)
    {
        $keys = array_keys($data);
        $string = '';
        foreach ($keys as $key){
            $string .= $key . '=:' . $key . ', ';
        }
        $keys = rtrim($string, ', ');
        $data['id'] = $id;
        $sql = "UPDATE {$table} SET {$keys} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id);
        $statement->execute($data);
    }

    public function delete($table, $id)
    {
        $sql = "DELETE FROM {$table} WHERE id=:id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
    }

    public function find($table, $column, $search_word)
    {
        $search_word = "%$search_word%";
        $statement  = $this->pdo->prepare("SELECT * FROM {$table} WHERE {$column} LIKE ?");
        $statement->execute(array($search_word));
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByColumn($table, $column, $value)
    {
        $field = $column . '=:' . $column;
        $sql = "SELECT * FROM {$table} WHERE {$field}";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([":$column" => $value]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}