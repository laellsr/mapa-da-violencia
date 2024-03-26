
<div id="modalApp">
    <div id="reportModal" class="modal fade" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <div class="modal-header border-bottom-0">
                    <label class="modal-title fs-4">Denuncie um crime!</label>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white;"></button>
                </div>
                <form @submit.prevent="submitReportForm" class="modal-body">
                    <div v-if="crimeList.length" class="form-floating mb-4">
                        <select v-model="reportCrime" id="reportCrime" class="form-select" required>
                            <option value="Selecione o tipo de ocorrência" selected disabled></option>
                            <option v-for="crime in crimeList" :value="crime.id" v-html="crime.name"></option>
                        </select>
                        <label for="reportCrime">Tipo de ocorrência</label>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-4">
                                <input v-model="reportDate" type="date" class="form-control" id="reportDate" required>
                                <label for="reportDate">Data da ocorrência</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-4">
                                <input v-model="reportTime" type="time" class="form-control" id="reportTime" required>
                                <label for="reportTime">Hora da ocorrência</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-4">
                        <input v-model="query" type="text" class="form-control" placeholder="Pesquise um endereço" id="reportSearchBar" required>
                        <label for="reportSearchBar">Pesquisa de endereço</label>
                    </div>
                    <div v-if="recommendations.length" v-for="(recommendation, index) in recommendations" class="form-check">
                        <input v-model="reportPlace" class="form-check-input mb-2" type="radio" :value="recommendation.element" :id="recommendation.id" :checked="(index==0) ?? 'checked'">
                        <label class="form-check-label" :for="recommendation.id" v-html="recommendation.display">
                        </label>
                    </div>
                    <div class="d-grid mt-4">
                        <button id="btnReportSubmit" type="submit" class="btn btn-lg btn-dark">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ Vite::asset('resources/js/components/ReportModal.js') }}" type="module"></script>
@endpush
@push('styles')
<style>
    /* #reportModal input:focus + label {
    color: orange;
    } */
</style>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/reportModal.css') }}">
@endpush