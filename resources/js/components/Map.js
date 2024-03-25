// import { createApp, ref, watch, onMounted } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.prod.js'
import { createApp, ref, watch, onMounted, toRaw } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'
import { setMockeMarkers } from './Marker'
createApp({
    setup() {
        /* Helpers */
        const apiURL =  window.location.protocol + "//" + window.location.host + '/api/'
        
        /* Search */
        const query = ref('')
        const barFocus = ref(false)
        const recommendations = ref([])
        const recommendationsSourceData = ref([])
       
        /* OffCanvas */
        const offCanvasModal = ref({})
        const statistics = ref({})
        
        /* Map */
        const map = ref([])
        const zoomLevel = ref(11)
        const overlayLayers = ref([])
        const heatLayer = ref([])
        
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
            await fetch(apiURL + 'reports/crimes')
                .then(response => response.json())
                .then(data => {
                    // Create the layers
                    data.forEach(crime => {
                        // Add the markers
                        let markers = []
                        crime.reports.forEach(report => {
                            let marker = L.marker([Number(report.lat), Number(report.lon)])
                            // marker.bindPopup(report.description)
                            markers.push(marker)
                            // heatmap data
                            heatLayer.value.push([Number(report.lat), Number(report.lon), crime.heatmap_intensity])
                        })
                        // Add the layer group to the overlay layers
                        let layerGroup = L.layerGroup(markers)
                        overlayLayers.value[crime.name] = layerGroup
                        layersData.push(layerGroup)
                    })
                })
                .catch(err => console.error(err))
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
            // setMockeMarkers(map,L)
            // Add the layers control
            var baseMaps = {
                '<input type="date">': layerCustomDate,
                "em até 3 meses": layerGroupThreeMonths
            }
            L.control.layers(baseMaps, toRaw(overlayLayers.value), {
                position: 'topright',
                collapsed: false,
                sortLayers: true
            }).addTo(map.value)
            // Add the heatmap
            let heat = L.heatLayer(heatLayer.value, {
                radius: 15,
                blur: 15,
                maxZoom: 12,
                gradient: {0.4: 'blue', 0.6: 'cyan', 0.7: 'lime', 0.8: 'yellow', 1: 'red'}
            })
            heat.addTo(map.value)
            // Add a zoomend event listener to the map
            const markerDisplayZoomLevel = 13
            var high = false;
            map.value.on('zoomend', function() {
                let currentZoomLevel = map.value.getZoom()
                if (currentZoomLevel >= markerDisplayZoomLevel && !high) {
                    // If the zoom level is high enough, add the markers
                    for (let layerName in overlayLayers.value) {
                        overlayLayers.value[layerName].addTo(map.value)
                    }
                    heat.setLatLngs([])
                    high = true
                } else if (currentZoomLevel < markerDisplayZoomLevel && high) {
                    // If the zoom level is too low, remove the markers
                    for (let layerName in overlayLayers.value) {
                        overlayLayers.value[layerName].remove()
                    }
                    heat.setLatLngs(heatLayer.value)
                    high = false
                }
            })
        })

        watch(query, (newVal) => {
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
        })


        function setExternalSearch(url, signal) {
            var placeTitle
            fetch(apiURL + 'external', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
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
        }

        function fitCurrentLocationBounds() {
            let boundingbox = currentLocation.value.boundingbox.map(Number)
            // boundingbox[2] -= 0.400 // margin-left
            map.value.fitBounds([
                [boundingbox[0], boundingbox[2]],
                [boundingbox[1], boundingbox[3]]
            ])
        }

        function updateOffCanvasStatistics() {
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
            currentLocation,
            statistics,
            selectSearchBarItem,
        }
    }
}).mount('#app')
