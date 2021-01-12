<?php
include_once 'language.php';
include_once 'api/get_rbg_stream_site.php';
?>

<?php
$link = base64_decode($_GET["s"]);
$data = strlen($link) > 0 ? ParseInformation($link) : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data["name"]; ?> | RBGreater</title>

    <script src="node_modules/hls.js/dist/hls.min.js"></script>

    <!-- Library stylesheets -->
    <link rel="stylesheet" href="node_modules/typeface-roboto/index.css">
    <link rel="stylesheet" href="node_modules/@material-icons/font/css/all.css">
    <!-- Custom stylesheets -->
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/watch.css">
</head>

<body>
<div class="back-btn">
    <a href="/index.php">
        <span id="back-btn" class="material-icons md-arrow_back"></span>
    </a>
</div>
<div id="main">
    <h1 id="page-title">
        <a href="/" aria-label="RBGreater Logo">
            <svg width="30rem" alignment-baseline="baseline" id="logo">
                <use href="static/logo.svg#RGBreaterLogo"/>
            </svg>
        </a>
    </h1>
    <h2 id="event-title"><?php echo $data["name"]; ?></h2>
    <h3 id="event-date"><?php echo $data["date"] . " " . $data["time"]; ?></h3>

    <?php
    if (is_null($data["hls_url"])) {
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
                var videoSrc = '<?php echo $data["hls_url"] ?>'
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