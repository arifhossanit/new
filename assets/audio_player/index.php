<?php
include("../../application/config/ajax_config.php");
//
?>

<!DOCTYPE html>
<html lang="en" >

<head>

  <meta charset="UTF-8">
  

  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.3.1/css/all.css'>
  
<style>
*:focus
{
    outline: none;
}

body
{
    font-family: Helvetica, Arial;
    margin: 0;
    background-color: #ffeff5;
}

#app-cover
{
    position: absolute;
    top: 50%;
    right: 0;
    left: 0;
    width: 430px;
    height: 100px;
    margin: -4px auto;
}

#bg-artwork
{
    position: fixed;
    top: -30px;
    right: -30px;
    bottom: -30px;
    left: -30px;
    background-image: url("https://raw.githubusercontent.com/himalayasingh/music-player-1/master/img/_1.jpg");
    background-repeat: no-repeat;
    background-size: cover;
    background-position: 50%;
    filter: blur(40px);
    -webkit-filter: blur(40px);
    z-index: 1;
}

#bg-layer
{
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: #fff;
    opacity: 0.51;
    z-index: 2;
}

#player
{
    position: relative;
    height: 100%;
    z-index: 3;
}

#player-track
{
    position: absolute;
    top: 0;
    right: 15px;
    left: 15px;
    padding: 13px;
    background-color: #fff7f7;
    border-radius: 15px;
    transition: 0.3s ease top;
    z-index: 1;
}

#player-track.active
{
    top: -250px;
}

#album-name
{
    color: #54576f;
    font-size: 17px;
    font-weight: bold;
}

#track-name
{
    color: #acaebd;
    font-size: 13px;
    margin: 2px 0 13px 0;
}

#track-time
{
    height: 12px;
    margin-bottom: 3px;
    overflow: hidden;
}

#current-time
{
    float: left;
}

#track-length
{
    float: right;
}

#current-time, #track-length
{
    color: transparent;
    font-size: 11px;
    background-color: #ffe8ee;
    border-radius: 10px;
    transition: 0.3s ease all;
}

#track-time.active #current-time, #track-time.active #track-length
{
    color: #f86d92;
    background-color: transparent;
}

#s-area, #seek-bar
{
    position: relative;
    height: 4px;
    border-radius: 4px;
}

#s-area
{
    background-color:#ffe8ee;
    cursor: pointer;
}

#ins-time
{
    position: absolute;
    top: -29px;
    color: #fff;
    font-size: 12px;
    white-space: pre;
    padding: 5px 6px;
    border-radius: 4px;
	display:none;
}

#s-hover
{
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    opacity: 0.2;
    z-index: 2;
}

#ins-time, #s-hover
{
    background-color: #3b3d50;
}

#seek-bar
{
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    width: 0;
    background-color: #fd6d94;
    transition: 0.2s ease width;
    z-index: 1;
}

#player-content
{
    position: relative;
    height: 100%;
    background-color: #fff;
    box-shadow: 0 30px 80px #656565;
    border-radius: 15px;
    z-index: 2;
}

#album-art
{
    position: absolute;
    top: -40px;
    width: 115px;
    height: 115px;
    margin-left: 40px;
    transform: rotateZ(0);
    transition: 0.3s ease all;
    box-shadow: 0 0 0 10px #fff;
    border-radius: 50%;
    overflow: hidden;
}

#album-art.active
{
    top: -60px;
    box-shadow: 0 0 0 4px #fff7f7, 0 30px 50px -15px #afb7c1;
}

#album-art:before
{
    content: '';
    position: absolute;
    top: 50%;
    right: 0;
    left: 0;
    width: 20px;
    height: 20px;
    margin: -10px auto 0 auto;
    background-color: #d6dee7;
    border-radius: 50%;
    box-shadow: inset 0 0 0 2px #fff;
    z-index: 2;
}

#album-art img
{
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    z-index: -1;
}

#album-art img.active
{
    opacity: 1;
    z-index: 1;
}

#album-art.active img.active
{
    z-index: 1;
    -webkit-animation: rotateAlbumArt 3s linear 0s infinite forwards;
            animation: rotateAlbumArt 3s linear 0s infinite forwards;
}

@-webkit-keyframes rotateAlbumArt
{
    0%{ transform: rotateZ(0); }
    100%{ transform: rotateZ(360deg); }
}

@keyframes rotateAlbumArt
{
    0%{ transform: rotateZ(0); }
    100%{ transform: rotateZ(360deg); }
}

#buffer-box
{
    position: absolute;
    top: 50%;
    right: 0;
    left: 0;
    height: 13px;
    color: #1f1f1f;
    font-size: 13px;
    font-family: Helvetica;
    text-align: center;
    font-weight: bold;
    line-height: 1;
    padding: 6px;
    margin: -12px auto 0 auto;
    background-color: rgba(255, 255, 255, 0.19);
    opacity: 0;
    z-index: 2;
}

#album-art img, #buffer-box
{
    transition: 0.1s linear all;
}

#album-art.buffering img
{
    opacity: 0.25;
}

#album-art.buffering img.active
{
    opacity: 0.8;
    filter: blur(2px);
    -webkit-filter: blur(2px);
}

#album-art.buffering #buffer-box
{
    opacity: 1;
}

#player-controls
{
    width: 250px;
    height: 100%;
    margin: 0 5px 0 141px;
    float: right;
    overflow: hidden;
}

.control
{
    width: 33.333%;
    float: left;
    padding: 12px 0;
}

.button
{
    width: 26px;
    height: 26px;
    padding: 25px;
    background-color: #fff;
    border-radius: 6px;
    cursor: pointer;
}

.button i
{
    display: block;
    color: #d6dee7;
    font-size: 26px;
    text-align: center;
    line-height: 1;
}

.button, .button i
{
    transition: 0.2s ease all;
}

.button:hover
{
    background-color: #d6d6de;
}

.button:hover i
{
    color: #fff;
}

#ytd-url {
  display: block;
  position: fixed;
  right: 0;
  bottom: 0;
  padding: 10px 14px;
  margin: 20px;
  color: #fff;
  font-size: 14px;
  text-decoration: none;
  background-color: #ae5f87;
  border-radius: 4px;
  box-shadow: 0 10px 20px -5px rgba(174, 95, 135, 0.86);
  z-index: 125;
}
</style>

  <script>
  window.console = window.console || function(t) {};
</script>  
  
  <script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
</script>


</head>
<?php
$hour = date('Hi');
$album = "";
$trackName = "";
$albumArtwork = "";
$trackUrl = "";
$image = "";
$u = 1;
$sql = $mysqli->query("select * from audio_files where h_from <= '".$hour."' AND h_to >= '".$hour."' order by rand() desc");
while($row = mysqli_fetch_assoc($sql)){
	if($u++ == 1){
		$class = 'active';
	}else{
		$class = '';
	}
	$album .='"'.$row['albume_name'].'",';	
	$trackName .='"'.$row['track_name'].'",';	
	$albumArtwork .='"_'.$row['id'].'",';	
	$trackUrl .='"'.$home.$row['mp3_file'].'",';	
	$image .='"<img src="'.$home.$row['track_picture'].'" class="'.$class.'" id="_'.$row['id'].'">",';	
}
$albums = rtrim($album,',');
$trackNames = rtrim($trackName,',');
$albumArtworks = rtrim($albumArtwork,',');
$trackUrls = rtrim($trackUrl,',');
$images = rtrim($image,',');
?>
<body translate="no" >
  <!-- Tracks used in this music/audio player application are free to use. I downloaded them from Soundcloud and NCS websites. I am not the owner of these tracks. -->

    <div id="app-cover">
        <div id="bg-artwork"></div>
        <div id="bg-layer"></div>
        <div id="player">
            <div id="player-track">
                <div id="album-name"></div>
                <div id="track-name"></div>
                <div id="track-time">
                    <div id="current-time"></div>
                    <div id="track-length"></div>
                </div>
                <div id="s-area">
                    <div id="ins-time"></div>
                    <div id="s-hover"></div>
                    <div id="seek-bar"></div>
                </div>
            </div>
            <div id="player-content">
                <div id="album-art">
					<?php
						echo $images;
					?>
                    <div id="buffer-box">Buffering ...</div>
                </div>
                <div id="player-controls">
                    <div class="control">
                        <div class="button" id="play-previous">
                            <i class="fas fa-backward"></i>
                        </div>
                    </div>
                    <div class="control">
                        <div class="button" id="play-pause-button">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                    <div class="control">
                        <div class="button" id="play-next">
                            <i class="fas fa-forward"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

			<a href="#" target="_blank" id="ytd-url">Full Monitor</a>
			<script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-157cd5b220a5c80d4ff8e0e70ac069bffd87a61252088146915e8726e5d9f147.js"></script>
			<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
			<script id="rendered-js" >
			$(function ()
{
  var playerTrack = $("#player-track"),bgArtwork = $('#bg-artwork'),bgArtworkUrl,albumName = $('#album-name'),trackName = $('#track-name'),albumArt = $('#album-art'),sArea = $('#s-area'),seekBar = $('#seek-bar'),trackTime = $('#track-time'),insTime = $('#ins-time'),sHover = $('#s-hover'),playPauseButton = $("#play-pause-button"),i = playPauseButton.find('i'),tProgress = $('#current-time'),tTime = $('#track-length'),seekT,seekLoc,seekBarPos,cM,ctMinutes,ctSeconds,curMinutes,curSeconds,durMinutes,durSeconds,playProgress,bTime,nTime = 0,buffInterval = null,tFlag = false,
  albums = [<?php echo $albums; ?>],
  trackNames = [<?php echo $trackNames; ?>],
  albumArtworks = [<?php echo $albumArtworks; ?>],
  trackUrl = [<?php echo $trackUrls; ?>],playPreviousTrackButton = $('#play-previous'),playNextTrackButton = $('#play-next'),currIndex = -1;

  function playPause()
  {
    setTimeout(function ()
    {
      if (audio.paused)
      {
        playerTrack.addClass('active');
        albumArt.addClass('active');
        checkBuffering();
        i.attr('class', 'fas fa-pause');
        audio.play();
      } else

      {
        playerTrack.removeClass('active');
        albumArt.removeClass('active');
        clearInterval(buffInterval);
        albumArt.removeClass('buffering');
        i.attr('class', 'fas fa-play');
        audio.pause();
      }
    }, 300);
  }


  function showHover(event)
  {
    seekBarPos = sArea.offset();
    seekT = event.clientX - seekBarPos.left;
    seekLoc = audio.duration * (seekT / sArea.outerWidth());

    sHover.width(seekT);

    cM = seekLoc / 60;

    ctMinutes = Math.floor(cM);
    ctSeconds = Math.floor(seekLoc - ctMinutes * 60);

    if (ctMinutes < 0 || ctSeconds < 0)
    return;

    if (ctMinutes < 0 || ctSeconds < 0)
    return;

    if (ctMinutes < 10)
    ctMinutes = '0' + ctMinutes;
    if (ctSeconds < 10)
    ctSeconds = '0' + ctSeconds;

    if (isNaN(ctMinutes) || isNaN(ctSeconds))
    insTime.text('--:--');else

    insTime.text(ctMinutes + ':' + ctSeconds);

    insTime.css({ 'left': seekT, 'margin-left': '-21px' }).fadeIn(0);

  }

  function hideHover()
  {
    sHover.width(0);
    insTime.text('00:00').css({ 'left': '0px', 'margin-left': '0px' }).fadeOut(0);
  }

  function playFromClickedPos()
  {
    audio.currentTime = seekLoc;
    seekBar.width(seekT);
    hideHover();
  }

  function updateCurrTime()
  {
    nTime = new Date();
    nTime = nTime.getTime();

    if (!tFlag)
    {
      tFlag = true;
      trackTime.addClass('active');
    }

    curMinutes = Math.floor(audio.currentTime / 60);
    curSeconds = Math.floor(audio.currentTime - curMinutes * 60);

    durMinutes = Math.floor(audio.duration / 60);
    durSeconds = Math.floor(audio.duration - durMinutes * 60);

    playProgress = audio.currentTime / audio.duration * 100;

    if (curMinutes < 10)
    curMinutes = '0' + curMinutes;
    if (curSeconds < 10)
    curSeconds = '0' + curSeconds;

    if (durMinutes < 10)
    durMinutes = '0' + durMinutes;
    if (durSeconds < 10)
    durSeconds = '0' + durSeconds;

    if (isNaN(curMinutes) || isNaN(curSeconds))
    tProgress.text('00:00');else

    tProgress.text(curMinutes + ':' + curSeconds);

    if (isNaN(durMinutes) || isNaN(durSeconds))
    tTime.text('00:00');else

    tTime.text(durMinutes + ':' + durSeconds);

    if (isNaN(curMinutes) || isNaN(curSeconds) || isNaN(durMinutes) || isNaN(durSeconds))
    trackTime.removeClass('active');else

    trackTime.addClass('active');


    seekBar.width(playProgress + '%');

    if (playProgress == 100)
    {
      i.attr('class', 'fa fa-play');
      seekBar.width(0);
      tProgress.text('00:00');
      albumArt.removeClass('buffering').removeClass('active');
      clearInterval(buffInterval);
    }
  }

  function checkBuffering()
  {
    clearInterval(buffInterval);
    buffInterval = setInterval(function ()
    {
      if (nTime == 0 || bTime - nTime > 1000)
      albumArt.addClass('buffering');else

      albumArt.removeClass('buffering');

      bTime = new Date();
      bTime = bTime.getTime();

    }, 100);
  }

  function selectTrack(flag) {
    if (flag == 0 || flag == 1)
    ++currIndex;else

    --currIndex;

    if (currIndex > -1 && currIndex < albumArtworks.length)
    {
      if (flag == 0)
      i.attr('class', 'fa fa-play');else

      {
        albumArt.removeClass('buffering');
        i.attr('class', 'fa fa-pause');
      }

      seekBar.width(0);
      trackTime.removeClass('active');
      tProgress.text('00:00');
      tTime.text('00:00');

      currAlbum = albums[currIndex];
      currTrackName = trackNames[currIndex];
      currArtwork = albumArtworks[currIndex];

      audio.src = trackUrl[currIndex];

      nTime = 0;
      bTime = new Date();
      bTime = bTime.getTime();

      if (flag != 0)
      {
        audio.play();
        playerTrack.addClass('active');
        albumArt.addClass('active');

        clearInterval(buffInterval);
        checkBuffering();
      }

      albumName.text(currAlbum);
      trackName.text(currTrackName);
      albumArt.find('img.active').removeClass('active');
      $('#' + currArtwork).addClass('active');

      bgArtworkUrl = $('#' + currArtwork).attr('src');

      bgArtwork.css({ 'background-image': 'url(' + bgArtworkUrl + ')' });
    } else

    {
      if (flag == 0 || flag == 1)
      --currIndex;else

      ++currIndex;
    }
  }

  function initPlayer(){
    audio = new Audio();
    selectTrack(0);
    audio.loop = true;
    playPauseButton.on('click', playPause);
    sArea.mousemove(function (event) {showHover(event);});
    sArea.mouseout(hideHover);
    sArea.on('click', playFromClickedPos);
    $(audio).on('timeupdate', updateCurrTime);
    playPreviousTrackButton.on('click', function () {selectTrack(-1);});
    playNextTrackButton.on('click', function () {selectTrack(1);});
  }

  initPlayer();
});
//# sourceURL=pen.js
    </script>
		</script>
	</body>
</html>