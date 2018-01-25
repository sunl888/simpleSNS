import axios from 'axios';
import { getCsrfToken } from '../utils/utils';

let token = getCsrfToken();

let tHttp = {};

tHttp.config = {};

tHttp.install = (Vue, { baseURL, router }) => {
  tHttp.config = {
    baseURL
  };
  tHttp.config['X-CSRF-TOKEN'] = token.content;
  let auth = {};
  let jwtToken = localStorage.getItem('jwt_token');
  if (jwtToken) {
    auth = {
      Authorization: 'Bearer ' + jwtToken
    };
  }
  Vue.prototype.$http = axios.create({
    baseURL,
    timeout: 6000,
    responseType: 'json',
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      ...auth
    }
  });
  Vue.prototype.$http.interceptors.response.use((response) => {
    return response;
  }, (error) => {
    if (error.code === 'ECONNABORTED') {
      Vue.prototype.$alert('请求超时', 'warning');
    } else if (error.response.status === 401 && error.response.data.code === '401.1') {
      Vue.prototype.$alert('请先登录', 'warning');
      Vue.router.replace({ name: 'login' });
    } else if (error.response.status === 422) {
      let errors = error.response.data.errors;
      let errStr = '';
      for (let errIndex in errors) {
        errStr += errors[errIndex] + ' ';
      }
      Vue.prototype.$alert(errStr, 'error');
    } else {
      if (error.config.noErrorTip) {
        return Promise.reject(error);
      }
      if (error.response.data.message) {
        Vue.prototype.$alert(error.response.data.message, 'error');
      }
    }
    return Promise.reject(error);
  });
};

export default tHttp;
