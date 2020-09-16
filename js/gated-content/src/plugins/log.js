import store from '@/store';

const Log = {
  // eslint-disable-next-line no-unused-vars
  install(Vue, options) {
    // eslint-disable-next-line no-param-reassign
    Vue.prototype.$log = {
      trackEventLoggedIn(user) {
        const event = new CustomEvent('virtual-y-log', {
          detail: {
            event_type: 'userLoggedIn',
            email: 'email' in user ? user.email : 'dummy',
          },
        });
        document.body.dispatchEvent(event);
      },
      trackEventEntityView(entityType, entityBundle, entityId) {
        const user = store.getters.getUser;
        const event = new CustomEvent('virtual-y-log', {
          detail: {
            email: 'email' in user ? user.email : 'dummy',
            event_type: 'entityView',
            entity_type: entityType,
            entity_bundle: entityBundle,
            entity_id: entityId,
          },
        });
        document.body.dispatchEvent(event);
      },
      trackNavigation(detail) {
        const event = new CustomEvent('virtual-y-navigation', {
          detail,
        });
        document.body.dispatchEvent(event);
      },
    };
  },
};

export default Log;
