<div class="reproductor" id="reproductor">
    <div class="infoCancion">
        <div class="now-playing">PLAYING x OF y</div>
        <div class="track-art"></div>
        <div class="name-Artist">
            <div class="track-name">Track Name</div>
            <div class="track-artist">Track Artist</div>
        </div>
    </div>

    <div class="botonesTimer">
        <div class="buttons">
            <div class="random-track" onclick="randomTrack()">
                <i class="fas fa-random fa-2x" title="random"></i>
            </div>
            <div class="prev-track" onclick="prevTrack()">
                <i class="fa fa-step-backward fa-2x"></i>
            </div>
            <div class="playpause-track" onclick="playpauseTrack()">
                <i class="fa fa-play-circle fa-5x"></i>
            </div>
            <div class="next-track" onclick="nextTrack()">
                <i class="fa fa-step-forward fa-2x"></i>
            </div>
            <div class="repeat-track" onclick="repeatTrack()">
                <i class="fa fa-repeat fa-2x" title="repeat"></i>
            </div>
        </div>

        <div class="timer">
            <div class="current-time">00:00</div>
            <input type="range" title="Timer" placeholder="Timer" min="1" max="100" value="0" class="seek_slider" onchange="seekTo()">
            <div class="total-duration">00:00</div>
        </div>
    </div>

    <div class="volumen">
        <i class="fa fa-volume-down"></i>
        <input type="range" title="Volumen" placeholder="Volumen" min="0" max="100" value="50" class="volume_slider" onchange="setVolume()">
        <i class="fa fa-volume-up"></i>
    </div>

</div>