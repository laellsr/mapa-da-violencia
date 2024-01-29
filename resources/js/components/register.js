const debug = false;
const reg_form = document.getElementById('reg_form');
const regformData = new FormData(reg_form);

const retrieveJsonMap = (mapkey) => {
    return new Map(JSON.parse(localStorage.getItem(mapkey)));
}

const psJsonMap = (mapList, key, infoPer) => {
    // Add new msg to the map

        if( mapList.has(infoPer[2]) ){
            console.log("Já cadastrado");
        }
        else {
        mapList.set(infoPer[2], infoPer);
        console.log("SET");
        }

    // Saves map with JSON format in LocalStorage
    localStorage.setItem(key, JSON.stringify(Array.from(mapList.entries())));
}

reg_form.addEventListener("submit", (e) => {
    //Não permite o comportamento padrão do evendo submit
    e.preventDefault();
    const name = document.getElementById("nameForm").value;
    const birthday = document.getElementById("birthdayForm").value;
    const email = document.getElementById("emailForm").value;
    const pass = document.getElementById("passForm").value;
    const infoPer = [name, birthday, email, pass];
    console.log(infoPer);
    let key = "regForm";

    //Retrieves List of localStorage with id
    //let msgList = retrieveJsonList(key);
    //Add new email to the list
    //msgList.push(kvInput);
    //Saves List with JSON format in LocalStorage
    //saveJsonList(key, msgList);
    
    // Retrieves the map
    let mapList = retrieveJsonMap(key);
    // Push new msg and save the map as JSON in LocalStorage
    psJsonMap(mapList, key, infoPer);
    
    //Debug Print mapList
    if (debug) {
        console.log(mapList);
    }
    
    alert("Usuario cadastrado!\n");
    //reset forms
    reg_form.reset();
});