<?php

$first_name = $last_name = $username = $password = $confirm_password = '';
$first_name_err = $last_name_err = $username_err = $password_err = $confirm_password_err = '';

$validate_failed = false;

if(!empty($_SESSION['logged_in']) && $_SESSION['logged_in'] == true ){
    header('location: index.php');
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    require_once 'db-connect.php';

    //first name validation
    if(empty(trim($_POST['first_name']))){
        $first_name_err = "Please enter first name";
        $validate_failed = true;
    }else{
        $first_name = trim($_POST['first_name']);
    }

    //last name validation
    if(empty(trim($_POST['last_name']))){
        $last_name_err = "Please enter last name";
        $validate_failed = true;
    }else{
        $last_name = trim($_POST['last_name']);
    }

    //username validation
    if(empty(trim($_POST['username']))){
        $username_err = "Please enter username";
        $validate_failed = true;
    }else{
        $username = trim($_POST['username']);
    }

    //password validation
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter password";
        $validate_failed = true;
    }else{
        $password = trim($_POST['password']);
    }

    //password confirmation validation
    if(empty(trim($_POST['confirm_password']))){
        $confirm_password_err = "Please confirm password";
        $validate_failed = true;
    }else{
        $confirm_password = trim($_POST['confirm_password']);
    }

    //check if password and confirm password are the same
    if($password != $confirm_password){
        $validate_failed = true;
        $confirm_password_err = "Passwords do not match";
    }

    if(!$validate_failed){

        $stm = $con->prepare("INSERT INTO users (first_name, last_name, username, password, registered_date, status) VALUES (?, ?, ?, ?, ?, 'active')");
        
        // $status = 'active';
        $registered_date = time();
        $hashed_password = sha1($password);


        $stm->bind_param('ssssi', $first_name, $last_name, $username, $hashed_password, $registered_date);

        
        $result = $stm->execute();

        if($result){
            header('location: login.php');
        }else{
            $error = 'Something went wrong';
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <title>Register</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Register</h3>
                        <form class="form" method="post">
                            <?php if(!empty($error)): ?>
                                <div class="alert alert-danger" role="alert">
                                <?=$error?>
                                </div>
                            <?php endif; ?>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control <?=empty($first_name) ? '' : 'is-invalid' ?>"
                                    value="<?=$first_name?>" name="first_name" id="first_name">
                                <label for="first_name">First name</label>
                                <div class="invalid-feedback"><?=$first_name_err?></div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control <?=empty($last_name) ? '' : 'is-invalid' ?>"
                                    value="<?=$last_name?>" name="last_name" id="last_name">
                                <label for="last_name">Last name</label>
                                <div class="invalid-feedback"><?=$last_name_err?></div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control <?=empty($username_err) ? '' : 'is-invalid' ?>"
                                    value="<?=$username?>" name="username" id="username">
                                <label for="username">Username</label>
                                <div class="invalid-feedback"><?=$username_err?></div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control <?=empty($password_err) ? '': 'is-invalid' ?>"
                                    name="password" id="password">
                                <label for="password">Password</label>
                                <div class="invalid-feedback"><?=$password_err?></div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control <?=empty($confirm_password_err) ? '': 'is-invalid' ?>"
                                    name="confirm_password" id="confirm_password">
                                <label for="confirm_password">Confirm confirm_password</label>
                                <div class="invalid-feedback"><?=$confirm_password_err?></div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>