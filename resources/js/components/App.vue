<template>
    <div id="app">
        <div class="heading">
            <h1>Curds</h1>
        </div>
        <curd-component
            v-for="curd in curds"
            v-bind="curd"
            :key="curd.id"
            @update="update"
            @del="del"
        ></curd-component>
        <div>
            <button @click="create">Add</button>
        </div>
    </div>
</template>

<script>
import CurdComponent from "./CurdComponent.vue";
export default {
    data() {
        return {
            curds: []
        };
    },
    methods: {
        async create() {
            const { data } = await axios.get('/api/curds/create');
            this.curds.push(data)
        },
        async read() {
            const { data } = await axios.get("/api/curds");
            this.curds = data;
        },
        async update(id, color) {
            await axios.put(`/api/curds/${id}`, { color });
            this.curds.find(curd => curd.id === id).color = color;
        },
        async del(id) {
            await axios.delete(`/api/curds/${id}`);
            let index = this.curds.findIndex(curd => curd.id === id);
            this.curds.splice(index, 1);
        }
    },
    created() {
        this.read();
    },
    components: {
        CurdComponent
    }
};
</script>

<style></style>
