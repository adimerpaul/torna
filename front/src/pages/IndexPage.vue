<template>
  <q-page>
    <div class="row q-pa-xs">
      <div class="col-12 col-sm-3" v-for="d in datos" :key="d.id">
        <q-card class="q-ma-xs">
          <q-card-section class="q-pa-none">
            <div class="row">
              <div :class="`col-5 q-pr-lg bg-${d.color} q-pa-lg flex flex-center`">
                <q-icon :name="`${d.icon}`" size="80px" color="white"  />
              </div>
              <div class="col-7 q-pa-md">
                <div class="text-h6">{{d.nombre}}</div>
                <div class="text-subtitle2">Cantidad ( {{d.cantidad}} )</div>
              </div>
            </div>
          </q-card-section>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script>
export default {
  name: `IndexPage`,
  data () {
    return {
      datos: [
        {
          id: 1,
          nombre: 'Tornaguias',
          cantidad: 0,
          color: 'info',
          icon: 'o_description'
        },
        {
          id: 2,
          nombre: 'Trasportes',
          cantidad: 0,
          color: 'warning',
          icon: 'o_directions_bus_filled'
        },
        {
          id: 3,
          nombre: 'Contratistas',
          cantidad: 0,
          color: 'positive',
          icon: 'work_outline'
        },
        {
          id: 4,
          nombre: 'Empresas',
          cantidad: 0,
          color: 'negative',
          icon: 'o_business'
        },
      ]
    }
  },
  created() {
    this.$api.get('tornaguia').then(res => {
      this.datos[0].cantidad = res.data.length
    })
    this.$api.get('transporte').then(res => {
      this.datos[1].cantidad = res.data.length
    })
    this.$api.get('contratista').then(res => {
      this.datos[2].cantidad = res.data.length
    })
    this.$api.get('empresa').then(res => {
      this.datos[3].cantidad = res.data.length
    })
  }
}
</script>
