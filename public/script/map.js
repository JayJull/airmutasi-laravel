var map = L.map("map", {
  zoomControl: false,
  scrollWheelZoom: false,
  touchZoom: false,
  doubleClickZoom: false,
}).setView([-2, 117.0577694], 5);
const mapIndonesiaURL =
  "/geo/indonesia-prov.geojson";

fetch(mapIndonesiaURL)
  .then((response) => response.json())
  .then((data) => {
    L.geoJson(data, {
      style: {
        color: "blue",
        fillColor: "blue",
        fillOpacity: 0.5,
      },
    }).addTo(map);
  });
