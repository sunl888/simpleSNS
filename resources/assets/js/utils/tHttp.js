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
  Vue.prototype.$http = axios.create({
    baseURL,
    timeout: 6000,
    responseType: 'json',
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  });
  Vue.prototype.$http.interceptors.response.use((response) => {
    return response;
  }, (error) => {
    if (error.code === 'ECONNABORTED') {
      Vue.prototype.$message('请求超时');
    } else if (error.response.status === 401 && error.response.data.code === '401.1') {
      Vue.prototype.$message({ type: 'info', msg: '请先登录' });
      Vue.router.replace({ name: 'login' });
    } else if (error.response.status === 422) {
      let errors = error.response.data.errors;
      let errStr = '';
      for (let errIndex in errors) {
        errStr += errors[errIndex] + ' ';
      }
      Vue.prototype.$message(errStr);
    } else {
      if (error.config.noErrorTip) {
        return Promise.reject(error);
      }
      if (error.response.data.message) {
        Vue.prototype.$message(error.response.data.message);
      }
    }
    return Promise.reject(error);
  });
};

export default tHttp;
