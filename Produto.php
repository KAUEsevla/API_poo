<?php
require_once 'Database.php';

class Produto {
    private Database $db;
    private string $table = 'produtos';

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getAll(): array {
        $sql = "SELECT * FROM {$this->table} ORDER BY id";
        return $this->db->select($sql);
    }//buscar todos os dados

    public function findById(int $id): ?array {
        $sql = "SELECT * FROM {$this->table} WHERE id = {$id} LIMIT 1";
        return $this->db->select($sql);
    }//buscar um dado específico

    public function create(array $data): int {
        $sql = "INSERT INTO {$this->table} (descri, preco) VALUES (:descri, :preco)";
        return $this->db->insert($sql, [
            'descri' => $data["descri"],
            'preco' => $data["preco"]
        ]);
    }//inserir um dado na tabela

    public function update(int $id, array $data): bool {
        $sql = "UPDATE {$this->table} SET descri = :descri, preco = :preco WHERE id = :id";
        $rows = $this->db->updatedelete($sql, [
            'descri' => $data["descri"],
            'preco' => $data["preco"],
            'id' => $id
        ]);
        return $rows > 0;
    }//atualizar um dado na tabela

    public function delete(int $id): bool {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $rows = $this->db->updatedelete($sql, ['id' => $id]);
        return $rows > 0;
    }//deletar um dado na tabela
}
?>