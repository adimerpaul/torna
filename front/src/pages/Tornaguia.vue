<template>
  <q-page>
    <q-table :rows="tornaguias" :columns="tornaguiaColums" :filter="search">
      <template v-slot:top-right>
        <q-toolbar>
          <q-btn color="primary" label="Crear tornagia" icon="add_circle_outline" @click="tornaguiaClick" />
          <q-input v-model="search"  outlined  dense placeholder="Buscar..." />
        </q-toolbar>
      </template>
      <template v-slot:body-cell-tipoMaterial="props">
        <q-td :props="props" auto-width >
          <q-badge dense text-color="white" :color="props.row.tipoMaterial=='Embolsado'?'green':'red'">{{props.row.tipoMaterial}}</q-badge>
        </q-td>
      </template>
      <template v-slot:body-cell-option="props">
        <q-td :props="props" auto-width >
          <q-btn-dropdown color="primary" label="Opciones">
            <q-list>
              <q-item clickable v-close-popup @click="ver(props.row)" >
                <q-item-section avatar>
                  <q-icon name="edit" />
                </q-item-section>
                <q-item-section>Modificar</q-item-section>
              </q-item>
              <q-item clickable v-close-popup @click="print(props.row)" >
                <q-item-section avatar>
                  <q-icon name="print" />
                </q-item-section>
                <q-item-section>Imprimir</q-item-section>
              </q-item>
            </q-list>
          </q-btn-dropdown>
        </q-td>
      </template>
    </q-table>
    <q-dialog v-model="showAddTornaguiaDialog" full-width >
      <q-card>
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">{{ tornaguiaCrear?'Generacion de':'Modificar'  }} Tornaguia o Cartaporte</div>
        </q-card-section>
        <q-card-section class="q-pt-none">
          <q-form @submit.prevent="tornaguiaCreate">
            <q-card>
              <q-card-section>
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <q-input  v-model="tornaguia.fecha" type="date" :label="`Fecha: ${tornaguia.fecha} `" outlined dense />
                  </div>
                  <div class="col-12 col-sm-6">
                    <q-input  v-model="tornaguia.numero" type="number" label="Número Asignado:" outlined dense />
                  </div>
                </div>
              </q-card-section>
              <q-card-section class="bg-primary text-white q-pa-xs">
                <div class="text-subtitle2">PROPIETARIO DEL MINERAL</div>
              </q-card-section>
              <q-card-section>
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <q-select  v-model="tornaguia.empresas" :rules="[ (val, rules) => !!val || 'Porfavor registrar dato' ]" required :options="empresas" label="Empresa Destiono:" outlined dense />
                  </div>
                  <div class="col-12 col-sm-6">
                    <q-select  v-model="tornaguia.contratistas"  :rules="[val=>!!val||'Porfavor registrar dato']" required :options="contratistas" label="Contratista:" outlined dense />
                  </div>
                </div>
              </q-card-section>
              <q-card-section class="bg-primary text-white q-pa-xs">
                <div class="text-subtitle2">PROCEDENCIA</div>
              </q-card-section>
              <q-card-section>
                <div class="row">
                  <div class="col-12 col-sm-4">
                    <q-input  v-model="tornaguia.yacimiento" label="Yacimiento:" outlined dense />
                  </div>
                  <div class="col-12 col-sm-4">
                    <q-input  v-model="tornaguia.tranca" label="Tranca:" outlined dense />
                  </div>
                  <div class="col-12 col-sm-4">
                    <q-input  v-model="tornaguia.cuadrilla" label="Cuadrilla:" outlined dense />
                  </div>
                </div>
              </q-card-section>
              <q-card-section class="bg-primary text-white q-pa-xs">
                <div class="text-subtitle2">MEDIO DE TRANSPORTE</div>
              </q-card-section>
              <q-card-section>
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <q-select  v-model="tornaguia.transportes" :rules="[val=>!!val||'Porfavor registrar dato']" required :options="transportes" label="Transporte:" outlined dense />
                  </div>
                  <div class="col-12 col-sm-6">
                    <q-select  v-model="tornaguia.drivers" :rules="[val=>!!val||'Porfavor registrar dato']"  required :options="drivers" label="Conductor:" outlined dense />
                  </div>
                </div>
              </q-card-section>
              <q-card-section class="bg-primary text-white q-pa-xs">
                <div class="text-subtitle2">TIPO DE MATERIAL</div>
              </q-card-section>
              <q-card-section>
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <div class="text-bold">Tipo de Material:</div>
                    <q-radio  v-model="tornaguia.tipoMaterial" val="Mineral" label="Mineral" />
                    <q-radio  v-model="tornaguia.tipoMaterial" val="Embolsado" label="Embolsado" />
                  </div>
                  <div class="col-12 col-sm-6">
                    <div class="text-bold">Minerales:</div>
                    <q-checkbox  v-model="tornaguia.mineralesSel" val="Sn" label="Sn" />
                    <q-checkbox  v-model="tornaguia.mineralesSel" val="Ag" label="Ag" />
                    <q-checkbox  v-model="tornaguia.mineralesSel" val="Pb" label="Pb" />
                    <q-checkbox  v-model="tornaguia.mineralesSel" val="Zn" label="Zn" />
                    <q-checkbox  v-model="tornaguia.mineralesSel" val="Otros" label="Otros" />
<!--                    <q-input  v-model="tornaguia.minerales" disable label="Minerales:" outlined dense />-->
                  </div>
                  <div class="col-12 col-sm-6">
                    <q-input  v-model="tornaguia.peso" type="number" label="Peso en Tn.:" outlined dense />
                  </div>
                  <div class="col-12 col-sm-6">
                    <q-input  v-model="tornaguia.sacos" type="number" label="Cantidad de Sacos:" outlined dense />
                  </div>
                </div>
              </q-card-section>
            </q-card>
            <q-btn :loading="loading"  type="submit" color="primary" icon="add_circle_outline" :label="tornaguiaCrear?'Guardar':'Modificar'" class="full-width" />
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
    <q-dialog v-model="showUpdateTornaguiaDialog" >
      <q-card class="full-width">
        <q-card-section class="row items-center">
          <div class="text-h6">Generacion de Tornaguia o Cartaporte</div>
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
    <div id="myelement" class="hidden"></div>
  </q-page>
</template>

<script>
import {date} from "quasar";
import {useCounterStore} from "stores/example-store";
import { Printd } from 'printd'
import QRCode from 'qrcode'

export default {
  name: `Tornaguia`,
  data () {
    return {
      store:useCounterStore(),
      roles: [
        'INSCRIPCION',
        'ACREDITACION',
        'REFRIGERIO',
        'ADMINISTRADOR',
      ],
      shape: [],
      showAddTornaguiaDialog: false,
      showUpdateTornaguiaDialog: false,
      search: '',
      tornaguias: [],
      tornaguia:{
        fecha:date.formatDate(new Date(), 'YYYY-MM-DD'),
        mineralesSel:[],
      },
      loading: false,
      tornaguiaCrear: true,
      empresas:[],
      contratistas:[],
      transportes:[],
      drivers:[],
      tornaguiaColums:[
        {name: 'option', field: 'option', label: 'Opciones', align: 'left', sortable: true},
        {name: 'id', field: 'id', label: 'No.', align: 'left', sortable: true},
        {name: 'fecha', field: 'fecha', label: 'Fecha', align: 'left', sortable: true},
        {name: 'empresa', label: 'Empresa destino', field: row=>row.empresa.nombre, align: 'left', sortable: true},
        {name: 'contratista', label: 'Contratista', field: row=>row.contratista.nombre, align: 'left', sortable: true},
        {name: 'minerales', label: 'Minerales', field: 'minerales', align: 'left', sortable: true},
        {name: 'tipoMaterial', label: 'Tipo Material', field: 'tipoMaterial', align: 'left', sortable: true},
        {name: 'transporte', label: 'Transporte', field: row=>row.transporte.placa, align: 'left', sortable: true},
        {name: 'conductor', label: 'Conductor', field: row=>row.driver.name, align: 'left', sortable: true},
        {name: 'user', label: 'Usuario', field: row=>row.user.name, align: 'left', sortable: true},
      ]
    }
  },
  mounted() {
    this.tornaguiasGet()
    this.$api.get('empresa').then((response) => {
      response.data.forEach((empresa) => {
        this.empresas.push({label:empresa.nombre, value:empresa.id})
      })
    });
    this.$api.get('contratista').then((response) => {
      response.data.forEach((contratista) => {
        this.contratistas.push({label:contratista.nombre, value:contratista.id})
      })
    });
    this.$api.get('transporte').then((response) => {
      response.data.forEach((transporte) => {
        this.transportes.push({label:transporte.placa, value:transporte.id})
      })
    });
    this.$api.get('driver').then((response) => {
      response.data.forEach((drive) => {
        this.drivers.push({label:drive.name, value:drive.id})
      })
    });
  },
  methods:{
    print(tornaguia){
      tornaguia.id=tornaguia.id.toString().padStart(6, '0')
      const d = new Printd()
      QRCode.toDataURL(tornaguia.id+'-'+tornaguia.driver.name)
        .then(url => {
          document.getElementById('myelement').innerHTML = `
<style>
  .center {
    text-align: center;
  }
  .border{
    border: 1px solid #70A89F;
  }
  .color{
    color: #70A89F;
  }
  .white{
    color: #fff;
  }
  .bold{
    font-weight: bold;
  }
  .width-100{
    width: 100%;
  }
  .width-50{
    width: 50%;
  }
    .width-25{
    width: 25%;
  }

  .black{
    color: black;
  }
  .red{
    color: #ce1212;
  }
  .h1{
    font-size: 1.5rem;
  }
  .h2{
    font-size: 1.3rem;
  }
  .h3{
    font-size: 1.2rem;
  }
  .h4{
    font-size: 1rem;
  }
  .h5{
    font-size: 0.8rem;
  }
  .background{
    background-color: #E4EBF5;
  }
  .background-black{
    background-color: #639F93;
  }

</style>
<table class="border" style="border-collapse: collapse" width="100%">
  <tr>
    <td class="center border"><img src="logo1.png" alt="logo1" width="50px"></td>
    <td class="center border color ">
    <div class="bold h1">Cooperativa Minera "POOPO" R.L.</div>
    <div class="h5">Personaria Juridica No. 487 - Fiche de REgistro No. 464 NIT 1023457027</div>
    <div class="h5">Cel. 72318861-71852849-72467605-71101685</div>
    <div class="h5">Poopo-Oruro-Bolivia</div>
    </td>
    <td class="center border"><img src="logo.png" alt="logo1" width="50px"></td>
  </tr>
  <tr>
    <td class="center border" colspan="3">
      <div class="bold h2 color background">TORNAGUIA O CARTA PORTE</div>
    </td>
</tr>
</table>
<table class="width-100">
  <tr>
    <td class="border width-50">
      <small class="bold h4 color">Fecha:</small><small class="black"> ${tornaguia.fecha} </small>
    </td>
    <td class="border width-50">
      <small class="bold h4 color">No:</small><small class="red"> ${tornaguia.id}</small>
    </td>
   </tr>
   <tr>
    <td class="border center white background-black">
      PROCEDENCIA
    </td>
    <td class="border center white background-black">
      PROPIETARIO DEL MINERAL
    </td>
</tr>
  <tr>
    <td class="border width-50">
      <div><small class="bold h4 color">Departamento:</small><small class="color"> Oruro Minicipio: Poopo </small></div>
      <div><small class="bold h4 color">Yacimiento:</small><small class="black"> ${tornaguia.yacimiento}</small></div>
      <div><small class="bold h4 color">Cuadrilla:</small><small class="black"> ${tornaguia.cuadrilla}</small></div>
      <div><small class="bold h4 color">Tranca de control:</small><small class="black"> ${tornaguia.tranca}</small></div>
    </td>
    <td class="border width-50">
      <div><small class="bold h4 color">Cooperativa Minera Poopo R.L.:</small></div>
      <div><small class="bold h4 color">Destino Empresa:</small><small class="black"> ${tornaguia.empresa.nombre}</small></div>
      <div><small class="bold h4 color">Contratista:</small><small class="black"> ${tornaguia.contratista.nombre}</small></div>
    </td>
   </tr>
      <tr>
    <td class="border center white background-black">
      MEDIO DE TRANSPORTE
    </td>
    <td class="border center white background-black">
    TIPO DE MATERIAL
    </td>
</tr>
  <tr>
    <td class="border width-50">
      <div><small class="bold h4 color">Tipo de transporte:</small><small class="black"> ${tornaguia.transporte.tipo} </small> <small class="bold h4 color">Marca:</small><small class="black"> ${tornaguia.transporte.marca} </small></div>
      <div><small class="bold h4 color">Color:</small><small class="black"> ${tornaguia.transporte.color}</small><small class="bold h4 color">Placa:</small><small class="black"> ${tornaguia.transporte.placa}</small></div>
      <div><small class="bold h4 color">Nombre del chofer:</small><small class="black"> ${tornaguia.driver.name}</small></div>
      <div><small class="bold h4 color">Ci :</small><small class="black"> ${tornaguia.driver.licencia}</small></div>
    </td>
    <td class="border width-50">
      <div><small class="bold h4 color">Tipo de Material:</small><small class="black">${tornaguia.tipoMaterial}</small></div>
      <div><small class="bold h4 color">Minerales:</small><small class="black"> ${tornaguia.minerales}</small></div>
      <div><small class="bold h4 color">Peso en Toneladas:</small><small class="black"> ${tornaguia.peso}</small></div>
      <div><small class="bold h4 color">Cantidad de Sacos:</small><small class="black"> ${tornaguia.sacos}</small></div>
      <div><small class="bold h4 color">No. de Lote:</small><small class="black"> </small></div>
    </td>
   </tr>
</table>
<table class="width-100">
<tr valign="bottom">
    <td class="width-25 border center color" >
        <div class="h5">Presidente, Consejo de</div>
        <div class="h5">Administracion</div>
        <div class="h5">Sello, Nombre, C.I. y Firma</div>
     </td>
     <td class="width-25 border center color">
        <div class="h5">Empresa Receptora</div>
        <div class="h5">Sello y Firma</div>
     </td>
     <td class="width-25 border center color">
        <div class="h5">Presidente, Consejo de</div>
        <div class="h5">Vigilancia</div>
        <div class="h5">Sello, Nombre, C.I. y Firma</div>
     </td>
     <td class="width-25 border center color">
        <img src="${url}" alt="">
     </td>
</tr>
</table>
    `
          d.print( document.getElementById('myelement') )
        })
        .catch(err => {
          console.error(err)
        })
    },
    ver(tornaguia){
      this.showAddTornaguiaDialog = true
      this.tornaguiaCrear = false
      this.tornaguia=tornaguia
      this.tornaguia.transportes={label:tornaguia.transporte.placa, value:tornaguia.transporte.id}
      this.tornaguia.empresas={label:tornaguia.empresa.nombre, value:tornaguia.empresa.id}
      this.tornaguia.contratistas={label:tornaguia.contratista.nombre, value:tornaguia.contratista.id}
      this.tornaguia.drivers={label:tornaguia.driver.name, value:tornaguia.driver.id}
      this.tornaguia.mineralesSel=tornaguia.minerales.split(",")
    },
    tornaguiaUpdate(){
      this.loading = true
      this.$api.put(`tornaguia/${this.tornaguia.id}`,this.tornaguia)
        .then(res=>{
          this.loading = false
          this.showUpdateTornaguiaDialog = false
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
        this.tornaguias=[]
        response.data.forEach(d=>{
          // d.fecha= date.formatDate(d.created_at, 'YYYY-MM-DD HH:mm:ss')
          this.tornaguias.push(d)
        })

        this.$q.loading.hide()
      })
    },
    tornaguiaClick(){
      this.tornaguia={
          fecha:date.formatDate(new Date(), 'YYYY-MM-DD'),
          mineralesSel:[],
      }
      this.showAddTornaguiaDialog = true;
      this.tornaguiaCrear=true
    },
    tornaguiaCreate(){
      if (this.tornaguiaCrear){
        this.loading = true
        this.tornaguia.empresa_id=this.tornaguia.empresas.value
        this.tornaguia.contratista_id=this.tornaguia.contratistas.value
        this.tornaguia.transporte_id=this.tornaguia.transportes.value
        this.tornaguia.driver_id=this.tornaguia.drivers.value
        this.tornaguia.user_id=this.store.user.id
        let materiales=''
        this.tornaguia.mineralesSel.forEach((mineral) => {
          materiales=materiales+mineral+','
        })
        this.tornaguia.minerales=materiales
        this.$api.post('tornaguia', this.tornaguia).then(response => {
          this.tornaguiasGet()
          this.showAddTornaguiaDialog = false
          this.tornaguia = {
            fecha:date.formatDate(new Date(), 'YYYY-MM-DD'),
            mineralesSel:[],
          }
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
        this.tornaguia.empresa_id=this.tornaguia.empresas.value
        this.tornaguia.contratista_id=this.tornaguia.contratistas.value
        this.tornaguia.transporte_id=this.tornaguia.transportes.value
        this.tornaguia.driver_id=this.tornaguia.drivers.value
        this.tornaguia.user_id=this.store.user.id
        let materiales=''
        this.tornaguia.mineralesSel.forEach((mineral) => {
          materiales=materiales+mineral+','
        })
        this.tornaguia.minerales=materiales
        this.$api.put('tornaguia/'+this.tornaguia.id, this.tornaguia).then(response => {
          this.tornaguiasGet()
          this.showAddTornaguiaDialog = false
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
      this.showUpdateTornaguiaDialog = true
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

}
</script>

<style scoped>
</style>
