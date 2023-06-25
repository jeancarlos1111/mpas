<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Maps') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div id="map" class="" style="height: 640px;"></div>
            </div>
        </div>
    </div>

    @push('scripts')

<script>
    let app = {{ Js::from($mapa->map) }}; 
    console.log(app);
  /* eslint-disable no-undef */
  /**
   * create and save a geojson
   */

  // config map
  let config = {
    minZoom: 7,
    maxZoom: 18,
    fullscreenControl: true,
  };
  // magnification with which the map will start
  const zoom = 8;
  // co-ordinates
  const lat = 20.900;
  const lng = -103.600;

  // calling map
  const map = L.map("map", config).setView([lat, lng], zoom);

  // Used to load and display tile layers on the map
  // Most tile servers require attribution, which you can set under `Layer`
  L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
  }).addTo(map);

  // --------------------------------------------------
  // Nofiflix options

  Notiflix.Notify.init({
    width: "280px",
    position: "right-bottom",
    distance: "10px",
  });

  // --------------------------------------------------
  // add buttons to map

  const customControl = L.Control.extend({
    // button position
    options: {
      position: "topright",
    },

    // method
    onAdd: function() {
      const array = [{
          title: "exportar características geojson",
          html: '<i class="fa-solid fa-file-export" style="color: #04070b;"></i>',
          className: "export link-button leaflet-bar",
        },
        {
          title: "guardar geojson",
          html: '<i class="fa-solid fa-floppy-disk" style="color: #04070b;"></i>',
          className: "save link-button leaflet-bar",
        },
        {
          title: "eliminar geojson",
          html: '<i class="fa-solid fa-trash" style="color: #04070b;"></i>',
          className: "remove link-button leaflet-bar",
        },
        {
          title: "cargar geojson desde archivo",
          html: "<input type='file' id='geojson' class='geojson' accept='text/plain, text/json, .geojson' onchange='openFile(event)' /><label for='geojson'><i class='fa-sharp fa-solid fa-upload' style='color: #04070b;'></i></label>",
          className: "load link-button leaflet-bar",
        },
      ];

      const container = L.DomUtil.create(
        "div",
        "leaflet-control leaflet-action-button"
      );

      array.forEach((item) => {
        const button = L.DomUtil.create("a");
        button.href = "#";
        button.setAttribute("role", "button");

        button.title = item.title;
        button.innerHTML = item.html;
        button.className += item.className;

        // add buttons to container;
        container.appendChild(button);
      });

      return container;
    },
  });
  map.addControl(new customControl());

  // Drow polygon, circle, rectangle, polyline
  // --------------------------------------------------

  let drawnItems = L.featureGroup().addTo(map);

  /*map.addControl(
    new L.Control.Draw({
      edit: {
        featureGroup: drawnItems,
        poly: {
          allowIntersection: false,
        },
      },
      draw: {
        polygon: {
          allowIntersection: false,
          showArea: true,
        },
      },
    })
  ); */

  /*map.on(L.Draw.Event.CREATED, function(event) {
    let layer = event.layer;
    let feature = (layer.feature = layer.feature || {});
    let type = event.layerType;

    feature.type = feature.type || "Feature";
    let props = (feature.properties = feature.properties || {});

    props.type = type;

    if (type === "circle") {
      props.radius = layer.getRadius();
    }

    drawnItems.addLayer(layer);
  }); */

  // --------------------------------------------------
  // save geojson to file

  const exportJSON = document.querySelector(".export");

  exportJSON.addEventListener("click", () => {
    // Extract GeoJson from featureGroup
    const data = drawnItems.toGeoJSON();

    if (data.features.length === 0) {
      Notiflix.Notify.failure("Debe tener algunos datos para guardar un archivo geojson");
      return;
    } else {
      Notiflix.Notify.info("Puede guardar los datos en un geojson");
    }

    // Stringify the GeoJson
    const convertedData =
      "text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(data));

    exportJSON.setAttribute("href", "data:" + convertedData);
    exportJSON.setAttribute("download", "data.geojson");
  });

  // --------------------------------------------------
  // save geojson to localstorage
  const saveJSON = document.querySelector(".save");

  saveJSON.addEventListener("click", (e) => {
    e.preventDefault();

    const data = drawnItems.toGeoJSON();

    if (data.features.length === 0) {
      Notiflix.Notify.failure("Debes tener algunos datos para guardarlo");
      return;
    } else {
      Notiflix.Notify.success("Los datos se han guardado en localstorage");
    }

    localStorage.setItem("geojson", JSON.stringify(data));
  });

  // --------------------------------------------------
  // remove gojson from localstorage

  const removeJSON = document.querySelector(".remove");

  removeJSON.addEventListener("click", (e) => {
    e.preventDefault();
    localStorage.removeItem("geojson");

    Notiflix.Notify.info("Todas las capas han sido eliminadas.");

    drawnItems.eachLayer(function(layer) {
      drawnItems.removeLayer(layer);
    });
  });

  // --------------------------------------------------
  // load geojson from localstorage

  const geojsonFromLocalStorage = app//JSON.parse(localStorage.getItem("geojson"));

  function setGeojsonToMap(geojson) {
    const feature = L.geoJSON(geojson, {
      style: function(feature) {
        return {
          color: "red",
          weight: 2,
        };
      },
      pointToLayer: (feature, latlng) => {
        if (feature.properties.type === "circle") {
          return new L.circle(latlng, {
            radius: feature.properties.radius,
          });
        } else if (feature.properties.type === "circlemarker") {
          return new L.circleMarker(latlng, {
            radius: 10,
          });
        } else {
          return new L.Marker(latlng);
        }
      },
      onEachFeature: function(feature, layer) {
        drawnItems.addLayer(layer);
        const coordinates = feature.geometry.coordinates.toString();
        const result = coordinates.match(/[^,]+,[^,]+/g);

        layer.bindPopup(
          "<span>Coordinates:<br>" + result.join("<br>") + "</span>"
        );
      },
    }).addTo(map);

    map.flyToBounds(feature.getBounds());
  }

  if (geojsonFromLocalStorage) {
    setGeojsonToMap(geojsonFromLocalStorage);
  }

  // --------------------------------------------------
  // get geojson from file

  function openFile(event) {
    const input = event.target;

    const reader = new FileReader();
    reader.onload = function() {
      const result = reader.result;
      const geojson = JSON.parse(result);

      Notiflix.Notify.info("Los datos han sido cargados desde el archivo.");

      setGeojsonToMap(geojson);
    };
    reader.readAsText(input.files[0]);
  }

  /* Seccion para guardar el mapa */
  let boton = document.getElementById('guardar');
 
  // Agregar un evento de clic al botón
/*   boton.addEventListener('click', function() {
    let name = document.getElementById('name').value;
    let category_id = document.getElementById('category_id').value;
    if(localStorage.getItem("geojson")) {
      if(name && category_id) {
        axios.post('/mapas', {
          name: name,
          category_id: category_id,
          map: JSON.parse(localStorage.getItem("geojson"))
      }).then(response => {
          Notiflix.Notify.success(`Los datos se han guardado para el mapa ${response.data.name}`);
          localStorage.removeItem("geojson");
          window.location.href = '/mapas';
      }).catch(e => {
          console.log(e);
      });
      } else {
        Notiflix.Notify.failure("Asegurese de rellenar los campos nombre y categoria");
      }
      
    } else {
      Notiflix.Notify.failure("Guarda primero las modificaciones del mapa");
    }
  }); */
</script>
@endpush
</x-app-layout>