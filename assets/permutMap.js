require('leaflet');

// eslint-disable-next-line
const L = window.L;

const NbUser = ((document.getElementsByClassName('permutMap')).length) + 1;

function initMap(
    homeLong = 2.8884657,
    homeLat = 48.9562018,
    workLong = 2.3488,
    workLat = 48.8534,
    UserHomeLong = 2.38333,
    UserHomeLat = 48.916672 ,
    UserWorkLong = 2.765796,
    UserWorkLat = 48.878462,
    lat = 48.852969,
    lon = 2.2,
) {
    for (let i = 1; i < NbUser; i += 1) {

        //Init Maps
        // Map Before
        const mapBefore = L.map((`map-before-${i}`), {
            zoomControl: false,
            scrollWheelZoom: false,
            dragging: false,
            tap: false,
            touchZoom: false,
            center: [48.852969, 2.2],
        }).setView(
            [lat, lon],
            10,
        );

        // Map After
        const mapAfter = L.map((`map-after-${i}`), {
            zoomControl: false,
            scrollWheelZoom: false,
            dragging: false,
            tap: false,
            touchZoom: false,
            center: [48.852969, 2.2],
        }).setView(
            [lat, lon],
            10,
        );

        // Init Tiles
        // Tiles on mapBefore
        L.tileLayer(
            'https://tile.thunderforest.com/atlas/{z}/{x}/{y}.png?apikey=99affac52963476dbbf2ed20db232af9',
            {
                attribution:
                'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
            },
        ).addTo(mapBefore);

        // Tiles on mapAfter
        L.tileLayer(
            'https://tile.thunderforest.com/atlas/{z}/{x}/{y}.png?apikey=99affac52963476dbbf2ed20db232af9',
            {
                attribution:
                'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
            },
        ).addTo(mapAfter);

        // Init Markers

        // on mapBefore
        const workIcon = L.divIcon({ className: 'fas fa-briefcase', iconAnchor: [12, 25] });
        L.marker([workLat, workLong], { icon: workIcon }).addTo(mapBefore);
        const homeIcon = L.divIcon({ className: 'fas fa-home', iconAnchor: [12, 25] });
        L.marker([homeLat, homeLong], { icon: homeIcon }).addTo(mapBefore);
        
        const userWorkIcon = L.divIcon({ className: 'fas fa-briefcase user', iconAnchor: [12, 25] });
        L.marker([UserWorkLat, UserWorkLong], { icon: userWorkIcon }).addTo(mapBefore);
        const userHomeIcon = L.divIcon({ className: 'fas fa-home user', iconAnchor: [12, 25] });
        L.marker([UserHomeLat, UserHomeLong], { icon: userHomeIcon }).addTo(mapBefore);

        // on mapAfter
        const newWorkIcon = L.divIcon({ className: 'fas fa-briefcase', iconAnchor: [12, 25] });
        L.marker([UserWorkLat, UserWorkLong], { icon: newWorkIcon }).addTo(mapAfter);
        const newHomeIcon = L.divIcon({ className: 'fas fa-home', iconAnchor: [12, 25] });
        L.marker([homeLat, homeLong], { icon: newHomeIcon }).addTo(mapAfter);
        
        const NewUserWorkIcon = L.divIcon({ className: 'fas fa-briefcase user', iconAnchor: [12, 25] });
        L.marker([workLat, workLong], { icon: NewUserWorkIcon }).addTo(mapAfter);
        const NewUserHomeIcon = L.divIcon({ className: 'fas fa-home user', iconAnchor: [12, 25] });
        L.marker([UserHomeLat, UserHomeLong], { icon: NewUserHomeIcon }).addTo(mapAfter);

        // Init Routes

        // on map Before
        fetch(`/leaflet/direction/${homeLong}/${homeLat}/${workLong}/${workLat}`)
        .then((response) => response.json())
        .then((data) => {
            data = data.geometry.coordinates;
            data.forEach((element) => {
                element = element.reverse();
            });
            L.polyline(data, { color: '#ed9f1a' }).addTo(mapBefore);
        });

        fetch(`/leaflet/direction/${UserHomeLong}/${UserHomeLat}/${UserWorkLong}/${UserWorkLat}`)
        .then((response) => response.json())
        .then((data) => {
            data = data.geometry.coordinates;
            data.forEach((element) => {
                element = element.reverse();
            });
            L.polyline(data, { color: '#00636f' }).addTo(mapBefore);
        });

        // on mapAfter

        fetch(`/leaflet/direction/${homeLong}/${homeLat}/${UserWorkLong}/${UserWorkLat}`)
        .then((response) => response.json())
        .then((data) => {
            data = data.geometry.coordinates;
            data.forEach((element) => {
                element = element.reverse();
            });
            L.polyline(data, { color: '#ed9f1a' }).addTo(mapAfter);
        });

        fetch(`/leaflet/direction/${UserHomeLong}/${UserHomeLat}/${workLong}/${workLat}`)
        .then((response) => response.json())
        .then((data) => {
            data = data.geometry.coordinates;
            data.forEach((element) => {
                element = element.reverse();
            });
            L.polyline(data, { color: '#00636f' }).addTo(mapAfter);
        });

        // Centrer les cartes sur les trajets
        mapBefore.fitBounds([
            [workLat, workLong],
            [homeLat, homeLong],
            [UserWorkLat, UserWorkLong],
            [UserHomeLat, UserHomeLong],
        ]);

        mapAfter.fitBounds([
            [workLat, workLong],
            [homeLat, homeLong],
            [UserWorkLat, UserWorkLong],
            [UserHomeLat, UserHomeLong],
        ]);




    }
}

window.onload = function () {
    initMap();
};