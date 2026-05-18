<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $password = $_POST['password'];

    // Demo Password
    if ($password === "a@d@m@i-n123") {

        $_SESSION['admin_logged_in'] = true;

        header("Location: dashboard.php");
        exit();

    } else {

        $error = "Invalid Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>

<style>

body{
    margin:0;
    font-family:Arial,sans-serif;
    background:#0a1628;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.login-box{
    width:350px;
    background:#fff;
    padding:40px;
    border-radius:10px;
    box-shadow:0 10px 30px rgba(0,0,0,.2);
}

h2{
    margin-bottom:25px;
    text-align:center;
    color:#0a1628;
}

input{
    width:100%;
    padding:14px;
    margin-bottom:20px;
    border:1px solid #ccc;
    border-radius:5px;
    font-size:15px;
    box-sizing:border-box;
}

button{
    width:100%;
    padding:14px;
    background:#ce2026;
    color:#fff;
    border:none;
    border-radius:5px;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#8c0f13;
}

.error{
    background:#ffdede;
    color:#b10000;
    padding:12px;
    border-radius:5px;
    margin-bottom:15px;
    text-align:center;
}

</style>
</head>
<body>

<div class="login-box">

    <h2>Admin Login</h2>

    <?php if($error != "") { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <form method="POST">

        <input
            type="password"
            name="password"
            placeholder="Enter Password"
            required
        >

        <button type="submit">
            Login
        </button>

    </form>

</div>

</body>
</html>