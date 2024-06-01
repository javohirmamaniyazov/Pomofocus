<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Already Verified</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background-color: #EF5350;
    }

    .wrapper {
        width: 100%;
        height: 100vh;
        display: flex;
        flex-direction: column;
        gap: 20px;
        justify-content: center;
        align-items: center;
        color: white;
    }

    .fa-info-circle {
        font-size: 150px;
    }
</style>

<body>

    <div class="wrapper">
        <i class="fa-solid fa-info-circle"></i>
        <h2>Email Already Verified</h2>
        <h4>Email: {{ $email }}</h4>
        <h4>This email address has already been verified.</h4>
    </div>

</body>

</html>
