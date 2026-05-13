<!-- Authentication -->

<?php
include_once 'Database.php';
if ($_POST) {
    $database = new Database();
    $db = $database->getConnection();
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if($stmt->execute([$_POST['username'], $hash])) {
        header("Location: login.php"); // [cite: 23]
    }
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body>
    <form method="post" class="auth-form">
        <h2>Join the Studio</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
        <p>Already a member? <a href="login.php">Login</a></p>
    </form>
</body>
</html>