<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="form">
        <h1>Get User ID</h1>
        <form action="{{ route('apiUser.get') }}" method="post">
            @csrf
            <input type="submit" value="Get User ID" >
        </form>
    </div>
</body>
</html>