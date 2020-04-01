<template>
    <div class="curd">
        <el-row>
            <el-col :span="3">
                <div class="grid-content"><img :src="image"/></div>
            </el-col>
            <el-col :span="6">
                <h3>Name: {{ name | properCase }}</h3>
            </el-col>
        </el-row>
        <el-row>
            <el-col :span="12">
                <select @change="update">
                    <option v-for="col in ['red', 'green']" :value="col" :key="col" :selected="col == color ? 'selected' : ''">{{ col | properCase }}</option>
                </select>
                <button @click="del">Delete</button>
            </el-col>
        </el-row>
    </div>
</template>

<script>
export default {
    computed: {
        image() {
            return `images/${this.color}.png`
        }
    },
    methods: {
        update(val) {
            this.$emit('update', this.id, val.target.selectedOptions[0].value)
        },
        del() {
            this.$emit('del', this.id)
        }
    },
    props: ['id', 'color', 'name'],
    filters: {
        properCase(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    }
}
</script>

<style>
    .grid-content img {
        max-width: 100%;
        height: auto;
    }
</style>
