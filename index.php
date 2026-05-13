<!-- CRUD view -->

<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: login.php");

include_once 'Database.php';
include_once 'Album.php';

$database = new Database();
$db = $database->getConnection();
$albumObj = new Album($db);

if (isset($_POST['add'])) {
    $albumObj->create($_POST['title'], $_POST['artist'], $_POST['genre'], $_SESSION['user_id']);
}

if (isset($_GET['delete'])) {
    $albumObj->delete($_GET['delete']);
}

$stmt = $albumObj->read($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Music Library</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <h1>My Vinyl Collection</h1>
        <a href="logout.php">Logout</a>
    </nav>
    
    <div class="container">
        <form method="post" class="add-box">
            <input type="text" name="title" placeholder="Album Title" required>
            <input type="text" name="artist" placeholder="Artist" required>
            <input type="text" name="genre" placeholder="Genre">
            <button type="submit" name="add">Add Album</button>
        </form>

        <div class="grid">
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="card">
                    <h3><?php echo $row['title']; ?></h3>
                    <p><?php echo $row['artist']; ?> (<?php echo $row['genre']; ?>)</p>
                    <a href="index.php?delete=<?php echo $row['id']; ?>" class="del-btn">Remove</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>