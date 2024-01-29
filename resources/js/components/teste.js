export function setMockeMarkers(map,L){
    var assetUrl=document.getElementById("assetUrl").value
    
    var medium_risk = L.icon({
        iconUrl: assetUrl+"medium_risk.png",
        iconSize:     [40, 60], 
        shadowSize:   [50, 64], 
        iconAnchor:   [20, 60], 
        shadowAnchor: [4, 62],  
        popupAnchor:  [-3, -76] 
    });

    var high_danger = L.icon({
        iconUrl: assetUrl+"high_danger.png",
        iconSize:     [40, 60], 
        shadowSize:   [50, 64], 
        iconAnchor:   [20, 60], 
        shadowAnchor: [4, 62],  
        popupAnchor:  [-3, -76] 
    });

    var gun = L.icon({
        iconUrl: assetUrl+"gun.png",
        iconSize:     [40, 60], 
        shadowSize:   [50, 64], 
        iconAnchor:   [20, 60], 
        shadowAnchor: [4, 62],  
        popupAnchor:  [-3, -76] 
    });

    var murder = L.icon({
        iconUrl: assetUrl+"murder.png",
        iconSize:     [40, 60], 
        shadowSize:   [50, 64], 
        iconAnchor:   [20, 60], 
        shadowAnchor: [4, 62],  
        popupAnchor:  [-3, -76] 
    });


    L.marker([-9.659, -35.701],{icon:medium_risk}).addTo(map.value)
    L.marker([-9.659, -35.702],{icon:high_danger}).addTo(map.value);
    L.marker([-9.659, -35.703],{icon:gun}).addTo(map.value);
    L.marker([-9.659, -35.704],{icon:medium_risk}).addTo(map.value);
    L.marker([-9.659, -35.705],{icon:murder}).addTo(map.value);
    ///////

    var heat = L.heatLayer([
        [-9.659, -35.701,1], // lat, lng, intensity
        [-9.659, -35.702,2],
        [-9.659, -35.703,3],
        [-9.659, -35.704,4],
        [-9.659, -35.705,5],
    ], {radius: 20}).addTo(map.value);
   
}