<template>
    <div>
        <form>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input
                            type="text"
                            class="form-control border-0"
                            placeholder="Name"
                            v-model="form.name"
                            required
                        >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input
                            type="email"
                            class="form-control border-0"
                            placeholder="Email Address"
                            v-model="form.email"
                            required
                        >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input
                            type="email"
                            class="form-control border-0"
                            placeholder="Phone Number"
                            v-model="form.phone"
                            required
                        >
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <textarea
                            class="form-control border-0"
                            placeholder="Message"
                            v-model="form.comments"
                        >
                        </textarea>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" @click.prevent="formSubmitted">Send Message &nbsp; <i class="fa fa-angle-right" aria-hidden="true"></i></button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
import ContactForm from '../models/contact-form';
    export default {
        data () {
            return {
                form: new ContactForm({
                    name: '',
                    email: '',
                    phone: '',
                    comments: '',
                    url: '/wp-json/kerigansolutions/v1/submit-contact-form'
                })
            }
        },
        computed: {
            hasError: function() {
                return this.form.hasError;
            },
            errorCode: function () {
                return this.form.errorCode;
            },
            success: function () {
                return this.form.success;
            }
        },
        methods: {
            formSubmitted () {
                this.form.submit();
            }
        }
    }
</script>
