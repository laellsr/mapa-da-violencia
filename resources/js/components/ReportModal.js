// import { createApp, ref, watch, onMounted } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.prod.js'
import { createApp, ref, watch, onMounted, toRaw } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'

createApp({
    setup() {
        /* Helpers */
        const apiURL =  window.location.protocol + "//" + window.location.host + '/api/'
        
        /* Form */
        const crimeList = ref([])
        const reportCrime = ref('')
        const reportDate = ref('')
        const reportTime = ref('')
        const reportPlace = ref({})


        /* Search */
        const query = ref('')
        const recommendations = ref([])
        const recommendationsSourceData = ref([])
        
        /* Abort Controller */
        let controller = new AbortController()
        let signal = controller.signal

        onMounted(async () => {
            fetch(apiURL + 'crimes')
                .then(response => response.json())
                .then(data => {
                    crimeList.value = data
                })
                .catch(err => console.log(err))
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
                            display: `${query.value} <span class="text-secondary fst-italic">- ${info}${postcode}</span>`,
                            element: element
                        })
                    })
                    reportPlace.value = data[0]
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
                    recommendations.value = []
                    recommendations.value.push({
                        display: `${placeTitle} <span class="text-dark-50 fst-italic">- ${data.display_name}</span>`,
                        element: data
                    })
                    reportPlace.value = data
                })
                .catch(err => console.error(err))
        }

        function submitReportForm() {
            document.getElementById('btnReportSubmit').setAttribute('disabled', 'disabled')
            let apiData = toRaw(reportPlace.value)
            const formData = {
                crime_id: reportCrime.value,
                date: reportDate.value,
                time: reportTime.value,
                osm_type: apiData.osm_type,
                osm_id: apiData.osm_id,
                lat: apiData.lat,
                lon: apiData.lon,
                suburb: apiData.address.suburb,
                city: apiData.address.city,
                state: apiData.address.state,
                region: apiData.address.region,
                country: apiData.address.country
            }
            console.log(formData);
            fetch(apiURL + 'reports/store', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(formData)
            })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        icon: "success",
                        title: "Feito!",
                        text: "Sua denúncia foi registrada e a aplicação será recarregada em instantes.",
                        showConfirmButton: false
                    })
                    setTimeout(function() {
                        location.reload();
                    }, 5000);
                })
                .catch((error) => {
                    Swal.fire({
                        icon: "error",
                        title: "Erro!",
                        text: JSON.stringify(error.errors) ?? "O servidor não conseguiu processar a sua requisição. Tente novamente mais tarde.",
                    });
                    document.getElementById('btnReportSubmit').removeAttribute('disabled')
                })
                
        }

        return { 
            query, 
            recommendations,

            crimeList,
            reportCrime,
            reportDate,
            reportTime,
            reportPlace,

            submitReportForm
        }
    }
}).mount('#modalApp')
