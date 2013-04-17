<?php
    //ini_set('display_errors', 1);
    //error_reporting(E_ALL);

    require '../TumblrLatestPhotos.class.php';

    $photos = new Tumblr_Latest_Photos( 'picturedept' );
    $latest_photos = $photos->generate('12');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Basic Masonry Example</title>

    <link rel="stylesheet" href="assets/css/style.css" type="text/css" media="screen" />
</head>
<body>
    <div class="wrapper">
        <?php foreach($latest_photos as $photo) : ?>
            <div class="post">
                <a href="<?php echo $photo->post_url; ?>" target="_blank"><img src="<?php echo $photo->photo->alt_sizes[0]->url; ?>" width="300" /></a>
                <h4 class="title"><?php echo $photo->blog_name; ?></h4>
                <p class="time"><?php echo $photo->date; ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script src="assets/js/jquery.masonry.min.js"></script>
    <script defer src="assets/js/script.js"></script>
</body>
</html>