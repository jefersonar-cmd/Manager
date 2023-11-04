<?php
session_start();
global $login;
if(isset($_SESSION['msg'])){
    $msg = $_SESSION['msg'];
    echo "<script>window.alert('".$msg."')</script>";
    unset($_SESSION['msg']);
}
if(isset($_SESSION['login'])){
    $login = $_SESSION['login'];
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-full min-w-full bg-gradient-to-r from-sky-400 via-sky-600 to-blue-800">
<div class="m-2 flex flex-col w-auto h-auto justify-center items-center">
    <a href="http://localhost:3000" class="font-bold text-2xl text-white p-3 bg-gradient-to-r from-sky-400 via-sky-600 to-blue-800 shadow-md m-2 rounded-tl-2xl rounded-br-2xl">
        Hellozermss
    </a>
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-80" action="valid.php" method="post">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                Username
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" type="text" placeholder="Username" value="<?php if($login != ''){echo $login;} ?>">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Password
            </label>
            <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="password" placeholder="******************">
            <p class="text-red-500 text-xs italic">Please choose a password.</p>
        </div>
        <div class="flex items-center justify-between space-x-2">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="login">
                Sign In
            </button>
            <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="forget">
                Forgot Password?
            </a>
        </div>
    </form>
</div>
</body>
</html>
