<?php
include_once 'language.php';
include_once 'api/get_rbg_streams.php';

function td($el) {
    return "<td>$el</td>";
}

function tr($el) {
    return "<tr>$el</tr>";
}


function constructLink($type, $link) {
    if ($type == "comb") {
        return '<a href="./watch/' . $link . '"><span class="material-icons md-dashboard"></span></a>';
    } else if ($type == "pres") {
        return '<a href="./watch/' . $link . '"><span class="material-icons md-present_to_all"></span></a>';
    } else if ($type == "cam") {
        return '<a href="./watch/' . $link . '"><span class="material-icons md-videocam"></span></a>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBGreater</title>

    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/js/content_handler.js"></script>

    <!-- Library stylesheets -->
    <link rel="stylesheet" href="/node_modules/typeface-roboto/index.css">
    <link rel="stylesheet" href="/node_modules/@material-icons/font/css/all.css">
    <!-- Custom stylesheets -->
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="/css/index.css">
</head>

<body>
<div id="main">
    <h1 id="page-title"><i>RBGreater</i></h1>
    <div>
        <h2 class="header"><?php echo $DICT["current_livestreams"]; ?></h2>
        <div id="livestreams">
            <?php
            if (sizeof($STREAMS["livestreams"]) == 0) {
                ?>
                <div class='no-entry'>
                    <p><i>No upcoming livestreams!</i></p>
                </div>
                <?php
            } else { ?>
                <table class='event-table'>
                    <tr>
                        <th>Title</th>
                        <th>Combined</th>
                        <th>Presentation</th>
                        <th>Camera</th>
                    </tr>
                    <?php
                    foreach ($STREAMS["livestreams"] as $item) {
                        echo tr(
                            td($item["info"]["name"])
                            . td(constructLink("comb", $item["links"]["comb"]))
                            . td(constructLink("pres", $item["links"]["pres"]))
                            . td(constructLink("cam", $item["links"]["cam"]))
                        );
                    }

                    ?>
                </table>
            <?php }
            ?>
        </div>
    </div>
    <div>
        <h2 class="header"><?php echo $DICT["vod"]; ?></h2>
        <div id="vod">
            <?php
            if (sizeof($STREAMS["vod"]) == 0) {
                ?>
                <div class='no-entry'>
                    <p><i>No video on demand entries!</i></p>
                </div>
                <?php
            } else { ?>
            <div class='event-list'>
                <?php
                $index = 0;
                foreach ($STREAMS["vod"] as $item) {
                    ?>
                    <div class='spoiler'>
                        <div class="spoiler-header" onclick="openVod(<?php echo $index; ?>)">
                            <p class='spoiler-title'><?php echo $item["info"]["name"]; ?></p>
                            <a class='spoiler-button'>
                                <span class='material-icons md-expand_more rotate-reset'
                                      id="spoiler-button-<?php echo $index; ?>"></span>
                            </a>
                        </div>
                        <div class='spoiler-content' id='spoiler-content-<?php echo $index; ?>'>
                            <table class="event-table">
                                <tr>
                                    <th>Date</th>
                                    <th>Combined</th>
                                    <th>Presentation</th>
                                    <th>Camera</th>
                                </tr>
                                <?php

                                foreach ($item["videos"] as $video) {
                                    echo tr(
                                        td($video["info"]["name"])
                                        . td(isset($video["links"]["comb"]) ? constructLink("comb", $video["links"]["comb"]) : "")
                                        . td(isset($video["links"]["pres"]) ? constructLink("pres", $video["links"]["pres"]) : "")
                                        . td(isset($video["links"]["cam"]) ? constructLink("cam", $video["links"]["cam"]) : "")
                                    );
                                }

                                ?>
                            </table>
                        </div>

                    </div>
                    <?php
                    $index++;
                }
                }
                ?>
            </div>
        </div>

        <div>
            <h2 class="header"><?php echo $DICT["vod_archive"]; ?></h2>
            <div id="vod_archive">
                <?php
                if (sizeof($STREAMS["vod"]) == 0) {
                    ?>
                    <div class='no-entry'>
                        <p><i>No video on demand entries!</i></p>
                    </div>
                    <?php
                } else { ?>
                <div class='event-list'>
                    <?php
                    $index = 0;
                    foreach ($STREAMS["vod_archive"] as $item) {
                        ?>
                        <div class='spoiler'>
                            <a target="_blank" href="<?php echo $item["info"]["link"]; ?>">
                                <div class="spoiler-header">
                                    <p class='spoiler-title'><?php echo $item["info"]["name"]; ?></p>
                                    <span class='material-icons md-open_in_new rotate-reset spoiler-button'></span>
                                </div>
                            </a>
                        </div>
                        <?php
                        $index++;
                    }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>