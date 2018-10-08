<template>
    <div>
        <div>
            <form method="post" @submit.prevent="onSubmit">
                <fieldset>
                    <legend class="text-center">GuestBook</legend>

                    <div class="form-group">
                        <label for="name">名字</label>
                        <div>
                            <input type="text"
                                   class="form-control"
                                   minlength="3"
                                   maxlength="30"
                                   :class="{'is-invalid': errors.name}"
                                   id="name"
                                   v-model="signature.name"
                                   required>
                            <span class="invalid-feedback" v-if="errors.name">{{ errors.name[0] }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">信箱</label>
                        <div>
                            <input type="email"
                                   class="form-control"
                                   minlength="3"
                                   maxlength="30"
                                   :class="{'is-invalid': errors.email}"
                                   id="email"
                                   v-model="signature.email"
                                   required>
                            <span class="invalid-feedback" v-if="errors.email">{{ errors.email[0] }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content">訊息</label>
                        <div>
                            <textarea class="form-control"
                                      :class="{'is-invalid': errors.content}"
                                      id="content"
                                      v-model="signature.content"
                                      rows="5"
                                      required></textarea>
                            <span class="invalid-feedback" v-if="errors.content">{{ errors.content[0] }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </fieldset>
            </form>

            <div class="alert alert-success" v-if="saved">
                <strong>成功！</strong>表單已送出！
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                signature: {
                    name: null,
                    email: null,
                    content: null
                },
                saved: false,
                errors: []
            };
        },
        methods: {
            onSubmit() {
                this.saved = false;
                axios.post('/api/signatures', this.signature, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                    .then(({data}) => {
                        this.success()
                    })
                    .catch(({response}) => {
                        this.error(response.data)
                    });
            },
            success() {
                this.saved = true;
                this.reset();
            },
            error(data) {
                this.errors = data;
            },
            reset() {
                this.errors = [];
                this.signature = {
                    name: null,
                    email: null,
                    content: null
                };
            }
        }
    }
</script>