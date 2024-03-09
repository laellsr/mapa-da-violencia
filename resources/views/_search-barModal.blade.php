<div id="SearchBarModal" class="bg-white rounded shadow" @mousedown.stop>
    <div class="rounded pt-1 mb-2">
        <div class="d-flex justify-content-center align-items-center">
            <input type="text" v-model="queryModal" class="form-control border-0 text-center" placeholder="Digite um endereço" @focusin="barFocusModal=true">
        </div>
    </div>
    <ul class="list-group recommendationsModal">
        <li v-show="barFocusModal" v-for="(item, index) in recommendationsModal" class="list-group-item border-0 shadow" v-html="item.display" @click="selectSearchBarItemModal(index)"></li>
    </ul>
</div>