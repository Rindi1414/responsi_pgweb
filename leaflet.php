<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1,userscalable=no,maximum-scale=1,width=device-width" />
  <meta name="mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="author" content="DIVSIG UGM" />
  <meta name="description" content="leaflet basic" />
  <link rel="stylesheet" href="/path/to/leaflet.css" />
  <title>Leaflet Map</title>

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <!-- Search CSS Library -->
  <link rel="stylesheet" href="assets/plugins/leaflet-search/leaflet-search.css" />

  <!-- Geolocation CSS Library for Plugin -->
  <link rel="stylesheet" href="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.css" />

  <!-- Leaflet Mouse Position CSS Library -->
  <link rel="stylesheet" href="assets/plugins/leaflet-mouseposition/L.Control.MousePosition.css" />

  <!-- Leaflet Measure CSS Library -->
  <link rel="stylesheet" href="assets/plugins/leaflet-measure/leaflet-measure.css" />

  <!-- EasyPrint CSS Library -->
  <link rel="stylesheet" href="assets/plugins/leaflet-easyprint/easyPrint.css" />
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Marker Cluster -->
  <link rel="stylesheet" href="assets/plugins/leaflet-markercluster/MarkerCluster.css">
  <link rel="stylesheet" href="assets/plugins/leaflet-markercluster/MarkerCluster.Default.css">
  <!-- WEB_RINDI\assets\plugins\leaflet-markercluster\leaflet.markercluster-src.js.map
  WEB_RINDI\leaflet.php -->
  <!--Routing-->
  <link rel="stylesheet" href="assets/plugins/leaflet-routing/leaflet-routing-machine.css" />

  < !--Botstrap-->
    < !-- CSS only -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity=" sha384- Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
      <link rel="stylesheet" href="assets/plugins/leaflet-routing-machine3.2.12/leaflet-routing-machine-3.2.12/dist/leaflet-routing-machine.css" />
      <!-- <link rel="stylesheet" href="index.css" /> -->
      <style>
        #map {
          height: 100vh;
        }

        /* Background pada Judul */
        *.info {
          padding: 6px 8px;
          font: 14px/16px Arial, Helvetica, sans-serif;
          background: white;
          background: rgba(255, 255, 255, 0.8);
          box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
          border-radius: 5px;
          text-align: center;
        }

        .info h2 {
          margin: 0 0 5px;
          color: #777;
        }
      </style>
</head>

<body>
  <div class="alert alert-info">
    <strong>WEBGIS</strong> by Rindi Tri Setyaningsih
  </div>
  <div id="map"></div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <script src=".data.js"></script>

  <!-- Search JavaScript Library -->
  <script src="assets/plugins/leaflet-search/leaflet-search.js"></script>

  <!-- Geolocation Javascript Library -->
  <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.min.js"></script>

  <!-- Leaflet Mouse Position JavaScript Library -->
  <script src="assets/plugins/leaflet-mouseposition/L.Control.MousePosition.js"></script>

  <!-- Leaflet Measure JavaScript Library -->
  <script src="assets/plugins/leaflet-measure/leaflet-measure.js"></script>

  <!-- EasyPrint JavaScript Library -->
  <script src="assets/plugins/leaflet-easyprint/leaflet.easyPrint.js"></script>

  <!-- Marker Cluster -->
  <script src="assets/plugins/leaflet-markercluster/leaflet.markercluster.js"></script>
  <script src="assets/plugins/leaflet-markercluster/leaflet.markercluster-src.js"></script>

  <!--Routing-->
  <script src="assets/plugins/leaflet-routing/leaflet-routing-machine.js"></script>
  <script src="assets/plugins/leaflet-routing/leaflet-routing-machine.min.js"></script>

  <script>
    var map = L.map("map").setView([-7.7956, 110.3695], 10);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      maxZoom: 19,
      attribution: 'Map data ©️ <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);


    var wfsgeoserver1 = L.geoJson(null, {
      pointToLayer: function(feature, latlng) {
        return L.marker(latlng, {
          // icon: L.icon({
          //   iconUrl: "assets/img/marker/fas_rumahsakit_rujukan.png",
          //   iconSize: [32, 32],
          //   iconAnchor: [16, 32],
          //   popupAnchor: [0, -32],
          //   tooltipAnchor: [16, -20]
          // })
        });
      },
      onEachFeature: function(feature, layer) {
        var content =
          "Kecamatan: " +
          feature.properties.kecamatan +
          "<br>" +
          "Jumlah: " +
          feature.properties.jumlah;

        layer.on({
          click: function(e) {
            wfsgeoserver1.bindPopup(content).openPopup();
          },
          mouseover: function(e) {
            wfsgeoserver1
              .bindTooltip(feature.properties.kecamatan)
              .openTooltip();
          },
          mouseout: function(e) {
            wfsgeoserver1.closePopup();
            wfsgeoserver1.closeTooltip();
          },
        });
      },
    });

    $.getJSON("wfsgeoserver1.php", function(data) {
      wfsgeoserver1.addData(data);
      wfsgeoserver1.addTo(map);
      map.fitBounds(wfsgeoserver1.getBounds());
      L.geoJson(data).addTo(map);

    });



    /* Judul dan Subjudul */
    var title = new L.Control();
    title.onAdd = function(map) {
      this._div = L.DomUtil.create('div', 'info');
      this.update();
      return this._div;
    };
    title.update = function() {
      this._div.innerHTML = '<h2>PERSEBARAN PANTAI DI YOGYAKARTA'
    };
    title.addTo(map);
    /* Image Watermark */
    L.Control.Watermark = L.Control.extend({
      onAdd: function(map) {
        var img = L.DomUtil.create("img");
        img.src = "assets/img/logo/LOGO_SIG_BLUE.png";
        img.style.width = "300px";
        return img;
      },
    });

    L.control.watermark = function(opts) {
      return new L.Control.Watermark(opts);
    };

    L.control.watermark({
      position: "bottomleft"
    }).addTo(map);
    /* Image Legend */
    L.Control.Legend = L.Control.extend({
      onAdd: function(map) {
        var img = L.DomUtil.create('img');
        img.src = 'assets/img/legenda/legenda3.jpeg';
        img.style.width = '300px';
        return img;
      }
    });
    L.control.Legend = function(opts) {
      return new L.Control.Legend(opts);
    }
    L.control.Legend({
      position: 'bottomleft'
    }).addTo(map);

    // Plugin Search
    var searchControl = new L.Control.Search({
      position: "topleft",
      layer: wfsgeoserver1, //Nama variabel layer
      propertyName: "kecamatan", //Field untuk pencarian
      marker: false,
      moveToLocation: function(latlng, title, map) {
        var zoom = map.getBoundsZoom(latlng.layer.getBounds());
        map.setView(latlng, zoom);
      },
    });
    searchControl
      .on("search:locationfound", function(e) {
        e.layer.setStyle({
          fillColor: "#ffff00",
          color: "#0000ff",
        });
      })
      .on("search:collapse", function(e) {
        featuresLayer.eachLayer(function(layer) {
          featuresLayer.resetStyle(layer);
        });
      });
    map.addControl(searchControl);
    /*Plugin Geolocation */
    var locateControl = L.control
      .locate({
        position: "topleft",
        drawCircle: true,
        follow: true,
        setView: true,
        keepCurrentZoomLevel: false,
        markerStyle: {
          weight: 1,
          opacity: 0.8,
          fillOpacity: 0.8,
        },
        circleStyle: {
          weight: 1,
          clickable: false,
        },
        icon: "fas fa-crosshairs",
        metric: true,
        strings: {
          title: "Click for Your Location",
          popup: "You're here. Accuracy {distance} {unit}",
          outsideMapBoundsMsg: "Not available",
        },
        locateOptions: {
          maxZoom: 16,
          watch: true,
          enableHighAccuracy: true,
          maximumAge: 10000,
          timeout: 10000,
        },
      })
      .addTo(map);
    /*Plugin Mouse Position Coordinate */
    L.control
      .mousePosition({
        position: "bottomright",
        separator: ",",
        prefix: "Point Coodinate: ",
      })
      .addTo(map);

    /*Plugin Measurement Tool */
    var measureControl = new L.Control.Measure({
      position: "topleft",
      primaryLengthUnit: "meters",
      secondaryLengthUnit: "kilometers",
      primaryAreaUnit: "hectares",
      secondaryAreaUnit: "sqmeters",
      activeColor: "#FF0000",
      completedColor: "#00FF00",
    });
    measureControl.addTo(map);

    /*Plugin EasyPrint */
    L.easyPrint({
      title: "Print",
    }).addTo(map);

    /*Plugin Routing*/
    L.Routing.control({
      waypoints: [
        L.latLng(-7.774876989477508, 110.3746770621709),
        L.latLng(-7.789865101510259, 110.37792578946565)
      ],
      routeWhileDragging: true
    }).addTo(map);
    $.getJSON('getLocations.php', function(data) {
    var markers = L.markerClusterGroup();

    for (var i = 0; i < data.length; i++) {
        var marker = L.marker([data[i][2], data[i][1]], {
            title: data[i][0]
        });

        marker.bindPopup('<a href="' + data[i][3] + '" target="_blank">' + data[i][0] + '</a>');
        markers.addLayer(marker);
    }

    map.addLayer(markers);
});

    // Function to determine color based on 'Village' attribute
    function getColor(value) {
      return value == 'Margokaton' ? "#67000d" :
        value === 'Margodadi' ? "#fb7050" :
        value === 'Margomulyo' ? "#fff5f0" :
        "#fff5f0"; // Default color
    }
    // Function to determine the color based on the 'value' attribute
    function getColor(jumlah) {
      return jumlah > 75000 ?
        "#67000d" :
        jumlah > 50000 ?
        "#fb7050" :
        jumlah > 10 ?
        "c45f37" :
        "c45f37";
    }
    $.getJSON("wfsgeoserver1.php", function(data) {
      L.geoJson(data, {
        style: function(feature) {
          return {
            color: getColor(feature.properties.jumlah)
          };
        }
      }).addTo(wfsgeoserver1);
      wfsgeoserver1.addTo(map);
      map.fitBounds(wfsgeoserver1.getBounds());
    });
  </script>
</body>

</html>