
<?php
session_start();
// include "../connect.php";
$conn = mysqli_connect('localhost','root',"",'sales');

$position=$_SESSION['SESS_LAST_NAME'];

if($position!="admin"){
    echo "<script>
        alert('Sorry, Access Denied!');
        window.location = 'index.php';
    </script>";
}

if(isset($_POST['btn_add_user'])){
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $name = $_POST['name'];
    $position = $_POST['position'];


    $sql = "";
    $res = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($res);
    if($row['username']=='$username'){
        echo "<script>
            alert('User Already Exist!');
            window.location = 'add_user.php';
        </script>";
    }else{
        $sql = "INSERT INTO user (username, password, name, position) VALUES('$username', '$password', '$name', '$position')";
        $result = mysqli_query($conn, $sql);
        if($result){
           echo "<script>
            alert('User Added Successfullly..');
            window.location = 'index.php';
           </script>";
           exit();
        }

    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <style>
        body{
            height: 100vh;
           background-image:  #FFFFFF;
           background-repeat: no-repeat;
           background-size: cover;
        }

        form{
            display:flex;
            flex-direction: column;
            align-items:center;
            justify-content:center;
            background-color: whitesmoke;
            margin: 100px 450px;
            border-radius: 10px;
            box-shadow: 2px 3px 4px black;
        }

        input, button{
            padding: 6px;
            margin-bottom: 5px;
        }

        button{
            background-color: #099909;
            color: white;
        }

        button:hover{
            opacity:0.8;
            cursor:pointer;
        }
    </style>
</head>
<body>
    <header>
        <a href="index.php"><h2>Back to Dashboard</h2></a>
    </header>

    <form action="add_user.php" method="post">
        <h2>Add User</h2>
        <input type="text" placeholder="Enter Username" name="username"><br><br>
        <input type="password" placeholder="Enter Password" name="password"><br><br>
        <input type="text" placeholder="Enter Name" name="name"><br><br>
        <input type="text" placeholder="Enter Position" name="position"><br><br>
        <button name="btn_add_user">Add user</button>
    </form>
</body>
</html>