/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.eventBus = new Vue()

import vuetify from './vuetify'
import router from './router'
import store from './vuex'

import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en'
import 'element-ui/lib/theme-chalk/index.css';

// import VueGoodTablePlugin from 'vue-good-table';

// import the styles
// import 'vue-good-table/dist/vue-good-table.css'

// Vue.use(VueGoodTablePlugin);

Vue.use(ElementUI, { locale });


// import Chartkick from 'vue-chartkick'
// import Chart from 'chart.js'
// Vue.use(Chartkick.use(Chart))

// import myExample from './components/ExampleComponent.vue'
// import myHeader from './components/include/Header'
// import myApp from './components/app.vue'
// import myHome from './components/register'
import mySupplier from './components/browse/supplier'
import myProfessional from './components/browse/professional'


// import myRegsupply from './components/register/supplier'

// import myCharts from './components/charts'


// import myAnimal from "./components/animals";
// import myPlantation from "./components/plantation";

// import myBrood from "./components/brood";

import moment from 'vue-moment'

import { mapState } from "vuex";

const app = new Vue({
    el: '#app',
    router,
    store,
    vuetify,
    components: {
        // myHeader, myHome,myApp,
        mySupplier,
        myProfessional
        // myCharts, myAnimal, myPlantation, myRegsupply, myBrood
    },

    data: {
        cart_count: 0,
        loading: true,
        snackbar: false,
        text: '',
        form: {
            weight: '',
            approximation: 'months',
            birthday: '',
        },

        options: [
            {
                lable: 'Charolais',
                value: '1',
            }, {
                lable: 'Merino',
                value: '2',
            }],
        order: null,
        register_form: {},
        edit_form: {},
        load_data: false,
        form_dialog: false,
        show_busket: false,
        userid: document.querySelector("meta[name='user-id']").getAttribute('content')
    },
    methods: {
        toggleActive(qty) {

            // alert('dwdwdddw');
            // this.activeKey = this.isActive(i) ? null : i;
            var payload = {
                model: 'addCart',
                data: this.form
            }

            if (this.cart_count < 1 && qty ==-1) {
                return
            }

            this.cart_count += qty
            this.text = 'Cart update'
            this.snackbar = true
            this.$store.dispatch('postItems', payload)
                .then(response => {
                    // this.cart_count += 1
                    // eventBus.$emit("broodEvent")
                });
        },
        checkout(data) {

            var payload = {
                model: '/order/' + data + '/product',
                data: this.form
                // data: this.form
            }
            this.$store.dispatch('postItems', payload)
                .then(response => {
                    this.text = 'Checkout complete'
                    this.snackbar = true
                    this.cart_count = 0
                    window.location.href = "/login";
                    // this.cart_count += 1
                    // eventBus.$emit("broodEvent")
                });
        },

        reduceCart() {
            if (this.cart_count > 0) {
                this.cart_count -= 1
            }
        },
        form_d() {
            // alert('test')
            this.form_dialog = true
        },
        addCart(id, qty) {

            // console.log(id, qty);
            // this.form_dialog = false

            // this.cart_count += 1
            // if (qty > this.cart_count) {
                this.cart_count += 1
            // } else {
            //     this.snackbar = true
            //     this.text = 'No more in stock'
            // }
        },

        get_items(model, update) {
            var payload = {
                model: model,
                data: this.form,
                update: update
            }
            console.log(payload);

            this.$store.dispatch('getItems', payload)
                .then(response => {
                    // eventBus.$emit("pushEvent", response)
                });
        },
        search_item(data) {
            console.log(data);
            var payload = {
                model: 'search_brood',
                update: 'updateBroodsList',
                search: data
            }
            console.log(payload);
            this.options = [
                {
                    value: 'Charolais',
                }, {
                    value: 'Merino',
                }
            ]
            return

            this.$store.dispatch('searchItems', payload)
                .then(response => {
                    // this.success('Created')
                    eventBus.$emit("pushEvent", response)
                });
        },
        save_item(model) {
            var payload = {
                model: model,
                data: this.form
            }
            console.log(payload);

            this.$store.dispatch('postItems', payload)
                .then(response => {
                    this.success('Updated')
                    eventBus.$emit("pushEvent", response)
                    window.location.reload()
                });
        },
        register_customer(model) {
            var payload = {
                model: model,
                data: this.register_form
            }
            console.log(payload);

            this.$store.dispatch('postItems', payload)
                .then(response => {
                    this.success('Account Created')
                    eventBus.$emit("pushEvent", response)
                    window.location.href = "/login";
                });
        },
        update_item(model) {
            var payload = {
                model: model,
                data: this.edit_form,
                id: this.edit_form.id,
            }
            console.log(payload);
            this.$store.dispatch('patchItems', payload)
                .then(response => {
                    this.success('Updated')
                    eventBus.$emit("pushEvent", response)
                    window.location.reload()
                });
        },
        open_edit(data) {
            // alert('owoow')
            console.log(data);
            this.edit_form = data

        },
        birth_day(data) {
            var diff = Math.floor((Date.parse(new Date()) - Date.parse(this.form.birthday)) / 86400000);
            console.log(data);

            if (data) {
                var approx = data
            } else {
                var approx = this.form.approximation
            }
            if (approx == "months") {
                console.log('months');

                diff = parseInt(diff) / 30
            } else if (approx == "years") {
                console.log('years');
                diff = parseInt(diff) / 365
            }
            this.form.approx_age = parseFloat(diff).toFixed(1)
        },
        birth_calc(data) {
            console.log(data.data);

            var d = new Date();
            this.form.birthday = d.setDate(d.getDate() - 5).toLocaleString();

            // var month=last.getMonth()+1;
            // var year=last.getFullYear();
        },
        success(text) {
            // this.text = text
            // this.snackbar = true

        this.$message({
            message: text,
            type: 'success'
          });

        },
        parse_data(update, data) {
            console.log(data);
            this.load_data = true

            var payload = {
                data: data,
                update: update,
            }
            console.log(payload);
            this.$store.dispatch('updateData', payload)
                .then(response => {
                    // this.success('Updated')
                    // eventBus.$emit("pushEvent", response)
                });

        },
        open_issue(id) {
            console.log(id);

            var payload = {
                update: 'updateIssue',
                id: id,
                model: 'show_issue'
            }
            console.log(payload);
            this.$store.dispatch('showItem', payload)
                .then(response => {
                    // this.success('Updated')
                    // eventBus.$emit("pushEvent", response)
                });
        },
        oder_info(order) {
            console.log(order);
            // return
            this.order = order
        },
    },
    mounted() {

        setTimeout(() => {
            this.loading = false
        }, 1500);
        this.get_items('get_notifications', 'updateNotification')
    },
    computed: {
        ...mapState(['errors', 'animals', 'issues_show', 'notifications']),
    },
});
