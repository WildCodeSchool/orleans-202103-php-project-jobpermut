require('leaflet');

// eslint-disable-next-line
const L = window.L;

const NbUser = ((document.getElementsByClassName('permutMap')).length) + 1;

function initMap(
    lat = 48.852969,
    lon = 2.2,
) {
    for (let i = 1; i < NbUser; i += 1) {
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
        L.tileLayer(
            'https://tile.thunderforest.com/atlas/{z}/{x}/{y}.png?apikey=99affac52963476dbbf2ed20db232af9',
            {
                attribution:
                'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
            },
        ).addTo(mapBefore);

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

        L.tileLayer(
            'https://tile.thunderforest.com/atlas/{z}/{x}/{y}.png?apikey=99affac52963476dbbf2ed20db232af9',
            {
                attribution:
                'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
            },
        ).addTo(mapAfter);
    }
}

window.onload = function () {
    initMap();
};
