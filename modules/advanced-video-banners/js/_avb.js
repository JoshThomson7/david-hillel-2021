var tag = document.createElement('script');
tag.src = "https://www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var playerInfoList = playerVideos;
var players = [];

function createPlayer(playerInfo) {
    apf_video = new YT.Player(playerInfo.id, {
        playerVars: {
            'autoplay': 1,
            'controls': 0,
            'autohide':1,
            'wmode':'opaque',
            'rel':0,
            'showinfo':0,
            'loop':1,
            'iv_load_policy':3,
            'enablejsapi':0,
            'version':3,
            'allowfullscreen':0,
            'playlist':playerInfo.videoId,
            'html5':1
        },
        videoId: playerInfo.videoId,
        events: {
            'onReady': onPlayerReady
        }
    });

    return apf_video;

}

function onYouTubeIframeAPIReady() {
    if (typeof playerInfoList === 'undefined') { return;}

    for (var i = 0; i < playerInfoList.length; i++) {
        var curplayer = createPlayer(playerInfoList[i]);
        players[i] = curplayer;
    }
}

function onPlayerReady(event) {
    event.target.mute();
    event.target.setPlaybackQuality('hd720');
}

jQuery(document).ready(function($) {
    $('#home_banners').lightSlider({
        item: 1,
        loop: false,
        auto: true,
        pause: 6000,
        selector: '.banner',
        easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        controls: false,
        enableDrag: false,
        slideMargin: 0
    });


    // --------------- Controls --------------- //
    $('.video__play').click(function(e) {
        e.preventDefault();
        apf_video.unMute();
        apf_video.seekTo(0);
        $(".banner__caption").addClass("off");
        $(".banner__video__controls").addClass("on");
    });

    $('body').on("click", '.video__mute, .video__unmute', function(e) {
        e.preventDefault();
        if ($(this).hasClass('video__mute')) {
            apf_video.mute();
        } else {
            apf_video.unMute();
        }

        $(this).toggleClass('video__mute video__unmute');
        $(this).children().toggleClass('ion-volume-high ion-volume-mute');
    });
});
