<template>
    <div>
        <div v-for="signature in signatures">
            {{ signature.id }} {{ signature.name }}<br>
            {{ signature.content }}<br>
        </div>
        <paginate
            :page-count="pageCount"
            :click-handler="fetch"
            :prev-text="'Prev'"
            :next-text="'Next'"
            :container-class="'pagination'">
        </paginate>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                signatures: [],
                pageCount: 1,
                endpoint: '/api/signatures?page='
            };
        },
        created() {
            this.fetch();
        },
        methods: {
            fetch(page = 1) {
                axios.get(this.endpoint + page)
                    .then(({data}) => {
                        this.signatures = data.data;
                        this.pageCount = data.meta.last_page;
                    });
            }
        }
    }
</script>
