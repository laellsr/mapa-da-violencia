export async function createIcons(apiUrl){
    // var assetUrl=document.getElementById("assetUrl").value
    var Colorlist=['purple','black','blue','purple','darkred','darkgreen','pink','brown','orange','red','Crimson','navy','lightYellow','lemonChiffon','IndianRed','Crimson','FireBrick']
    var crimes= await fetch(apiUrl+'crimes').then(response=>response.json())
    var i=0
    var crimeColorsDict={};
    crimes.forEach(element => {
        crimeColorsDict[element.id]=Colorlist[i]
        i++;
    });
    i=0
    // console.log(crimeColorsDict)
    return crimeColorsDict;
    
    // var medium_risk = L.icon({
    //     iconUrl: new URL('../../img/medium_risk.png', import.meta.url).href,
    //     iconSize:     [40, 60], 
    //     shadowSize:   [50, 64], 
    //     iconAnchor:   [20, 60], 
    //     shadowAnchor: [4, 62],  
    //     popupAnchor:  [-3, -76] 
    // });

    // var high_danger = L.icon({
    //     iconUrl: new URL('../../img/high_danger.png', import.meta.url).href,
    //     iconSize:     [40, 60], 
    //     shadowSize:   [50, 64], 
    //     iconAnchor:   [20, 60], 
    //     shadowAnchor: [4, 62],  
    //     popupAnchor:  [-3, -76] 
    // });

    // var gun = L.icon({
    //     iconUrl: new URL('../../img/gun.png', import.meta.url).href,
    //     iconSize:     [40, 60], 
    //     shadowSize:   [50, 64], 
    //     iconAnchor:   [20, 60], 
    //     shadowAnchor: [4, 62],  
    //     popupAnchor:  [-3, -76] 
    // });

    // var murder = L.icon({
    //     iconUrl: new URL('../../img/murder.png', import.meta.url).href,
    //     iconSize:     [40, 60], 
    //     shadowSize:   [50, 64], 
    //     iconAnchor:   [20, 60], 
    //     shadowAnchor: [4, 62],  
    //     popupAnchor:  [-3, -76] 
    // });


    // L.marker([-9.659, -35.701],{icon:medium_risk}).addTo(map.value)
    // L.marker([-9.659, -35.702],{icon:high_danger}).addTo(map.value);
    // L.marker([-9.659, -35.703],{icon:gun}).addTo(map.value);
    // L.marker([-9.659, -35.704],{icon:medium_risk}).addTo(map.value);
    // L.marker([-9.659, -35.705],{icon:murder}).addTo(map.value);
    // ///////   
}