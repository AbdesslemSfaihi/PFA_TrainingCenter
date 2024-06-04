import Addsubject from '@/pages/subjects/Addsubject.vue';

export const routes = [
  { path: '/', redirect: '/dashboard' },
  {
    path: '/',
    component: () => import('@/layouts/default.vue'),
    children: [
      {
        path: 'dashboard',
        component: () => import('@/pages/dashboard.vue'),
      },
      {
        path: 'subjects',
        component: () => import('@/pages/subjects/subjects.vue'),
      },
      {
        path: 'modules',
        component: () => import('@/pages/modules/modules.vue'),
      },
      {
        name: "Addsubject",
        path: "/addsubject",
        component: Addsubject
      },
      {
        path: 'modules/add',
        component: () => import('@/pages/modules/Addmodule.vue'),
      },
      {
        path: 'trainingCourses',
        component: () => import('@/pages/traincourse/trainCourse.vue'),
      },

      {
        path: 'trainingCourses/add',
        component: () => import('@/pages/traincourse/addTrainCourse.vue'),
      },
      {
        path: 'people',
        component: () => import('@/pages/people/people.vue'),
      },

      {
        path: 'people/add',
        component: () => import('@/pages/people/addPeople.vue'),
      },
      {
        path: 'subjectmodule',
        component: () => import('@/pages/subjectmodule/subjectmodule.vue'),
      },

      {
        path: 'subjectmodule/add',
        component: () => import('@/pages/subjectmodule/Addsubjectmodule.vue'),
      },

      {
        path: 'seance',
        component: () => import('@/pages/seance/seance.vue'),
      },

      {
        path: 'seance/add',
        component: () => import('@/pages/seance/addSeance.vue'),
      },

      {
        path: 'sessions',
        component: () => import('@/pages/session/session.vue'),
      },
      {
        path: 'sessions/add',
        component: () => import('@/pages/session/addSession.vue'),
      },
      {
        path: 'account-settings',
        component: () => import('@/pages/account-settings.vue'),
      },

      {
        path: 'typography',
        component: () => import('@/pages/typography.vue'),
      },
      {
        path: 'icons',
        component: () => import('@/pages/icons.vue'),
      },
      {
        path: 'cards',
        component: () => import('@/pages/cards.vue'),
      },
      {
        path: 'tables',
        component: () => import('@/pages/tables.vue'),
      },
      {
        path: 'form-layouts',
        component: () => import('@/pages/form-layouts.vue'),
      },
    ],
  },
  {
    path: '/',
    component: () => import('@/layouts/blank.vue'),
    children: [
      {
        path: 'login',
        component: () => import('@/pages/login.vue'),
      },
      {
        path: 'register',
        component: () => import('@/pages/register.vue'),
      },
      {
        path: '/:pathMatch(.*)*',
        component: () => import('@/pages/[...error].vue'),
      },
    ],
  },
]



