import{createApp as _,ref as a,onMounted as w,watch as A,toRaw as T}from"https://unpkg.com/vue@3/dist/vue.esm-browser.js";_({setup(){const c=window.location.protocol+"//"+window.location.host+"/api/",p=a([]),h=a(""),f=a(""),b=a(""),s=a({}),d=a(""),n=a([]),v=a([]);let i=new AbortController,u=i.signal;w(async()=>{fetch(c+"crimes").then(e=>e.json()).then(e=>{p.value=e}).catch(e=>console.log(e))});let m=null;A(d,e=>{if(i.abort(),i=new AbortController,u=i.signal,e.includes("booking.com")){S(e,u);return}m&&clearTimeout(m),m=setTimeout(()=>{fetch("https://nominatim.openstreetmap.org/search.php?q="+encodeURI(e)+"&format=jsonv2&addressdetails=1&polygon_geojson=1",{signal:u}).then(o=>o.json()).then(o=>{n.value=[],v.value=o,o.forEach(t=>{let r=t.display_name.indexOf(","),y=t.display_name.substring(r+1).trim(),l=t.address.postcode!==void 0?` - ${t.address.postcode}`:"";n.value.push({display:`${d.value} <span class="text-secondary fst-italic">- ${y}${l}</span>`,element:t})}),s.value=o[0]}).catch(o=>{o.name!=="AbortError"&&console.error("Another error: ",o)})},1e3)});function S(e,o){var t;fetch(c+"external",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({url:e})}).then(r=>r.text()).then(r=>{let l=new DOMParser().parseFromString(r,"text/html");t=l.querySelector("#hp_hotel_name > div > h2").innerText;let g=l.querySelector("#hotel_address").getAttribute("data-atlas-latlng").split(",");return fetch("https://nominatim.openstreetmap.org/reverse?lat="+g[0]+"&lon="+g[1]+"&format=jsonv2",{signal:o})}).then(r=>r.json()).then(r=>{n.value=[],n.value.push({display:`${t} <span class="text-dark-50 fst-italic">- ${r.display_name}</span>`,element:r}),s.value=r}).catch(r=>console.error(r))}function x(){document.getElementById("btnReportSubmit").setAttribute("disabled","disabled");let e=T(s.value);const o={crime_id:h.value,date:f.value,time:b.value,osm_type:e.osm_type,osm_id:e.osm_id,lat:e.lat,lon:e.lon,suburb:e.address.suburb,city:e.address.city,state:e.address.state,region:e.address.region,country:e.address.country};console.log(o),fetch(c+"reports/store",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify(o)}).then(t=>t.json()).then(t=>{if(t.errors){Swal.fire({icon:"error",title:"Falta algo!",text:"Lembre-se de colocar o endereço a partir da rua. Ex.: Rua Azuzinha, 12, <bairro>..."}),document.getElementById("btnReportSubmit").removeAttribute("disabled");return}Swal.fire({icon:"success",title:"Feito!",text:"Sua denúncia foi registrada e a aplicação será recarregada em instantes.",showConfirmButton:!1}),setTimeout(function(){location.reload()},5e3)}).catch(t=>{Swal.fire({icon:"error",title:"Erro!",text:JSON.stringify(t.errors)??"O servidor não conseguiu processar a sua requisição. Tente novamente mais tarde."}),document.getElementById("btnReportSubmit").removeAttribute("disabled")})}return{query:d,recommendations:n,crimeList:p,reportCrime:h,reportDate:f,reportTime:b,reportPlace:s,submitReportForm:x}}}).mount("#modalApp");
