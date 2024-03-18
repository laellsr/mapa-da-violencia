/* Helpers */
const apiURL =  window.location.protocol + "//" + window.location.host + '/api/';

/* Pega a lista de crimes no banco e retorna*/
async function fetchCrimes() {
    try {
        const response = await fetch(apiURL + 'crimes');
        const data = await response.json();
        return data;
    } catch (err) {
        alert(err);
    }
}

/* Exibe os resultados do retorno da função como options no select crimeType do front */
fetchCrimes().then(data => {
    const crimeType = document.getElementById("crimeType");
    data.forEach(crime => {
        var option = document.createElement("option");
        option.value = crime.name;
        option.text = crime.name;
        crimeType.appendChild(option);
    });
}
).catch(err => {console.log(err);});