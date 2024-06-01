<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Success</title>
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

    .fa-circle-check {
        font-size: 150px;
    }

    /* Styling for the link button */
    a {
        padding: 10px 20px;
        background-color: #fff;
        color: #EF5350;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    a:hover {
        background-color: #eee;
    }
</style>

<body>

    <div class="wrapper">
        <i class="fa-solid fa-circle-check"></i>
        <h2>Activation has been Verified</h2>
        <h4>Email: {{ $email }}</h4>
        <h4><a href="http://localhost:5173/">Please return to the Website</a></h4>
    </div>

</body>

</html>
