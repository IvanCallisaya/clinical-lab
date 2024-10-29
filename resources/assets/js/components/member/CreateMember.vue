<template>
  <div class="wrap">
    <div class="modal fade" id="create-member" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="defaultModalLabel">Asociado nuevo</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" v-if="errors">
              <ul>
                <li v-for="error in errors">{{ error[0] }}</li>
              </ul>
            </div>
            <form>
              <div class="row">
                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">account_box</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="CI" v-model="customer.ci">
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">account_circle</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Nombre"
                        v-model="customer.customer_name">
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">email</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Correo electrónico"
                        v-model="customer.email">
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">phone</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Teléfono" v-model="customer.phone">
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">map</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Dirección" v-model="customer.address" />
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">card_membership</i>
                    </span>
                    <div>Tipo de membresia: {{ selected }}</div>

                    <select v-model="selected">
                      <option disabled value="">Por favor seleccione uno</option>
                      <option>3 meses</option>
                      <option>6 meses</option>
                      <option>12 meses</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <div>Seleccione la imagen del carnet<i class="material-icons">image</i></div>
                    </span>
                    <div class="form-line">
                      <input type="file" accept="image/*" capture="camera" @change="onImageChange($event, 1)"
                        class="form-control" />
                    </div>
                  </div>
                  <div v-if="imagePreview1">
                    <img :src="imagePreview1" alt="Preview 1" style="width: 100%; height: auto; margin-top: 10px;" />
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <div>Seleccione la foto del nuevo asociado<i class="material-icons">image</i></div>
                    </span>
                    <div class="form-line">
                      <input type="file" accept="image/*" capture="camera" @change="onImageChange($event, 2)"
                        class="form-control" />
                    </div>
                  </div>
                  <div v-if="imagePreview2">
                    <img :src="imagePreview2" alt="Preview 2" style="width: 100%; height: auto; margin-top: 10px;" />
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <div>Seleccione el comprobante de pago<i class="material-icons">image</i></div>
                    </span>
                    <div class="form-line">
                      <input type="file" accept="image/*" capture="camera" @change="onImageChange($event, 3)"
                        class="form-control" />
                    </div>
                  </div>
                  <div v-if="imagePreview3">
                    <img :src="imagePreview3" alt="Preview 3" style="width: 100%; height: auto; margin-top: 10px;" />
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <br>
            <button @click="createMember" type="button" class="btn btn-success waves-effect">Guardar</button>
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "../../vue-asset";
import mixin from "../../mixin";

export default {
  mixins: [mixin],

  data() {
    return {
      selected: "",
      customer_id: "",
      user_id: "",
      customer: {
        customer_name: "",
        email: "",
        phone: "",
        address: "",
        ci: ""
      },
      image_ci: null,
      image_photo: null,
      image_payment: null,
      imagePreview1: null,
      imagePreview2: null,
      imagePreview3: null,
      errors: null
    };
  },

  methods: {
    onImageChange(event, imageNumber) {
      const file = event.target.files[0];
      if (file) {
        switch (imageNumber) {
          case 1:
            this.image_ci = file;
            this.imagePreview1 = URL.createObjectURL(file);
            break;
          case 2:
            this.image_photo = file;
            this.imagePreview2 = URL.createObjectURL(file);
            break;
          case 3:
            this.image_payment = file;
            this.imagePreview3 = URL.createObjectURL(file);
            break;
        }
      }
    },
    async createMember() {
      const formData = new FormData();
      formData.append('customer_name', this.customer.customer_name);
      formData.append('email', this.customer.email);
      formData.append('phone', this.customer.phone);
      formData.append('address', this.customer.address);
      formData.append('ci', this.customer.ci);

      try {
        // Primero, creamos el customer
        const response = await axios.post('customer', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        console.log(response.data.data);
        this.customer_id = response.data.data; // Ajusta según cómo te devuelva el ID del customer el backend
        console.log(this.customer_id);
        try {
          const responseUser = await axios.get('get-user/');
          console.log('user id: ' + responseUser.data);

          this.user_id = responseUser.data;
          console.log(this.user_id) // Ajusta según cómo te devuelva el ID del customer el backend
        } catch (error) {
          console.error('Error al obtener el ID del usuario', error);
        }
        // Ahora que tenemos el customer_id, creamos el member
        const memberFormData = new FormData();
        memberFormData.append('customer_name', this.customer.customer_name);
        memberFormData.append('email', this.customer.email);
        memberFormData.append('phone', this.customer.phone);
        memberFormData.append('address', this.customer.address);
        memberFormData.append('ci', this.customer.ci);
        memberFormData.append('membresy_type', this.selected);
        memberFormData.append('customer_id', this.customer_id);
        memberFormData.append('user_id', this.user_id);

        // Adjuntar las imágenes si están presentes
        if (this.image_ci) {
          memberFormData.append('image_ci', this.image_ci);
        }
        if (this.image_photo) {
          memberFormData.append('image_photo', this.image_photo);
        }
        if (this.image_payment) {
          memberFormData.append('image_payment', this.image_payment);
        }

        const memberResponse = await axios.post('member', memberFormData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });

        // Limpiar los datos del formulario y cerrar el modal
        $("#create-member").modal("hide");
        this.customer = {
          customer_name: "",
          email: "",
          phone: "",
          address: "",
          ci: ""
        };
        this.selected = "";
        this.image_ci = null;
        this.image_photo = null;
        this.image_payment = null;
        this.imagePreview1 = null;
        this.imagePreview2 = null;
        this.imagePreview3 = null;
        this.errors = null;
        EventBus.$emit("customer-created", memberResponse.data);
        
        this.successALert(response.data);
      } catch (err) {
        if (err.response) {
          this.errors = err.response.data.errors;
        }
        console.error('Error al crear el cliente o el miembro', err);
      }
    },
  },

  // end of method section

  created() {


  },


};
</script>