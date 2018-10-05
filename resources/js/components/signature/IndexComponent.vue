<template>
    <div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Content</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="signature in data" :key="signature.index">
                    <td>{{ signature.id }}</td>
                    <td>{{ signature.name }}</td>
                    <td>{{ signature.content }}</td>
                </tr>
            </tbody>
        </table>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item" :class="[meta.current_page == 1 ? 'disabled' : '']">
                    <a class="page-link" href="" @click.prevent="fetch(links.first)">第一頁</a>
                    </li>
                <li class="page-item" :class="[meta.current_page == 1 ? 'disabled' : '']">
                    <a class="page-link" href="" @click.prevent="fetch(links.prev)">上一頁</a>
                </li>
                <li class="page-item" v-for="page in pages" :key="page.index" :class="[page == meta.current_page ? 'active' : '']">
                    <a class="page-link" href="" @click.prevent="fetch(url + page)">{{ page }}</a>
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
                url: '/api/signatures?page=',
                each_side: 3,
                data: [],
                links: [],
                meta: [],
                pages: []
            };
        },
        created() {
            this.fetch(this.url);
        },
        methods: {
            fetch: function (url) {
                axios.get(url)
                    .then(({data}) => {
                        this.data = data.data;
                        this.links = data.links;
                        this.meta = data.meta;
                        setTimeout(this.paginate(this.meta, this.each_side), 3000);
                        // this.paginate(this.meta, this.each_side);
                    });
            },
            paginate: function (meta, each_side) {
                let arr = [];
                let start;
                let end;

                switch (true) {
                    case (meta.current_page <= each_side):
                        start = 1;
                        end = each_side * 2 + 1;
                    break;
                    case (meta.current_page >=  meta.last_page - each_side):
                        start = meta.last_page - (each_side * 2);
                        end = meta.last_page;
                    break;
                    default:
                        start = meta.current_page - each_side;
                        end = meta.current_page + each_side;
                }

                for (let i = start; i <= end; i++) {
                    arr.push(i);
                }

                this.pages = arr;
            }
        }
    }
</script>
