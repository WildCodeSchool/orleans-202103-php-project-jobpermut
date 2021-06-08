// On initialise la latitude et la longitude de Paris (centre de la carte)
        var lat = 48.852969;
        var lon = 1.8;
        var map = null;
        // Fonction d'initialisation de la carte
        function initMap() {
            // Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"
            map = L.map('map', { zoomControl: false, scrollWheelZoom: false }).setView([lat, lon], 10);
            // Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, thunderforest.com
            L.tileLayer('https://tile.thunderforest.com/atlas/{z}/{x}/{y}.png?apikey=99affac52963476dbbf2ed20db232af9', {
                // Il est toujours bien de laisser le lien vers la source des données
                attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
                minZoom: 10,
                maxZoom: 10
            }).addTo(map);
        }
        window.onload = function(){
    // Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
    initMap(); 
        };