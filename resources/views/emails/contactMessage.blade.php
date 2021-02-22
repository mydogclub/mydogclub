<!DOCTYPE html>
<html>
<head>
    <title> Сообщение с сайта my-dog.club </title>
</head>

<body>
    <h2><span style="color:red;"> Адресс отправителя: </span> {{ $email }}
<br>
<span style="color:red;"> Тема письма: </span> {{ $title }}
<br>
<span style="color:red;"> Текст сообщения: </span><br>{{ $msg }}
</h2>
</body>

</html>