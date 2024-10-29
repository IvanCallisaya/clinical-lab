require('./vue-asset');
Vue.component('create-member', require('./components/member/CreateMember.vue'));
Vue.component('view-member', require('./components/member/ViewMember.vue'));

var app = new Vue({

    el: '#inventory'
});