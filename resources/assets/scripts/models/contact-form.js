import axios from 'axios';
import alertify from 'alertifyjs';

export default class ContactForm {

    constructor (data) {
        for (let field in data) {
            this[field]       = data[field];
            this.hasError     = false;
            this.errorMessage = "";
            this.errorCode    = "";
            this.success      = false;
        }
    }
    submit () {
        axios.post(this.url, {
            name:      this.name,
            email:     this.email,
            phone:     this.phone,
            comments:  this.comments,
            listing:   this.listing,
            price:     this.price,
            address:   this.address,
            image:     this.image
        }).then(() => {
            this.success = true;
            this.clearForm();
            alertify.success('Thanks! We\'ll get back with you as soon as possible!');

        }).catch(err => {
            this.hasError     = true;
            this.errorMessage = err.response.data.message;
            this.errorCode    = err.response.data.code;
            alertify.error(this.errorMessage);
        });
    }
    clearForm() {
        this.name      = "";
        this.email     = "";
        this.phone     = "";
        this.comments  = "";
    }
}