<template>
  <div class="wrap">
    <div class="body">
      <div class="row">
        <div class="col-md-4">
          <input type="text" class="form-control" v-on:keyup="getData()" placeholder="Buscar por nombre" name=""
            v-model="name">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control" v-on:keyup="getData()" placeholder="Buscar por correo" name=""
            v-model="email">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control" v-on:keyup="getData()" placeholder="Buscar por teléfono" name=""
            v-model="phone">
        </div>
      </div>

      <div class="loading" v-if="isLoading">
        <h2 style="text-align:center">Cargando.......</h2>
      </div>

      <div class="table-responsive" v-else>
        <table class="table table-condensed table-hover">
          <thead>
            <tr>
              <th>CI</th>
              <th>Nombre de del asociado</th>
              <th>Correo electrónico</th>
              <th>Teléfono</th>
              <th>Membresia</th>
              <th>Dirección</th>
              <th>Estado</th>
              <th>Editar</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(value, index) in members.data" v-bind:key="index">
              <td>{{ value.ci }}</td>
              <td>{{ value.customer_name }}</td>
              <td>{{ value.email }}</td>
              <td>{{ value.phone }}</td>
              <td>{{ value.membresy_type }}</td>
              <td>{{ value.address }}</td>
              <td>{{ value.status }}</td>

              <td>
                <button @click="editcustomer(value.id)" type="button"
                  class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                  <i class="material-icons">edit</i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <pagination :pageData="members"></pagination>

      <div class="row">
        <update-member></update-member>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "../../vue-asset";
import mixin from "../../mixin";

import UpdateMember from "./UpdateMember.vue";
import Pagination from '../pagination/pagination.vue';

export default {
  mixins: [mixin],

  components: {
    "update-member": UpdateMember,
    "pagination": Pagination,
  },

  data() {
    return {
      members: [],
      name: "",
      email: "",
      phone: "",
      isLoading: true,
      userId: null,
    };
  },
  created() {
    var _this = this;
    this.getData();

    EventBus.$on("member-created", function () {
      _this.getData();
    });
  },

  methods: {
    getData(page = 1) {
      this.isLoading = true;
      console.log(base_url);

      axios
        .get(
          base_url +
          "member-list?page=" +
          page +
          "&name=" +
          this.name +
          "&email=" +
          this.email +
          "&phone=" +
          this.phone
        ).then((response) => {
           console.log(response.data);

          this.members = response.data;
          this.isLoading = false;
        })

        .catch(error => {
          console.log(error);

        });
    },



    // edit vendor

    editcustomer(id) {
      EventBus.$emit("member-edit", id);
    },

    showMessage(data) {
      if (data.status == "success") {
        toastr.success(data.message, "Success Alert", { timeOut: 500 });
      } else {
        toastr.error(data.message, "Error Alert", { timeOut: 500 });
      }
    },
    pageClicked(pageNo) {
      var vm = this;
      vm.getData(pageNo);
    }
  },

  computed: {

  },

};
</script>