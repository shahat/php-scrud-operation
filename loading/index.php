<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <title>Loader</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css'>
    <link rel='stylesheet' href='./style.css'>
</head>

<body>
    <div class='scene'>
        <div class='cube-wrapper'>
            <div class='cube'>
                <div class='cube-faces'>
                    <div class='cube-face shadow'></div>
                    <div class='cube-face bottom'></div>
                    <div class='cube-face top'></div>
                    <div class='cube-face left'></div>
                    <div class='cube-face right'></div>
                    <div class='cube-face back'></div>
                    <div class='cube-face front'></div>
                </div>
            </div>
        </div>
    </div>
    <script>
    setTimeout(function() {
        window.location.replace("http://localhost/crud/admin/users/list.php");
    }, 3000); // 3000 milliseconds = 3 seconds
    </script>
</body>

</html>