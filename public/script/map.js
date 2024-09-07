var map;
function InitMap() {
    if (map) {
        map.remove();
    }
    let newMap = L.map("map", {
        zoomControl: false,
        scrollWheelZoom: false,
        touchZoom: false,
        doubleClickZoom: false,
    }).setView([-2, 117.0577694], 5);
    const mapIndonesiaURL = "/geo/indonesia-prov.geojson";

    var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    svg.innerHTML = `
            <defs>
                <pattern id="imagePattern" patternUnits="userSpaceOnUse" width="130" height="86.5">
                    <image href="/images/backgrounds/square-texture.jpg" x="0" y="0" width="130" height="86.5" />
                </pattern>
            </defs>
        `;
    svg.classList.add("h-0");
    document.body.appendChild(svg);

    fetch(mapIndonesiaURL)
        .then((response) => response.json())
        .then((data) => {
            L.geoJson(data, {
                style: function () {
                    return {
                        fillColor: 'url(#imagePattern)',  // Fill with the pattern
                        weight: 2,
                        opacity: 1,
                        color: '#000',
                        fillOpacity: 0.8
                    };
                }
            }).addTo(newMap);
            document.getElementById("loading") &&
                document.getElementById("loading").classList.add("hidden");
        });
    return newMap;
}
map = InitMap();
