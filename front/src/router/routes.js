import Login from "pages/Login";
import Empresa from "pages/Empresa";
import Contratista from "pages/Contratista";
import Transporte from "pages/Transporte";
import Tornaguia from "pages/Tornaguia";

const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/IndexPage.vue') },
      { path: 'empresa', component: Empresa },
      { path: 'contratista', component: Contratista },
      { path: 'transporte', component: Transporte },
      { path: 'tornaguia', component: Tornaguia },
    ]
  },
  {
    path: '/login',
    component: Login,
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
