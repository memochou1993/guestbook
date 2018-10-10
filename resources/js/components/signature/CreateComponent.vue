<template>
    <div>
        <form @submit.prevent="onSubmit">
            <fieldset>
                <legend class="text-center">GuestBook</legend>

                <div class="form-group">
                    <label for="name">名字</label>
                    <div>
                        <input type="text"
                            minlength="3"
                            maxlength="30"
                            id="name"
                            :class="[
                                'form-control', {
                                    'is-valid': nameIsValid,
                                    'is-invalid': nameIsInvalid
                                }
                            ]"
                            v-model="signature.name"
                            required>
                        <span class="invalid-feedback" v-if="nameIsInvalid">{{ errors.name[0] }}</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">信箱</label>
                    <div>
                        <input type="email"
                            minlength="3"
                            maxlength="30"
                            id="email"
                            :class="[
                                'form-control', {
                                    'is-valid': emailIsValid,
                                    'is-invalid': emailIsInvalid
                                }
                            ]"
                            v-model="signature.email"
                            required>
                        <span class="invalid-feedback" v-if="emailIsInvalid">{{ errors.email[0] }}</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="content">訊息</label>
                    <div>
                        <textarea id="content"
                            :class="[
                                'form-control', {
                                    'is-valid': contentIsValid,
                                    'is-invalid': contentIsInvalid
                                }
                            ]"
                            v-model="signature.content"
                            required></textarea>
                        <span class="invalid-feedback" v-if="contentIsInvalid">{{ errors.content[0] }}</span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </fieldset>
        </form>

        <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="saved">
            <strong>成功！表單已送出！</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                url: '/api/signatures',
                signature: {
                    name: '',
                    email: '',
                    content: ''
                },
                validation: {
                    name: /^[a-zA-Z0-9\u4e00-\u9fa5]{3,30}$/,
                    email: /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+\.[a-zA-Z0-9_-]+$/,
                    content: /^.{3,30}$/
                },
                saved: false,
                errors: []
            };
        },
        computed: {
            nameIsValid: function() {
                return this.validation.name.test(this.signature.name.trim());
            },
            nameIsInvalid: function() {
                return (!this.validation.name.test(this.signature.name.trim()) && this.errors.name);
            },
            emailIsValid: function() {
                return this.validation.email.test(this.signature.email.trim());
            },
            emailIsInvalid: function() {
                return (!this.validation.email.test(this.signature.email.trim()) && this.errors.email);
            },
            contentIsValid: function() {
                return this.validation.content.test(this.signature.content.trim());
            },
            contentIsInvalid: function() {
                return (!this.validation.content.test(this.signature.content.trim()) && this.errors.content);
            }
        },
        methods: {
            onSubmit() {
                this.saved = false;
                axios.post(this.url, this.signature)
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
                    name: '',
                    email: '',
                    content: ''
                };
            }
        }
    }
</script>
