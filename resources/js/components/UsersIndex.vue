<template>
    <div class="users">
        <div class="loading" v-if="loading">Loading ...</div>
        <div class="error" v-if="error">{{ error }}</div>
        <div class="try-again"><button>Try again</button></div>
        <div class="pagination">
            <button :disabled="!prevPage" @click="goToPrev">Prev</button>
            {{ paginationCount }}
            <button :disabled="!nextPage" @click="goToNext">Next</button>
        </div>
        <ul v-if="users">
            <li v-for="{id, name, email} in users" :key="id">
                <p><strong>Name:</strong> {{ name }}</p>
                <p><strong>Email:</strong> {{ email }}</p>
                <router-link :to="{ name: 'users.edit', params: { id } }">edit</router-link>
            </li>
        </ul>
    </div>
</template>

<script>
const getUsers = (page, callback) => {
    const params = { page };

    axios
        .get("/api/users", { params })
        .then(response => {
            callback(null, response.data);
        })
        .catch(error => {
            callback(error, error.response.data);
        });
};

export default {
    data() {
        return {
            loading: false,
            error: false,
            users: null,
            links: {
                first: null,
                last: null,
                prev: null,
                next: null,
            },
            meta: null,
        };
    },
    computed: {
        nextPage() {
            if (! this.meta || this.meta.current_page === this.meta.last_page) {
                return
            }

            return this.meta.current_page + 1;
        },
        prevPage() {
            if (! this.meta || this.meta.current_page === this.meta.first_page) {
                return
            }

            return this.meta.current_page - 1
        },
        paginationCount() {
            if (!this.meta) {
                return
            }

            const {current_page, last_page} = this.meta;
            return ` ${current_page} of ${last_page} `;
        }
    },
    beforeRouteEnter (to, form, next) {
        const params = {page: to.query.page};

        getUsers(to.query.page, (err, data) => {
            next(vm => vm.setData(err, data));
        })

    },
    beforeRouteUpdate (to, from, next) {
        this.meta = this.links = this.users = null;
        getUsers(to.query.page, (err, data) => {
            this.setData(err, data)
            next();
        })
    },
    methods: {
        setData(err, {data: users, links, meta}) {
            if (err) {
                this.error = err.toString();
            } else {
                this.users = users;
                this.links = links;
                this.meta  = meta;
            }
        },
        goToPrev() {
            this.$router.push({
                query: {
                    page: this.prevPage
                }
            })
        },
        goToNext() {
            this.$router.push({
                query: {
                    page: this.nextPage
                }
            })
        }
    }
};
</script>

<style></style>
