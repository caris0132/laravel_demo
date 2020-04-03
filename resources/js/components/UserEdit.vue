<template>
    <div>
        <div v-if="message" class="alert">{{ message }}</div>
        <div class="loading" v-if="!loaded">loading ...</div>
        <form class="form" @submit.prevent="onSubmit($event)" v-else>
            <div class="form-group">
                <label for="user_name">Name</label>
                <input
                    id="user_name"
                    v-model="user.name"
                    class="form-control"
                />
            </div>
            <div class="form-group">
                <label for="user_email">Email</label>
                <input
                    id="user_email"
                    v-model="user.email"
                    class="form-control"
                />
            </div>
            <div class="form-group">
                <button class="btn btn-success" :disabled="saving">Update</button>
            </div>
        </form>
    </div>
</template>

<script>
import api from "../api/users";
export default {
    data() {
        return {
            loaded: false,
            saving: false,
            message: '',
            user: {
                id: 0,
                name: "",
                email: ""
            }
        };
    },
    methods: {
        onSubmit(event) {
            this.saving = true;
            const {id, ...data} = this.user;
            api.update(id, data)
                .then(response => {
                    this.message = "upadated";
                    setTimeout(() => {
                        this.message = null;
                    }, 2000);
                    this.user = response.data.data;
                })
                .catch(err => {
                    console.log(err);
                })
                .then(_ => {
                    this.saving = false;
                });
        }
    },
    created() {
        api.find(this.$route.params.id)
            .then(response => {
                this.loaded = true;
                this.user = response.data.data;
            })
            .catch(err => {});
    }
};
</script>

<style lang="scss" scoped>
$red: lighten(red, 30%);
$darkRed: darken($red, 50%);
.form-group label {
    display: block;
}
.alert {
    background: $red;
    color: $darkRed;
    padding: 1rem;
    margin-bottom: 1rem;
    width: 50%;
    border: 1px solid $darkRed;
    border-radius: 5px;
}
</style>
