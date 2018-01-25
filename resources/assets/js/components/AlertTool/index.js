import AlertTool from './AlertTool.vue';
import Vue from 'vue';
let Alert = Vue.extend(AlertTool);
export default function alert (content, type) {
  let instance = new Alert({
    data: {
      content,
      type
    }
  });
  instance.$mount();
  document.body.appendChild(instance.$el);
  return instance;
}
