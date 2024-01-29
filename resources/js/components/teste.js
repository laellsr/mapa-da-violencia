export function setMockeMarkers(map,L){
    var assetUrl=document.getElementById("assetUrl").value
    
    var greenIcon = L.icon({
        iconUrl: assetUrl+"medium_risk.png",
        iconSize:     [40, 40], 
        shadowSize:   [50, 64], 
        iconAnchor:   [20, 40], 
        shadowAnchor: [4, 62],  
        popupAnchor:  [-3, -76] 
    });




    L.marker([-9.659, -35.701],{icon:greenIcon}).addTo(map.value);
    L.marker([-9.659, -35.702],).addTo(map.value);
    L.marker([-9.659, -35.703],).addTo(map.value);
    L.marker([-9.659, -35.704],).addTo(map.value);
    L.marker([-9.659, -35.705],).addTo(map.value);
    
   
}