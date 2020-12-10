<?php
include_once 'language.php';
include_once 'api/get_rbg_hls_link.php';
?>

<?php
$link = base64_decode($_GET["s"]);
$hls_url = strlen($link) > 0 ? get_rbg_hls_link($link) : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBGreaterAgain</title>

    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

    <!-- Library stylesheets -->
    <link rel="stylesheet" href="fonts/fonts.css">
    <link rel="stylesheet" href="iconfont/material-icons.css">
    <!-- Custom stylesheets -->
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div id="main">
        <h1 id="page-title"><a href="/"><i>RBGreater - RBG but in sexy</i></a></h1>
        
        <?php
        if(is_null($hls_url)) {
        ?>
        <div class='no-entry'>
            <p><i><?php echo $DICT['stream_not_found']; ?></i></p>
        </div>
        <?php
        } else {
        ?>
        <div id="stream-frame">
            <video id="stream" controls></video>
            <script>
                var video = document.getElementById('stream');
                var videoSrc = '<?php echo $hls_url ?>'
                if (Hls.isSupported()) {
                    var hls = new Hls();
                    hls.loadSource(videoSrc);
                    hls.attachMedia(video);
                } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                    video.src = videoSrc;
                }
            </script>
        </div>
        <?php
        }
        ?>
    </div>
</body>

</html>