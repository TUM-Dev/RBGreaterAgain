<?php
error_reporting(-1);
ini_set('display_errors', 'On');
include 'simple_html_dom.php';

// First get html of remote page
$URL = "https://pabst.dev/rbg/example_no_live.html";
$html = file_get_html($URL);

// Initialize basic data structure
$data = array();
$data["livestreams"] = array();
$data["vod"] = array();
$data["vod_archive"] = array();
// First index is normally current live events (first ul)
// Second index is normally VOD - current semester (second ul)
// Last index is normally VOD - archive (last ul)
$index = 0;
$indexToType = array(0 => "live", 1 => "vod");
// If there are currently no active livestreams, the types shift (as 0 is now vod, because there is no ul with livestream-events existing)
if (strpos($html->find("main", 0), "Derzeit gibt es keine aktiven Livestreams")) {
    $indexToType[0] = "vod";
    $indexToType[1] = null;
}
// Find the amount of all uls on the whole html page (to identify last one)
$totalLists = sizeof($html->find("ul"));
// If the archive (last ul) was found already
$archiveFound = False;
for ($index; !$archiveFound; $index++) {

    // Check if we are in a sub ul of an VOD-Entry (then skip as this was already read in) or if we are at the last list entry
    if (!array_key_exists($index, $indexToType) && $index != $totalLists - 1)
        continue;

    // Find all lists to go through them
    $lists = $html->find("ul", $index);

    // Check if we are in the archive ul
    if ($index == $totalLists - 1) {
        $archiveFound = True;
        $indexToType[$index] = "vod_archive";
    }

    // Got through each list entry and parse data
    foreach ($lists->find('li') as $entry) {
        $element = array();
        // If this is a live entry, get name and links
        if ($indexToType[$index] == "live") {
            $link = $entry->find('a');
            if (sizeof($link) > 1) {
                // Got a Livestream-Entry
                $element["info"] = array();
                $element["links"] = array();
                $element["info"]["name"] = FormatText($link[0]->innertext);
                $element["links"]["overall"] = FormatText($link[0]->attr["href"]);
                if (sizeof($link) > 1)
                    $element["links"]["comb"] = FormatText($link[1]->attr["href"]);
                if (sizeof($link) > 2)
                    $element["links"]["pres"] = FormatText($link[2]->attr["href"]);
                if (sizeof($link) > 3)
                    $element["links"]["cam"] = FormatText($link[3]->attr["href"]);
            }
            $data["livestreams"][] = $element;
        } else if ($indexToType[$index] == "vod") {
            // If this is a VOD Entry it contains a header (in bold)
            if ($entry->find("b") != null) {
                // Got a VOD Entry
                $element["info"] = array();
                $element["videos"] = array();
                $element["info"]["name"] = FormatText($entry->find(".vodlistth", 0)->innertext);
                foreach ($entry->find("li") as $videoEntry) {
                    $videoEntry = array();
                    $link = $entry->find('a');
                    $videoEntry["info"]["name"] = FormatText($link[0]->innertext);
                    $videoEntry["links"]["overall"] = FormatText($link[0]->attr["href"]);
                    if (sizeof($link) > 1)
                        $videoEntry["links"]["comb"] = FormatText($link[1]->attr["href"]);
                    if (sizeof($link) > 2)
                        $videoEntry["links"]["pres"] = FormatText($link[2]->attr["href"]);
                    if (sizeof($link) > 3)
                        $videoEntry["links"]["cam"] = FormatText($link[3]->attr["href"]);
                    $element["videos"][] = $videoEntry;
                }
                $data["vod"][] = $element;
            }
        } else if ($indexToType[$index] == "vod_archive") {
            // Got a VOD - Archive Entry
            $element["info"] = array();
            $element["info"]["name"] = FormatText($entry->find("a", 0)->innertext);
            $element["info"]["link"] = FormatText($entry->find("a", 0)->attr["href"]);
            $data["vod_archive"][] = $element;
        } else {
            break;
        }
    }
}

function FormatText($string)
{
    $string = trim(strip_tags($string));
    return $string;
}

// Return data in json format
header('Content-Type: application/json');
echo json_encode($data);
