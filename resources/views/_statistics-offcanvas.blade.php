<div v-show="Object.keys(currentLocation).length !== 0">
    <button id="LocationBtn" class="btn btn-dark ms-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#LocationInfo" aria-controls="LocationInfo">Mostrar informações</button>
    <div class="offcanvas offcanvas-start h-75 ms-3 shadow rounded" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="LocationInfo" aria-labelledby="LocationInfoLabel">
        <div class="offcanvas-header">
            <h4 class="offcanvas-title" id="LocationInfoLabel" v-html="currentLocation.name"></h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div v-show="Object.keys(statistics).length !== 0" class="offcanvas-body pt-0">
            <small class="text-black-50 mb-3" v-html="currentLocation.display_name"></small>
            <p class="mt-3" v-html="statistics.comparison"></p>
            <p class="mb-3">@{{ 'Ao todo, pela manhã foram registrada(s) ' + statistics.morningReports + ' ocorrências, à tarde ' + statistics.afternoonReports + ', à noite ' + statistics.nightReports + ' e na madrugada ' + statistics.dawnReports + '.' }}</p>
            <p class="mb-4">@{{ ' A tabela abaixo detalha quais foram as ocorrência(s) para ' + statistics.placeReport + '.' }}</p>
            <table v-if="statistics.crimes" class="table table-sm align-middle text-center" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th>Crime/Total</th>
                        <th>Manhã</th>
                        <th>Tarde</th>
                        <th>Noite</th>
                        <th>Madrugada</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="crime in statistics.crimes">
                        <td>@{{ crime.name + ' (' + crime.reports_count + ')' }}</td>
                        <td>@{{ crime.morning_reports_count }}</td>
                        <td>@{{ crime.afternoon_reports_count }}</td>
                        <td>@{{ crime.night_reports_count }}</td>
                        <td>@{{ crime.dawn_reports_count }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>