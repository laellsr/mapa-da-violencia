const debug = false;
const report_form = document.getElementById('report_form');

const retrieveJsonMap = (mapkey) => {
    return new Map(JSON.parse(localStorage.getItem(mapkey)));
}

const psJsonMap = (mapList, key, typeForm, cepForm) => {
    // Add new msg to the map
    try {
        mapList.get(typeForm).push(cepForm);
        console.log("GET");
    } catch {
        mapList.set(typeForm, [cepForm]);
        console.log("SET");
    }

    // Saves map with JSON format in LocalStorage
    localStorage.setItem(key, JSON.stringify(Array.from(mapList.entries())));
}

report_form.addEventListener("submit", (e) => {
    //Não permite o comportamento padrão do evendo submit
    e.preventDefault();
    let typeForm = document.getElementById("reportType").value;
    let cepForm = document.getElementById('cepForm').value;
    let key = "reportForm"

    //Retrieves List of localStorage with id
    //let msgList = retrieveJsonList(key);
    //Add new email to the list
    //msgList.push(kvInput);
    //Saves List with JSON format in LocalStorage
    //saveJsonList(key, msgList);
    
    // Retrieves the map
    let mapList = retrieveJsonMap(key);
    // Push new msg and save the map as JSON in LocalStorage
    psJsonMap(mapList, key, typeForm, cepForm);
    
    //Debug Print mapList
    if (debug) {
        console.log(mapList);
    }
    
    alert("Denuncia enviada!\n");
    //reset forms
    report_form.reset();
});