<template>
  <q-page>
    <q-table :rows="tornaguias" :columns="tornaguiaColums" :filter="search">
      <template v-slot:top-right>
        <q-toolbar>
          <q-btn flat icon="add_circle_outline" @click="showAddUserDialog = true;tornaguiaCrear=true" />
          <q-input v-model="search"  outlined  dense placeholder="Buscar..." />
        </q-toolbar>
      </template>
      <template v-slot:body-cell-estado="props">
        <q-td :props="props" auto-width >
          <q-badge dense text-color="white" :color="props.row.estado=='Activo'?'green':'red'">{{props.row.estado}}</q-badge>
        </q-td>
      </template>
      <template v-slot:body-cell-option="props">
        <q-td :props="props" auto-width >
          <q-btn flat dense icon="o_edit" @click="tornaguiaEdit(props.row)" />
          <q-btn flat dense icon="o_delete" @click="tornaguiaDelete(props.row)" />
        </q-td>
      </template>
    </q-table>
    <q-dialog v-model="showAddUserDialog" >
      <q-card style="width: 700px;max-width: 85vw">
        <q-card-section class="row items-center">
          <div class="text-h6">Agregar Tornaguia</div>
        </q-card-section>
        <q-card-section>
          <q-form @submit.prevent="tornaguiaCreate">
            <q-input v-model="tornaguia.nombre" hint="" required outlined label="Nombre" />
            <q-select v-model="tornaguia.ciudad" hint="" required outlined label="Ciudad" :options="['ORURO','LA PAZ','COCHABAMBA','SANTA CRUZ','POTOSI','TARIJA','CHUQUISACA','BENI','PANDO']" />
            <q-input v-model="tornaguia.telefono" hint="" required outlined label="Telefono" />
            <q-input v-model="tornaguia.nit" hint="" required outlined label="NIT" />
            <q-btn :loading="loading" type="submit" color="primary" icon="add_circle_outline" label="Guardar" class="full-width" />
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
    <q-dialog v-model="showUpdateUserDialog" >
      <q-card style="width: 700px;max-width: 85vw">
        <q-card-section class="row items-center">
          <div class="text-h6">Agregar Tornaguia</div>
        </q-card-section>
        <q-card-section>
          <q-form @submit.prevent="tornaguiaUpdate">
            <q-input v-model="tornaguia.nombre" hint="" required outlined label="Nombre" />
            <q-select v-model="tornaguia.ciudad" hint="" required outlined label="Ciudad" :options="['ORURO','LA PAZ','COCHABAMBA','SANTA CRUZ','POTOSI','TARIJA','CHUQUISACA','BENI','PANDO']" />
            <q-input v-model="tornaguia.telefono" hint="" required outlined label="Telefono" />
            <q-input v-model="tornaguia.nit" hint="" required outlined label="NIT" />
            <q-btn :loading="loading" type="submit" color="primary" icon="add_circle_outline" label="Guardar" class="full-width" />
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </q-page>
</template>

<script>
export default {
  name: `User`,
  data () {
    return {
      roles: [
        'INSCRIPCION',
        'ACREDITACION',
        'REFRIGERIO',
        'ADMINISTRADOR',
      ],
      showAddUserDialog: false,
      showUpdateUserDialog: false,
      search: '',
      tornaguias: [],
      tornaguia:{},
      loading: false,
      tornaguiaCrear: true,
      tornaguiaColums:[
        {name: 'option', field: 'option', label: 'Opciones', align: 'left', sortable: true},
        {name: 'estado', field: 'estado', label: 'Estado', align: 'left', sortable: true},
        {name: 'id', label: 'ID', field: 'id', align: 'left', sortable: true},
        {name: 'nombre', label: 'Nombre', field: 'nombre', align: 'left', sortable: true},
        {name: 'ciudad', label: 'Ciudad', field: 'ciudad', align: 'left', sortable: true},
      ]
    }
  },
  methods:{
    tornaguiaUpdate(){
      this.loading = true
      this.$api.put(`tornaguia/${this.tornaguia.id}`,this.tornaguia)
        .then(res=>{
          this.loading = false
          this.showUpdateUserDialog = false
          this.$q.notify({
            color: 'green-4',
            textColor: 'white',
            icon: 'check_circle',
            message: 'Tornaguia actualizado'
          })
          this.tornaguia = {}
          this.tornaguiasGet()
        })
        .catch(err=>{
          this.loading = false
          this.$q.notify({
            color: 'red-4',
            textColor: 'white',
            icon: 'error',
            message: 'Error al actualizar usuario'
          })
        })
    },
    tornaguiasGet(){
      this.$q.loading.show()
      this.$api.get('tornaguia').then(response => {
        this.tornaguias = response.data
        this.$q.loading.hide()
      })
    },
    tornaguiaCreate(){
      if (this.tornaguiaCrear){
        this.loading = true
        this.$api.post('tornaguia', this.tornaguia).then(response => {
          this.tornaguiasGet()
          this.showAddUserDialog = false
          this.tornaguia = {}
          this.loading = false
        }).catch(error => {
          this.loading = false
          this.$q.notify({
            color: 'negative',
            message: error.response.data.message,
            icon: 'report_problem',
            position: 'top'
          })
        })
      }else{
        this.loading = true
        this.$api.put('tornaguia/'+this.tornaguia.id, this.tornaguia).then(response => {
          this.tornaguiasGet()
          this.showAddUserDialog = false
          this.tornaguia = {}
          this.loading = false
        }).catch(error => {
          this.loading = false
          this.$q.notify({
            color: 'negative',
            message: error.response.data.message,
            icon: 'report_problem',
            position: 'top'
          })
        })
      }
    },
    tornaguiaEdit(tornaguia){
      this.tornaguia = tornaguia
      this.tornaguiaCrear = false
      this.showUpdateUserDialog = true
    },
    updatePassword(tornaguia){
      this.$q.dialog({
        title: 'Cambiar contraseña',
        message: 'Ingrese la nueva contraseña',
        prompt: {
          model: '',
          type: 'password'
        },
        cancel: true,
        persistent: true
      }).onOk(data => {
        this.$api.put(`updatePassword/${tornaguia.id}`,{password:data})
          .then(res=>{
            this.$q.notify({
              color: 'green-4',
              textColor: 'white',
              icon: 'check_circle',
              position: 'top',
              message: 'Contraseña actualizada'
            })
          })
          .catch(err=>{
            this.$q.notify({
              color: 'red-4',
              textColor: 'white',
              icon: 'error',
              position: 'top',
              message: err.response.data.message
            })
          })
      }).onCancel(() => {
        console.log('Cancel')
      }).onDismiss(() => {
        console.log('Dismissed')
      })
    },
    tornaguiaDelete(tornaguia){
      this.$q.dialog({
        title: 'Eliminar',
        message: '¿Está seguro de eliminar el usuario?',
        ok: 'Si',
        cancel: 'No'
      }).onOk(() => {
        this.$q.loading.show()
        this.$api.delete('tornaguia/'+tornaguia.id).then(response => {
          this.tornaguiasGet()
        })
      })
    }
  },
  created() {
    this.tornaguiasGet()
  }
}
</script>

<style scoped>
</style>
