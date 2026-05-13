<!-- CRUD -->

<?php
class Album {
    private $conn;
    private $table = "albums";

    public function __construct($db) { $this->conn = $db; }

    // Read: Display list [cite: 28]
    public function read($user_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt;
    }

    // Create: Add item [cite: 27]
    public function create($title, $artist, $genre, $user_id) {
        $query = "INSERT INTO " . $this->table . " (title, artist, genre, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$title, $artist, $genre, $user_id]);
    }

    // Delete: Remove item [cite: 30]
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>