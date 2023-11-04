<?php
session_start();
global $uname, $login;
if(isset($_SESSION['msg'])){
    $msg = $_SESSION['msg'];
    echo "<script>window.alert('".$msg."')</script>";
    unset($_SESSION['msg']);
}
if(isset($_SESSION['login'])){
    $login = $_SESSION['login'];
}
if (isset($_SESSION['name'])) {
    $uname = $_SESSION['name'];
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manager : Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-full min-w-full bg-gradient-to-r from-sky-400 via-sky-600 to-blue-800">
<div class="m-2 flex flex-col w-auto h-auto justify-center items-center">
    <a href="/" class="font-bold text-2xl text-white p-3 bg-gradient-to-r from-sky-400 via-sky-600 to-blue-800 shadow-md m-2 rounded-tl-2xl rounded-br-2xl">
        Hellozermss
    </a>
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="register/register.php" method="post" accept-charset="UTF-8">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                Nome Completo
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Thomas Turbando" value="<?php if($uname != ''){echo $uname;} ?>" name="username">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="login">
                Login
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="login" type="text" placeholder="Login" value="<?php if($login != ''){echo $login;} ?>" name="login">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                New Password
            </label>
            <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************" name="pass">
            <p class="text-red-500 text-xs italic">Please choose a password.</p>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="rpassword">
                Repeat New Password
            </label>
            <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="rpassword" type="password" placeholder="******************" name="repass">
            <p class="text-red-500 text-xs italic">Please choose repeat a password.</p>
        </div>
        <div class="flex items-center justify-center">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="reg">
                Signup
            </button>
        </div>
    </form>
</div>
</body>
</html>
