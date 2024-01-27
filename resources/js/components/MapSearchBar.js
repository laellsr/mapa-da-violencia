// import { createApp, ref, watch, onMounted } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.prod.js'
import { createApp, ref, watch, onMounted } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'

createApp({
    setup() {
        /* Search */
        const query = ref('')
        const barFocus = ref(false)
        const recommendations = ref([])
        const recommendationsSourceData = ref([])
        const currentLocation = ref({})
        const currentLocationGeometry = ref({})
        const currentLocationMarker = ref({})
        /* Map */
        const map = ref([])
        const zoomLevel = ref(14)
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

        onMounted(() => {
            map.value = L.map('map', {zoomControl: false, attributionControl: false}).setView([-9.663136558749533, -35.71422457695007], zoomLevel.value)
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 19}).addTo(map.value)
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
                }
            }).addTo(map.value)
        })

        function selectSearchBarItem(index) {
            barFocus.value = false
            query.value = ''
            currentLocation.value = recommendationsSourceData.value[index]
            drawCurrentLocationGeometry()
            drawCurrentLocationMarker()
            fitCurrentLocationBounds()
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