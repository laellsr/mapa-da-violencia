<div v-show="Object.keys(currentLocation).length !== 0">
    <button id="LocationBtn" class="btn btn-dark ms-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#LocationInfo" aria-controls="LocationInfo">Mostrar informações</button>
    <div class="offcanvas offcanvas-start h-75 ms-3 shadow rounded" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="LocationInfo" aria-labelledby="LocationInfoLabel">
        <div v-if="currentLocation.name" class="offcanvas-header">
            <h5 class="offcanvas-title" id="LocationInfoLabel" v-html="currentLocation.name"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div v-if="currentLocation.name" class="offcanvas-body">
            <p class="mb-3" v-html="currentLocation.display_name"></p>
            {{-- <div v-if="Object.keys(maceioCrimesLabelData).length !== 0">
                <h6>Relatados nos últimos 3 meses</h6>
                <ul>
                    <p v-html="'Total de crimes: ' + maceioCrimesTotalData"></p>
                    <li v-for="(label, index) in maceioCrimesLabelData" v-html="'<b>'+((maceioCrimesData[index]*100)/maceioCrimesTotalData).toFixed(2) + '%</b> - ' + label"></li>
                </ul>
            </div> --}}
        </div>
    </div>
</div>