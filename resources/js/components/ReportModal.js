/* Helpers */
const apiURL =  window.location.protocol + "//" + window.location.host + '/api/';

/* Pega a lista de crimes no banco e retorna*/
async function fetchCrimes() {
    try {
        const response = await fetch(apiURL + 'crimes');
        const data = await response.json();
        return data;
    } catch (err) {
        console.log(err);
    }
}

/* Exibe os resultados do retorno da função como options no select crimeType do front */
fetchCrimes().then(data => {
    const crimeType = document.getElementById("crimeType");
    data.forEach(crime => {
        var option = document.createElement("option");
        option.value = crime.id;
        option.text = crime.name;
        crimeType.appendChild(option);
    });
}
).catch(err => {console.log(err);});


document.addEventListener('DOMContentLoaded', function() {
    var reportForm = document.getElementById('report_form');

    reportForm.addEventListener('submit', function(event) {
        //event.preventDefault();
        try {
            var currentLocationModal = JSON.parse(localStorage.getItem('currentLocationModal'));
            console.log(currentLocationModal.name);
            var formData = {
                //TEST
                crime_id: document.getElementById('crimeType').value,
                //END
                osm_type: currentLocationModal.osm_type[0].toUpperCase(),
                osm_id: currentLocationModal.osm_id,
                lat: currentLocationModal.lat,
                lon: currentLocationModal.lon,
                date: document.getElementById('date_ocorrencia').value,
                time: document.getElementById('time_ocorrencia').value,
            };
            console.log(formData);
            fetch(apiURL + 'reports/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                // Lidar com a resposta aqui
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        } catch (error) {
            console.error('Error:', error);
        }
    });
});