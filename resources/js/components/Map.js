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
        
        /* Map */
        const map = ref([])
        const zoomLevel = ref(14)
        const overlayLayers = ref([])
        
        /* App Data */
        const currentLocation = ref({})
        const currentLocationGeometry = ref({})
        const currentLocationMarker = ref({})
        
        /* Abort Controller */
        let controller = new AbortController()
        let signal = controller.signal

        watch(query, (newVal) => {
            // Abort the previous request
            controller.abort()
            // Create a new AbortController
            controller = new AbortController()
            signal = controller.signal
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

        onMounted(async () => {
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
                layers: layersData,
                minZoom: 3,
                maxZoom: 19,
                maxBounds: L.latLngBounds([-90, -180], [90, 180]),
                wraparound: true
                // Do not show other worlds when dragging
            }).setView([-9.663136558749533, -35.71422457695007], zoomLevel.value)
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
            setMockeMarkers(map,L)
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
        })    

        function selectSearchBarItem(index) {
            barFocus.value = false
            query.value = ''
            currentLocation.value = recommendationsSourceData.value[index]
            drawCurrentLocationGeometry()
            drawCurrentLocationMarker()
            fitCurrentLocationBounds()
            new bootstrap.Offcanvas('#LocationInfo').show()
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
            boundingbox[2] -= 0.400 // margin-left
            map.value.fitBounds([
                [boundingbox[0], boundingbox[2]],
                [boundingbox[1], boundingbox[3]]
            ])
        }

        return { 
            query, 
            recommendations,
            barFocus,
            currentLocation,
            selectSearchBarItem
        }
    }
}).mount('#app')



/* Essa parte do código é para pegar o nome da cidade, vila, estado, etc. */

// let city = element.address.city ?? element.address.town ?? element.address.municipality
// let village = element.address.village ?? element.address.hamlet ?? element.address.suburb ?? element.address.neighbourhood ?? element.address.city_district
// let state = element.address.state ?? element.address.province ?? element.address.state_district ?? element.address.village
// let display_name = ''
// if (city !== undefined && city != element.name ) display_name += `${city}, `
// if (village !== undefined && village != element.name ) display_name += `${village}, `
// if (state !== undefined && state != element.name ) display_name += `${state}`
// if (display_name !== '') display_name += ', '
// let postcode = ''
// if (element.address.postcode !== undefined) postcode = ` - ${element.address.postcode}`
// let item = {
//     display: `${element.name} - <span class="text-black-50 fst-italic">${display_name}${element.address.country}${postcode}</span>`,
//     // coordinates: [element.lat, element.lon],
//     boundingbox: element.boundingbox
// }

/* Fim - Comentei pq pode deixar mais lento */