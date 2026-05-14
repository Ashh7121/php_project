<?php
session_start();
// Security: Check if user is logged in using $_SESSION [cite: 22]
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirection [cite: 23]
    exit();
}

include_once 'Database.php';
include_once 'Album.php';

$database = new Database();
$db = $database->getConnection();
$albumObj = new Album($db);

// Fetch only the items belonging to this user [cite: 7]
$stmt = $albumObj->read($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Music Library - View All</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <h1>My Library</h1>
        <div>
            <a href="index.php" style="margin-right: 15px;">Add New</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>
    
    <div class="container">
        <h2>Your Saved Albums</h2>
        <hr>
        
        <div class="grid">
            <?php if ($stmt->rowCount() > 0): ?>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="card">
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p><strong>Artist:</strong> <?php echo htmlspecialchars($row['artist']); ?></p>
                        <p><strong>Genre:</strong> <?php echo htmlspecialchars($row['genre']); ?></p>
                        <a href="index.php?delete=<?php echo $row['id']; ?>" class="del-btn" onclick="return confirm('Are you sure?')">Remove from Library</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Your library is empty. <a href="index.php">Add your first album here!</a></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>