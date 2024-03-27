// import { createApp, ref, watch, onMounted } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.prod.js'
import { createApp, ref, watch, onMounted, toRaw } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'
import { createIcons} from './Marker'
createApp({
    setup() {
        /* Helpers */
        const apiURL =  window.location.protocol + "//" + window.location.host + '/api/'
        
        /* Loading */
        const showLoading = ref(true)
        const showSearchBarLoading = ref(false)

        /* Search */
        const query = ref('')
        const barFocus = ref(false)
        const recommendations = ref([])
        const recommendationsSourceData = ref([])

        /* Date Filter */
        let date = new Date()
        date.setMonth(date.getMonth() - 3);
        const dateFilter = ref(date.toISOString().split('T')[0])
       
        /* OffCanvas */
        const offCanvasModal = ref({})
        const statistics = ref({})
        
        /* Map */
        const map = ref([])
        const zoomLevel = ref(11)
        const overlayLayers = ref([])
        const controlLayers = ref({})
        const heatLayer = ref([])
        const heatmap = ref({})
        const heatmapGradientBar = ref(true)
        
        /* App Data */
        const currentLocation = ref({})
        const currentLocationGeometry = ref({})
        const currentLocationMarker = ref({})
        
        /* Abort Controller */
        let controller = new AbortController()
        let signal = controller.signal

        onMounted(async () => {
            // offcanvas
            offCanvasModal.value = new bootstrap.Offcanvas('#LocationInfo')
            // Create the base layers
            var layerGroupThreeMonths = L.layerGroup()
            var layerCustomDate = L.layerGroup()
            var layersData = []
            layersData.push(layerGroupThreeMonths)
            // Create the overlay layers and markers
            await fetchCrimesAndUpdateLayers()
            // Create the map
            map.value = L.map('map', {
                zoomControl: false, 
                attributionControl: false,
                // layers: layersData,
                minZoom: 3,
                maxZoom: 18,
                maxBounds: L.latLngBounds([-90, -180], [90, 180]),
                wraparound: true
                // Do not show other worlds when dragging
            }).setView([-9.6, -35.71422457695007], zoomLevel.value)
            // Add the tile layer
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                noWrap: true,
                worldCopyJump: true
            }).addTo(map.value)
            // Zoom control interface
            L.control.zoom({position: 'bottomright'}).addTo(map.value)
            // Plugin to show user location
            L.control.locate({
                position: 'bottomright',
                flyTo: false, 
                drawCircle: true,
                showPopup: false, 
                markerClass: L.circleMarker,
                strings: {
                  title: "Mostrar minha localização",
                  popup: "Você está dentro de {distance} {unit} deste ponto"
                },
                locateOptions: {
                  maxZoom: 16, 
                },
            }).addTo(map.value)
            // Add the custom date control
            L.Control.DatePicker = L.Control.extend({
                onAdd: function(map) {
                    var container = L.DomUtil.create('div')
                    container.id = "datePickerContainer"
                    container.className = "bg-white rounded shadow-sm border border-dark p-2"
                    L.DomEvent.disableClickPropagation(container)
                    var label = L.DomUtil.create('label', '', container)
                    label.innerHTML = 'Serão mostrados apenas as ocorrências até a data selecionada. Por padrão, são exibidos apenas os dados dos últimos 3 meses.'
                    label.className = "form-label"
                    var input = L.DomUtil.create('input', '', container)
                    input.type = "date"
                    input.className = "form-control form-control-sm"
                    input.value = dateFilter.value
                    input.onchange = function(e) {
                        console.log("change");
                        dateFilter.value = e.target.value
                        updateLayersOnMap()
                    }
                    return container
                },
                onRemove: function(map) {
                    // Nothing to do here
                }
            })
            L.control.datepicker = function(opts) {
                return new L.Control.DatePicker(opts)
            }
            L.control.datepicker({ position: 'topright' }).addTo(map.value)
            // Add the gradient bar control
            // L.Control.GradientBar = L.Control.extend({
            //     onAdd: function(map) {
            //         var container = L.DomUtil.create('div');
            //         container.id = "gradientBarContainer"
            //         var gradientBar = L.DomUtil.create('div', '', container);
            //         gradientBar.className = "gradient-bar";
            //         L.DomEvent.disableClickPropagation(gradientBar);
            //         return gradientBar;
            //     }
            // });
            // var gradientBar = new L.Control.GradientBar({ position: 'topright' });
            // gradientBar.addTo(map.value);
            // Add the layers control
            var baseMaps = {
                '<input type="date">': layerCustomDate,
                "em até 3 meses": layerGroupThreeMonths
            }
            controlLayers.value = L.control.layers({}, toRaw(overlayLayers.value), {
                position: 'topright',
                collapsed: false,
                sortLayers: false
            }).addTo(map.value)
            // Add the heatmap
            heatmap.value = L.heatLayer(heatLayer.value, {
                radius: 15,
                blur: 15,
                maxZoom: 12,
                gradient: {0.4: 'blue', 0.6: 'cyan', 0.7: 'lime', 0.8: 'yellow', 1: 'red'}
            })
            heatmap.value.addTo(map.value)
            // Add a zoomend event listener to the map
            const markerDisplayZoomLevel = 13
            var high = false
            map.value.on('zoomend', function() {
                let currentZoomLevel = map.value.getZoom()
                if (currentZoomLevel >= markerDisplayZoomLevel && !high) {
                    // If the zoom level is high enough, add the markers
                    for (let layerName in overlayLayers.value) {
                        overlayLayers.value[layerName].addTo(map.value)
                    }
                    heatmap.value.setLatLngs([])
                    high = true
                    heatmapGradientBar.value = false
                } else if (currentZoomLevel < markerDisplayZoomLevel && high) {
                    // If the zoom level is too low, remove the markers
                    for (let layerName in overlayLayers.value) {
                        overlayLayers.value[layerName].remove()
                    }
                    heatmap.value.setLatLngs(heatLayer.value)
                    high = false
                    heatmapGradientBar.value = true
                }
            })
            hideLoadingContainer()
        })

        function showLoadingContainer() {
            showLoading.value = true
        }

        function hideLoadingContainer() {
            showLoading.value = false
        }

        async function updateLayersOnMap() {
            // Show the loading container
            showLoadingContainer()
            // Disable zoom
            lockZoom()
            // Remove the current layers
            for (let layerName in overlayLayers.value) {
                overlayLayers.value[layerName].remove()
            }
            // Clear heatmap
            heatmap.value.setLatLngs([])
            // Clear the heat layer
            heatLayer.value = []
            // Add the new layers
            await fetchCrimesAndUpdateLayers()
            // Update the heatmap
            heatmap.value.setLatLngs(heatLayer.value)
            // Update the map
            for (let layerName in overlayLayers.value) {
                overlayLayers.value[layerName].addTo(map.value)
            }
            // Update the control layers
            map.value.removeControl(controlLayers.value)
            // Add the layers control
            controlLayers.value = L.control.layers({}, toRaw(overlayLayers.value), {
                position: 'topright',
                collapsed: false,
                sortLayers: false
            }).addTo(map.value)
            // Enable zoom
            unlockZoom()
            // Hide the loading container
            hideLoadingContainer()
        }

        function lockZoom() {
            map.value.touchZoom.disable()
            map.value.doubleClickZoom.disable()
            map.value.scrollWheelZoom.disable()
            map.value.boxZoom.disable()
        }

        function unlockZoom() {
            map.value.touchZoom.enable()
            map.value.doubleClickZoom.enable()
            map.value.scrollWheelZoom.enable()
            map.value.boxZoom.enable()
        }

        async function fetchCrimesAndUpdateLayers() {
            try {
                const response = await fetch(apiURL + 'reports/crimes', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ date: dateFilter.value })
                })
                const data = await response.json()
                const colorsCrime = await createIcons(apiURL)
                overlayLayers.value = []
                // Create the layers
                data.forEach(crime => {
                    // Add the markers
                    let markers = []
                    crime.reports.forEach(report => {
                        let marker = L.circleMarker([Number(report.lat), Number(report.lon)])
                        marker.setStyle({fillColor: colorsCrime[report.crime_id],radius:6,stroke:false,fillOpacity:1})
                        marker.bindTooltip(crime.name)
                        markers.push(marker)
                        // heatmap data
                        heatLayer.value.push([Number(report.lat), Number(report.lon), crime.heatmap_intensity])
                    })
                    // Add the layer group to the overlay layers
                    let layerGroup = L.layerGroup(markers)
                    overlayLayers.value['<span class="me-1 ms-1 border" style="border-radius: 5px; background-color:' + colorsCrime[crime.id]+'; width:10px; height:10px; display:inline-block"></span>'+crime.name] = layerGroup
                });
            } catch (err) {
                console.error(err);
            }
        }

        let timeoutId = null;

        watch(query, (newVal) => {
            // Show the search bar loading
            showSearchBarLoading.value = true
            // Abort the previous request
            controller.abort()
            // Create a new AbortController
            controller = new AbortController()
            signal = controller.signal
            // Check if is a booking.com url
            if (newVal.includes('booking.com')) {
                setExternalSearch(newVal, signal)
                return
            }
            // Clear the previous timeout if there is one
            if (timeoutId) {
                clearTimeout(timeoutId)
            }
            // Set a new timeout
            timeoutId = setTimeout(() => {
                // Make a new request
                fetch('https://nominatim.openstreetmap.org/search.php?q=' + encodeURI(newVal) + '&format=jsonv2&addressdetails=1&polygon_geojson=1', { signal })
                    .then(response => response.json())
                    .then(data => {
                        recommendations.value = []
                        recommendationsSourceData.value = data // Used to fit the map
                        data.forEach( element => {
                            let commaIndex = element.display_name.indexOf(',')
                            let info = element.display_name.substring(commaIndex + 1).trim()
                            let postcode = (element.address.postcode !== undefined) ? ` - ${element.address.postcode}` : ''
                            recommendations.value.push({
                                display: `${element.name} <span class="text-black-50 fst-italic">- ${info}${postcode}</span>`,
                            })
                        })
                    })
                    .catch(err => {
                        if (err.name !== 'AbortError') {
                            console.error('Another error: ', err)
                        }
                    })
                // Hide the search bar loading
                showSearchBarLoading.value = false
            }, 1000); // delay of 1 second
        })


        function setExternalSearch(url, signal) {
            var placeTitle
            fetch(apiURL + 'external', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ url: url })
            })
                .then(response => response.text())
                .then(html => {
                    let parser = new DOMParser();
                    let doc = parser.parseFromString(html, 'text/html');
                    placeTitle = doc.querySelector('#hp_hotel_name > div > h2').innerText;
                    let placeLocal = doc.querySelector('#hotel_address').getAttribute('data-atlas-latlng').split(',')
                    return fetch('https://nominatim.openstreetmap.org/reverse?lat=' + placeLocal[0] + '&lon=' + placeLocal[1] + '&format=jsonv2', { signal })
                })
                .then(response => response.json())
                .then(data => {
                    cleanBar()
                    recommendations.value = []
                    recommendationsSourceData.value = []
                    data.name = placeTitle
                    currentLocation.value = data
                    updateMap()
                })
                .catch(err => console.error(err))
        }

        function cleanBar() {
            barFocus.value = false
            query.value = ''
        }

        function selectSearchBarItem(index) {
            cleanBar()
            currentLocation.value = recommendationsSourceData.value[index]
            updateMap()
        }

        function updateMap() {
            statistics.value = {}
            drawCurrentLocationGeometry()
            drawCurrentLocationMarker()
            fitCurrentLocationBounds()
            updateOffCanvasStatistics()
        }

        function drawCurrentLocationGeometry() {
            if (Object.keys(currentLocationGeometry.value).length !== 0) {
                map.value.removeLayer(currentLocationGeometry.value)
            }
            currentLocationGeometry.value = L.geoJSON(currentLocation.value.geojson, {style: {fill: false}})
            currentLocationGeometry.value.addTo(map.value)
        }

        function drawCurrentLocationMarker() {
            if (Object.keys(currentLocationMarker.value).length !== 0) {
                map.value.removeLayer(currentLocationMarker.value)
            }
            currentLocationMarker.value = L.marker([Number(currentLocation.value.lat), Number(currentLocation.value.lon)])
            currentLocationMarker.value.addTo(map.value)
            currentLocationMarker.value.bindPopup(currentLocation.value.name).openPopup()
        }

        function fitCurrentLocationBounds() {
            let boundingbox = currentLocation.value.boundingbox.map(Number)
            // boundingbox[2] -= 0.400 // margin-left
            map.value.fitBounds([
                [boundingbox[0], boundingbox[2]],
                [boundingbox[1], boundingbox[3]]
            ])
            map.value.panBy([-80, 0])
        }

        function updateOffCanvasStatistics() {
            currentLocation.value.address.date = dateFilter.value
            fetch(apiURL + 'crimes/statistics', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(currentLocation.value.address)
            })
                .then(response => response.json())
                .then(data => {
                    statistics.value = data;
                })
                .catch(err => console.error(err))   
            offCanvasModal.value.show()
        }

        return { 
            query, 
            recommendations,
            barFocus,
            showLoading,
            showSearchBarLoading,
            heatmapGradientBar,
            currentLocation,
            statistics,
            dateFilter,
            selectSearchBarItem,
        }
    }
}).mount('#app')
