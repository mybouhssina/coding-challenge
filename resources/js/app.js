import { createApp } from "vue";
import { library } from '@fortawesome/fontawesome-svg-core'
import { faSearch } from '@fortawesome/free-solid-svg-icons'

library.add(faSearch)
import App from "./components/App.vue";

let vueInstance = createApp(App);

vueInstance.config.globalProperties.$route = route /*Ziggy global function route()*/
vueInstance.mount("#app")

require("./bootstrap");
