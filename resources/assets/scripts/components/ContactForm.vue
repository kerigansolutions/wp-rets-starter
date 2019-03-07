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
                    <invisible-recaptcha sitekey="6LeMNZYUAAAAAJpD5qeCaFsW0TLP-Cy3HsO-B2we" :callback="formSubmitted"
                        class="btn btn-primary" type="submit" id="contact-form-submit-button" >
                        Send Message &nbsp; <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </invisible-recaptcha>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
import InvisibleRecaptcha from 'vue-invisible-recaptcha';
import ContactForm from '../models/contact-form';
    export default {
        components: {
            'invisible-recaptcha': InvisibleRecaptcha
        },
        props: ['listing'],
        data () {
            return {
                form: new ContactForm({
                    name: '',
                    email: '',
                    phone: '',
                    comments: '',
                    url: '/wp-json/kerigansolutions/v1/submit-contact-form',
                    listing: '',
                    image: '',
                    address: '',
                    price: ''
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
        mounted () {
            if(this.listing != ''){
                this.form.listing = this.listing.mls_account;
                this.form.image   = this.listing.media_objects.data[0].url;
                this.form.address = this.listing.full_address;
                this.form.price   = this.listing.price;
            }
        },
        methods: {
            formSubmitted () {
                this.form.submit();
            }
        }
    }
</script>
