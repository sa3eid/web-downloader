<?php

$file = '';
$error = '';
$success = '';
$image = '';

if(isset($_POST["download"])){
    
    if(empty($_POST["url"])){
        $error = '<p class="text-danger"><b>Enter URL</b></p>';
    }else{
        if(!filter_var($_POST["url"], FILTER_VALIDATE_URL)){
            $error = '<p class="text-danger"><b>Invalid URL</b></p>';
        }else{
            $url = $_POST["url"];
            //initialization of curl session
    
            $file_path = 'downloads/' . uniqid() . '.jpg';
            $fp = fopen($file_path, 'w+');
    
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_FILE, $fp);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($curl, CURLOPT_SSLVERSION, 3);
            // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            // curl_setopt($curl, CURLOPT_TIMEOUT, 20);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            $file_data = curl_exec($curl);
    
            // echo $file_data;
            // print_r(curl_getinfo($curl));
            curl_close($curl);
    
            fwrite($fp, $file_data);
            fclose($fp); 
            // $file_path = 'downloads/' . uniqid() . '.jpg';
            // $file = fopen($file_path, 'w+');
            //writing data to file
            
            $image = '<img src="'.$file_path.'" class="img-thumbnail" width="250 />';
            $success = '<p class="text-success"><b>Image is downloaded successfully</b></p>';
        } 
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple PHP Web Downloader</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mx-5 my-5">
        <h3 class="text-info">Download JPG File from URL</h3><br>
        <!-- <form action="./file_process.php" method="post"> -->
        <form method="post">
            <div class="form-group">
                <label for="url">Enter a valid link URL (only jpg files supported)</label>
                <input class="form-control" id="url" type="text" name="url"><br>
                <input type="submit" value="Download" name="download" class="btn btn-primary btn-lg" />
                
                <div class="my-1">
                    <?= isset($image) ? $image : NULL; ?><br>
                </div>
                <div class ="error my-1">
                    <?= isset($error) ? $error : NULL; ?>
                </div>
                <div class="success my-1">
                    <?= isset($success) ? $success : NULL; ?>
                </div>
            </div>
        </form><br>
    </div>
</body>
</html>