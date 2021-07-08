require('leaflet');

// eslint-disable-next-line
const L = window.L;

const permutMap = document.getElementsByClassName('permutMap');

function initMap(
    homeLong = 2.8884657,
    homeLat = 48.9562018,
    workLong = 2.3488,
    workLat = 48.8534,
    userHomeLong = 2.38333,
    userHomeLat = 48.916672,
    userWorkLong = 2.765796,
    userWorkLat = 48.878462,
    lat = 48.852969,
    lon = 2.2,
) {
    permutMap.forEach((element) => {
        if (element.classList.contains('map-before')) {
            const mapBefore = L.map(element, {
                zoomControl: false,
                scrollWheelZoom: false,
                dragging: false,
                tap: false,
                touchZoom: false,
                center: [48.852969, 2.2],
            }).setView([lat, lon], 10);

            L.tileLayer(
                'https://tile.thunderforest.com/atlas/{z}/{x}/{y}.png?apikey=99affac52963476dbbf2ed20db232af9',
                {
                    attributuion:
                        'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
                },
            ).addTo(mapBefore);

            // Init Markers

            // on mapBefore
            const workIcon = L.divIcon({
                className: 'fas fa-briefcase',
                iconAnchor: [12, 25],
            });

            L.marker([workLat, workLong], { icon: workIcon }).addTo(mapBefore);

            const homeIcon = L.divIcon({
                className: 'fas fa-home',
                iconAnchor: [12, 25],
            });

            L.marker([homeLat, homeLong], { icon: homeIcon }).addTo(mapBefore);

            const userWorkIcon = L.divIcon({
                className: 'fas fa-briefcase user',
                iconAnchor: [12, 25],
            });

            L.marker([userWorkLat, userWorkLong], { icon: userWorkIcon }).addTo(mapBefore);

            const userHomeIcon = L.divIcon({
                className: 'fas fa-home user',
                iconAnchor: [12, 25],
            });

            L.marker([userHomeLat, userHomeLong], { icon: userHomeIcon }).addTo(mapBefore);

            fetch(`/leaflet/direction/${homeLong}/${homeLat}/${workLong}/${workLat}`)
                .then((response) => response.json())
                .then((datas) => {
                    const data = datas.geometry.coordinates;
                    data.forEach((elements) => {
                        elements = elements.reverse();
                    });
                    L.polyline(data, { color: '#ed9f1a' }).addTo(mapBefore);
                });

            fetch(`/leaflet/direction/${userHomeLong}/${userHomeLat}/${userWorkLong}/${userWorkLat}`)
                .then((response) => response.json())
                .then((datas) => {
                    const data = datas.geometry.coordinates;
                    data.forEach((elements) => {
                        elements = elements.reverse();
                    });
                    L.polyline(data, { color: '#00636f' }).addTo(mapBefore);
                });

            // Centrer les cartes sur les trajets
            mapBefore.fitBounds([
                [workLat, workLong],
                [homeLat, homeLong],
                [userWorkLat, userWorkLong],
                [userHomeLat, userHomeLong],
            ]);
        }

        if (element.classList.contains('map-after')) {
            // Map After
            const mapAfter = L.map(element, {
                zoomControl: false,
                scrollWheelZoom: false,
                dragging: false,
                tap: false,
                touchZoom: false,
                center: [48.852969, 2.2],
            }).setView([lat, lon], 10);

            L.tileLayer(
                'https://tile.thunderforest.com/atlas/{z}/{x}/{y}.png?apikey=99affac52963476dbbf2ed20db232af9',
                {
                    attribution:
                        'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
                },
            ).addTo(mapAfter);

            // on mapAfter
            const newWorkIcon = L.divIcon({
                className: 'fas fa-briefcase',
                iconAnchor: [12, 25],
            });

            L.marker([userWorkLat, userWorkLong], { icon: newWorkIcon }).addTo(mapAfter);

            const newHomeIcon = L.divIcon({
                className: 'fas fa-home',
                iconAnchor: [12, 25],
            });

            L.marker([homeLat, homeLong], { icon: newHomeIcon }).addTo(mapAfter);

            const NewUserWorkIcon = L.divIcon({
                className: 'fas fa-briefcase user',
                iconAnchor: [12, 25],
            });

            L.marker([workLat, workLong], { icon: NewUserWorkIcon }).addTo(mapAfter);

            const NewUserHomeIcon = L.divIcon({
                className: 'fas fa-home user',
                iconAnchor: [12, 25],
            });

            L.marker([userHomeLat, userHomeLong], {
                icon: NewUserHomeIcon,
            }).addTo(mapAfter);

            fetch(`/leaflet/direction/${homeLong}/${homeLat}/${userWorkLong}/${userWorkLat}`)
                .then((response) => response.json())
                .then((datas) => {
                    const data = datas.geometry.coordinates;
                    data.forEach((elements) => {
                        elements = elements.reverse();
                    });
                    L.polyline(data, { color: '#ed9f1a' }).addTo(mapAfter);
                });

            fetch(`/leaflet/direction/${userHomeLong}/${userHomeLat}/${workLong}/${workLat}`)
                .then((response) => response.json())
                .then((datas) => {
                    const data = datas.geometry.coordinates;
                    data.forEach((elements) => {
                        elements = elements.reverse();
                    });
                    L.polyline(data, { color: '#00636f' }).addTo(mapAfter);
                });

            mapAfter.fitBounds([
                [workLat, workLong],
                [homeLat, homeLong],
                [userWorkLat, userWorkLong],
                [userHomeLat, userHomeLong],
            ]);
        }
    });
}

window.onload = function () {
    initMap();
};
