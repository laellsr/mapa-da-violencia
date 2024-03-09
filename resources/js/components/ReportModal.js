// import { createApp, ref, watch, onMounted } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.prod.js'
import { createApp, ref, watch, onMounted, toRaw } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'
import { setMockeMarkers } from './Marker'
createApp({
    setup() {
        /* Helpers */
        const apiURL =  window.location.protocol + "//" + window.location.host + '/api/'
        
        /* Search */
        const queryModal = ref('')
        const barFocusModal = ref(false)
        const recommendationsModal = ref([])
        const recommendationsSourceData = ref([])
        
        /* App Data */
        const currentLocation = ref({})
        
        /* Abort Controller */
        let controller = new AbortController()
        let signal = controller.signal

        watch(queryModal, (newVal) => {
            // Abort the previous request
            controller.abort()
            // Create a new AbortController
            controller = new AbortController()
            signal = controller.signal
            // Make a new request
            fetch('https://nominatim.openstreetmap.org/search.php?q=' + encodeURI(newVal) + '&format=jsonv2&addressdetails=1&polygon_geojson=1', { signal })
                .then(response => response.json())
                .then(data => {
                    recommendationsModal.value = []
                    recommendationsSourceData.value = data // Used to fit the map
                    data.forEach( element => {
                        let commaIndex = element.display_name.indexOf(',')
                        let info = element.display_name.substring(commaIndex + 1).trim()
                        let postcode = (element.address.postcode !== undefined) ? ` - ${element.address.postcode}` : ''
                        recommendationsModal.value.push({
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

        function selectSearchBarItemModal(index) {
            barFocusModal.value = false
            queryModal.value = ''
            currentLocation.value = recommendationsSourceData.value[index]
            fitCurrentLocationBounds()
            new bootstrap.Offcanvas('#LocationInfo').show()
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
            queryModal, 
            recommendationsModal,
            barFocusModal,
            currentLocation,
            selectSearchBarItemModal
        }
    }
}).mount('#app')