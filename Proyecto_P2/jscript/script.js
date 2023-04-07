let now_playing = document.querySelector('.now-playing');
let track_art = document.querySelector('.track-art');
let track_name = document.querySelector('.track-name');
let track_artist = document.querySelector('.track-artist');

let playpause_btn = document.querySelector('.playpause-track');
let next_btn = document.querySelector('.next-track');
let prev_btn = document.querySelector('.prev-track');

let seek_slider = document.querySelector('.seek_slider');
let volume_slider = document.querySelector('.volume_slider');
let curr_time = document.querySelector('.current-time');
let total_duration = document.querySelector('.total-duration');
let randomIcon = document.querySelector('.fa-random');
let curr_track = document.createElement('audio');

let track_index = 0;
let isPlaying = false;
let isRandom = false;
let updateTimer;

var music_list = Array();

//FUNCIONES PARA ESCUCHAR CANCION TRAS PULSAR AL PLAY CUANDO APARECEN LAS CANCIONES 
function reproducirSeleccionado(datos){
    music_list = new Array();
    for (let cancion of datos) {
        music_list.push(cancion);
    }
    loadTrack(0);
    playTrack();
};

//Funcion para que cuando le de a me gusta se añada a la playlist me gusta que tien reservada la id playlist  0

function cambiarIcono(idCancion, idPlaylist, duracionCancion) {
    const boton = document.getElementById(`boton-corazon${idCancion}`);
    const valor = document.getElementById(`valor${idCancion}`);
    console.log(valor.value)
    if (valor.value == 0) {
        console.log("vacio a lleno");
        console.log(idPlaylist);

        boton.innerHTML = '<i class="fa fa-heart fa-2x"></i>'; //corazon lleno
        valor.value = 1;

        // hacer la petición AJAX
        const rutaDirectorio = window.location.pathname.split('/').slice(0, -1).join('/');
        const url = rutaDirectorio + '/includes/Cancion.php';
        console.log(rutaDirectorio); // "/ruta/al/directorio"
        const xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // aquí puedes hacer algo si la petición fue exitosa
            } else {
                console.log("ERROR");
                // aquí puedes manejar errores si la petición falló
            }
        };
        xhr.send(`idCancion=${idCancion}&idPlaylist=${idPlaylist}&duracionCancion=${duracionCancion}&accion=agregar-me-gusta`);
    } 
    else{
        console.log("lleno a vacio");
        console.log(idPlaylist);

        boton.innerHTML = '<i class="fa fa-heart-o fa-2x"></i>'; // corazon vacio
        valor.value = 0;
        // hacer la petición AJAX
        const rutaDirectorio = window.location.pathname.split('/').slice(0, -1).join('/');
        const url = rutaDirectorio + '/includes/Cancion.php';
        console.log(rutaDirectorio); // "/ruta/al/directorio"
        const xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // aquí puedes hacer algo si la petición fue exitosa
            } else {
                console.log("ERROR");
                // aquí puedes manejar errores si la petición falló
            }
        };
        xhr.send(`idCancion=${idCancion}&idPlaylist=${idPlaylist}&duracionCancion=${duracionCancion}&accion=quitar-me-gusta`);
    }
};


//----------------------------------------------------------------------------------------------------------------------
function loadTrack(track_index) {
    clearInterval(updateTimer);
    reset();

    curr_track.src = music_list[track_index].music;
    curr_track.load();
    track_art.style.backgroundImage = "url(" + music_list[track_index].img + ")";
    track_name.textContent = music_list[track_index].name;
    track_artist.textContent = music_list[track_index].artist;
    now_playing.textContent = "Playing music " + (track_index + 1) + " of " + music_list.length;

    updateTimer = setInterval(setUpdate, 1000);

    curr_track.addEventListener('ended', nextTrack);
}

function reset() {
    curr_time.textContent = "00:00";
    total_duration.textContent = "00:00";
    seek_slider.value = 0;
}
function randomTrack() {
    isRandom ? pauseRandom() : playRandom();
}
function playRandom() {
    isRandom = true;
    randomIcon.classList.add('randomActive');
}
function pauseRandom() {
    isRandom = false;
    randomIcon.classList.remove('randomActive');
}
function repeatTrack() {
    let current_index = track_index;
    loadTrack(current_index);
    playTrack();
}
function playpauseTrack() {
    isPlaying ? pauseTrack() : playTrack();
}
function playTrack() {
    curr_track.play();
    isPlaying = true;
    playpause_btn.innerHTML = '<i class="fa fa-pause-circle fa-5x"></i>';
}
function pauseTrack() {
    curr_track.pause();
    isPlaying = false;
    playpause_btn.innerHTML = '<i class="fa fa-play-circle fa-5x"></i>';
}
function nextTrack() {
    if (track_index < music_list.length - 1 && isRandom === false) {
        track_index += 1;
    } else if (track_index < music_list.length - 1 && isRandom === true) {
        let random_index = Number.parseInt(Math.random() * music_list.length);
        track_index = random_index;
    } else {
        track_index = 0;
    }
    loadTrack(track_index);
    playTrack();
}
function prevTrack() {
    if (track_index > 0) {
        track_index -= 1;
    } else {
        track_index = music_list.length - 1;
    }
    loadTrack(track_index);
    playTrack();
}
function seekTo() {
    let seekto = curr_track.duration * (seek_slider.value / 100);
    curr_track.currentTime = seekto;
}
function setVolume() {
    curr_track.volume = volume_slider.value / 100;
}
function setUpdate() {
    let seekPosition = 0;
    if (!isNaN(curr_track.duration)) {
        seekPosition = curr_track.currentTime * (100 / curr_track.duration);
        seek_slider.value = seekPosition;

        let currentMinutes = Math.floor(curr_track.currentTime / 60);
        let currentSeconds = Math.floor(curr_track.currentTime - currentMinutes * 60);
        let durationMinutes = Math.floor(curr_track.duration / 60);
        let durationSeconds = Math.floor(curr_track.duration - durationMinutes * 60);

        if (currentSeconds < 10) { currentSeconds = "0" + currentSeconds; }
        if (durationSeconds < 10) { durationSeconds = "0" + durationSeconds; }
        if (currentMinutes < 10) { currentMinutes = "0" + currentMinutes; }
        if (durationMinutes < 10) { durationMinutes = "0" + durationMinutes; }

        curr_time.textContent = currentMinutes + ":" + currentSeconds;
        total_duration.textContent = durationMinutes + ":" + durationSeconds;
    }
}