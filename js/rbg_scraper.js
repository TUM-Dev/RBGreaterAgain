$(document).ready(() => {
    $.ajax({
        url: "api/get_rbg_streams_in_json.php",
        type: "GET",
        crossDomain: true,
        success: function (data) {
            console.log(data);
            if (data.livestreams.length == 0) {
                $("#livestreams").append("<p>No livestreams upcoming!</p>");
            } else {
                for (var livestream of data.livestreams) {
                    $("#livestreams").append("<p>" + livestream.info.name + "</p>");
                }
            }
            if (data.vod.length == 0) {
                $("#vod").append("<p>No VOD available!</p>");
            } else {
                for (var vod of data.vod) {
                    $("#vod").append("<p>" + vod.info.name + "</p>");
                }
            }
            if (data.vod_archive.length == 0) {
                $("#vod_archive").append("<p>No VOD in the archive!</p>");
            } else {
                for (var vod of data.vod_archive) {
                    $("#vod_archive").append("<p>" + vod.info.name + "</p>");
                }
            }
        }
    });
});