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
      { path: '', component: () => import('pages/IndexPage.vue') ,meta:{requiresAuth: true}},
      { path: 'empresa', component: Empresa ,meta:{requiresAuth: true}},
      { path: 'contratista', component: Contratista ,meta:{requiresAuth: true}},
      { path: 'transporte', component: Transporte ,meta:{requiresAuth: true}},
      { path: 'tornaguia', component: Tornaguia ,meta:{requiresAuth: true}},
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
