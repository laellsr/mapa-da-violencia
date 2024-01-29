<div id="SearchBar" class="mt-3 ms-3 ps-1 bg-white rounded shadow" @mousedown.stop>
    <div class="rounded pt-1 mb-2">
        <div class="d-flex justify-content-center align-items-center">
            <span class="ps-4 pe-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                    class="bi bi-search" viewBox="0 0 16 16">
                    <path
                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                </svg>
            </span>
            <input type="text" v-model="query" class="form-control border-0" placeholder="Digite um endereço" @focusin="barFocus=true">
        </div>
    </div>
    <ul class="list-group recommendations">
        <li v-show="barFocus" v-for="(item, index) in recommendations" class="list-group-item border-0 shadow" v-html="item.display" @click="selectSearchBarItem(index)"></li>
    </ul>
</div>