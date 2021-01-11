<?php
include 'simple_html_dom.php';
include_once 'CacheAccess.php';
// First get html of remote page
$URL = "https://live.rbg.tum.de/cgi-bin/streams";
$html = CacheAccess::getHtml($URL);

// Initialize basic data structure
$data = [];
$data["livestreams"] = [];
$data["vod"] = [];
$data["vod_archive"] = [];
// First index is normally current live events (first ul)
// Second index is normally VOD - current semester (second ul)
// Last index is normally VOD - archive (last ul)
$index = 0;
$indexToType = [0 => "live", 1 => "vod"];
// If there are currently no active livestreams, the types shift (as 0 is now vod, because there is no ul with livestream-events existing)
if (strpos($html->find("main", 0), "Derzeit gibt es keine aktiven Livestreams")) {
    // If first is empty -> leave index of ul, if does not exist at all skip index
    if (sizeof($html->find("ul", 0)->find("li")) == 0) {
        $indexToType[0] = null;
        $indexToType[1] = "vod";
    } else {
        $indexToType[0] = "vod";
        $indexToType[1] = null;
    }
}
// Find the amount of all uls on the whole html page (to identify last one)
$totalLists = sizeof($html->find("ul"));
// If the archive (last ul) was found already
$archiveFound = false;
for ($index; !$archiveFound; $index++) {

    // Check if we are in a sub ul of an VOD-Entry (then skip as this was already read in) or if we are at the last list entry
    if (!array_key_exists($index, $indexToType) && $index != $totalLists - 1) {
        continue;
    }

    // Find all lists to go through them
    $lists = $html->find("ul", $index);

    // Check if we are in the archive ul
    if ($index == $totalLists - 1) {
        $archiveFound = true;
        $indexToType[$index] = "vod_archive";
    }

    // Got through each list entry and parse data
    foreach ($lists->find('li') as $entry) {
        $element = [];
        // If this is a live entry, get name and links
        if ($indexToType[$index] == "live") {
            $link = $entry->find('a');
            if (sizeof($link) > 1) {
                // Got a Livestream-Entry
                $element["info"] = [];
                $element["links"] = [];
                $element["info"]["name"] = FormatText($link[0]->innertext);
                $element["links"]["overall"] = FormatAndShortenLink($link[0]->attr["href"]);
                if (sizeof($link) > 1) {
                    $element["links"]["comb"] = FormatAndShortenLink($link[1]->attr["href"]);
                }
                if (sizeof($link) > 2) {
                    $element["links"]["pres"] = FormatAndShortenLink($link[2]->attr["href"]);
                }
                if (sizeof($link) > 3) {
                    $element["links"]["cam"] = FormatAndShortenLink($link[3]->attr["href"]);
                }
            }
            $data["livestreams"][] = $element;
        } else if ($indexToType[$index] == "vod") {
            // If this is a VOD Entry it contains a header (in bold)
            if ($entry->find("b") != null) {
                // Got a VOD Entry
                $element["info"] = [];
                $element["videos"] = [];
                $element["info"]["name"] = FormatText($entry->find(".vodlistth", 0)->innertext);
                foreach ($entry->find("li") as $videoEntry) {
                    $retEntry = [];
                    $link = $videoEntry->find('a');
                    $retEntry["info"]["name"] = FormatText($link[0]->innertext);
                    $retEntry["links"]["overall"] = FormatAndShortenLink($link[0]->attr["href"]);
                    if (sizeof($link) > 1) {
                        $retEntry["links"]["comb"] = FormatAndShortenLink($link[1]->attr["href"]);
                    }
                    if (sizeof($link) > 2) {
                        $retEntry["links"]["pres"] = FormatAndShortenLink($link[2]->attr["href"]);
                    }
                    if (sizeof($link) > 3) {
                        $retEntry["links"]["cam"] = FormatAndShortenLink($link[3]->attr["href"]);
                    }
                    $element["videos"][] = $retEntry;
                }
                $data["vod"][] = $element;
            }
        } else if ($indexToType[$index] == "vod_archive") {
            // Got a VOD - Archive Entry
            $element["info"] = [];
            $element["info"]["name"] = FormatText($entry->find("a", 0)->innertext);
            $element["info"]["link"] = FormatLink($entry->find("a", 0)->attr["href"]);
            $data["vod_archive"][] = $element;
        } else {
            break;
        }
    }
}
function FormatLink($string) {
    if (substr($string, 0, 4) === "http") {
        return FormatText($string);
    }
    return FormatText("https://live.rbg.tum.de$string");
}

function FormatAndShortenLink($string) {
    return CacheAccess::getVideoShortId(FormatLink($string));
}

function FormatText($string) {
    $string = trim(strip_tags($string));
    return $string;
}

$STREAMS = $data;
