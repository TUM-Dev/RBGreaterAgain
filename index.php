<?php
include_once 'language.php';
include_once 'api/get_rbg_streams.php';

function td($el)
{
    return "<td>$el</td>";
}

function tr($el)
{
    return "<tr>$el</tr>";
}


function constructLink($type, $link)
{

    $link = base64_encode($link);

    if ($type == "comb") {
        return '<a href="./watch.php?s=' . $link . '"><span class="material-icons md-dashboard"></span></a>';
    } else if ($type == "pres") {
        return '<a href="./watch.php?s=' . $link . '"><span class="material-icons md-present_to_all"></span></a>';
    } else if ($type == "cam") {
        return '<a href="./watch.php?s=' . $link . '"><span class="material-icons md-videocam"></span></a>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBGreater</title>

    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="js/content_handler.js"></script>

    <!-- Library stylesheets -->
    <link rel="stylesheet" href="node_modules/typeface-roboto/index.css">
    <link rel="stylesheet" href="node_modules/@material-icons/font/css/all.css">
    <!-- Custom stylesheets -->
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
<div id="main">
    <h1 id="page-title">
        <a href="/" aria-label="RBGreater Logo">
            <svg id="logo" width="30rem" viewBox="0 0 168 41" version="1.1" xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/">
                <g style="fill:var(--primary-color2);fill-rule:nonzero;">
                    <path d="M0,40L0,0L23.65,0L23.65,23.033L14.648,23.033L23.65,33.095L23.65,40L19.073,40L7.629,27.768L7.629,40L0,40ZM7.629,16.128L16.326,16.128L16.326,6.905L7.629,6.905L7.629,16.128Z"/>
                    <path d="M47.097,40L23.142,40L23.142,0L43.689,0L47.097,4.784L47.097,40ZM30.771,33.095L39.468,33.095L39.468,23.033L30.771,23.033L30.771,33.095ZM30.771,16.128L39.468,16.128L39.468,8.483L38.349,6.905L30.771,6.905L30.771,16.128Z"/>
                    <path d="M47.097,6.905L47.097,33.095L57.879,33.095L57.879,24.02L52.743,24.02L52.743,16.128L65,16.128L65,40L39.468,40L39.468,0L65,0L65,6.905L47.097,6.905Z"/>
                </g>
                <g style="fill:var(--primary-color);fill-rule:nonzero;">
                    <path d="M79.915,25.937C79.645,25.739 79.354,25.587 79.041,25.482C78.727,25.377 78.393,25.324 78.037,25.324C76.625,25.324 75.514,25.85 74.703,26.901C73.893,27.953 73.347,29.573 73.064,31.763L71.959,40.001L68,40.001L70.302,22.411L74.114,22.411L73.82,24.693C74.507,23.716 75.259,22.989 76.076,22.513C76.892,22.037 77.773,21.799 78.718,21.799C79.148,21.799 79.572,21.854 79.989,21.966C80.406,22.077 80.812,22.25 81.204,22.485L79.915,25.937Z"/>
                    <path d="M85.808,29.091L94.814,29.091C94.777,27.903 94.412,26.966 93.718,26.28C93.025,25.593 92.095,25.25 90.928,25.25C89.602,25.25 88.479,25.596 87.558,26.289C86.637,26.982 86.054,27.916 85.808,29.091ZM94.593,34.602L97.448,36.847C96.428,38.195 95.324,39.178 94.133,39.797C92.942,40.415 91.573,40.725 90.026,40.725C87.435,40.725 85.342,39.936 83.746,38.359C82.15,36.782 81.352,34.707 81.352,32.134C81.352,29.116 82.269,26.639 84.105,24.703C85.94,22.767 88.276,21.799 91.112,21.799C93.482,21.799 95.37,22.538 96.775,24.016C98.181,25.494 98.884,27.477 98.884,29.963C98.884,30.173 98.875,30.442 98.856,30.77C98.838,31.098 98.81,31.491 98.773,31.948L85.459,31.948C85.459,33.544 85.858,34.815 86.656,35.761C87.454,36.708 88.516,37.181 89.842,37.181C90.762,37.181 91.637,36.955 92.466,36.503C93.295,36.052 94.004,35.418 94.593,34.602Z"/>
                    <path d="M105.974,31.763C105.974,33.445 106.361,34.756 107.134,35.696C107.908,36.636 108.982,37.106 110.357,37.106C111.941,37.106 113.193,36.469 114.114,35.195C115.035,33.921 115.495,32.165 115.495,29.926C115.495,28.404 115.084,27.195 114.262,26.298C113.439,25.402 112.328,24.953 110.928,24.953C109.418,24.953 108.215,25.565 107.319,26.79C106.422,28.015 105.974,29.672 105.974,31.763ZM118.166,40.001L114.206,40.001L114.501,38.071C113.813,38.95 113.021,39.605 112.125,40.038C111.229,40.471 110.198,40.687 109.031,40.688C106.748,40.687 104.983,39.961 103.737,38.507C102.49,37.054 101.867,34.991 101.867,32.319C101.867,29.165 102.629,26.623 104.151,24.693C105.673,22.764 107.669,21.799 110.136,21.799C111.303,21.799 112.386,22.043 113.387,22.532C114.387,23.02 115.311,23.766 116.158,24.768L116.508,22.411L120.468,22.411L118.166,40.001Z"/>
                    <path d="M123.948,40.001L125.79,25.825L122.77,25.825L123.23,22.411L126.214,22.411L127.079,15.75L131.039,15.75L130.21,22.411L133.378,22.411L132.917,25.825L129.75,25.825L127.908,40.001L123.948,40.001Z"/>
                    <path d="M138.773,29.091L147.779,29.091C147.742,27.903 147.377,26.966 146.683,26.28C145.99,25.593 145.06,25.25 143.893,25.25C142.567,25.25 141.444,25.596 140.523,26.289C139.602,26.982 139.019,27.916 138.773,29.091ZM147.558,34.602L150.413,36.847C149.393,38.195 148.289,39.178 147.098,39.797C145.907,40.415 144.538,40.725 142.991,40.725C140.4,40.725 138.307,39.936 136.711,38.359C135.115,36.782 134.317,34.707 134.317,32.134C134.317,29.116 135.234,26.639 137.07,24.703C138.905,22.767 141.241,21.799 144.077,21.799C146.447,21.799 148.335,22.538 149.74,24.016C151.146,25.494 151.849,27.477 151.849,29.963C151.849,30.173 151.84,30.442 151.821,30.77C151.803,31.098 151.775,31.491 151.738,31.948L138.424,31.948C138.424,33.544 138.823,34.815 139.621,35.761C140.419,36.708 141.481,37.181 142.807,37.181C143.727,37.181 144.602,36.955 145.431,36.503C146.26,36.052 146.969,35.418 147.558,34.602Z"/>
                    <path d="M166.711,25.937C166.441,25.739 166.149,25.587 165.836,25.482C165.523,25.377 165.188,25.324 164.832,25.324C163.421,25.324 162.309,25.85 161.499,26.901C160.689,27.953 160.142,29.573 159.86,31.763L158.755,40.001L154.796,40.001L157.098,22.411L160.91,22.411L160.615,24.693C161.303,23.716 162.055,22.989 162.871,22.513C163.688,22.037 164.568,21.799 165.514,21.799C165.944,21.799 166.367,21.854 166.785,21.966C167.202,22.077 167.607,22.25 168,22.485L166.711,25.937Z"/>
                </g>
            </svg>
        </a>
    </h1>
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
                                        . td(isset($video["links"]["pres"]) ? constructLink("comb", $video["links"]["pres"]) : "")
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