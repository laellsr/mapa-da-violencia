import { createApp, ref, watch, onMounted } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.prod.js'

createApp({
    setup() {
        /* Search */
        const query = ref('')
        const recommendations = ref([])
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
            controller = new AbortController();
            signal = controller.signal;
            // Make a new request
            fetch('https://nominatim.openstreetmap.org/search.php?q=' + newVal + '&format=jsonv2&addressdetails=1', { signal })
                .then(response => response.json())
                .then(data => {
                    // recommendations.value = data;
                    let places = [];
                    data.forEach(element => {
                        let city = element.address.city ?? element.address.town ?? element.address.municipality
                        let item = {
                            display: `${element.name} - <span class="text-black-50">${city}, ${element.address.state}, ${element.address.country}</span>`,
                            coordinates: [element.lat, element.lon]
                        }
                        places.push(item);
                    });
                    recommendations.value = places;
                    console.log(data)
                })
                .catch(err => {
                    if (err.name !== 'AbortError') {
                        console.error('Another error: ', err)
                    }
                })
        })

        onMounted(() => {
            map.value = L.map('map').setView([-9.663136558749533, -35.71422457695007], zoomLevel.value);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map.value);
        })

        function flyTo(coordinates) {
            map.value.setView(coordinates, 16);
        }

        return { 
            query, 
            recommendations, 
            flyTo 
        }
    }
}).mount('#app')