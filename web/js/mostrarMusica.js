window.onload = function() {
    var artistsUrl = 'https://api.spotify.com/v1/playlists/3mn4kXt07PEGZFR46h3HhN?fields=tracks&limit=4';
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
        .then(accessToken => getCanciones(accessToken, artistsUrl))
        .catch(error => {
            console.error('Error al obtener el token:', error);
            throw error;
        });
}

// Función para obtener información de artistas
function getCanciones(accessToken, artistsUrl) {
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
    .then(data => {
        var tracks = data.tracks.items.slice(0, 6); // Obtengo los 6 primeros

        var container = document.getElementById('mostrarCanciones');

        tracks.forEach(item => {
            var track = item.track;//Obtengo la info
            var albumImageUrl = track.album.images[0].url;//Obtengo la foto de la canción
            var artistName = track.artists[0].name;// Obtengo el nombre del artista
            var songName = track.name;//Obtengo el nombre de la cancion

            var card = document.createElement('div');
            card.classList.add('card', 'border-0', 'mt-3', 'mb-3', 'h-50', 'w-25');

            var cardContent = `
                <img src="${albumImageUrl}" class="bd-placeholder-img card-img-top" alt="book">
                <div class="content d-flex flex-column align-items-center justify-content-center w-100 h-100">
                    <p class="fs-5 text-white mx-4">${artistName}</p>
                    <p class=" text-white">${songName}</p>
                </div>
            `;

            card.innerHTML = cardContent;
            container.appendChild(card);
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
