<?php
include_once 'language.php';
include_once 'api/get_rbg_stream_site.php';
include_once 'api/ShortLinkAccess.php';

$link = ShortLinkAccess::getVideoUrl($_GET["s"]);
$hls_url = ParseInformation($link)["hls_url"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBGreaterAgain</title>

    <script src="/node_modules/hls.js/dist/hls.min.js"></script>

    <!-- Library stylesheets -->
    <link rel="stylesheet" href="/node_modules/typeface-roboto/index.css">
    <link rel="stylesheet" href="/node_modules/@material-icons/font/css/all.css">
    <!-- Custom stylesheets -->
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="/css/video_only.css">
</head>

<body>
<div id="main">
    <?php
    if (is_null($hls_url)) {
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