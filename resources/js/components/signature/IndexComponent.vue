<template>
    <div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>編號</th>
                    <th>名字</th>
                    <th>內容</th>
                    <th>訊息</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="signature in data" :key="signature.index">
                    <td>{{ signature.id }}</td>
                    <td>{{ signature.name }}</td>
                    <td>{{ signature.content }}</td>
                    <td><a href="" @click.prevent="destroy(signature.id)">刪除</a></td>
                </tr>
            </tbody>
        </table>

        <div class="d-flex justify-content-end">
            顯示筆數：
            <select v-model="per_page">
                <option>5</option>
                <option>10</option>
                <option>15</option>
            </select>
        </div>

        <div class="d-flex justify-content-center">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item" :class="[meta.current_page == 1 ? 'disabled' : '']">
                        <a class="page-link" href="" @click.prevent="fetch(links.first)">第一頁</a>
                        </li>
                    <li class="page-item" :class="[meta.current_page == 1 ? 'disabled' : '']">
                        <a class="page-link" href="" @click.prevent="fetch(links.prev)">上一頁</a>
                    </li>
                    <li class="page-item" v-for="page in pages" :key="page.index" :class="[page == meta.current_page ? 'active' : '']">
                        <a class="page-link" href="" @click.prevent="fetch(url + '?page=' + page)">{{ page }}</a>
                    </li>
                    <li class="page-item" :class="[meta.current_page == meta.last_page ? 'disabled' : '']">
                        <a class="page-link" href="" @click.prevent="fetch(links.next)">下一頁</a>
                    </li>
                    <li class="page-item" :class="[meta.current_page == meta.last_page ? 'disabled' : '']">
                        <a class="page-link" href="" @click.prevent="fetch(links.last)">最後頁</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<style>
    .page-link:active {
        z-index: 1;
        color: #fff;
        background-color: #3490dc;
        border-color: #3490dc;
    }
    .page-link:focus {
        -webkit-box-shadow: 0 0 0 0rem;
                box-shadow: 0 0 0 0rem;
    }
</style>

<script>
    export default {
        data() {
            return {
                url: '/api/signatures',
                per_page: 5,
                pagination_size: 5,
                data: [],
                links: [],
                meta: [],
                pages: []
            };
        },
        created() {
            this.fetch();
        },
        watch: {
            per_page() {
                this.fetch();
            }
        },
        methods: {
            fetch(url = this.url + '?page=') {
                axios.get(url + '&per_page=' + this.per_page)
                    .then(({data}) => {
                        this.data = data.data;
                        this.links = data.links;
                        this.meta = data.meta;
                        this.paginate();
                    });
            },
            paginate(meta = this.meta) {
                let arr = [];
                let begin;
                let end;

                switch (true) {
                    case (meta.current_page <= (this.pagination_size - 1) / 2):
                        begin = 1;
                        end = this.pagination_size;
                    break;

                    case (meta.current_page >= meta.last_page - (this.pagination_size - 1) / 2):
                        begin = meta.last_page - (this.pagination_size - 1);
                        end = meta.last_page;
                    break;

                    default:
                        begin = meta.current_page - (this.pagination_size - 1) / 2;
                        end = meta.current_page + (this.pagination_size - 1) / 2;
                }

                for (let i = begin; i <= end; i++) {
                    arr.push(i);
                }

                this.pages = arr;
            },
            destroy(id) {
                if (confirm('確定刪除？')) {
                    axios.delete(this.url + '/' + id)
                        .then(response => {
                            this.data = _.remove(this.data, function (data) {
                                return data.id !== id;
                            });
                            this.fetch(this.url + '?page=' + this.meta.current_page);
                        });
                }
            }
        }
    }
</script>
