/*MOSTRAR Y OCULTAR INPUT SONG*/
    document.getElementsByClassName('songSearch-btn')[0].onclick = function(){
        document.getElementsByClassName('songSearch-input')[0].classList.toggle('d-none');
        this.classList.toggle('d-none');
    }
    document.getElementsByClassName('songSearchClose-btn')[0].onclick = function(){
        document.getElementsByClassName('songSearch-input')[0].classList.toggle('d-none');
        document.getElementsByClassName('songSearch-btn')[0].classList.toggle('d-none');
    }
/*Funcion cambia cancion*/
    document.getElementById( "button-songSearch").addEventListener("click",buscar,false);
    function buscar() {
        var texto = document.getElementsByName("cancion")[0].value;
        //https://api.spotify.com/v1/search?q=${texto}&type=track
        
        var artistsUrl = `https://api.spotify.com/v1/search?q=%25${texto}%25&type=track`;
        obtenerToken(artistsUrl);
    }
    
    // Coloca tu Client ID y Client Secret aquí
    const clientId = '49372f6f9d0c44989013884275198826';
    const clientSecret = '1ec15bf195f54937aa8be67d1eeb8831';
    
    // Codifica las credenciales en formato Base64
    const credentials = btoa(`${clientId}:${clientSecret}`);
    
    // URL de la API de Spotify para obtener el token de acceso
    const tokenUrl = 'https://accounts.spotify.com/api/token';
    
    // Configuración para la solicitud de token
    const tokenRequestConfig = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Authorization': `Basic ${credentials}`
        },
        body: 'grant_type=client_credentials'
    };
    
    // Función para obtener el token de acceso
    function obtenerToken(artistsUrl) {
        fetch(tokenUrl, tokenRequestConfig)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error al obtener el token. Código: ${response.status}`);
                }
                return response.json();
            })
            .then(data => data.access_token)
            .then(accessToken => getArtists(accessToken, artistsUrl))
            .catch(error => {
                console.error('Error al obtener el token:', error);
                throw error;
            });
    }
    
    // Función para obtener información de artistas
    function getArtists(accessToken, artistsUrl) {
        fetch(artistsUrl, {
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error al obtener la información de artistas. Código: ${response.status}`);
            }
            return response.json();
        })
        .then(data => data.tracks.items)
        .then(tracks => {                                   
            const track = tracks[0]; // Obtener la primera canción de la lista
            //Imagen
            const albumImageUrl = track.album.images[0].url;
            //Artista
            const artistName =track.artists[0].name;
            //Cancion
            const nameSong = track.name;
            //Audio     
            const audio=track.preview_url;
            //Enviar info a php
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log('Song changed succesfully');
                    window.location.reload();
                }
            };
            xhr.open("GET", "index.php?ctl=guardarCancion&imagen=" + albumImageUrl + "&artista=" + artistName + "&cancion=" + nameSong + "&audio=" + encodeURIComponent(audio), true);
            xhr.send();
        })
    }